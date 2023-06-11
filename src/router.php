<?php
function notFound()
{
    return include_once(ROOT_PATH . '/php/assets/html/404.html');
}

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$pathParts = explode('/', $path);
$route = array_shift($pathParts);

$controllers = [];
foreach (scandir(ROOT_PATH . '/controllers') as $file) {
    if (strpos($file, 'controller.php') !== false) {
        require_once(ROOT_PATH . '/controllers/' . $file);
        $className = ucfirst(str_replace('.controller.php', '', $file)) . 'Controller';
        $controllers[$className] = new $className();
    }
}

$controller;
$action;

switch ($route) {
    case '':
        echo 'home';
        break;
    case 'index.php':
        echo 'home';
        break;

    default:
        $class = ucfirst($route) . 'Controller';
        if (!array_key_exists($class, $controllers)) {
            notFound();
            break;
        }
        $controller = $controllers[$class];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $action = 'get';
                break;
            case 'POST':
                $action = 'post';
                break;
            case 'PUT':
                $action = 'put';
                break;
            case 'DELETE':
                $action = 'delete';
                break;
            default:
                echo 'other than GET, POST, PUT, DELETE';
                notFound();
                break;
        }

        if (!method_exists($controller, $action)) {
            echo 'method not found';
            notFound();
            break;
        }
        // print_r(var_dump($pathParts));
        $controller->$action($pathParts);
        break;
}
?>