<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 10.02.16
 * Time: 7:42
 */

namespace App\Modules\Site\Models;
use T4\Orm\Model;


class Review
    extends Model

{
    static protected $schema = [

        'columns' => [
            'publiched' => ['type' => 'datetime'],
            'text' => ['type' => 'text'],

        ],

    ];
}