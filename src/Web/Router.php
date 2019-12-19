<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.12.19
 * Time: 9:12
 */

namespace App\Web;

use App\Util\Container;

class Router
{
    protected $containerInstance;

    public function __construct()
    {
        $this->containerInstance = Container::getContainer();
    }

    private function handler(array $info)
    {
        $controllerClass = $info['controller'];
        $controllerMethod = $info['method'];

        $class = sprintf("App\Controller\%s", $controllerClass);

        $reflector = new \ReflectionClass($class);
        $dependenciesToInject = [];
        foreach ($reflector->getConstructor()->getParameters() as $parameter) {
            $data = $parameter->getClass()->name;
            if (!is_null($data)) {
                $dependenciesToInject[] = $this->containerInstance[$data];
            }
        }

        $instance = new $class(...$dependenciesToInject);
        return $instance->$controllerMethod();
    }

    public function init()
    {
        switch ($_SERVER[REQUEST_URI]) {
            case "/":
                $this->handler([
                    'controller' => 'MainController',
                    'method' => 'index'
                ]);
                break;
            default:
                echo "Unknown path";
                break;
        }
    }
}