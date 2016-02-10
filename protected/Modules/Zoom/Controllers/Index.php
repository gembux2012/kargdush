<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 07.02.16
 * Time: 11:21
 */

namespace App\Modules\Zoom\Controllers;

use App\Modules\Site\Models\Service;
use T4\Mvc\Controller;
use App\Modules\Site\Models\Org;
use App\Modules\Site\Models\TimeTable;
use App\Models\UserData;
use App\Modules\News\Models\Topic;
use App\Modules\News\Models\Story;



class Index
    extends Controller
{
    public function actionDefault()
    {
        $this->data->item=Org::findByPK(1);

    }

    public function actionOrg()
    {
        $this->data->item=Org::findByPK(1);
        $this->data->director=UserData::findByQuery('SELECT * FROM users_data WHERE __user_id
                                                IN (SELECT  __user_id FROM __user_roles_to___users WHERE __role_id
                                                IN (SELECT __id  FROM __user_roles WHERE name = "director"))');

    }

    const PAGE_SIZE=20;

    public function actionNews()
    {
        $item = Topic::findByTitle('Новости');
        $lft=$item->__lft;
        $rgt=$item->__rgt;


        $this->data->items=Story::findAllByQuery('SELECT * FROM news_stories  WHERE __topic_id
            IN (SELECT __id FROM news_topics WHERE __lft >='.$lft.' AND __rgt <= '.$rgt.' ) AND published IS NOT NULL  ORDER BY published DESC LIMIT 20');

        $this->data->item=Org::findByPK(1);

    }

    public function actionServices(){
        $this->data->item=Org::findByPK(1);
        $this->data->items=Service::findAll();
    }

    public function actionTrainers()
    {
        $this->data->item=Org::findByPK(1);
        $this->data->items=UserData::findAllByQuery('SELECT * FROM users_data WHERE __user_id
                                                IN (SELECT  __user_id FROM __user_roles_to___users WHERE __role_id
                                                IN (SELECT __id  FROM __user_roles WHERE name = "trainer"))');
    }

    public function actionTimeTable()
    {
        $this->data->item=Org::findByPK(1);
        $this->data->items=TimeTable::findAll();
    }



}