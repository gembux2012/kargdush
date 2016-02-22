<?php


namespace App\Modules\LoadImg\Controllers;


use T4\Mvc\Controller;
use App\Modules\Site\Models\SiteImage;
use App\Modules\Site\Models\SiteDoc;


class Index extends Controller
{
   public function actionDefault($name,$id,$subclass)
   {
      $this->data->namefield=$name;
      $this->data->id=$id;
      $this->data->subclass=$subclass;

   }

   public function actionLoadImage($id,$subclass)
   {
      $this->data->id=$id;
      $this->data->subclass=$subclass;

   }



   public function actionLoadDoc($id,$subclass)
   {
      $this->data->id=$id;
      $this->data->subclass=$subclass;


   }

   public function actionAploadImg()
   {
      $path='/site/image/'.$this->app->request->post
              ->subclass.'/'.$this->app->request->post->id.'/';

      $realUploadPath = \T4\Fs\Helpers::getRealPath($path);
      if (!is_dir($realUploadPath)) {
         try {
            \T4\Fs\Helpers::mkDir($realUploadPath);
         } catch (\T4\Fs\Exception $e) {
            throw new Exception($e->getMessage());
         }
      }
      // Helpers::mkDir(ROOT_PATH_PUBLIC . DS .'/images/pages');

      $uploaddir = $realUploadPath;
      $file = $this->app->request->post->value;
      $name = $this->app->request->post->name;
      // Получаем расширение файла
      $getMime = explode('.', $name);
      $mime = end($getMime);
      // Выделим данные
      $data = explode(',', $file);

// Декодируем данные, закодированные алгоритмом MIME base64
      $encodedData = str_replace(' ','+',$data[1]);
      $decodedData = base64_decode($encodedData);

// Создаем изображение на сервере
      if(file_put_contents($uploaddir.$name, $decodedData)) {
         echo $name.":загружен успешно";
      }
      else {
         // Показать сообщение об ошибке, если что-то пойдет не так.
         echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
      }

      $in_img=imagecreatefromjpeg($path.$name);
      $out_img=imagecreatetruecolor(500,500);
      var_dump(imagecopyresampled($out_img,$in_img,0,0,0,0,500,500,imagesx($in_img),imagesy($in_img)));

      var_dump(imagejpeg($out_img,$path.'tmp.jpg',NULL));die;
      imagedestroy($in_img);
      imagedestroy($out_img);
      //$lin='__'.lcfirst($this->app->request->post->class).'_id';
      $subclass=$this->app->request->post->subclass;
      $item=new SiteImage();
      $item->image=$path.$name;
      $item->published = date('Y-m-d H:i:s', time());
      $item->$subclass=$this->app->request->post->id;
      $item->save();
      die;
      //$this->redirect('admin/rubrics?id='.$this->app->request->post->pageid);

   }

   public function actionUpLoadDoc()
   {
      $path='/site/doc/'.$this->app->request->post
              ->subclass.'/'.$this->app->request->post->id.'/';
      $realUploadPath = \T4\Fs\Helpers::getRealPath($path );
      if (!is_dir($realUploadPath)) {
         try {
            \T4\Fs\Helpers::mkDir($realUploadPath);
         } catch (\T4\Fs\Exception $e) {
            throw new Exception($e->getMessage());
         }
      }
      if(isset($_FILES["myfile"]))
      {
         $ret = array();

//	This is for custom errors;
         /*	$custom_error= array();
             $custom_error['jquery-upload-file-error']="File already exists";
             echo json_encode($custom_error);
             die();
         */
         $error =$_FILES["myfile"]["error"];
         //You need to handle  both cases
         //If Any browser does not support serializing of multiple files using FormData()
         $subclass=$this->app->request->post->subclass;



         if(!is_array($_FILES["myfile"]["name"])) //single file
         {
            $fileName = $_FILES["myfile"]["name"];
            move_uploaded_file($_FILES["myfile"]["tmp_name"],$realUploadPath .$fileName);
            $ret[]= $fileName;
            $item=new SiteDoc();
            $item->doc=$path.$fileName;
            $item->title=$this->app->request->post->name;
            $item->$subclass=$this->app->request->post->id;
            $item->save();
         }
         else  //Multiple files, file[]
         {
            $fileCount = count($_FILES["myfile"]["name"]);
            for($i=0; $i < $fileCount; $i++)
            {
               $fileName = $_FILES["myfile"]["name"][$i];
               move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$realUploadPath .$fileName);
               $ret[]= $fileName;
               $item=new SiteDoc();
               $item->doc=$path.$fileName;
               $item->title=$this->app->request->post->name;
               $item->$subclass=$this->app->request->post->id;
               $item->save();

            }

         }
         echo json_encode($ret);
      }
   }

   public function actionUpLoadImage()
   {
      $path = '/site/image/' . $this->app->request->post
              ->subclass . '/' . $this->app->request->post->id . '/';

      $realUploadPath = \T4\Fs\Helpers::getRealPath($path);
      if (!is_dir($realUploadPath)) {
         try {
            \T4\Fs\Helpers::mkDir($realUploadPath);
         } catch (\T4\Fs\Exception $e) {
            throw new Exception($e->getMessage());
         }
      }
      if (isset($_FILES["myfile"])) {
         $ret = array();

//	This is for custom errors;
        	/*$custom_error= array();
             $custom_error['jquery-upload-file-error']="File already exists";
             echo json_encode($custom_error);
             die();
            */
        echo json_encode( $error = $_FILES["myfile"]["error"]);
         //You need to handle  both cases
         //If Any browser does not support serializing of multiple files using FormData()
         $subclass = $this->app->request->post->subclass;


         if (!is_array($_FILES["myfile"]["name"])) //single file
         {
            $fileName = $_FILES["myfile"]["name"];
            move_uploaded_file($_FILES["myfile"]["tmp_name"], $realUploadPath . $fileName);
            $ret[] = $fileName;
            $item = new SiteImage();
            $item->image = $path . $fileName;
            $item->$subclass = $this->app->request->post->id;
            $item->save();
         } else  //Multiple files, file[]
         {
            $fileCount = count($_FILES["myfile"]["name"]);
            for ($i = 0; $i < $fileCount; $i++) {
               $fileName = $_FILES["myfile"]["name"][$i];
               move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $realUploadPath . $fileName);
               $ret[] = $fileName;

               $in_img=imagecreatefromjpeg($path.$fileName);
               $out_img=imagecreatetruecolor(500,500);
               var_dump(imagecopyresampled($out_img,$in_img,0,0,0,0,500,500,imagesx($in_img),imagesy($in_img)));

               var_dump(imagejpeg($out_img,$path.'tmp.jpg',NULL));die;
               imagedestroy($in_img);
               imagedestroy($out_img);

               $item = new SiteImage();
               $item->image = $path . $fileName;
               $item->$subclass = $this->app->request->post->id;
               $item->save();

            }

         }
         echo json_encode($ret);
      }
   }

}