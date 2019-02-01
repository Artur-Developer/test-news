<?php

namespace frontend\modules\news\controllers;

use Yii;
use common\models\News;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;


class NewsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','post','error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex($year=0,$month='',$theme_id = 0,$page=1)
    {
        $startIndex = ($page-1)*5;


        $getYearNews = News::getYearNews();
        $countNews = News::getCountNewsByMonths();
        $countThemes = News::getCountToThemes();

        if($year > 0 && $theme_id > 0){

            $countAllNews = News::getCountNewsByTheme($theme_id);
            $lastPage = ceil($countAllNews/5);
            $News = News::getNewsToYearAndTheme(intval($year),$theme_id);
            return $this->render('index',[
                'countNews'=>$countNews,
                'getYearNews'=>$getYearNews,
                'countThemes'=>$countThemes,
                'News'=>$News,
                'startIndex'=>$startIndex,
                'lastPage'=>$lastPage,
                'pageNum'=>$page,
            ]);
        }
        if(!$year && $theme_id > 0){
            $countAllNews = News::getCountNewsByTheme($theme_id);
            $lastPage = ceil($countAllNews/5);
            $News = News::getNewsToThemes($theme_id);
            return $this->render('index',[
                'countNews'=>$countNews,
                'getYearNews'=>$getYearNews,
                'countThemes'=>$countThemes,
                'News'=>$News,
                'startIndex'=>$startIndex,
                'lastPage'=>$lastPage,
                'pageNum'=>$page,
            ]);
        }

        if($year > 0 && $month != ''){
            $countAllNews = News::getCountNewsByYearAndMonth($year,$month);
            $lastPage = ceil($countAllNews/5);
            $News = News::getNewsToSort(intval($year),$month);
            $themes = News::getNewsToYearThemes($year);
            return $this->render('index',[
                'countNews'=>$countNews,
                'getYearNews'=>$getYearNews,
                'countThemes'=>$countThemes,
                'News'=>$News,
                'themes'=>$themes,
                'startIndex'=>$startIndex,
                'lastPage'=>$lastPage,
                'pageNum'=>$page,
            ]);
        }

        elseif($year > 0 ){
            $countAllNews = News::getCountNewsByYear($year);
            $lastPage = ceil($countAllNews/5);
            $News = News::getNewsToYear(intval($year));
            $themes = News::getNewsToYearThemes($year);
            return $this->render('index',[
                'countNews'=>$countNews,
                'getYearNews'=>$getYearNews,
                'countThemes'=>$countThemes,
                'News'=>$News,
                'themes'=>$themes,
                'startIndex'=>$startIndex,
                'lastPage'=>$lastPage,
                'pageNum'=>$page,
            ]);
        }
        else{
            $countAllNews = News::getCountNews();
            $lastPage = ceil($countAllNews/5);

            return $this->render('index',[
                'countNews'=>$countNews,
                'getYearNews'=>$getYearNews,
                'countThemes'=>$countThemes,
                'News'=> News::getNews($startIndex,$lastPage),
                'startIndex'=>$startIndex,
                'lastPage'=>$lastPage,
                'pageNum'=>$page,
            ]);
        }

    }
    public function actionPost($id)
    {
        $Post = News::getViewPost($id);
        return $this->render('post',[
            'Post'=> $Post
        ]);

    }
}
