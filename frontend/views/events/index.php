<div class="slider-wrapper" style="background-image: url('images/bgc-1.png')">
    <div class="content__slider">
        <?php if ($banner['object_title2']) : ?>
            <?php foreach ($banner['object_title2'] as $key => $item) : ?>
                <div class="content__slider-item">
                    <div class="content__slider-item-wrapper">

                        <div class="content__slider-item-description">
                            <a class="content__slider-item-title" href="<?php echo $banner['object_link2'][$key] ?>">
                                <?php echo $item ?>
                            </a>
                            <a  class="content__slider-item-text" href="<?php echo $banner['object_link2'][$key] ?>">
                                <?php echo $banner['object_text2'][$key] ?>
                            </a>
                            <?php if (\Yii::$app->user->identity->type == 1) : ?>
                                <a class="content__slider-item-add" href="/profile/events/create">Предложить мероприятие</a>
                            <?php elseif (\Yii::$app->user->isGuest) : ?>
                                <a class="content__slider-item-add" data-fancybox href="#registration_organization">Предложить мероприятие</a>
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
                <a href="/events">Мероприятия</a>
            </div>
            <?php echo \Yii::$app->view->renderFile('@frontend/views/components/filter.php',
                [
                        'type'=> 'events',
                        'is_main' => 0,
                        'company_id' => 0
                ]); ?>
            <div class="context-box__header-add">
                <?php if (\Yii::$app->user->identity->type == 1) : ?>
                    <a class="context-box__header-add" href="/profile/events/create">Добавить мероприятие</a>
                <?php elseif (\Yii::$app->user->isGuest) : ?>
                    <a class="context-box__header-add" data-fancybox href="#registration_organization">Добавить мероприятие</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="context-box__header-right">
            <div class="context-box__header-map_online">
                <a data-type="events" href="#">
                    Мероприятия онлайн
                </a>
            </div>
            <div class="context-box__header-map">
                <a data-fancybox href="#map_events">Мероприятия на карте</a>
            </div>
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="events" data-sort="date">По дате</a><br>
                    <a href="#" data-type="events" data-sort="like">По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($eventsCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($eventsCategory as $key => $item) : ?>
                <a href="#" data-category="<?php echo $item->id ?>" data-type="events"
                   class="context-box-tags-item">#<?php echo $item->name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="context-box-wrapper row">
        <?php if ($events) : ?>
            <?php foreach ($events as $key => $item) :
                echo \Yii::$app->view->renderFile('@frontend/views/events/item.php', ['item'=> $item]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
<?php if ($events) : ?>
    <script type="text/javascript">
        ymaps.ready(function () {
            var map = new ymaps.Map("map_item_events", {
                center: [55.753215, 37.622504],
                zoom: 10
            });

            <?php foreach ($events as $key => $item) :
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
                    href: '<?php    echo \Yii::getAlias('@frontendUrl') .'/' . $item->parentSlug . '/events/' . $item->id   ?>'
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
