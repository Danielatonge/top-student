<?php

/**
 * @var yii\web\View $this
 * @var common\models\Discounts $model
 */

$this->title = 'Создать скидку';
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discounts-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'company'  => $company
    ]) ?>

</div>
