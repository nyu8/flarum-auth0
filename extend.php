<?php

use Flarum\Extend;
use NYU8\FlarumAuth0\Auth0Controller;

return [
  (new Extend\Frontend('forum'))
    ->js(__DIR__ . '/js/dist/forum.js'),
  (new Extend\Frontend('admin'))
    ->js(__DIR__ . '/js/dist/admin.js'),
  new Extend\Locales(__DIR__ . '/locale'),
  (new Extend\Routes('forum'))
    ->get('/auth/auth0', 'auth.auth0', Auth0Controller::class),
  (new Extend\Settings)
    ->serializeToForum('nyu8Auth0LoginButtonTitle', 'nyu8-auth0.login_button_title')
    ->serializeToForum('nyu8Auth0HidePasswordLogin', 'nyu8-auth0.hide_password_login'),
];
