<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Logs $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'datetime',
                    'status_code',
                    'url:url',
                    'token',
                    'method'
                ],
            ]) ?>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ответ</a>
                </li>
                <?php if (json_decode($model->body)) : ?>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Тело запроса</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Заголовки</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <code>
                        <?php echo '<pre>';
                        print_r(json_decode($model->response, true));
                        echo '</pre>'; ?>
                        </code>
                </div>
                
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <code>
                        <?php echo '<pre>';
                        print_r(json_decode(json_decode($model->body, true), true));
                        echo '</pre>'; ?>
                    </code>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <code>
                        <?php echo '<pre>';
                        print_r(json_decode($model->headers, true));
                        echo '</pre>'; ?>
                    </code>
                </div>
            </div>
        </div>
    </div>
</div>
