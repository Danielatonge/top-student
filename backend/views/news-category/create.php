<?php

/**
 * @var yii\web\View $this
 * @var common\models\NewsCategory $model
 */

$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории новостей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
