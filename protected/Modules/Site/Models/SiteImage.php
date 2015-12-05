<?php


namespace App\Modules\Site\Models;
use App\Models\UserData;
use T4\Orm\Model;
use T4\Fs\Helpers;

class SiteImage
    extends Model
{
    static protected $schema = [
        'table'=>'site_images',
        'columns' => [
            'title' => ['type' => 'string', 'default' => ''],
            'image' => ['type' => 'string'],
            'doc' => ['type' => 'string'],
        ],
        'relations' => [
            'service' => ['type' => self::BELONGS_TO, 'model' => Service::class],
            'trainer' => ['type' => self::BELONGS_TO, 'model' => Trainer::class],
            'student' => ['type' => self::BELONGS_TO, 'model' => Student::class],
            'org' => ['type' => self::BELONGS_TO, 'model' => Org::class],
            'story' => ['type' => self::BELONGS_TO, 'model' => Story::class],
            'userdata' => ['type' => self::BELONGS_TO, 'model' => UserData::class],
        ]
    ];

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function deleteImage()
    {
        if ($this->image) {
            try {
                Helpers::removeFile(ROOT_PATH_PUBLIC . $this->image);
                $this->image = '';

            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

}