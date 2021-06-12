<h1><?php echo $vacancy->title ?></h1>
<div class="single__header row">
    <div class="single__header-image col-md-5">
        <?php $preview = $vacancy->preview ?  $vacancy->preview : $vacancy->image; ?>
        <div class="element_image">
            <img src="<?php echo $preview ?>">
            <?php
            $str = '';
            if ($vacancy->salary) {
                if (mb_strlen($vacancy->salary) >= 18) {
                    $str = 'style="font-size: 10px"';
                } elseif (mb_strlen($vacancy->salary) > 15) {
                    $str = 'style="font-size: 11px"';
                } else if (mb_strlen($vacancy->salary) > 10) {
                    $str = 'style="font-size: 13px"';
                }
                if (is_numeric($vacancy->salary)) {
                    $vacancy->salary = $vacancy->salary . ' руб.';
                }
            }
            ?>
            <?php if ($vacancy->salary) : ?><div <?php echo $str ?> class="price"><?php echo $vacancy->salary ?></div> <?php endif; ?>
            <div class="tag">#<?php echo $vacancy->firstCategory ?></div>
        </div>
    </div>
    <div class="single__header-info col-md-7">
        <?php if (\Yii::$app->user->identity->type == 2) :
            $is_active = $vacancy->checkUser();
            ?>
            <?php if ($is_active) : ?>
                <a class="submit-btn" data-id="<?php echo $vacancy->id ?>" data-type="vacancies" href="#">Отказаться</a>
            <?php else : ?>
                <a class="submit-btn" data-id="<?php echo $vacancy->id ?>" data-type="vacancies" href="#">Отправить
                    отклик</a>
            <?php endif; ?>
        <?php endif; ?>
        <span class="single__header-info-span">Поделиться с друзьями</span>
        <div class="single__header-info-socials">
            <div class="single__header-info-socials-list">
                <a class="shareIcon" data-type="vk" href="#"><img src="/images/vk.png"></a>
                <a class="shareIcon" data-type="twitter" href="#"><img src="/images/tw.png"></a>
                <a class="shareIcon" data-type="facebook" href="#"><img src="/images/fb.png"></a>
            </div>
            <div data-type="vacancies" data-id="<?php echo $vacancy->id ?>"
                 class="like"></div>
        </div>
        <div class="single__header-info-company">
            <?php $company = $vacancy->companyData; ?>
            <p>Организация: <a class="org-link" href="/<?php echo $vacancy->parentSlug ?>"><?php echo $company->organizationName ?></a></p>
            <?php if ($company->phoneNumber) : ?>
                <p>Телефон: <a class="org-link" href="tel:<?php echo $company->phoneNumber ?>"><?php echo $company->phoneNumber ?></a></p>
            <?php endif; ?>
            <?php if ($company->website) : ?>
                <p>Сайт: <a target="_blank" class="org-link" href="<?php echo $company->website ?>"><?php echo $company->website ?></a></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="context-text">
    <?php echo nl2br($vacancy->text) ?>
</div>
<?php
$address = json_decode($vacancy->address, true);
$metro = json_decode($vacancy->metro, true);
$coords = json_decode($vacancy->coords, true);
if ($address[0]) :
    ?>
    <div class="content-map">
        <?php foreach ($address as $key => $item) : ?>
            <div class="address">
                <?php echo $metro[$key]; ?>. <?php echo str_replace('Москва', '', $item); ?>
            </div>
        <?php endforeach; ?>
        <div id="map" style="height: 450px"></div>
    </div>
<?php endif; ?>
<div class="col-md-12 addition-title">
    <h3>Популярные вакансии</h3>
</div>
<div class="context-box-wrapper row">
    <?php if ($vacancies) : ?>
        <?php foreach ($vacancies as $key => $item) : ?>
            <?php echo \Yii::$app->view->renderFile('@app/views/vacancies/item.php', ['item' => $item]); ?>
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
                        href: '<?php    echo \Yii::getAlias('@frontendUrl') . '/' . $vacancy->parentSlug . '/events/' . $vacancy->slug   ?>'
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
