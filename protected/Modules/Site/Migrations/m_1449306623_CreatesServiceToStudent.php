<?php

namespace App\Modules\Site\Migrations;

use T4\Orm\Migration;

class m_1449306623_CreatesServiceToStudent
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('services_to_students'))
        {
            $this->createTable('services_to_students', [
                '__student_id' => ['type' => 'link'],
                '__service_id' => ['type' => 'link'],
            ]);

        }
    }

    public function down()
    {
        $this->dropTable('students_to_users_data');
    }

}