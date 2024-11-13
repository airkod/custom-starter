<?php
require_once __DIR__ . '/../vendor/autoload.php';

$env = getenv('AIR_ENV') ?: 'live';

if ($env === 'dev') {
  $config = array_replace_recursive(
    require_once __DIR__ . '/../config/live.php',
    require_once __DIR__ . '/../config/dev.php'
  );
} else {
  $config = require_once __DIR__ . '/../config/live.php';
}

echo \Air\Core\Front::getInstance($config)
  ->bootstrap()
  ->run();