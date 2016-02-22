<?php

namespace App\Modules\News\Controllers;

use App\Components\Admin\Controller;
use App\Models\User;
use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
use App\Modules\Site\Models\SiteImage;
use T4\Core\Exception;
use T4\Fs\Helpers;
use App\Components\SimpleImage;


class Admin
    extends Controller
{

    const PAGE_SIZE = 20;

    public function actionDefault($page = 1)
    {
        $item = Topic::findByTitle('Новости');
        $lft=$item->__lft;
        $rgt=$item->__rgt;

        $offset= ($page-1)*self::PAGE_SIZE;
        $limit= self::PAGE_SIZE;
        $this->data->itemsCount=Story::findALLByQuery('SELECT * FROM news_stories  WHERE __topic_id
            IN (SELECT __id FROM news_topics WHERE __lft >='.$lft.' AND __rgt <= '.$rgt.'  ORDER BY __lft) AND published IS NOT NULL' )->count();

        $this->data->items=Story::findAllByQuery('SELECT * FROM news_stories  WHERE __topic_id
            IN (SELECT __id FROM news_topics WHERE __lft >='.$lft.' AND __rgt <= '.$rgt.' ) AND published IS NOT NULL  ORDER BY published DESC LIMIT '.$offset.','.$limit );

        $this->data->activePage = $page;
        $this->data->pageSize = self::PAGE_SIZE;

    }

    public function actionView($id)
    {
        $this->data->id = $id;
    }

    public function actionEdit($id = null)
    {
        if (null === $id || 'new' == $id) {
            $this->data->item = new Story();
        } else {
            $this->Resize($id);
            $this->data->item = Story::findByPK($id);

        }
    }

  public function Resize($id)
  {
      $item = Story::findByPK($id);
      if (isset($item->photo[0])) {
          $realPath = Helpers::getRealPath($item->photo[0]->image);
          $image = new SimpleImage();
          $image->load($realPath);
          $image->resize(1024, 360);
          //$image->resizeToHeight(360);
          $image->save($realPath);

      }
  }

    public function actionSave()
    {
        if (!empty($this->app->request->post->id)) {
            $item = Story::findByPK($this->app->request->post->id);
        } else {
            $item = new Story();
        }
        $item->fill($this->app->request->post);
        $item
            ->uploadImage('image')
            ->save();
        $this->redirect('/admin/news/');
    }

    public function actionDelete($id)
    {
        $item = Story::findByPK($id);
        $item->delete();
        $this->redirect('/admin/news/');
    }

    public function actionDeleteImage($id)
    {
        $item = SiteImage::findByPK($id);
        if ($item) {
            $item->deleteImage();
            $item->delete();
            $item->save();
            $this->data->result = true;
        } else {
            $this->data->result = false;
        }
    }

    /**
     * TOPICS
     */

    public function actionTopics()
    {
        $this->data->items = Topic::findAllTree();
    }

    public function actionTopicEdit($id = null)
    {
        if (null === $id || 'new' == $id) {
            $this->data->item = new Topic();
        } else {
            $this->data->item = Topic::findByPK($id);
        }
    }

    public function actionTopicSave()
    {
        if (!empty($this->app->request->post->id)) {
            $item = Topic::findByPK($this->app->request->post->id);
        } else {
            $item = new Topic();
        }
        $item->fill($this->app->request->post);
        $item->save();
        $this->redirect('/admin/news/topics/');
    }

    public function actionTopicDelete($id)
    {
        $item = Topic::findByPK($id);
        if ($item) {
            $item->delete();
        }
        $this->redirect('/admin/news/topics/');
    }

    public function actionTopicUp($id)
    {
        $item = Topic::findByPK($id);
        if (empty($item))
            $this->redirect('/admin/news/topics');
        $sibling = $item->getPrevSibling();
        if (!empty($sibling)) {
            $item->insertBefore($sibling);
        }
        $this->redirect('/admin/news/topics');
    }

    public function actionTopicDown($id)
    {
        $item = Topic::findByPK($id);
        if (empty($item))
            $this->redirect('/admin/news/topics');
        $sibling = $item->getNextSibling();
        if (!empty($sibling)) {
            $item->insertAfter($sibling);
        }
        $this->redirect('/admin/news/topics');
    }

    public function actionTopicMoveBefore($id, $to)
    {
        try {
            $item = Topic::findByPK($id);
            if (empty($item)) {
                throw new Exception('Source element does not exist');
            }
            $destination = Topic::findByPK($to);
            if (empty($destination)) {
                throw new Exception('Destination element does not exist');
            }
            $item->insertBefore($destination);
            $this->data->result = true;
        } catch (Exception $e) {
            $this->data->result = false;
            $this->data->error = $e->getMessage();
        }
    }

    public function actionTopicMoveAfter($id, $to)
    {
        try {
            $item = Topic::findByPK($id);
            if (empty($item)) {
                throw new Exception('Source element does not exist');
            }
            $destination = Topic::findByPK($to);
            if (empty($destination)) {
                throw new Exception('Destination element does not exist');
            }
            $item->insertAfter($destination);
            $this->data->result = true;
        } catch (Exception $e) {
            $this->data->result = false;
            $this->data->error = $e->getMessage();
        }
    }

    ////blog
    public function actionBlog($page=1)
    {
        $item = Topic::findByTitle('Блог');
        $lft=$item->__lft;
        $rgt=$item->__rgt;

        $offset= ($page-1)*self::PAGE_SIZE;
        $limit= self::PAGE_SIZE;
        $this->data->itemsCount=Story::findALLByQuery('SELECT * FROM news_stories  WHERE __topic_id
            IN (SELECT __id FROM news_topics WHERE __lft >='.$lft.' AND __rgt <= '.$rgt.'  ORDER BY __lft) AND published IS NOT NULL' )->count();

        $this->data->items=Story::findAllByQuery('SELECT * FROM news_stories  WHERE __topic_id
            IN (SELECT __id FROM news_topics WHERE __lft >='.$lft.' AND __rgt <= '.$rgt.' ) AND published IS NOT NULL  ORDER BY published DESC LIMIT '.$offset.','.$limit );

        $this->data->activePage = $page;
        $this->data->pageSize = self::PAGE_SIZE;


    }

    public function actionBlogEdit($id,$baselink)
    {
        if('new'== $id){
            $this->data->item=new Story();

        } else {
            $this->data->item = Story::findByPK($id);
        }
        $item = Topic::findByPK(2);
        $this->data->themes = $item->findAllChildren();
        $this->data->baselink=$baselink;
    }

    public function actionBlogSave()
    {
        if (!empty($this->app->request->post->id)) {
            $item = Story::findByPK($this->app->request->post->id);
            $new=false;
        } else {
            $item = new Story();
            $new=true;
        }


        $item->user=User::findByPK($this->app->user->__id);
        $item->fill($this->app->request->post);
        $item->save();
        if($new){
            $this->redirect('/admin/news/BlogEdit?id='.$item->Pk.'&baselink='.$this->app->request->post->baselink);
        } else {
            $this->redirect($this->app->request->post->baselink);
        }
    }

    public function actionBlogDelete($id)
    {
        $item = Story::findByPK($id);
        $item->delete();
        $this->redirect('/news/blog');
    }

    public  function actionBlogPhotoEdit($id)
    {
        $this->data->item=SiteImage::findByPK($id);
    }

    public  function actionBlogPhotoDelete($id)
    {
        $item=SiteImage::findByPK($id);
        $story=SiteImage::findByPK($id)->story;
        $item->delete();
        $this->redirect('/admin/news/BlogEdit/?id='.$story->Pk);


    }



    public  function actionBlogPhotoSave()
    {
        $item=SiteImage::findByPK($this->app->request->post->id);
        $item->title=$this->app->request->post->title;
        $item->save();
        $this->redirect('/admin/News/BlogEdit/?id='.$item->story->Pk);

    }


}