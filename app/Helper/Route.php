<?php

declare(strict_types=1);

namespace App\Helper;

use Air\Core\Exception\ClassWasNotFound;
use Air\Core\Exception\DomainMustBeProvided;
use Air\Core\Front;
use App\Model\Article;

class Route
{
  /**
   * @param array $route
   * @param array $params
   * @param bool $onlyUri
   * @return string
   * @throws ClassWasNotFound
   * @throws DomainMustBeProvided
   */
  public static function assemble(array $route = [], array $params = [], bool $onlyUri = true): string
  {
    $url = trim(Front::getInstance()->getRouter()->assemble($route, $params, true, $onlyUri));
    if (str_ends_with($url, '?')) {
      $url = substr($url, 0, strlen($url) - 1);
    }
    return $url;
  }

  /**
   * @param string $phone
   * @return string
   */
  public static function tel(string $phone): string
  {
    return "tel:" . $phone;
  }

  /**
   * @param string $email
   * @return string
   */
  public static function email(string $email): string
  {
    return "mailto:" . $email;
  }

  /**
   * @return string
   * @throws ClassWasNotFound
   * @throws DomainMustBeProvided
   */
  public static function home(): string
  {
    return self::assemble();
  }
}