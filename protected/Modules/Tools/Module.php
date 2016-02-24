<?php
namespace App\Modules\Site;

class Module
    extends \App\Components\Module
{

    public function getAdminMenu()
    {
        return  [


            ['title' => 'Tools', 'icon' => '<i class="glyphicon glyphicon-th-list"></i>', 'sub' => [
                ['title' => 'Очистка баз', 'url' => '/admin/Tools'],


            ]],
        ];

    }

}