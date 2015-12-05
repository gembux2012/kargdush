<?php

namespace App\Modules\Site\Migrations;

use T4\Orm\Migration;

class m_1447946898_CreateStudentsToUserData
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('students_to_users_data'))
        {
            $this->createTable('students_to_users_data', [
                '__student_id' => ['type' => 'link'],
                '__userdata_id' => ['type' => 'link'],
            ]);

        }
    }

    public function down()
    {
        $this->dropTable('students_to_users_data');
    }

}