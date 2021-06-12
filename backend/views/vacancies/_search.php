<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Vacancies $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="vacancies-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'title') ?>
    <?php echo $form->field($model, 'company_id') ?>
    <?php echo $form->field($model, 'company_name') ?>
    <?php echo $form->field($model, 'salary') ?>
    <?php // echo $form->field($model, 'text') ?>
    <?php // echo $form->field($model, 'address') ?>
    <?php // echo $form->field($model, 'phone') ?>
    <?php // echo $form->field($model, 'image') ?>
    <?php // echo $form->field($model, 'is_active') ?>
    <?php // echo $form->field($model, 'is_approved') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
