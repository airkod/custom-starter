<?php

return [
  'env' => 'live',
  'air' => [
    'modules' => '\\App\\Module',
    'exception' => false,
    'phpIni' => [
      'display_errors' => '0',
    ],
    'startup' => [
      'error_reporting' => 0,
      'date_default_timezone_set' => 'Europe/Kyiv',
    ],
    'loader' => [
      'path' => realpath(dirname(__FILE__)) . '/../app',
      'namespace' => 'App',
    ],
    'db' => [
      'driver' => 'mongodb',
      'servers' => [[
        'host' => 'localhost',
        'port' => 27017,
      ]],
      'db' => getenv('AIR_DB_DB')
    ],
    'storage' => [
      'route' => '_storage',
      'url' => getenv('AIR_FS_URL'),
      'key' => getenv('AIR_FS_KEY'),
    ],
    'logs' => [
      'enabled' => true,
      'exception' => true,
      'route' => '_logs',
    ],
    'fontsUi' => 'fontsUi',
    'admin' => [
      'title' => 'Execrot',
      'logo' => '/assets/ui/images/logo.png',
      'favicon' => '/assets/ui/images/favicon.ico',
      'manage' => '_admin',
      'history' => '_adminHistory',
      'system' => '_system',
      'fonts' => '_fonts',
      'codes' => '_codes',
      'robotsTxt' => '_robotsTxt',
      'notAllowed' => '_notAllowed',
      'rich-content' => [
        'file', 'files', 'text', 'embed', 'quote', 'html'
      ],
      'auth' => [
        'route' => '_auth',
        'cookieName' => 'authIdentity',
        'source' => 'database',
        'root' => [
          'login' => getenv('AIR_ADMIN_AUTH_ROOT_LOGIN'),
          'password' => getenv('AIR_ADMIN_AUTH_ROOT_PASSWORD'),
        ]
      ],
      'tiny' => getenv('AIR_ADMIN_TINY_KEY'),
      'menu' => require_once 'nav.php',
      'locale' => 'en'
    ]
  ],
  'router' => [
    'cli' => [
      'module' => 'cli'
    ],
    'admin.*' => [
      'module' => 'admin',
      'air' => [
        'asset' => [
          'underscore' => false,
          'prefix' => '/assets/air',
        ],
      ]
    ],
    '*' => [
      'strict' => true,
      'module' => 'ui',
      'routes' => require_once 'routes.php',
      'prefix' => '/:language',
      'air' => [
        'view' => [
          'minify' => true,
        ],
        'cache' => [
          'enabled' => false,
        ],
        'asset' => [
          'underscore' => false,
          'prefix' => '/assets/ui',
        ],
      ]
    ],
  ],
];
