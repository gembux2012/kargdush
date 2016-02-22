<?php

namespace App\Modules\Site\Controllers;


use App\Components\Admin\Controller;
use App\Modules\Site\Models\Org;
use App\Modules\Site\Models\Service;
use App\Modules\Site\Models\Student;
use App\Modules\Site\Models\SiteImage;
use App\Modules\Site\Models\SiteDoc;
use App\Modules\Site\Models\TimeTable;
use App\Modules\Site\Models\Trainer;
use App\Modules\Site\Module;
use T4\Core\Collection;
use App\Models\UserData;
use T4\Core\Std;

class Admin
    extends Controller
{
  public function actionServices()
  {
    $this->data->items=Service::findAll();
    $m=new Module();
      $n=$m->getAdminMenu();
      var_dump($n[0]['sub'][5]);die;
  }

    public function actionServiceEdit($id = 'new')
    {
        if('new' == $id){
            $this->data->item=new Service();
        } else {
            $this->data->item = Service::findByPK($id);
            $this->data->trainers = UserData::findAllByQuery('SELECT * FROM users_data WHERE __user_id
                                                IN (SELECT  __user_id FROM __user_roles_to___users WHERE __role_id
                                                IN (SELECT __id  FROM __user_roles WHERE name = "trainer"))');
            $this->data->students = Student::findAll();
        }

    }

    public function actionSave()
    {
        if (!empty($this->app->request->post->id)) {
            $item = Service::findByPK($this->app->request->post->id);

            if (isset($this->app->request->post->trainer)) {
                $item->userdata = new Collection();
                foreach ($this->app->request->post->trainer as $id) {
                    $submodel = UserData::FindByPk($id);
                    $item->userdata->append($submodel);
                }
            } else {
                for ($i = 0; $item->userdata->count(); $i++) {
                    unset($item->userdata[$i]);
                }
            }

            if (isset($this->app->request->post->students)) {
                $item->student = new Collection();
                foreach ($this->app->request->post->students as $id) {
                    $submodel = Student::FindByPk($id);
                    $item->student->append($submodel);
                }
            } else {
                for ($i = 0; $item->student->count(); $i++) {
                    unset($item->student[$i]);
                }
            }
        } else {
            $item = new Service();
        }

        $item->fill($this->app->request->post);
        if (!isset($this->app->request->post->paid)) {
            $item->paid=0;
        }
        $item->save();
        $this->redirect('/admin/site/services');

    }

    public function actionServiceDeLete($id)
    {
        $item=Service::findByPK($id);
        $item->delete();
        $item->save();
        $this->redirect('/admin/site/services');
    }

    public  function actionPhotoDelete($id)
    {
        $item=SiteImage::findByPK($id);
        $service=SiteImage::findByPK($id)->service;
        $item->delete();
        $this->redirect('/admin/site/ServiceEdit/?id='.$service->Pk);


    }

    public  function actionPhotoEdit($id)
    {
        $this->data->item=SiteImage::findByPK($id);
    }

    public  function actionPhotoSave()
    {
        $item=SiteImage::findByPK($this->app->request->post->id);
        $item->title=$this->app->request->post->title;
        $item->save();
        $this->redirect('/admin/site/ServiceEdit/?id='.$item->service->Pk);

    }

    ///trainer

    public function actionTrainers()
    {
        $this->data->items=UserData::findAllByQuery('SELECT * FROM users_data WHERE __user_id
                                                IN (SELECT  __user_id FROM __user_roles_to___users WHERE __role_id
                                                IN (SELECT __id  FROM __user_roles WHERE name = "trainer"))');
    }

    public function actionTrainerEdit($id = 'new')
    {
           $this->data->item = UserData::findByPK($id);
            $this->data->students = Student::findAll();
    }

    public function actionTrainerSave()
    {
            $item = UserData::findByPK($this->app->request->post->id);

            if (isset($this->app->request->post->students)) {
                $item->student = new Collection();
                foreach ($this->app->request->post->students as $id) {
                    $submodel = Student::FindByPk($id);
                    $item->student->append($submodel);
                }
            } else {
                for ($i = 0; $item->student->count(); $i++) {
                    unset($item->student[$i]);
                }
            }


        $item->fill($this->app->request->post);
        $item->save();
        $this->redirect('/admin/site/trainers');

    }

    public function actionTrainerDeLete($id)
    {
        $item=Service::findByPK($id);
        $item->delete();
        $item->save();
        $this->redirect('/admin/site/services');
    }

    public  function actionTrainerPhotoDelete($id)
    {
        $item=SiteImage::findByPK($id);
        $service=SiteImage::findByPK($id)->service;
        $item->delete();
        $this->redirect('/admin/site/ServiceEdit/?id='.$service->Pk);


    }



    public  function actionTrainerPhotoSave()
    {
        $item=SiteImage::findByPK($this->app->request->post->id);
        $item->title=$this->app->request->post->title;
        $item->save();
        $this->redirect('/admin/site/ServiceEdit/?id='.$item->service->Pk);

    }

    ////student

    public function actionStudents()
    {
        $this->data->items=Student::findAll();
    }

    public function actionStudentEdit($id = 'new')
    {
        if('new' == $id){
            $this->data->item=new Student();
        } else {

            $this->data->item = Student::findByPK($id);
        }

    }

    public function actionStudentSave()
    {
        if (!empty($this->app->request->post->id)) {
            $item = Student::findByPK($this->app->request->post->id);

            } else {
            $item = new Student();
        }

        $item->fill($this->app->request->post);
        $item->save();
        $this->redirect('/admin/site/Students');

    }

    public function actionStudentDeLete($id)
    {
        $item=Student::findByPK($id);
        $item->delete();
        $item->save();
        $this->redirect('/admin/site/Students');
    }

    public  function actionStudentPhotoDelete($id)
    {
        $item=SiteImage::findByPK($id);
        $student=SiteImage::findByPK($id)->student;
        $item->delete();
        $this->redirect('/admin/site/StudentEdit/?id='.$student->Pk);


    }

        public  function actionStudentPhotoSave()
    {
        $item=SiteImage::findByPK($this->app->request->post->id);
        $item->title=$this->app->request->post->title;
        $item->save();
        $this->redirect('/admin/site/ServiceEdit/?id='.$item->service->Pk);

    }

    ///org
    public  function actionOrg()
    {
        $this->data->item=Org::findByPK(1);
        $this->data->director=UserData::findByQuery('SELECT * FROM users_data WHERE __user_id
                                                IN (SELECT  __user_id FROM __user_roles_to___users WHERE __role_id
                                                IN (SELECT __id  FROM __user_roles WHERE name = "director"))');


    }

    public  function actionDocEdit($id)
    {
        $this->data->item=SiteDoc::findByPK($id);

    }

    public  function actionOrgSave()
    {
        $org=Org::findByPK($this->app->request->post->id);
        $org->fill($this->app->request->post);
        $org->save();

        if(isset($this->app->request->post->direct_id)) {
            $director = UserData::findByPK($this->app->request->post->direct_id);
            $director->text = $this->app->request->post->direct_about;
            $director->save();
        }
        $this->redirect('/admin');

    }



    public  function actionDocSave()
    {
        $item=SiteDoc::findByPK($this->app->request->post->id);
        $item->title=$this->app->request->post->title;
        $item->save();
        $this->redirect('/admin/site/org');

    }

    public  function actionDocDelete($id)
    {
        $item=SiteDoc::findByPK($id);
        $item->delete();
        $this->redirect('/admin/site/org');


    }

    public  function actionTimeTable()
    {
       /* $services=Service::findAll();
        foreach($services as  $service){
            $tt=new TimeTable();
            //var_dump($service->__id);die;
            $tt->services=$service->Pk;
            $tt->save();
        }
       */
        $this->data->items=TimeTable::findAll();
    }

    public  function actionSetTimeTable()
    {
        $item=TimeTable::findByPK($this->app->request->post->pk);
        $item->{$this->app->request->post->name}=$this->app->request->post->value;
        $item->save();
        die;
    }


}