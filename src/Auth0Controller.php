<?php

namespace NYU8\FlarumAuth0;

use Auth0\SDK\Auth0;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Flarum\Forum\Auth\Registration;
use Flarum\Forum\Auth\ResponseFactory;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Locale\Translator;
use Illuminate\Support\Arr;
use Laminas\Diactoros\Response\RedirectResponse;

class Auth0Controller implements RequestHandlerInterface
{
  /**
   * @var ResponseFactory
   */
  protected $response;

  /**
   * @var SettingsRepositoryInterface
   */
  protected $settings;

  /**
   * @var Translator
   */
  protected $translator;

  public function __construct(ResponseFactory $response, SettingsRepositoryInterface $settings, Translator $translator)
  {
    $this->response = $response;
    $this->settings = $settings;
    $this->translator = $translator;
  }

  /**
   *
   * @param ServerRequestInterface $request
   * @return ResponseInterface
   */
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $redirectUri = (string) $request->getAttribute('originalUri', $request->getUri()->withQuery(''));
    $provider = $this->getProvider($redirectUri);

    $userInfo = $provider->getUser();

    if (!$userInfo) {
      $loginUrl = $provider->getLoginUrl();
      return new RedirectResponse($loginUrl . '&display=popup');
    }

    if (!Arr::get($userInfo, 'email_verified')) {
      throw new Exception($this->translator->trans('nyu8-auth0.forum.email_unverified_message'));
    }

    $email = Arr::get($userInfo, 'email');

    return $this->response->make(
      'auth0',
      $email,
      function (Registration $registration) use ($email, $userInfo) {
        $registration->provideTrustedEmail($email)
          ->provideAvatar(Arr::get($userInfo, 'picture'))
          ->suggestUsername(Arr::get($userInfo, 'nickname'))
          ->setPayload($userInfo);
      }
    );
  }

  private function getProvider(string $redirectUri): Auth0
  {
    return new Auth0([
      'domain' => $this->settings->get('nyu8-auth0.domain'),
      'client_id' => $this->settings->get('nyu8-auth0.client_id'),
      'client_secret' => $this->settings->get('nyu8-auth0.client_secret'),
      'redirect_uri' => $redirectUri,
    ]);
  }
}
