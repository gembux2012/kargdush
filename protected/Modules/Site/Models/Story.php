<?php

namespace App\Modules\Site\Models;

use App\Modules\Site\Models\SiteImage;
use T4\Core\Exception;
use T4\Fs\Helpers;
use T4\Http\Uploader;
use T4\Mvc\Application;
use T4\Orm\Model;

class Story
    extends Model
{
    static protected $schema = [
        'table' => 'news_stories',
        'columns' => [
            'title' => ['type'=>'string'],
            'published' => ['type'=>'datetime'],
            'image' => ['type'=>'string', 'default'=>''],
            'lead' => ['type'=>'text'],
            'text' => ['type'=>'text'],
        ],
        'relations' => [
            'topic' => ['type'=>self::BELONGS_TO, 'model'=>Topic::class],
            'photo' => ['type'=>self::BELONGS_TO, 'model'=>SiteImage::class],
        ]
    ];
 }