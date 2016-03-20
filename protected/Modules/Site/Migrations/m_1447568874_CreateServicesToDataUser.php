<?php

namespace App\Modules\Site\Migrations;

use T4\Orm\Migration;

class m_1447568874_CreateServicesToDataUser
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('services_to_userdata'))
        {
            $this->createTable('services_to_userdata', [
                '__userdata_id' => ['type' => 'link'],
                '__service_id' => ['type' => 'link'],
            ]);

        }
    }

    public function down()
    {
        $this->dropTable('services_to_userdata');
    }

}