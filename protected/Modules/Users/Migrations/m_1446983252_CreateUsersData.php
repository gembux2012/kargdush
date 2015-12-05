<?php

namespace App\Modules\Users\Migrations;

use T4\Orm\Migration;

class m_1446983252_CreateUsersData
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('users_data'))
        {
            $this->createTable('users_data', [
                'name'     => ['type'=>'string'],
                'text'  => ['type'=>'text'],
                '__users'  => ['type'=>'link'],
            ], [
                ['columns' => ['name']],
            ]);

        }
    }

    public function down()
    {
    }

}