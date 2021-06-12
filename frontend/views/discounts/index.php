<div class="slider-wrapper" style="background-image: url('images/bgc-2.png')">
    <div class="content__slider">
        <?php if ($banner['object_title3']) : ?>
            <?php foreach ($banner['object_title3'] as $key => $item) : ?>
                <div class="content__slider-item">
                    <div class="content__slider-item-wrapper">

                        <div class="content__slider-item-description">
                            <a class="content__slider-item-title" href="<?php echo $banner['object_link3'][$key] ?>">
                                <?php echo $item ?>
                            </a>
                            <a  class="content__slider-item-text" href="<?php echo $banner['object_link3'][$key] ?>">
                                <?php echo $banner['object_text3'][$key] ?>
                            </a>
                            <?php if (\Yii::$app->user->identity->type == 1) : ?>
                                <a class="content__slider-item-add" href="/profile/discounts/create">Предложить скидку</a>
                            <?php elseif (\Yii::$app->user->isGuest) : ?>
                                <a class="content__slider-item-add" data-fancybox href="#registration_organization">Предложить скидку</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach;   ?>
        <?php    endif;   ?>
    </div>
</div>
<div class="context-box">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                <a href="/discounts">Скидки</a>
            </div>
            <?php echo \Yii::$app->view->renderFile('@frontend/views/components/filter.php',
                [
                    'type'=> 'discounts',
                    'is_main' => 0,
                    'company_id' => 0
                ]); ?>
            <div class="context-box__header-add">
                <?php if (\Yii::$app->user->identity->type == 1) : ?>
                    <a href="/profile/discounts/create">Добавить скидку</a>
                <?php elseif (\Yii::$app->user->isGuest) : ?>
                    <a data-fancybox href="#registration_organization">Добавить скидку</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="context-box__header-right">
            <div class="context-box__header-map_online">
                <a data-type="discounts" data-main="0" href="#">
                    Скидки онлайн
                </a>
            </div>
            <div class="context-box__header-map">
                <a data-fancybox href="#map_discount">Скидки на карте</a>
            </div>
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="discounts" data-sort="date">По дате</a><br>
                    <a href="#" data-type="discounts" data-sort="like">По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($discountsCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($discountsCategory as $key => $item) : ?>
                <a href="#" data-category="<?php echo $item->id ?>" data-type="discounts" class="context-box-tags-item">#<?php echo $item->name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="context-box-wrapper row">
        <?php if ($discounts) : ?>
            <?php foreach ($discounts as $key => $item) :
                echo \Yii::$app->view->renderFile('@frontend/views/discounts/item.php', ['item'=> $item]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
<?php if ($discounts) : ?>
    <script type="text/javascript">
        ymaps.ready(function () {
            var map = new ymaps.Map("map_item_discounts", {
                center: [55.753215, 37.622504],
                zoom: 10
            });

            <?php foreach ($discounts as $key => $item) :
            $coords = json_decode($item->coords, true);
            if (is_array($coords)) :
            foreach ($coords as $index => $coord) :
            $coord =  implode(',', array_reverse(explode(',', $coord)));
            ?>
            var marker<?php    echo $key   ?><?php    echo $index;   ?> = new ymaps.Placemark(
                [<?php    echo $coord   ?>],
                {
                    hintContent: '<?php    echo $item->title   ?>'
                },
                {
                    hasBalloon: false,
                    href: '<?php    echo \Yii::getAlias('@frontendUrl') .'/' . $item->parentSlug . '/discounts/' . $item->id   ?>'
                }
            );
            marker<?php    echo $key   ?><?php    echo $index;   ?>.events.add('click', function (e) {
                location = e.get('target').options.get('href');
            });
            <?php    $add .= '.add(marker' . $key . $index . ')';   ?>
            <?php    endforeach;  ?>
            <?php endif; ?>
            <?php    endforeach;  ?>
            map.geoObjects<?php    echo $add   ?>;
        });
    </script>
<?php endif; ?>
