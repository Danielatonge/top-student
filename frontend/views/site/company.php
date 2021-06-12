<div class="context-box">
    <div class="context-box-wrapper">
        <?php if ($company->logoImage) : ?>
        <div class="company-block-image ">
            <img src="<?php echo $company->logoImage ?>">
        </div>
        <?php endif; ?>
        <div class="company-block-content ">
            <h2 class="company-block-title">
                <?php echo $company->organizationName ?>
            </h2>
            <div class="company-block-description">
                <?php echo $company->description ?>
            </div>
            <?php if (\Yii::$app->user->id == $company->user_id) : ?>
                <div class="company-block-button header-add">
                    <a href="/profile">Редактировать профиль</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if ($events) : ?>
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
                    'company_id' => $company->user_id,
                    'is_news' => false
                ]); ?>
            <div class="context-box__header-add">
                <?php if (\Yii::$app->user->identity->type == 1) : ?>
                    <a href="/profile/events/create">Добавить мероприятие</a>
                <?php elseif (\Yii::$app->user->isGuest) : ?>
                    <a data-fancybox href="#registration_organization">Добавить мероприятие</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="context-box__header-right">
            <div class="context-box__header-map_online">
                <a data-type="events"   data-company-id="<?php echo $company->user_id; ?>" data-main="0" href="#">
                    Мероприятия онлайн
                </a>
            </div>
            <div class="context-box__header-map">
                <a data-fancybox href="#map_events">Мероприятия на карте</a>
            </div>
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="events" data-sort="date" data-company-id="<?php echo $company->user_id; ?>" >По дате</a><br>
                    <a href="#" data-type="events" data-sort="like" data-company-id="<?php echo $company->user_id; ?>" >По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($eventsCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($eventsCategory as $key => $item) : ?>
                <a href="#" data-company-id="<?php echo $company->user_id ?>" data-category="<?php echo $item->id ?>" data-type="events" class="context-box-tags-item">#<?php echo $item->name ?></a>
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
<?php endif; ?>
<?php if ($discounts) : ?>
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
                    'company_id' => $company->user_id,
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
                <a data-type="discounts" data-company-id="<?php echo $company->user_id; ?>" data-main="1" href="#">
                    Скидки онлайн
                </a>
            </div>
            <div class="context-box__header-map">
                <a data-fancybox href="#map_discount">Скидки на карте</a>
            </div>
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="discounts" data-sort="date" data-company-id="<?php echo $company->user_id; ?>" >По дате</a><br>
                    <a href="#" data-type="discounts" data-sort="like" data-company-id="<?php echo $company->user_id; ?>" >По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($discountsCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($discountsCategory as $key => $item) : ?>
                <a href="#" data-category="<?php echo $item->id ?>" data-type="discounts"  data-company-id="<?php echo $company->user_id ?>" class="context-box-tags-item">#<?php echo $item->name ?></a>
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
        <div class="show-all-btn col-md-12">
            <a href="/discounts">Посмотреть все скидки</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($vacancies) : ?>
<div class="context-box">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                <a href="/vacancies">Вакансии</a>
            </div>
            <?php echo \Yii::$app->view->renderFile('@frontend/views/components/filter.php',
                [
                    'type'=> 'vacancies',
                    'is_main' => 0,
                    'company_id' => $company->user_id,
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
                <a data-type="vacancies" data-company-id="<?php echo $company->user_id; ?>"  href="#">
                    Вакансии онлайн
                </a>
            </div>
            <div class="context-box__header-map">
                <a data-fancybox href="#map_vacancies">Вакансии на карте</a>
            </div>
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="vacancies" data-sort="date" data-company-id="<?php echo $company->user_id; ?>" >По дате</a><br>
                    <a href="#" data-type="vacancies" data-sort="like" data-company-id="<?php echo $company->user_id; ?>" >По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($vacanciesCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($vacanciesCategory as $key => $item) : ?>
                <a href="#" data-category="<?php echo $item->id ?>" data-type="vacancies"
                   data-company-id="<?php echo $company->user_id ?>"
                   class="context-box-tags-item">#<?php echo $item->name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="context-box-wrapper row">
        <?php if ($vacancies) : ?>
            <?php foreach ($vacancies as $key => $item) :
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
<?php if($news) : ?>
<div class="context-box">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                <a href="/news">Новости</a>
            </div>
            <?php echo \Yii::$app->view->renderFile('@frontend/views/components/filter.php',
                [
                    'type'=> 'news',
                    'is_main' => 0,
                    'company_id' => $company->user_id,
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
                    <a href="#" data-type="news"  data-sort="date" data-company-id="<?php echo $company->user_id; ?>" >По дате</a><br>
                    <a href="#" data-type="news" data-sort="like" data-company-id="<?php echo $company->user_id; ?>" >По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($newsCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($newsCategory as $key => $item) : ?>
                <a href="#" data-category="<?php echo $item->id ?>" data-type="news"
                   data-company-id="<?php echo $company->user_id ?>"
                   class="context-box-tags-item">#<?php echo $item->name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="context-box-wrapper row">
        <?php if ($news) : ?>
            <?php foreach ($news as $key => $item) :
                echo \Yii::$app->view->renderFile('@frontend/views/news/item.php', ['item'=> $item]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php if (!$news & !$events & !$vacancies & !$discounts) : ?>
<div class="context-box" style="min-height: 600px">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                Ничего не найдено
            </div>
        </div>
    </div>
</div>
    <?php else : ?>
    <?php echo \Yii::$app->view->renderFile('@frontend/views/components/partners.php'); ?>
<?php endif; ?>
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
                    href: '<?php    echo \Yii::getAlias('@frontendUrl') . '/discounts/' . $item->slug   ?>'
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
                    href: '<?php    echo \Yii::getAlias('@frontendUrl') . '/discounts/' . $item->slug   ?>'
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

            <?php foreach ($vacancies as $key => $item) :
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
                    href: '<?php    echo \Yii::getAlias('@frontendUrl') . '/discounts/' . $item->slug   ?>'
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
