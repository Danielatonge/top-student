<?php
/**
 * @var yii\web\View $this
 * @var string $content
 */

use yii\helpers\Html;

\frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/jquery.fancybox.css"/>
    <link rel="stylesheet" href="/css/slick/slick-theme.css"/>
    <link rel="stylesheet" href="/css/slick.css"/>
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/style.css?ver=11">
    <link rel="stylesheet" href="/css/mobile.css?ver=10">
    <link rel="stylesheet" href="/css/cropper.css">
    <link href="/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=21b5bc5d-3721-4578-91e4-e9d11c86c640&lang=ru_RU&load=package.map,Geolink"
            type="text/javascript">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" rel="stylesheet" />
    <?php echo \Yii::$app->helper->putSeo(); ?>
    <?php if (\Yii::$app->params['og']) :  ?>
        <?php foreach (\Yii::$app->params['og'] as $key => $item) : ?>
            <meta property="og:<?php echo $key ?>" content="<?php echo $item ?>">
        <?php    endforeach;   ?>
    <?php endif; ?>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <?php $this->head() ?>
    <?php echo Html::csrfMetaTags() ?>
    <?php if (\Yii::$app->user->isGuest) : ?>
        <script>var guest = true;</script>
    <?php else : ?>
        <script>var guest = false;</script>
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>
<?php $this->beginBody() ?>
<?php echo $content ?>
<script src="/js/jquery-3.5.1.min.js"></script>
<script src="/js/jquery.fancybox.min.js"></script>
<script src="/js/slick.min.js"></script>
<script src="/js/inputmask.js"></script>
<script src="/js/datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>
<?php
if (strstr($_SERVER['REQUEST_URI'], 'profile')) :
?>
<!--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>-->
    <script src="/js/cropper.js"></script>
<?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/js/jquery.suggestions.min.js"></script>

<script src="/js/app.js?ver=6"></script>
<script src="/js/auth.js"></script>
<?php $this->endBody() ?>
<div class="preloader-layout">
    <div class="preloader">
        <img src="/images/preloader.png">
    </div>
</div>
</body>
</html>
<?php $this->endPage() ?>

