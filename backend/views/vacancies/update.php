<?php

/**
 * @var yii\web\View $this
 * @var common\models\Vacancies $model
 */

$this->title = 'Обновить вакансии: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Вакансии', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="vacancies-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'company'  => $company
    ]) ?>

</div>
