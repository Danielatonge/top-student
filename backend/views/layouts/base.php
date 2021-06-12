<?php
use backend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var string $content
 */

$bundle = BackendAsset::register($this);

$this->params['body-class'] = $this->params['body-class'] ?? null;
$keyStorage = Yii::$app->keyStorage;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=hqsg3sd081g9zc7mr4anzkzc86jze8uqsombjtdgfixzt5fx"></script>
    <script>
        var tinymceUploadUrl = '<?php echo Yii::$app->urlManager->createUrl(['/storage/upload-tinymce']) ?>'
    </script>
    <script>
        tinymce.init({
            forced_root_block: '',
            selector: '.tinymce',
            height: 600,
            language: 'ru',
            language_url: '/tinymce/ru.js',
            plugins: [
                "advlist autolink lists link charmap print anchor",
                "searchreplace code fullscreen"
            ]
        });
    </script>
    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<?php echo Html::beginTag('body', [
    'class' => implode(' ', [
        ArrayHelper::getValue($this->params, 'body-class'),
        $keyStorage->get('adminlte.sidebar-fixed') ? 'layout-fixed' : null,
        $keyStorage->get('adminlte.sidebar-mini') ? 'sidebar-mini' : null,
        $keyStorage->get('adminlte.sidebar-collapsed') ? 'sidebar-collapse' : null,
        $keyStorage->get('adminlte.navbar-fixed') ? 'layout-navbar-fixed' : null,
        $keyStorage->get('adminlte.body-small-text') ? 'text-sm' : null,
        $keyStorage->get('adminlte.footer-fixed') ? 'layout-footer-fixed' : null,
    ]),
])?>
    <?php $this->beginBody() ?>
        <?php echo $content ?>
    <?php $this->endBody() ?>
<?php echo Html::endTag('body') ?>
</html>
<?php $this->endPage() ?>
