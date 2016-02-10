<?php

namespace App\Controllers;

use App\Modules\Site\Models\Org;
use T4\Mvc\Controller;
use App\Modules\News\Models\Topic;
use App\Modules\News\Models\Story;

class Index
    extends Controller
{

    public function actionDefault()
    {
     if($this->app->user)
        $this->data->useradmin=$this->app->user->hasRole('admin');
        //var_dump($this->app->user->roles[0]->title);die;

    }

    public function actionHeader()
    {
        $this->data->item=Org::findByPK(1);
    }

    public function actionFooter()
    {
        $item = Topic::findByPk(2);
        $lft=$item->__lft;
        $rgt=$item->__rgt;
        $this->data->item=Org::findByPK(1);
        $this->data->blog=Story::findByQuery('SELECT * FROM news_stories  WHERE __topic_id
            IN (SELECT __id FROM news_topics WHERE __lft >='.$lft.' AND __rgt <= '.$rgt.' ) AND published IS NOT NULL  ORDER BY published DESC LIMIT 1' );
        //var_dump()
    }

    public function actionZoom()
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
