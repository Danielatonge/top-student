<?php

/**
 * @var yii\web\View $this
 * @var common\models\Vacancies $model
 */

$this->title = 'Создать вакансию';
$this->params['breadcrumbs'][] = ['label' => 'Вакансии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacancies-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'company'  => $company
    ]) ?>

</div>
