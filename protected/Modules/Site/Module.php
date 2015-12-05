<?php
namespace App\Modules\Site;

class Module
    extends \App\Components\Module
{

    public function getAdminMenu()
    {
        return  [
            ['title' => 'Организация', 'icon' => '<i class="glyphicon glyphicon-th-list"></i>', 'sub' => [
                ['title' => 'Данные организация', 'url' => '/admin/Site/Org'],
                ['title' => 'Секции ', 'url' => '/admin/site/services'],
                ['title' => 'Тренеры ', 'url' => '/admin/site/trainers'],
                ['title' => 'Ученики', 'url' => '/admin/site/Students'],
            ]],
        ];

    }

}