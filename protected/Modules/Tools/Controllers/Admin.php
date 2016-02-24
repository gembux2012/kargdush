<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 23.02.16
 * Time: 14:19
 */

namespace App\Modules\Tools\Controllers;


use App\Modules\Site\Models\Story;
use T4\Mvc\Controller;



class Admin
    extends Controller

{
    public function actionDefault()
    {
        $this->data->news=Story::findAllByQuery('SELECT * FROM news_stories WHERE published < DATE_SUB(CURDATE(),INTERVAL 12 MONTH )')->count();
    }

}