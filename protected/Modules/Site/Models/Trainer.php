<?php


namespace App\Modules\Site\Models;


use T4\Orm\Model;

class Trainer
    extends Model

{
    static protected $schema = [
        'columns' =>[
            'name'     => ['type'=>'string'],
            'text'  => ['type'=>'text'],

        ],
        'relations' => [
            'service' => ['type'=>self::MANY_TO_MANY, 'model'=>Service::class],
            'student' => ['type'=>self::MANY_TO_MANY, 'model'=>Student::class],
            'photo' =>['type' => self::HAS_MANY, 'model' =>SiteImage::class],
            'blog' =>['type' => self::HAS_MANY, 'model' =>Blog::class],
        ]
    ];

    public function beforeDelete()
    {

        foreach($this->photo as $value){
            $item=SiteImage::FindByPk($value->Pk);
            $this->deleteImage($item);
            $item->delete();
        }
        $tmp=new \SplFileInfo  (ROOT_PATH_PUBLIC.$item->image);
        rmdir($tmp->getPath());

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