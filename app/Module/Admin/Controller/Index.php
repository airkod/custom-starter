<?php

declare(strict_types=1);


use Air\Crud\Controller\AuthCrud;

class Index extends AuthCrud
{
  /**
   * @return void
   */
  public function index(): void
  {
    $this->redirect('/_system');
  }
}