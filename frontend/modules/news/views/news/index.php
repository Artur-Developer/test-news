<?
use \yii\bootstrap\Html;
use yii\helpers\Url;
use common\models\News;

/* @var $getYearNews - список всех годов */
/* @var $countNews - массив с месяцами по годам  с подсчётом новсотей на каждый месяц*/
/* @var $News - Массив с новостями*/
/* @var $lastPage - последняя страница в пагинации*/
/* @var $lastPage - последняя страница в пагинации*/
?>
<style>
    #work_area{
        width: 800px;
        margin: 100px auto;
    }
    #work_area li{
        display: inline-block;
        font-size: 15px;
        padding: 10px;
    }
    #work_area .current{
        border: 1px solid #424242;
        background-color: #dce6eb;
        font-size: 18px;
        padding: 3px 7px;
    }
</style>

<div class="view_news-index">
    <h1>Модуль вывода Новостей</h1>

    <h3>Админская чать</h3>
    <button class="btn"><?= \yii\bootstrap\Html::a('Модуль создания и редактирования Новостей', \yii\helpers\Url::to(['../../../backend/web/site/index'])) ?></button>
    <br>
    <br>
        <div class="col-md-4">
            <br>
            <?= Html::a('Сбросить фильтры', Url::to(['/view_news/news/index'])) ?>
            <br>
            <br>
            <? foreach ($getYearNews as $year):?>
                <br>
                <p><?= Html::a($year['year'], Url::to(['/view_news/news/index', 'year' => $year['year']])) ?>​</p>
                <? if(!empty($themes) && Yii::$app->request->get('year') == $year['year']):?>
                    <ul>
                        <? foreach ($themes as $theme):?>
                            <li><?= Html::a($theme['theme_title'], Url::to(['/view_news/news/index', 'year' => $year['year'], 'theme_id' => $theme['theme_id']]))?> (<?=$theme['count'] ?>)</li>
                        <? endforeach;?>
                    </ul>
                <? endif; ?>
                <? foreach ($countNews as $data):?>
                    <? if($year['year'] == $data['year']):?>
                        <? ?>
                        <p><?= Html::a(News::transactionMonth($data['month']) . " (".$data['count'].")", Url::to(['/view_news/news/index', 'year' => $data['year'], 'month' => $data['month']])) ?>​</p>
                        <? endif;?>
                <? endforeach;?>
            <? endforeach;?>
            <br>
            <br>
            <? if(!empty($countThemes)):?>
                <p>Темы Новостей</p>
                <ul>
                    <? foreach ($countThemes as $theme):?>
                        <li><?= Html::a($theme['theme_title'], Url::to(['/view_news/news/index', 'theme_id' => $theme['theme_id']]))?> (<?=$theme['count'] ?>)</li>
                    <? endforeach;?>
                </ul>
            <? endif; ?>

        </div>
    <div class="col-md-8">
        <? foreach ($News as $post):?>
            <div class="news">
                <h3><?= Html::a($post['title'], Url::to(['/view_news/news/post', 'id' => $post['news_id']]), ['data-method' => 'POST']) ?></h3>
                <p><?= Yii::$app->formatter->asNtext((\yii\helpers\StringHelper::truncate($post['text'], 256))) ?></p>
                <span style="float: left;font-size: 17px">Дата публикации: <?= $post['date']?></span>
                <? if(!Yii::$app->user->isGuest):?>
                    <button class="btn" style="float: right"><?= Html::a('Редактировать',  Url::to(['../../../backend/web/news/news2/update','id'=>$post['news_id']])) ?></button>
                <? endif;?>
                <button class="btn" style="float: right"><?= Html::a('Читать полностью', Url::to(['/view_news/news/post', 'id' => $post['news_id']]), ['data-method' => 'POST']) ?></button>
                <br>
                <br>
            </div>
        <? endforeach;?>
    </div>
    <div class="container">
        <ul id="work_area">
            <?
            $year = Yii::$app->request->get('year');
            $month = Yii::$app->request->get('month');
            $theme_id = Yii::$app->request->get('theme_id');
            ?>

            <? if($pageNum > 1): ?>
                <li><?= Html::a('&lt;&lt;', Url::to(['/view_news/news/index', 'page' => 1,'year' => $year, 'month' => $month, 'theme_id' => $theme_id]))?></li>
                <li><?= Html::a('&lt;', Url::to(['/view_news/news/index', 'page' => $pageNum-1,'year' => $year, 'month' => $month, 'theme_id' => $theme_id]))?></li>
            <? endif; ?>

            <? for($i = 1; $i<=$lastPage; $i++):?>
                <li <?=($i == $pageNum) ? 'class="current"' : '';?>><?= Html::a($i, Url::to(['/view_news/news/index', 'page' => $i,'year' => $year, 'month' => $month, 'theme_id' => $theme_id]))?> </li>
            <? endfor; ?>

            <? if($pageNum < $lastPage): ?>
                <li><?= Html::a('&gt;', Url::to(['/view_news/news/index', 'page' => $pageNum+1,'year' => $year, 'month' => $month, 'theme_id' => $theme_id]))?></li>
                <li><?= Html::a('&gt;&gt;', Url::to(['/view_news/news/index', 'page' => $lastPage,'year' => $year, 'month' => $month, 'theme_id' => $theme_id]))?></li>
            <? endif; ?>
        </ul>
    </div>

</div>
