<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

   <h1>Админ панель</h1>

    <h3>Клиентская чать (Вывод новостей для клиентов)</h3>
    <?= \yii\bootstrap\Html::a('Модуль вывода Новостей', \yii\helpers\Url::to(['../../../frontend/web/view_news/news/index'])) ?>
</div>
