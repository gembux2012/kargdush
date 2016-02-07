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
                'pn' => ['type' => 'string' ],
                'vt' => ['type' => 'string'],
                'sr' => ['type' => 'string'],
                'cht' => ['type' => 'string'],
                'pt' => ['type' => 'string'],
                'sb' => ['type' => 'string'],
                'vs' => ['type' => 'string'],
                '__service_id' => ['type' => 'link'],
            ]);

        }
    }

    public function down()
    {
        $this->dropTable('timetables');
    }

}