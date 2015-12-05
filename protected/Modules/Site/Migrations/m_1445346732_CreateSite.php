<?php

namespace App\Modules\Site\Migrations;

use T4\Orm\Migration;
use App\Modules\Site\Models\Org;

class m_1445346732_CreateSite
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('services'))
        {
            $this->createTable('services', [
                'title'     => ['type'=>'string'],
                'text'  => ['type'=>'text'],

            ], [
                ['columns' => ['title']],

            ]);
        }

        if (!$this->existsTable('trainers'))
        {
            $this->createTable('trainers', [
                'name'     => ['type'=>'string'],
                'text'  => ['type'=>'text'],
            ], [
                ['columns' => ['name']],
            ]);

        }

        if (!$this->existsTable('students'))
        {
            $this->createTable('students', [
                'name'     => ['type'=>'string'],
                'text'  => ['type'=>'text'],
                '__trainer_id' => ['type'=>'link'],
                '__service_id' => ['type'=>'link'],


            ], [
                ['columns' => ['name']],
            ]);
        }

        if (!$this->existsTable('org'))
        {
            $this->createTable('org', [
                'title_short'     => ['type'=>'string'],
                'title'     => ['type'=>'string'],
                'address'   => ['type' => 'string'],
                'email'   => ['type' => 'string'],
                'phone'   => ['type' => 'string'],
                'text'  => ['type'=>'text'],
                'direct_name'   => ['type' => 'string'],
                'direct_about'   => ['type' => 'text'],
            ], [
                ['columns' => ['title']],
            ]);

            $this->createTable('site_docs', [
                    'title' => ['type' => 'string'],
                    'doc' => ['type' => 'string'],
                    '__org_id' => ['type' => 'link'],
                ]
            );
        }

        $org=new Org();
        $org->save();


        if (!$this->existsTable('students_to_trainers'))
        {
            $this->createTable('students_to_trainers', [
                '__trainer_id' => ['type' => 'link'],
                '__student_id' => ['type' => 'link'],
            ]);
        }

        if (!$this->existsTable('blogs'))
        {
            $this->createTable('blogs', [
                'name'     => ['type'=>'string'],
                'text'  => ['type'=>'text'],
                'published' => ['type' => 'datetime'],
                '__trainer_id' => ['type'=>'link'],

            ], [
                ['columns' => ['name']],
            ]);
        }







    }

    public function down()
    {
    }

}