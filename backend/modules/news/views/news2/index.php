<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date',

            [
                'attribute'=>'theme_id',
                'value'=>function($data){

                    $return = \common\models\Themes::find()->where(['theme_id' => $data->theme_id])->one();
                    return $return->theme_title;
                },
                'filter'=> \common\models\Themes::find()->select(['theme_title'])->indexBy('theme_id')->column(),
            ],
            [
                'attribute' => 'text',
                'value' => function ($model) {
                    return \yii\helpers\StringHelper::truncate($model->text, 100);
                },
            ],
            'title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
