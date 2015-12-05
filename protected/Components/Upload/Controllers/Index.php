<?php


namespace App\Modules\LoadImg\Controllers;


use T4\Mvc\Controller;

class Index extends Controller
{
   public function actionDefault($name,$id,$class,$path)
   {
      $this->data->name=$name;
      $this->data->id=$id;
      $this->data->class=$class;
      $this->data->path=$path;

   }

   public function actionAploadImg()
   {

      $realUploadPath = \T4\Fs\Helpers::getRealPath($this->app->request->post->path);
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
      var_dump($decodedData);
      var_dump($uploaddir.$name);
// Создаем изображение на сервере
      if(file_put_contents($uploaddir.$name, $decodedData)) {
         echo $name.":загружен успешно";
      }
      else {
         // Показать сообщение об ошибке, если что-то пойдет не так.
         echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
      }
      $relation='__'.lcfirst($this->app->request->post->class()).'_id';
      $item=new $this->app->request->post->class();
      $item->image=$this->app->request->post->path.$name;
      $item->$relation=$this->app->request->post->id;
      $item->save();
      die;
      //$this->redirect('admin/rubrics?id='.$this->app->request->post->pageid);

   }

}