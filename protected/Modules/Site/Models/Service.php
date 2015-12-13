<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.09.15
 * Time: 16:53
 */

namespace App\Modules\Site\Models;
use App\Models\UserData;
use App\Modules\Gallery\Models\Photo;
use T4\Orm\Model;
use T4\Fs\Helpers;
use App\Modules\Site\Models\ServiceImage;
use App\Modules\Site\Models\Trainer;
use App\Modules\Site\Models\Student;


class Service
    extends Model

{
    static protected $schema = [

            'columns' => [
                'title'     => ['type'=>'string'],
                'text'  => ['type'=>'text'],
                'paid'  => ['type'=>'bool'],
                'tarif'  => ['type'=>'string'],


            ],
            'relations' => [
                'userdata' =>['type' => self::MANY_TO_MANY, 'model' =>UserData::class],
                'photo' =>['type' => self::HAS_MANY, 'model' =>SiteImage::class],
                'student' =>['type' => self::MANY_TO_MANY, 'model' =>Student::class],
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