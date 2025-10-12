<?php

use App\Core\App;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/helpers.php';

$app = App::init();

$router = $app->router();

require __DIR__ . '/../routes/web.php';

return $app;
