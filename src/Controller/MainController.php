<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.12.19
 * Time: 9:55
 */

namespace App\Controller;

use App\Service\UtilService;

class MainController
{
    private $service;

    public function __construct(UtilService $service)
    {
        $this->service = $service;
    }

    public function index()
      {
          return $this->service->foo();
      }
}