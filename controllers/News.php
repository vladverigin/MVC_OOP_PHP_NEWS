<?php

namespace controllers;

class News
{
    public function showOne(int $id){
        $news = \models\News::getOne($id);
        include ('./views/news/view.php');
    }

    public function showPage(int $page){
        $offset = $page*5-5;
        $news = \models\News::getWithOffsetAndLimit(5,$offset);
        $pagesAmount = \models\News::getAmountOfPages(5);
        $currentPage = $page;
//        echo "Page is $page and pages amount - $pagesAmount ";
        include ('./views/news/news.php');
    }

    public function show(){
        $news = \models\News::getWithOffsetAndLimit(5,0);
        $pagesAmount = \models\News::getAmountOfPages(5);
        $currentPage = 1;
        include ('./views/news/news.php');
    }
}
