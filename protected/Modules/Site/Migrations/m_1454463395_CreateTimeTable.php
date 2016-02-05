<?php

namespace App\Modules\Site\Migrations;

use T4\Orm\Migration;

class m_1454463395_CreateTimeTable
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('timetables'))
        {
            $this->createTable('timetables', [
                'service' => ['type' => 'string'],
                'pn' => ['type' => 'string', 'default'=>''],
                'vt' => ['type' => 'string', 'default'=>''],
                'sr' => ['type' => 'string', 'default'=>''],
                'cht' => ['type' => 'string','default'=>''],
                'pt' => ['type' => 'string','default'=>''],
                'sb' => ['type' => 'string','default'=>''],
                'vs' => ['type' => 'string','default'=>''],
                '__service_id' => ['type' => 'link'],
            ]);

        }
    }

    public function down()
    {
        $this->dropTable('timetable');
    }

}