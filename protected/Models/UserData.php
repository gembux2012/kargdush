<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 08.11.15
 * Time: 17:54
 */

namespace App\Models;


use App\Modules\Site\Models\Service;
use App\Modules\Site\Models\SiteImage;
use App\Modules\Site\Models\Student;
use T4\Orm\Model;

class UserData
    extends Model
{
    protected static $schema = [
        'table' => 'users_data',
        'columns' => [
            'name'     => ['type'=>'string'],
            'text'  => ['type'=>'text'],
        ],
        'relations' => [
            'user' => ['type' => self::BELONGS_TO, 'model' => User::class],
            'photo' => ['type' => self::HAS_MANY, 'model' => SiteImage::class],
            'service' => ['type' => self::MANY_TO_MANY, 'model' => Service::class],
            'student' => ['type' => self::MANY_TO_MANY, 'model' => Student::class],
        ]
    ];

    public function beforeDelete()
    {

        foreach($this->photo as $value){
            $item=SiteImage::FindByPk($value->Pk);
            $this->deleteImage($item);
            $item->delete();
        }


        return parent::beforeDelete();
    }

    public function deleteImage($item)
    {
        if ($item->image) {
            try {
                Helpers::removeFile(ROOT_PATH_PUBLIC . $item->image);

            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }
}