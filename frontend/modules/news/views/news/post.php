<?
use \yii\bootstrap\Html;
use yii\helpers\Url;

/* @var $Post - детали новости */
?>
<div class="view_news-post">
    <div class="col-md-10">
        <button class="btn"><?= Html::a('Все новости',  Url::to(['/view_news/news/index'])) ?></button>
        <br>
        <div class="news">
                <h3><?= $Post['title']?></h3>
                <p>Тема: <b><?= $Post['theme_title']?></b></p>
                <p><?= $Post['text']?></p>
                <span style="float: left;font-size: 17px">Дата публикации: <?= $Post['date']?></span>
                <br>
            <? if(!Yii::$app->user->isGuest):?>
                <button class="btn" style="float: right"><?= Html::a('Редактировать',  Url::to(['../../../backend/web/news/news2/update','id'=>$Post['news_id']])) ?></button>
            <? endif;?>
            </div>
    </div>
</div>
