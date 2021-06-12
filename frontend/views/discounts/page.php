<h1><?php echo $discount->title ?></h1>
<?php $gallery = json_decode($discount->gallery, true);

?>
<div class="single__header row">
    <div class="col-md-5 single-slider">
        <?php $preview = $discount->preview ?  $discount->preview : $discount->image; ?>
        <a data-fancybox="" href="<?php echo $preview ?>" class="element_image"
           style="background-image: url('<?php echo $preview ?>')">
            <?php
            $str = '';
            if ($discount->sales) {
                if (mb_strlen($discount->sales) >= 18) {
                    $str = 'style="font-size: 10px"';
                } elseif (mb_strlen($discount->sales) > 15) {
                    $str = 'style="font-size: 11px"';
                } else if (mb_strlen($discount->sales) > 10) {
                    $str = 'style="font-size: 13px"';
                }
            }
            if (is_numeric($discount->sales)) {
                $discount->sales .= '%';
            }
            ?>
            <div <?php echo $str ?> class="price">  <?php echo $discount->free ? 'Бесплатно' : $discount->sales ; ?></div>
            <div class="tag">#<?php echo $discount->firstCategory ?></div>
        </a>
        <?php if ($gallery) : ?>
            <?php foreach ($gallery as $key => $item) :
                $image = str_replace('\\', '/', $item['base_url'] . $item['path']);
                ?>
                <a data-fancybox="" href="<?php echo $image ?>" class="element_image"
                   style="background-image: url('<?php echo $image ?>')">
                    <div <?php echo $str ?> class="price">  <?php echo $discount->free ? 'Бесплатно' : $discount->sales ; ?></div>
                    <div class="tag">#<?php echo $discount->firstCategory ?></div>
                </a>
            <?php endforeach;; ?>
        <?php endif; ?>
    </div>
    <div class="single__header-info col-md-7">
        <div class="single__header-info-price_box">
            <div class="single__header-info-company" style="margin-top: 0">
                <?php $promocode = $discount->promocode ? $discount->promocode : 'TopStudents'; ?>
                <p><?php echo $discount->type == 1 ? 'Скидка по промокоду '. $promocode : 'Скидка по студенческому билету' ?></p>
            </div>
        </div>

        <span class="single__header-info-span">Поделиться с друзьями</span>
        <div class="single__header-info-socials">
            <div class="single__header-info-socials-list">
                <a class="shareIcon" data-type="vk" href="#"><img src="/images/vk.png"></a>
                <a class="shareIcon" data-type="twitter" href="#"><img src="/images/tw.png"></a>
                <a class="shareIcon" data-type="facebook" href="#"><img src="/images/fb.png"></a>
            </div>
            <div data-type="discounts" data-id="<?php echo $discount->id ?>" class="like"></div>
        </div>
        <div class="single__header-info-company">
            <?php $company = $discount->companyData; ?>
            <p>Организация: <a class="org-link" href="/<?php echo $discount->parentSlug ?>"><?php echo $company->organizationName ?></a></p>
            <?php if ($company->phoneNumber) : ?>
                <p>Телефон: <a class="org-link" href="tel:<?php echo $company->phoneNumber ?>"><?php echo $company->phoneNumber ?></a></p>
            <?php endif; ?>
            <?php if ($company->website) : ?>
                <p>Сайт: <a target="_blank" class="org-link" href="<?php echo $company->website ?>"><?php echo $company->website ?></a></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-5 mini-slider">
        <?php if ($gallery  && count($gallery) > 1) : ?>
        <div class="mini-slider-item" style="background-image: url('<?php echo $discount->preview ?>')"></div>
            <?php foreach ($gallery as $key => $item) :
                $image = str_replace('\\', '/', $item['base_url'] . $item['path']);
                ?>
                <div class="mini-slider-item" style="background-image: url('<?php echo $image ?>')"></div>
            <?php endforeach;; ?>
        <?php endif; ?>
    </div>
</div>
<div class="context-text">
    <?php echo nl2br($discount->text) ?>

</div>
<?php
$address = json_decode($discount->address, true);
$metro = json_decode($discount->metro, true);
$coords = json_decode($discount->coords, true);
if ($address[0]) :
    ?>
    <div class="content-map">
        <?php foreach ($address as $key => $item) : ?>
            <div class="address">
                <?php echo $metro[$key]; ?>. <span class="ymaps-geolink"><?php echo str_replace('Москва', '', $item); ?></span>
            </div>
        <?php endforeach; ?>
        <div id="map" style="height: 450px"></div>
    </div>
<?php endif; ?>
<?php if ($discounts) : ?>
    <div class="col-md-12 addition-title">
        <h3>Популярные скидки</h3>
    </div>
    <div class="context-box-wrapper row">

        <?php foreach ($discounts as $key => $item) : ?>
            <?php echo \Yii::$app->view->renderFile('@app/views/discounts/item.php', ['item' => $item]); ?>
        <?php    endforeach;   ?>

    </div>
<?php endif; ?>
<?php if ($coords) :
    ?>
    <script type="text/javascript">
        ymaps.ready(function () {
            var map = new ymaps.Map("map", {
                center: [55.753215, 37.622504],
                zoom: 11
            });

            <?php  foreach ($coords as $key => $item) :
            if ($item) :
            $c = implode(',', array_reverse(explode(',', $item))); ?>

            var marker<?php    echo $key   ?> = new ymaps.Placemark(
                [<?php    echo $c   ?>],
                {
                    hintContent: '<?php    echo $address[$key]   ?>'
                },
                {
                    hasBalloon: false,
                    href: '<?php    echo \Yii::getAlias('@frontendUrl') . '/' . $discount->parentSlug . '/events/' . $discount->slug   ?>'
                }
            );
            marker<?php    echo $key   ?>.events.add('click', function (e) {
                location = e.get('target').options.get('href');
            });
            <?php    $add .= '.add(marker' . $key . ')';   ?>

            <?php    endif;
            endforeach;  ?>
            map.geoObjects<?php    echo $add   ?>;

        });
    </script>
<?php endif; ?>



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
