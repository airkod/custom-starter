<?php

declare(strict_types=1);

namespace App\Module\Ui\Controller;

use Air\Core\ErrorController;
use Air\Core\Exception\ClassWasNotFound;
use Air\Core\Front;
use Air\Log;
use Air\Model\Exception\CallUndefinedMethod;
use Air\Model\Exception\ConfigWasNotProvided;
use Air\Model\Exception\DriverClassDoesNotExists;
use Air\Model\Exception\DriverClassDoesNotExtendsFromDriverAbstract;

class Error extends ErrorController
{
  /**
   * @return array|void
   * @throws ClassWasNotFound
   * @throws CallUndefinedMethod
   * @throws ConfigWasNotProvided
   * @throws DriverClassDoesNotExists
   * @throws DriverClassDoesNotExtendsFromDriverAbstract
   */
  public function index()
  {
    $request = $this->getRequest();
    $exception = $this->getException();

    if ($request->isAjax()) {
      $this->getView()->setLayoutEnabled(false);
    }

    $this->getResponse()->setStatusCode($exception->getCode() ?? 500);

    $config = [
      ...['enabled' => false, 'exception' => false, 'route' => '_logs',],
      ...Front::getInstance()->getConfig()['air']['logs'] ?? []
    ];

    if ($config['exception'] === true) {
      Log::error($exception->getMessage(), [
        'ip' => $request->getIp(),
        'user-agent' => $request->getUserAgent(),
        'trace' => $exception->getTrace(),
        'code' => $this->getResponse()->getStatusCode(),
        'params' => [
          'get' => $request->getGetAll(),
          'post' => $request->getPostAll(),
        ],
      ]);
    }

    if (Front::getInstance()->getConfig()['air']['exception'] ?? false) {
      return [
        'message' => $exception->getMessage(),
        'trace' => $exception->getTrace()
      ];
    }
  }
}
