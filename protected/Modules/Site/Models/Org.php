<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.09.15
 * Time: 16:58
 */

namespace App\Modules\Site\Models;
use T4\Orm\Model;


class Org
    extends Model

{
    static protected $schema = [

        'table' => 'org',
        'columns' => [
            'title_short' => ['type' => 'string'],
            'title' => ['type' => 'string'],
            'email' => ['type' => 'string'],
            'address' => ['type' => 'string'],
            'phone' => ['type' => 'string'],
            'text' => ['type' => 'text'],
            'direct_name' => ['type' => 'string'],
            'direct_about' => ['type' => 'text'],
        ],
        'relations' => [
            'photo' =>['type' => self::HAS_MANY, 'model' =>SiteImage::class],
            'doc' =>['type' => self::HAS_MANY, 'model' =>SiteDoc::class]
            ]

    ];
}