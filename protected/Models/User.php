<?php

namespace App\Models;

use App\Modules\News\Models\Story;
use T4\Orm\Model;

/**
 * Class User
 * @package App\Models
 * @property string $email
 * @property string $password
 * @property \T4\Core\Collection|\App\Models\Role[] $roles
 */
class User
    extends Model
{
    protected static $schema = [
        'table' => '__users',
        'columns' => [
            'email'     => ['type'=>'string'],
            'password'  => ['type'=>'string'],
        ],
        'relations' => [
            'roles' => ['type' => self::MANY_TO_MANY, 'model' => Role::class],
            'userdata' => ['type' => self::HAS_ONE, 'model' => UserData::class],
            'story' => ['type' => self::HAS_MANY, 'model' => Story::class],

        ]
    ];

    public function getRoleNames()
    {
        return $this->roles->collect('name');
    }

    public function hasRole($roleName)
    {
        return in_array($roleName, $this->getRoleNames());
    }

}