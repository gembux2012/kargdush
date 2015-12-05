<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 02.11.15
 * Time: 18:45
 */

namespace App\Modules\Site\Models;


use T4\Orm\Model;
use T4\Fs\Helpers;

class SiteDoc
    extends Model
{
    static protected $schema = [
        'table' => 'site_docs',
        'columns' => [
            'title' => ['type' => 'string', 'default' => ''],
            'doc' => ['type' => 'string'],
        ],
        'relations' => [
            'org' => ['type' => self::BELONGS_TO, 'model' => Org::class],
        ]
    ];


}