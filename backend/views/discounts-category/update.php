<?php

/**
 * @var yii\web\View $this
 * @var common\models\DiscountsCategory $model
 */

$this->title = 'Обовить категорию: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории скидок', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="discounts-category-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
