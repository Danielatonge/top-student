<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\Logs $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="logs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'datetime') ?>
    <?php echo $form->field($model, 'status_code') ?>
    <?php echo $form->field($model, 'url') ?>
    <?php // echo $form->field($model, 'response') ?>
    <?php // echo $form->field($model, 'body') ?>
    <?php // echo $form->field($model, 'headers') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
