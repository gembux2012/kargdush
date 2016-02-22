<?php

namespace App\Modules\Site\Migrations;

use T4\Orm\Migration;

class m_1455067440_CreateReviews
    extends Migration
{

    public function up()
    {

        if (!$this->existsTable('reviews'))
        {
            $this->createTable('reviews', [
                'publiched' => ['type' => 'datetime'],
                'text' => ['type' => 'text'],

            ]
             );
        }
    }

    public function down()
    {
        $this->dropTable('reviews');
    }

}