<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.12.19
 * Time: 9:15
 */

namespace App\Util;

class Container
{
    private static $selfInstance;

    protected static $container;

    protected $services;

    protected function __wakeUp()
    {
        throw new \Exception("Call unserialize on singleton");
    }

    public function __clone(){}

    public static function getInstance()
    {
        if (!self::$selfInstance) {
           self::$selfInstance = new static;
        }
        return self::$selfInstance;
    }

    protected function __construct() {}

    public static function getContainer()
    {
        return self::$container;
    }

    public function init()
      {
          $services = require_once "config/container.php";

          $container = self::$container ?? [];

          foreach ($services as $service) {
              if (!array_key_exists($service, $container)) {
                  $container[$service] = new $service;
              }
          }

          self::$container = $container;

      }
}