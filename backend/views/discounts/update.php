<?php

/**
 * @var yii\web\View $this
 * @var common\models\Discounts $model
 */

$this->title = 'Обновить скидку: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="discounts-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'company'  => $company
    ]) ?>

</div>
