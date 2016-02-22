<?php

namespace App\Modules\Admin\Controllers;

use App\Components\Admin\Controller;
use T4\Core\Exception;
use T4\Http\E404Exception;
use T4\Mvc\Route;
use T4\Mvc\Router;

class Index
    extends Controller
{

    public function actionDefault()
    {
        $this->data->diskfree=disk_free_space("/home/alex/domains")/1024/1024/1024;

    }

    public function actionModule($module, $controller = 'Admin', $action = Router::DEFAULT_ACTION)
    {
        try {

            $this->app->runRoute(
                new Route('/' . ucfirst($module) . '/' . ucfirst($controller) . '/' . ucfirst($action)),
                Router::getInstance()->getFormatByExtension($this->app->request->extension)
            );
            exit;

        } catch (Exception $e) {

            throw new E404Exception('Ошибка админ-панели в модуле ' . $module . ': ' . $e->getMessage());

        }
    }

}