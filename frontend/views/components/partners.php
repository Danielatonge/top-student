<?php
    use common\models\KeyStorageItem;

    $model  =  KeyStorageItem::find()->where(['key' => 'card-banner'])->one();
    $data = json_decode($model->value, true);
?>
<?php if ($data['object_link']) :  ?>
<div class="context-box">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                Наши партнеры
            </div>
            <div class="context-box__header-add">
                <?php if (\Yii::$app->user->isGuest) : ?>
                    <a data-fancybox href="#registration_organization">Стать партнером</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="context-box-wrapper">
        <div class="partner-wrapper">
            <?php foreach ($data['object_link'] as $key => $item) :

                ?>
            <a href="<?php    echo $item;   ?>" class="partner-item">
                <img src="<?php    echo str_replace('\\', '/', $data['object_image'][$key]['base_url']. $data['object_image'][$key]['path'])   ?>">
            </a>
            <?php    endforeach;   ?>
            <?php foreach ($data['object_link'] as $key => $item) :

                ?>
                <a href="<?php    echo $item;   ?>" class="partner-item">
                    <img src="<?php    echo str_replace('\\', '/', $data['object_image'][$key]['base_url']. $data['object_image'][$key]['path'])   ?>">
                </a>
            <?php    endforeach;   ?>
        </div>
    </div>
</div>
    <?php endif; ?>
