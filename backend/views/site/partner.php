
<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use trntv\yii\datetime\DateTimeWidget;
use common\base\MultiModel;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

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
                                <h2>Партнеры</h2>
                                <div class="custom-widjet box box-primary border-left border-right">
                                    <div class="card-body">
                                        <div class="container-items">
                                            <?php if ($data->object_link) : ?>
                                                <?php foreach ($data->object_link as $key => $item) : ?>
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
                                                                           for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                    <input class="md-textarea form-control"
                                                                           name="DynamicModel[object_link][]"
                                                                           value="<?php echo $data->object_link[$key] ?>"
                                                                    >
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group field-dynamicmodel-object_image">
                                                                        <label class="control-label"
                                                                               for="dynamicmodel-object_image">Изображение</label>
                                                                        <div>
                                                                            <input type="hidden"
                                                                                   id="dynamicmodel-object_image"
                                                                                   class="empty-value "
                                                                                   name="DynamicModel[object_image][<?php echo $key; ?>]">
                                                                            <input type="file"
                                                                                   id="object_image<?php echo $key; ?>"
                                                                                   class="object_image<?php echo $key; ?>"
                                                                                   name="_fileinput_object_image">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($data->object_image[$key]) :
                                                        $image_data = json_encode(array($data->object_image[$key]));
                                                    else :
                                                        $image_data = 'null';
                                                    endif;

                                                    $this->registerJs("jQuery('.object_image" . $key . "').yiiUploadKit({'url':'/file/storage/upload?fileparam=_fileinput_object_image','multiple':false,'sortable':false,'maxNumberOfFiles':1,'maxFileSize':5000000,'minFileSize':null,'acceptFileTypes':/(\.|\/)(gif|jpe?g|png)$/i,'files':" . $image_data . ",'previewImage':true,'showPreviewFilename':false,'pathAttribute':'path','baseUrlAttribute':'base_url','pathAttributeName':'path','baseUrlAttributeName':'base_url','messages':{'maxNumberOfFiles':'Достигнуто максимальное кол-во файлов','acceptFileTypes':'Тип файла не разрешен','maxFileSize':'Файл слишком большой','minFileSize':'Файл меньше минимального размера'},'name':'DynamicModel[object_image][" . $key . "]'})");
                                                    ?>
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
                                                                       for="dynamicmodel-photo_start_text">Ссылка</label>
                                                                <input class="md-textarea form-control"
                                                                       name="DynamicModel[object_link][]"
                                                                >
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group field-dynamicmodel-object_image">
                                                                    <label class="control-label"
                                                                           for="dynamicmodel-object_image">Изображение</label>
                                                                    <div>
                                                                        <input type="hidden"
                                                                               id="dynamicmodel-object_image"
                                                                               class="empty-value "
                                                                               name="DynamicModel[object_image][0]">
                                                                        <input type="file" id="object_image0"
                                                                               class="object_image0"
                                                                               name="_fileinput_object_image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $this->registerJs("jQuery('.object_image0').yiiUploadKit({'url':'/file/storage/upload?fileparam=_fileinput_object_image','multiple':false,'sortable':false,'maxNumberOfFiles':1,'maxFileSize':5000000,'minFileSize':null,'acceptFileTypes':/(\.|\/)(gif|jpe?g|png)$/i,'files':null,'previewImage':true,'showPreviewFilename':false,'pathAttribute':'path','baseUrlAttribute':'base_url','pathAttributeName':'path','baseUrlAttributeName':'base_url','messages':{'maxNumberOfFiles':'Достигнуто максимальное кол-во файлов','acceptFileTypes':'Тип файла не разрешен','maxFileSize':'Файл слишком большой','minFileSize':'Файл меньше минимального размера'},'name':'DynamicModel[object_image][0]'})");
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <button type="button"
                                                        class="add-item btn btn-primary interface-add4">
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
