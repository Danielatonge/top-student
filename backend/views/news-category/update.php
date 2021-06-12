<?php

/**
 * @var yii\web\View $this
 * @var common\models\NewsCategory $model
 */

$this->title = 'Обновить категорию: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории новостей', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="news-category-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
