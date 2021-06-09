import app from 'flarum/forum/app';
import {extend} from 'flarum/common/extend';
import LogInButtons from 'flarum/forum/components/LogInButtons';
import LogInButton from 'flarum/forum/components/LogInButton';
import ItemList from 'flarum/common/utils/ItemList';

app.initializers.add('nyu8-auth0', () => {
  console.log('Hello, auth0!');

  extend(LogInButtons.prototype, 'items', (items: ItemList) => {
    let loginButtonTitle =
      app.forum.attribute('nyu8Auth0LoginButtonTitle') ||
      app.translator.trans('nyu8-auth0.forum.login_button_title_default');

    items.add(
      'auth0',
      <LogInButton
        className="Button Button--primary Button--block"
        path="/auth/auth0"
      >
        {loginButtonTitle}
      </LogInButton>,
    );
  });
});
