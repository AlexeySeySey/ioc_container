<?php

require __DIR__.'/vendor/autoload.php';

App\Util\Container::getInstance()->init();
(new App\Web\Router)->init();

