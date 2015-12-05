<?php

namespace App\Migrations;

use App\Models\Role;
use App\Models\User;
use App\Modules\News\Models\Topic;
use App\Modules\News\Models\Story;
use T4\Orm\Migration;

class m_0000000001_CreateWebApp
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('__blocks')) {
            $this->createTable('__blocks', [
                    'section'   => ['type'=>'int'],
                    'path'      => ['type'=>'string'],
                    'template'  => ['type'=>'string'],
                    'options'   => ['type'=>'text'],
                    'order'     => ['type'=>'int'],
                ], [
                    ['columns'=>['section']],
                    ['columns'=>['order']],
                ]
            );
        };

        if (!$this->existsTable('__users')) {

            $this->createTable('__users', [
                'email' => ['type' => 'string'],
                'password' => ['type' => 'string'],
            ], [
                ['columns' => ['email']],
            ]);


            $this->createTable('__user_roles', [
                'name' => ['type' => 'string'],
                'title' => ['type' => 'string'],
            ], [
                ['type' => 'unique', 'columns' => ['name']]
            ]);

            $this->createTable('__user_roles_to___users', [
                '__user_id' => ['type' => 'link'],
                '__role_id' => ['type' => 'link'],
            ]);

            $this->createTable('users_data', [
                'name'     => ['type'=>'string'],
                'text'  => ['type'=>'text'],
                '__user_id'  => ['type'=>'link'],


            ], [
                ['columns' => ['name']],
            ]);

            $this->createTable('news_topics', [
                'title' => ['type'=>'string']
            ], [

            ], [
                'tree'
            ]);


            $this->createTable('news_stories', [
                'title' => ['type'=>'string', 'length' => 1024],
                'published' => ['type'=>'datetime'],
                'image' => ['type'=>'string'],
                'lead' => ['type'=>'text'],
                'text' => ['type'=>'text'],
                '__topic_id' => ['type'=>'link'],
                '__user_id' => ['type'=>'link'],
            ], [
                'topic'=>['columns'=>['__topic_id']],
                'user'=>['columns'=>['__user_id']]
            ]);

            $this->createTable('site_images', [
                    'title' => ['type' => 'string'],
                    'image' => ['type' => 'string'],
                    'doc' => ['type' => 'string'],
                    'published' => ['type' => 'datetime'],
                    '__service_id' => ['type' => 'link'],
                    '__trainer_id' => ['type' => 'link'],
                    '__student_id' => ['type' => 'link'],
                    '__org_id' => ['type' => 'link'],
                    '__story_id' => ['type' => 'link'],
                    '__userdata_id' => ['type' => 'link'],
                ]
            );

            $rubric=new Topic();
            $rubric->title="Новости";
            $rubric->save();

            $rubric=new Topic();
            $rubric->title="Блог";
            $rubric->save();

            $role1 = new Role();
            $role1->name = 'director';
            $role1->title = 'Директор';
            $role1->save();

            $role2 = new Role();
            $role2->name = 'trainer';
            $role2->title = 'Тренер';
            $role2->save();

            $role = new Role();
            $role->name = 'admin';
            $role->title = 'Администратор';
            $role->save();

            $user = new User();
            $user->email = 'admin@t4.org';
            $user->password = \T4\Crypt\Helpers::hashPassword('Supervisor123');
            $user->roles->append($role);
            $user->save();




            $this->createTable('__user_sessions', [
                'hash'          => ['type'=>'string'],
                '__user_id'     => ['type'=>'link'],
                'userAgentHash' => ['type'=>'string'],
            ], [
                'hash'  => ['columns'=>['hash']],
                'user'  => ['columns'=>['__user_id']],
                'ua'    => ['columns'=>['userAgentHash']],
            ]);

        }

    }

    public function down()
    {
        $this->dropTable('__user_sessions');
        $this->dropTable('__user_roles_to___users');
        $this->dropTable('__user_roles');
        $this->dropTable('__users');
        $this->dropTable('users_data');

        $this->dropTable('__blocks');
    }

}