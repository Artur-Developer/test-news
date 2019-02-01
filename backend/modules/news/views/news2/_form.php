<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    --><?//=  \dosamigos\datepicker\DatePicker::widget([
//        'name'  => 'date',
//        'value'  => Yii::$app->formatter->asDatetime($model->date,'DD.MM.YYYY'),
//        'language' => 'ru',
////        'format' => 'dd.mm.yyyy',
//    ]); ?>

    <?php
    $getThemeAll = \yii\helpers\ArrayHelper::map($getTheme,'theme_id','theme_title');
    $params = [
        'prompt' => 'Выберите тему'
    ];
    echo $form->field($model, 'theme_id')->dropDownList($getThemeAll,$params);
    ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
