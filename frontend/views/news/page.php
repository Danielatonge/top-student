<h1>Новости</h1>
<?php $gallery = json_decode($new->gallery, true); ?>
<div class="single__header row">
    <div class="col-md-5 single-slider">
        <?php $preview = $new->preview ?  $new->preview : $new->image; ?>
        <a data-fancybox="gallery" href="<?php echo $preview ?>" class="element_image"
           style="background-image: url('<?php echo $preview ?>')">
            <div class="price"><?php echo date('d.m.Y', strtotime($new->created_at)); ?></div>
            <div class="tag">#<?php echo $new->firstCategory ?></div>
        </a>
        <?php if ($gallery) : ?>
            <?php foreach ($gallery as $key => $item) :
                $image = str_replace('\\', '/', $item['base_url'] . $item['path']);
                ?>
                <a data-fancybox="gallery" href="<?php echo $image ?>" class="element_image"
                   style="background-image: url('<?php echo $image ?>')">
                    <div class="price"><?php echo date('d.m.Y', strtotime($new->created_at)); ?></div>
                    <div class="tag">#<?php echo $new->firstCategory ?></div>
                </a>
            <?php endforeach;; ?>
        <?php endif; ?>
    </div>
    <div class="single__header-info col-md-7">
        <div style="margin-bottom: 20px" class="single__header-info-price_box">
            <span style="margin-left: 0; " class="newprice"><?php echo $new->title ?></span>
        </div>
        <span class="single__header-info-span">Поделиться с друзьями</span>
        <div class="single__header-info-socials">
            <div class="single__header-info-socials-list">
                <a class="shareIcon" data-type="vk" href="#"><img src="/images/vk.png"></a>
                <a class="shareIcon" data-type="twitter" href="#"><img src="/images/tw.png"></a>
                <a class="shareIcon" data-type="facebook" href="#"><img src="/images/fb.png"></a>
            </div>
            <div data-type="news" data-id="<?php echo $new->id ?>" class="like"></div>
        </div>
        <div class="single__header-info-company">
            <?php $company = $new->companyData; ?>
            <p>Организация: <a class="org-link" href="/<?php echo $new->parentSlug ?>"><?php echo $company->organizationName ?></a></p>
            <?php if ($company->phoneNumber) : ?>
                <p>Телефон: <a class="org-link" href="tel:<?php echo $company->phoneNumber ?>"><?php echo $company->phoneNumber ?></a></p>
            <?php endif; ?>
            <?php if ($company->website) : ?>
                <p>Сайт: <a target="_blank" class="org-link" href="https://<?php echo $company->website ?>"><?php echo $company->website ?></a></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-5 mini-slider">
        <?php if ($gallery  && count($gallery) > 1) : ?>

        <div class="mini-slider-item" style="background-image: url('<?php echo $new->preview ?>')"></div>
        <?php if ($gallery) : ?>
            <?php foreach ($gallery as $key => $item) :
                $image = str_replace('\\', '/', $item['base_url'] . $item['path']);
                ?>
                <div class="mini-slider-item" style="background-image: url('<?php echo $image ?>')"></div>
            <?php endforeach;; ?>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<div class="col-md-12 context-text">
    <?php echo nl2br($new->text) ?>

</div>
<div class="col-md-12 addition-title">
    <h3>Последние новости</h3>
</div>
<div class="context-box-wrapper row">
    <?php if ($news) : ?>
        <?php foreach ($news as $key => $item) : ?>
            <?php echo \Yii::$app->view->renderFile('@app/views/news/item.php', ['item' => $item]); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<style>
    .mini-slider .slick-track {
        width: 100% !important;
    }
    .slick-prev:before, .slick-next:before {
        height: 25px;
        width: 17px;
        background-size: 79%;
        background-repeat: no-repeat;
        background-image: url('/images/arr.png');
        color: white;
        opacity: 1;
        left: unset;
    }

    .slick-prev:hover:before {
        background-image: url('/images/arr.png');
        transform: unset;
    }

    .slick-next:hover:before {
        background-image: url('/images/arr.png');
        transform: rotate(180deg);
    }

    .slick-next {
        right: 60px;
    }

    .slick-prev {
        left: 13px;
        z-index: 9999;
    }

    .slick-next:before {
        right: unset;
    }

    .price, .tag {
        bottom: 0;
    }
</style>
