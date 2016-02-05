<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 03.02.16
 * Time: 7:43
 */

namespace App\Modules\Site\Models;


use T4\Orm\Model;

class TimeTable
    extends Model
{
    static protected $schema = [

        'columns' => [
            'service' => ['type' => 'string'],
            'pn' => ['type' => 'string'],
            'vt' => ['type' => 'string'],
            'sr' => ['type' => 'string'],
            'cht' => ['type' => 'string'],
            'pt' => ['type' => 'string'],
            'sb' => ['type' => 'string'],
            'vs' => ['type' => 'string'],

        ],

        'relations' => [
            
            'services' => ['type' => self::BELONGS_TO, 'model' =>Service::class],


        ]
    ];

}