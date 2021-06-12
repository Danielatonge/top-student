<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\News $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'category_id') ?>
    <?php echo $form->field($model, 'title') ?>
    <?php echo $form->field($model, 'text') ?>
    <?php echo $form->field($model, 'image') ?>
    <?php // echo $form->field($model, 'rules') ?>
    <?php // echo $form->field($model, 'date_start') ?>
    <?php // echo $form->field($model, 'date_end') ?>
    <?php // echo $form->field($model, 'created_at') ?>
    <?php // echo $form->field($model, 'updated_at') ?>
    <?php // echo $form->field($model, 'company_id') ?>
    <?php // echo $form->field($model, 'is_active') ?>
    <?php // echo $form->field($model, 'is_approved') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
