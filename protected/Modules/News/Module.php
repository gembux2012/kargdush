<?php

namespace App\Modules\News;

class Module
    extends \App\Components\Module
{

    public function getAdminMenu()
    {
        return [
            ['title' => 'Новости, рубрики блога', 'icon' => '<i class="glyphicon glyphicon-th-list"></i>', 'sub' => [
                ['title' => 'Рубрики', 'url' => '/admin/news/topics'],
                ['title' => 'Новости', 'url' => '/admin/news/'],
                ['title' => 'Блог', 'url' => '/admin/news/blog/'],
            ]],
        ];
    }

} 