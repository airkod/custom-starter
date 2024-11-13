<?php

declare(strict_types=1);

namespace App\Module\Ui\Controller;

use Air\Core\Controller;
use Air\Core\Exception\ClassWasNotFound;
use Air\Model\Exception\CallUndefinedMethod;
use Air\Model\Exception\ConfigWasNotProvided;
use Air\Model\Exception\DriverClassDoesNotExists;
use Air\Model\Exception\DriverClassDoesNotExtendsFromDriverAbstract;
use Air\Model\Meta\Exception\PropertyWasNotFound;
use App\Model\GeneralMeta;

abstract class Base extends Controller
{
  /**
   * @return void
   * @throws CallUndefinedMethod
   * @throws ClassWasNotFound
   * @throws ConfigWasNotProvided
   * @throws DriverClassDoesNotExists
   * @throws DriverClassDoesNotExtendsFromDriverAbstract
   * @throws PropertyWasNotFound
   */
  public function postRun(): void
  {
    parent::postRun();

    if (!$this->getView()->getDefaultMeta()) {
      $this->getView()->setDefaultMeta(function () {
        return GeneralMeta::one()->meta;
      });
    }

    if ($this->getRequest()->isAjax()) {
      $this->getView()->setLayoutEnabled(false);

      $this->getResponse()->setHeader('title', json_encode(
        $this->getView()->getMeta()->getComputedData()['title']
      ));
    }
  }
}