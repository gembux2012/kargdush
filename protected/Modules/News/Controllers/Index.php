<?php

namespace App\Modules\News\Controllers;

use App\Models\User;
use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
use T4\Http\E404Exception;
use T4\Mvc\Controller;

class Index
    extends Controller
{
    const PAGE_SIZE=20;

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

    public function actionNewsOne($id)
    {
        $this->data->item = Story::findByPK($id);
        if (empty($this->data->item)) {
            throw new E404Exception('Новость не найдена');
        }
    }

    public function actionBlogOne($id)
    {
        $this->data->item = Story::findByPK($id);
        if (empty($this->data->item)) {
            throw new E404Exception('Новость не найдена');
        }
    }

    ///my
    public function actionPageForTopic($title)
    {
        $title=urldecode($title);
        $this->data->items=Story::findAllByQuery('SELECT * FROM news_stories  WHERE __topic_id
            IN (SELECT __id FROM news_topics WHERE title="Новости") AND published IS NOT NULL  ORDER BY published DESC LIMIT 10' );


        if(Topic::findByTitle($title)) {
            $this->data->items = Topic::findByTitle($title)->stories;
        }
    }

    public function actionSlaider($id)
    {

     $this->data->items=Story::FindByPk($id);

    }

    public function actionBlog($page=1,$topic=2)
    {
        $item = Topic::findByPk($topic);
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
        $this->data->themes = Topic::findByTitle('Блог')->findAllChildren();
        $this->data->topic=$topic;


    }

    public function actionBlogEdit()
    {

        $this->data->themes=Topic::findByTitle('Блог')->findAllChildren();
    }


}