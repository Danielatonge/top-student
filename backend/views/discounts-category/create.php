<?php

/**
 * @var yii\web\View $this
 * @var common\models\DiscountsCategory $model
 */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Категории скидок', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discounts-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
