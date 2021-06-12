<?php
/**
 * @author Ilia Bortsov <ibortsov-dev@yandex.ru>

 * @var yii\web\View $this
 * @var string $content
 */
?>
<?php $this->beginContent('@backend/views/layouts/common.php'); ?>
    <div class="box">
        <div class="box-body">
            <?php echo $content ?>
        </div>
    </div>
<?php $this->endContent(); ?>

