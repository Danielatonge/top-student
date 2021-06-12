<div class="slider-wrapper" style="background-image: url('images/bgc.png')">
    <div class="content__slider">
        <?php if ($banner['object_title']) : ?>
        <?php foreach ($banner['object_title'] as $key => $item) : ?>
        <div class="content__slider-item">
            <div class="content__slider-item-wrapper">

                <div class="content__slider-item-description">
                    <a class="content__slider-item-title" href="<?php echo $banner['object_link'][$key] ?>">
                            <?php echo $item ?>
                    </a>
                    <a  class="content__slider-item-text" href="<?php echo $banner['object_link'][$key] ?>">
                            <?php echo $banner['object_text'][$key] ?>
                    </a>
                    <?php if (\Yii::$app->user->identity->type == 1) : ?>
                        <a class="content__slider-item-add" href="/profile/news/create">Предложить новость</a>
                    <?php elseif (\Yii::$app->user->isGuest) : ?>
                        <a class="content__slider-item-add" data-fancybox href="#registration_organization">Предложить новость</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach;   ?>
        <?php    endif;   ?>
    </div>
</div>
<div class="context-box is-front">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                <a href="/events">Мероприятия</a>
            </div>
            <?php echo \Yii::$app->view->renderFile('@frontend/views/components/filter.php',
                [
                    'type'=> 'events',
                    'is_main' => 1,
                    'company_id' => 0,
                    'is_news' => false
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
                    <a data-type="events" data-main="1" href="#">
                        Мероприятия онлайн
                    </a>
            </div>
            <div class="context-box__header-map">
                <a data-fancybox href="#map_events">Мероприятия на карте</a>
            </div>
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="events" data-sort="date" data-is-main="true">По дате</a><br>
                    <a href="#" data-type="events" data-sort="like" data-is-main="true">По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($eventsCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($eventsCategory as $key => $item) : ?>
                <a href="#" data-category="<?php echo $item->id ?>" data-is-main="true" data-type="events"
                   class="context-box-tags-item">#<?php echo $item->name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="context-box-wrapper row">
        <?php if ($events) : ?>
            <?php foreach ($events as $key => $item) :
                if ($key == 6) break;
                echo \Yii::$app->view->renderFile('@frontend/views/events/item.php', ['item'=> $item]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="show-all-btn col-md-12">
            <a href="/events">Посмотреть все мероприятия</a>
        </div>
    </div>

</div>
<div class="context-box is-front">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                <a href="/discounts">Скидки</a>
            </div>
            <?php echo \Yii::$app->view->renderFile('@frontend/views/components/filter.php',
                [
                    'type'=> 'discounts',
                    'is_main' => 1,
                    'company_id' => 0,
                    'is_news' => false
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
                <a data-type="discounts" data-main="1" href="#">
                    Скидки онлайн
                </a>
            </div>
            <div class="context-box__header-map">
                <a data-fancybox href="#map_discount">Скидки на карте</a>
            </div>
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="discounts" data-sort="date" data-is-main="true">По дате</a><br>
                    <a href="#" data-type="discounts" data-sort="like" data-is-main="true">По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($discountsCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($discountsCategory as $key => $item) : ?>
                <a href="#" data-category="<?php echo $item->id ?>" data-is-main="true" data-type="discounts" class="context-box-tags-item">#<?php echo $item->name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="context-box-wrapper row">
        <?php if ($discounts) : ?>
            <?php foreach ($discounts as $key => $item) :
                if ($key == 6) break;
                echo \Yii::$app->view->renderFile('@frontend/views/discounts/item.php', ['item'=> $item]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="show-all-btn col-md-12">
            <a href="/discounts">Посмотреть все скидки</a>
        </div>
    </div>

</div>
<?php if ($vacancies) : ?>
<div class="context-box is-front">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                <a href="/vacancies">Вакансии</a>
            </div>
            <?php echo \Yii::$app->view->renderFile('@frontend/views/components/filter.php',
                [
                    'type'=> 'vacancies',
                    'is_main' => 1,
                    'company_id' => 0,
                    'is_news' => false
                ]); ?>
            <div class="context-box__header-add">
                <?php if (\Yii::$app->user->identity->type == 1) : ?>
                    <a href="/profile/vacancies/create">Добавить вакансию</a>
                <?php elseif (\Yii::$app->user->isGuest) : ?>
                    <a data-fancybox href="#registration_organization">Добавить вакансию</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="context-box__header-right">
            <div class="context-box__header-map_online">
                <a data-type="vacancies" data-main="1" href="#">
                    Вакансии онлайн
                </a>
            </div>
            <div class="context-box__header-map">
                <a data-fancybox href="#map_vacancies">Вакансии на карте</a>
            </div>
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="vacancies" data-sort="date" data-is-main="true">По дате</a><br>
                    <a href="#" data-type="vacancies" data-sort="like" data-is-main="true">По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($vacanciesCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($vacanciesCategory as $key => $item) : ?>
                <a href="#" data-category="<?php echo $item->id ?>" data-is-main="true" data-type="vacancies" class="context-box-tags-item">#<?php echo $item->name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="context-box-wrapper row">
        <?php if ($vacancies) : ?>
            <?php foreach ($vacancies as $key => $item) :
                if ($key == 6) break;
                echo \Yii::$app->view->renderFile('@frontend/views/vacancies/item.php', ['item'=> $item]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="show-all-btn col-md-12">
            <a href="/vacancies">Посмотреть все вакансии</a>
        </div>
    </div>
    
</div>
<?php endif; ?>
<?php if ($news) : ?>
<div class="context-box is-front">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                <a href="/news">Новости</a>
            </div>
            <?php echo \Yii::$app->view->renderFile('@frontend/views/components/filter.php',
                [
                    'type'=> 'news',
                    'is_main' => 1,
                    'company_id' => 0,
                    'is_news' => true
                ]); ?>
            <div class="context-box__header-add">
                <?php if (\Yii::$app->user->identity->type == 1) : ?>
                    <a href="/profile/news/create">Добавить новость</a>
                <?php elseif (\Yii::$app->user->isGuest) : ?>
                    <a data-fancybox href="#registration_organization">Добавить новость</a>
                <?php endif; ?>

            </div>
        </div>
        <div class="context-box__header-right">
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="news" data-sort="date" data-is-main="true">По дате</a><br>
                    <a href="#" data-type="news" data-sort="like" data-is-main="true">По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($newsCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($newsCategory as $key => $item) : ?>
                <a href="#" data-is-main="true" data-category="<?php echo $item->id ?>" data-type="news"
                   class="context-box-tags-item">#<?php echo $item->name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="context-box-wrapper row">
        <?php if ($news) : ?>
            <?php foreach ($news as $key => $item) :
                if ($key == 3) break;
                echo \Yii::$app->view->renderFile('@frontend/views/news/item.php', ['item'=> $item]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="show-all-btn col-md-12">
            <a href="/news">Посмотреть все новости</a>
        </div>
    </div>

</div>
<?php endif; ?>
<?php echo \Yii::$app->view->renderFile('@frontend/views/components/partners.php'); ?>
<?php if ($events) : ?>
    <script type="text/javascript">
        ymaps.ready(function () {
            var map = new ymaps.Map("map_item_events", {
                center: [55.753215, 37.622504],
                zoom: 10
            });

            <?php $add=''; foreach ($events as $key => $item) :
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
<?php if ($discounts) : ?>
<script type="text/javascript">
    ymaps.ready(function () {
        var map = new ymaps.Map("map_item_discounts", {
            center: [55.753215, 37.622504],
            zoom: 10
        });

        <?php $add = ''; foreach ($discounts as $key => $item) :
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
<?php if ($vacancies) : ?>
    <script type="text/javascript">
        ymaps.ready(function () {
            var map = new ymaps.Map("map_item_vacancies", {
                center: [55.753215, 37.622504],
                zoom: 10
            });

            <?php $add =''; foreach ($vacancies as $key => $item) :
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
                    href: '<?php    echo \Yii::getAlias('@frontendUrl') .'/' . $item->parentSlug . '/vacancies/' . $item->id   ?>'
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
