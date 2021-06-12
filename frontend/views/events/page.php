<h1><?php echo $event->title ?></h1>
<div class="single__header row">
    <div class="single__header-image col-md-5">
        <?php $preview = $event->preview ?  $event->preview : $event->image; ?>
        <div class="element_image">
            <img src="<?php echo $preview ?>">
            <div class="price"><?php echo date('d.m.Y', strtotime($event->date_start)); ?></div>
            <div class="tag">#<?php echo $event->firstCategory ?></div>
        </div>
    </div>
    <div class="single__header-info col-md-7">
        <div class="single__header-info-price_box">
            <?php if ($event->price_sale) : ?>
                <span class="oldprice"><?php echo $event->price; ?> руб.</span>
                <span class="newprice"><?php echo $event->price_sale; ?> руб.</span>
            <?php else : ?>
                <span style="margin-left: 0" class="newprice"><?php
                    if ($event->free) {
                        echo 'Бесплатно';
                    } else {
                        echo $event->price ? $event->price . ' руб.' : 'Бесплатно';
                    }
                    ?></span>
            <?php endif; ?>
        </div>
        <?php if (\Yii::$app->user->identity->type == 2) : ?>
            <?php $is_active = $event->checkUser(); ?>
                <?php if ($event->closed_registration) : ?>
                    <a class="submit-btn" target="_blank" href="<?php echo $event->link ?>">Участвовать</a>
                <?php elseif ($is_active) : ?>
                    <a class="submit-btn" data-id="<?php echo $event->id ?>" data-type="events" href="#">Отказаться</a>
                <?php else : ?>
                    <a class="submit-btn" data-id="<?php echo $event->id ?>" data-type="events" href="#">Участвовать</a>
                <?php endif; ?>
        <?php elseif(\Yii::$app->user->isGuest ) : ?>
            <a class="submit-btn" data-fancybox="" href="#registration_student">Участвовать</a>
        <?php endif; ?>
        <span class="single__header-info-span">Поделиться с друзьями</span>
        <div class="single__header-info-socials">
            <div class="single__header-info-socials-list">
                <a class="shareIcon" data-type="vk" href="#"><img src="/images/vk.png"></a>
                <a class="shareIcon" data-type="twitter" href="#"><img src="/images/tw.png"></a>
                <a class="shareIcon" data-type="facebook" href="#"><img src="/images/fb.png"></a>
            </div>
            <div data-type="events" data-id="<?php echo $event->id ?>" class="like"></div>
        </div>
        <div class="single__header-info-company">
            <?php $company = $event->companyData; ?>
            <p>Организация: <a class="org-link" href="/<?php echo $event->parentSlug ?>"><?php echo $company->organizationName ?></a></p>
            <?php if ($company->phoneNumber) : ?>
                <p>Телефон: <a class="org-link" href="tel:<?php echo $company->phoneNumber ?>"><?php echo $company->phoneNumber ?></a></p>
            <?php endif; ?>
            <?php if ($company->website) : ?>
                <p>Сайт: <a target="_blank" class="org-link" href="<?php echo $company->website ?>"><?php echo $company->website ?></a></p>
            <?php endif; ?>

            <?php if ($event->link && !$event->closed_registration) : ?>
                <p><a target="_blank" href="<?php echo $event->link ?>"><?php echo $event->link ?></a></p>
            <?php endif; ?>
            <?php if ($event->category_id == 3) : ?>
                <?php if ($event->encouraging) : ?><p>Форма поощрения
                    - <?php echo $event->encouraging ?></p> <?php endif; ?>
                <p>Питание - <?php echo $event->food ? 'Предусмотрено' : 'Не предусмотрено' ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="context-text">
    <?php echo nl2br($event->text) ?>

</div>
<?php
$address = json_decode($event->address, true);
$metro = json_decode($event->metro, true);
$coords = json_decode($event->coords, true);

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
<div class="col-md-12 addition-title">
    <h3>Ближайшие мероприятия</h3>
</div>
<div class="context-box-wrapper row">
    <?php if ($events) : ?>
        <?php foreach ($events as $key => $item) : ?>
            <?php echo \Yii::$app->view->renderFile('@app/views/events/item.php', ['item' => $item]); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
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
                    href: '<?php    echo \Yii::getAlias('@frontendUrl') . '/' . $event->parentSlug . '/events/' . $event->slug   ?>'
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
