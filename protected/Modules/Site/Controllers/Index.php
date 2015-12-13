<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.10.15
 * Time: 8:14
 */

namespace App\Modules\Site\Controllers;


use App\Modules\Site\Models\Service;
use App\Modules\Site\Models\Org;
use App\Modules\Site\Models\Student;
use App\Modules\Site\Models\Trainer;
use App\Models\UserData;
use T4\Mvc\Controller;


class Index
    extends Controller
{
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


}