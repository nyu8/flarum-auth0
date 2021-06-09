import app from 'flarum/admin/app';

app.initializers.add('nyu8-auth0', () => {
  console.log('Hello, NYU8!');

  app.extensionData
    .for('nyu8-auth0')
    .registerSetting({
      setting: 'nyu8-auth0.domain',
      type: 'text',
      label: app.translator.trans('nyu8-auth0.admin.domain_label'),
      help: app.translator.trans('nyu8-auth0.admin.domain_help'),
    })
    .registerSetting({
      setting: 'nyu8-auth0.client_id',
      type: 'text',
      label: app.translator.trans('nyu8-auth0.admin.client_id_label'),
    })
    .registerSetting({
      setting: 'nyu8-auth0.client_secret',
      type: 'text',
      label: app.translator.trans('nyu8-auth0.admin.client_secret_label'),
    })
    .registerSetting({
      setting: 'nyu8-auth0.login_button_title',
      type: 'text',
      label: app.translator.trans('nyu8-auth0.admin.login_button_title_label'),
      help: app.translator.trans('nyu8-auth0.admin.login_button_title_help', {
        default: app.translator.trans(
          'nyu8-auth0.admin.login_button_title_default',
        ),
      }),
    })
    .registerSetting({
      setting: 'nyu8-auth0.hide_password_login',
      type: 'boolean',
      label: app.translator.trans('nyu8-auth0.admin.hide_password_login_label'),
    });
});
