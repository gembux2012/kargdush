<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.09.15
 * Time: 16:55
 */

namespace App\Modules\Site\Models;
use App\Models\UserData;
use T4\Orm\Model;
use T4\Fs\Helpers;


class Student
    extends Model

{
    static protected $schema = [
        'columns' =>[
            'name'     => ['type'=>'string'],
            'text'  => ['type'=>'text'],

        ],
        'relations' => [
            'trainer' => ['type'=>self::MANY_TO_MANY, 'model'=>UserData::class],
            'service' => ['type'=>self::MANY_TO_MANY, 'model'=>Service::class],
            'photo' =>['type' => self::HAS_MANY, 'model' =>SiteImage::class],
            ]


        ];
    public function beforeDelete()
    {

        foreach($this->photo as $value){
            $item=SiteImage::FindByPk($value->Pk);
            $this->deleteImage($item);

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