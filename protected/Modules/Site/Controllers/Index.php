<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.10.15
 * Time: 8:14
 */

namespace App\Modules\Site\Controllers;


use App\Modules\Site\Models\Review;
use App\Modules\Site\Models\Service;
use App\Modules\Site\Models\Org;
use App\Modules\Site\Models\Student;
use App\Modules\Site\Models\TimeTable;
use App\Modules\Site\Models\Trainer;
use App\Models\UserData;
use T4\Mvc\Controller;


class Index
    extends Controller
{
    const PAGE_SIZE=10;
    public function actionServices()
    {
        $this->data->items=Service::findAll(['where'=>'paid=0']);
        $this->data->itemspaid=Service::findAll(['where'=>'paid=1']);

    }

    public function actionService($id)
    {
        $this->data->item=Service::findByPK($id);
    }

    public function actionTrainer($id)
    {
       $this->data->item=UserData::findByPK($id);
    }

    public function actionPaidServices()
    {
        $this->data->items=Service::findAllByTitle(['where'=>'paid'==0]);

    }



    public function actionOrg()
    {
        $this->data->item=Org::findByPK(1);
        $this->data->director=UserData::findByQuery('SELECT * FROM users_data WHERE __user_id
                                                IN (SELECT  __user_id FROM __user_roles_to___users WHERE __role_id
                                                IN (SELECT __id  FROM __user_roles WHERE name = "director"))');

    }

    public function actionTrainers()
    {
        $this->data->items=UserData::findAllByQuery('SELECT * FROM users_data WHERE __user_id
                                                IN (SELECT  __user_id FROM __user_roles_to___users WHERE __role_id
                                                IN (SELECT __id  FROM __user_roles WHERE name = "trainer"))');
    }

    public function actionStudents()
    {
        $this->data->student=Student::findAll();

    }

    public function actionStudent($id)
    {
        $this->data->item=Student::findByPK($id);

    }

    public function actionTimeTable()
    {
        $this->data->items=TimeTable::findAll();
    }

    public function actionReviews($page=1)
    {
       $this->data->itemsCount=Review::findAll()->count();
        $this->data->items=Review::findAll();
        $this->data->items = Review::findAll([
            'offset' => ($page - 1) * self::PAGE_SIZE,
            'limit' => self::PAGE_SIZE,
            'order by' => 'desk',

        ]);
        $this->data->activePage = $page;
        $this->data->pageSize = self::PAGE_SIZE;
    }

    public function actionReviewsSave()
    {
        $item=new Review();
        $item->text=$this->app->request->post->text;
        $item->publiched=date('Y-m-d H:i:s', time());;
        $item->save();
        $this->redirect('/Site/Reviews');

    }


}