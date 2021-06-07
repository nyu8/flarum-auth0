<?php

use Flarum\Extend;

return [
  (new Extend\Frontend('forum'))
    ->js(__DIR__ . '/js/dist/forum.js'),
  (new Extend\Frontend('admin'))
    ->js(__DIR__ . '/js/dist/admin.js'),
];
