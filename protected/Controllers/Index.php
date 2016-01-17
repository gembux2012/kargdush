<?php

namespace App\Controllers;

use App\Modules\Site\Models\Org;
use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionDefault()
    {
     $this->data->useradmin=$this->app->user->hasRole('admin');

    }

    public function actionHeader()
    {
        $this->data->item=Org::findByPK(1);
    }

    public function actionFooter()
    {
        $this->data->item=Org::findByPK(1);
    }




    public function action404()
    {
    }

    public function actionCaptcha($config = null)
    {
        if (null !== $config) {
            $config = $this->app->config->extensions->captcha->$config;
        }
        $this->app->extensions->captcha->generateImage($config);
        die;
    }

}
