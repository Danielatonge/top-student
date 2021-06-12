
<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use trntv\yii\datetime\DateTimeWidget;
use common\base\MultiModel;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;
$this->title = 'Настройки баннеров';
$model = new MultiModel([
    'models' => [
        'banner' => new \yii\base\DynamicModel([
            'fake'
        ]),
    ]
]);

$model = $model->getModel('banner');
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
    'id' => 'dynamic-form-1',
]);

?>
<div class="nav-tabs-custom margin-minus-10 nav-tabs-in">
    <div class="tab-content">
        <div class="active tab-pane" id="contentPage">
            <div class="nav-tabs-custom margin-minus-10">
                <div class="tab-content">
                    <div class="active tab-pane" id="firstBlock">
                        <div style="display: none">
                            <?php echo $form->field($model, 'fake')->widget(
                                Upload::class,
                                [
                                    'url' => ['/file/storage/upload'],
                                    'maxFileSize' => 5000000, // 5 MiB,
                                    'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                                ])->label(false);
                            ?>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h2>Баннеры</h2>
                                <div class="custom-widjet box box-primary border-left border-right">
                                    <div class="card-body">
                                    <h3>Главная страница</h3>
                                        <div class="container-items">
                                            <?php if ($data->object_title) : ?>
                                                <?php foreach ($data->object_title as $key => $item) : ?>
                                                    <div class="item box box-default border-left border-right">
                                                        <div class="card-header clearfix with-border">
                                                            <div class="text-right">
                                                                <button type="button"
                                                                        class="remove-item btn btn-danger btn-xs">
                                                                    <i class="fa-fw fas fa-trash"
                                                                       aria-hidden=""></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_title][]"
                                                                           value="<?php echo $data->object_title[$key] ?>"
                                                                    >
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Текст</label>
                                                                    <textarea class="md-textarea form-control"
                                                                              name="DynamicModel[object_text][]"><?php echo $data->object_text[$key] ?></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_link][]"
                                                                           value="<?php echo $data->object_link[$key] ?>"
                                                                    >
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <div class="item box box-default border-left border-right">
                                                    <div class="card-header clearfix with-border">
                                                        <div class="text-right">
                                                            <button type="button"
                                                                    class="remove-item btn btn-danger btn-xs">
                                                                <i class="fa-fw fas fa-trash" aria-hidden=""></i>
                                                            </button>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_title][]"
                                                                >
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Текст</label>
                                                                <textarea  name="DynamicModel[object_text][]" class="md-textarea form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_link][]"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <button type="button"
                                                        class="add-item btn btn-primary interface-add1">
                                                    <i class="glyphicon glyphicon-plus"></i><span>Добавить</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-widjet box box-primary border-left border-right">
                                    <div class="card-body">
                                        <h3>Мероприятия</h3>
                                        <div class="container-items">
                                            <?php if ($data->object_title2) : ?>
                                                <?php foreach ($data->object_title2 as $key => $item) : ?>
                                                    <div class="item box box-default border-left border-right">
                                                        <div class="card-header clearfix with-border">
                                                            <div class="text-right">
                                                                <button type="button"
                                                                        class="remove-item btn btn-danger btn-xs">
                                                                    <i class="fa-fw fas fa-trash"
                                                                       aria-hidden=""></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_title2][]"
                                                                           value="<?php echo $data->object_title2[$key] ?>"
                                                                    >
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Текст</label>
                                                                    <textarea class="md-textarea form-control"
                                                                              name="DynamicModel[object_text2][]"><?php echo $data->object_text2[$key] ?></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_link2][]"
                                                                           value="<?php echo $data->object_link2[$key] ?>"
                                                                    >
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <div class="item box box-default border-left border-right">
                                                    <div class="card-header clearfix with-border">
                                                        <div class="text-right">
                                                            <button type="button"
                                                                    class="remove-item btn btn-danger btn-xs">
                                                                <i class="fa-fw fas fa-trash" aria-hidden=""></i>
                                                            </button>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_title2][]"
                                                                >
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Текст</label>
                                                                <textarea  name="DynamicModel[object_text2][]" class="md-textarea form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_link2][]"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <button type="button"
                                                        class="add-item btn btn-primary interface-add2">
                                                    <i class="glyphicon glyphicon-plus"></i><span>Добавить</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-widjet box box-primary border-left border-right">
                                    <div class="card-body">
                                        <h3>Скидки</h3>
                                        <div class="container-items">
                                            <?php if ($data->object_title3) : ?>
                                                <?php foreach ($data->object_title3 as $key => $item) : ?>
                                                    <div class="item box box-default border-left border-right">
                                                        <div class="card-header clearfix with-border">
                                                            <div class="text-right">
                                                                <button type="button"
                                                                        class="remove-item btn btn-danger btn-xs">
                                                                    <i class="fa-fw fas fa-trash"
                                                                       aria-hidden=""></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_title3][]"
                                                                           value="<?php echo $data->object_title3[$key] ?>"
                                                                    >
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Текст</label>
                                                                    <textarea class="md-textarea form-control"
                                                                              name="DynamicModel[object_text3][]"><?php echo $data->object_text3[$key] ?></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_link3][]"
                                                                           value="<?php echo $data->object_link3[$key] ?>"
                                                                    >
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <div class="item box box-default border-left border-right">
                                                    <div class="card-header clearfix with-border">
                                                        <div class="text-right">
                                                            <button type="button"
                                                                    class="remove-item btn btn-danger btn-xs">
                                                                <i class="fa-fw fas fa-trash" aria-hidden=""></i>
                                                            </button>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_title3][]"
                                                                >
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Текст</label>
                                                                <textarea  name="DynamicModel[object_text3][]" class="md-textarea form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_link3][]"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <button type="button"
                                                        class="add-item btn btn-primary interface-add3">
                                                    <i class="glyphicon glyphicon-plus"></i><span>Добавить</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-widjet box box-primary border-left border-right">
                                    <div class="card-body">
                                        <h3>Вакансии</h3>
                                        <div class="container-items">
                                            <?php if ($data->object_title4) : ?>
                                                <?php foreach ($data->object_title4 as $key => $item) : ?>
                                                    <div class="item box box-default border-left border-right">
                                                        <div class="card-header clearfix with-border">
                                                            <div class="text-right">
                                                                <button type="button"
                                                                        class="remove-item btn btn-danger btn-xs">
                                                                    <i class="fa-fw fas fa-trash"
                                                                       aria-hidden=""></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_title4][]"
                                                                           value="<?php echo $data->object_title4[$key] ?>"
                                                                    >
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Текст</label>
                                                                    <textarea class="md-textarea form-control"
                                                                              name="DynamicModel[object_text4][]"><?php echo $data->object_text4[$key] ?></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_link4][]"
                                                                           value="<?php echo $data->object_link4[$key] ?>"
                                                                    >
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <div class="item box box-default border-left border-right">
                                                    <div class="card-header clearfix with-border">
                                                        <div class="text-right">
                                                            <button type="button"
                                                                    class="remove-item btn btn-danger btn-xs">
                                                                <i class="fa-fw fas fa-trash" aria-hidden=""></i>
                                                            </button>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_title4][]"
                                                                >
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Текст</label>
                                                                <textarea  name="DynamicModel[object_text4][]" class="md-textarea form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_link4][]"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <button type="button"
                                                        class="add-item btn btn-primary interface-add5">
                                                    <i class="glyphicon glyphicon-plus"></i><span>Добавить</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-widjet box box-primary border-left border-right">
                                    <div class="card-body">
                                        <h3>Новости</h3>
                                        <div class="container-items">
                                            <?php if ($data->object_title5) : ?>
                                                <?php foreach ($data->object_title5 as $key => $item) : ?>
                                                    <div class="item box box-default border-left border-right">
                                                        <div class="card-header clearfix with-border">
                                                            <div class="text-right">
                                                                <button type="button"
                                                                        class="remove-item btn btn-danger btn-xs">
                                                                    <i class="fa-fw fas fa-trash"
                                                                       aria-hidden=""></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_title5][]"
                                                                           value="<?php echo $data->object_title5[$key] ?>"
                                                                    >
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Текст</label>
                                                                    <textarea class="md-textarea form-control"
                                                                              name="DynamicModel[object_text5][]"><?php echo $data->object_text5[$key] ?></textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_link5][]"
                                                                           value="<?php echo $data->object_link5[$key] ?>"
                                                                    >
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <div class="item box box-default border-left border-right">
                                                    <div class="card-header clearfix with-border">
                                                        <div class="text-right">
                                                            <button type="button"
                                                                    class="remove-item btn btn-danger btn-xs">
                                                                <i class="fa-fw fas fa-trash" aria-hidden=""></i>
                                                            </button>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Заголовок</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_title5][]"
                                                                >
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Текст</label>
                                                                <textarea  name="DynamicModel[object_text5][]" class="md-textarea form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="control-label"
                                                                       for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_link5][]"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <button type="button"
                                                        class="add-item btn btn-primary interface-add5">
                                                    <i class="glyphicon glyphicon-plus"></i><span>Добавить</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="form-group margin-top-30">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>


<?php ActiveForm::end(); ?>
