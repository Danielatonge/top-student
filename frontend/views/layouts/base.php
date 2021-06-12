<?php
/**
 * @var yii\web\View $this
 * @var string $content
 */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div class="page-wrapper">
    <header>
            <a class="logo" href="/"><img src="/images/logo.svg"></a>

            <div class="main-menu">
                <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'events')) echo 'active' ?>" href="/events"><span>Мероприятия</span></a>
                <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'discounts')) echo 'active' ?>" href="/discounts"><span>Скидки</span></a>
                <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'vacancies')) echo 'active' ?>" href="/vacancies"><span>Вакансии</span></a>
                <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'news')) echo 'active'  ?>" href="/news"><span>Новости</span></a>
                <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'about')) echo 'active'  ?>" href="/about"><span>О нас</span></a>
            </div>

        <div class="search">
            <form method="get" action="/search" ">
                <input placeholder="Поиск" name="s" value="<?php echo $_GET['s'] ?>" type="text" >
            </form>
        </div>
        <div class="account">
            <?php if (\Yii::$app->user->isGuest) : ?>
                <!--            <a class="desktop-hidden" href="#"><img src="/images/account.png"></a>-->
                <div style="position: relative" class="popup-box-menu">
                    <a href="#registration_popup" class="mobile-hidden popup-button">
                        Регистрация
                    </a>
                    <div id="registration_popup" class="hidden popup-block-menu">
                        <a data-fancybox href="#registration_student">Для студентов</a><br>
                        <a data-fancybox href="#registration_organization">Для организаций</a>
                    </div>
                </div>
                <div>
                    <a data-fancybox href="#auth" class="mobile-hidden ">Вход</a>
                </div>
                <a class="desktop-hidden mobile-wrapper-account" href="#">
                    <img src="/images/account.png">
                    <div class="menu-mobile-account desktop-hidden">
                        <a data-fancybox href="#auth">Вход</a><br>
                        <a data-fancybox href="#registration_student">Регистрация для студентов</a><br>
                        <a data-fancybox href="#registration_organization">Регистрация для организаций</a>
                    </div>
                </a>
            <?php else : ?>
                <a class="desktop-hidden" href="/profile"><img src="/images/account.png"></a>
            <div class="mobile-hidden">
                <a style="color: #ff4545" class="mobile-hidden" href="/profile"> <?php echo \Yii::$app->user->identity->headerName ?></a>

            </div>
                <!--                <a href="/logout" class="logout"><img src="/images/logout.png"></a>-->
            <?php endif; ?>
        </div>

    </header>
    <?php
    $req_uri = $_SERVER['REQUEST_URI'];
    //if (!strstr($req_uri, 'profile')) :
        ?>

    <div class="main-menu-mobile" <?php if (strstr($req_uri, 'profile')) : ?> style="margin-bottom: -10px" <?php endif; ?>>
        <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'events') && !strstr($_SERVER['REQUEST_URI'], 'profile')) echo 'active' ?>" href="/events"><span>Мероприятия</span></a>
        <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'discounts') && !strstr($_SERVER['REQUEST_URI'], 'profile')) echo 'active' ?>" href="/discounts"><span>Скидки</span></a>
        <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'vacancies') && !strstr($_SERVER['REQUEST_URI'], 'profile')) echo 'active' ?>" href="/vacancies"><span>Вакансии</span></a>
        <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'news') && !strstr($_SERVER['REQUEST_URI'], 'profile')) echo 'active'  ?>" href="/news"><span>Новости</span></a>
    </div>
    <?php //endif; ?>
    <div class="content-wrapper <?php echo \Yii::$app->params['body'] ?>">
        <?php echo $content ?>
    </div>


    <footer>
        <div class="footer-content">
            <div class="footer-wrapper row mobile-hidden">
                <div class="col-md-4 footer__info">
                    <a class="major__link" href="tel:+7 964 770 59 70">+7 964 770 59 70</a>
                    <a class="major__link last" href="mailto:info@topstudents.ru">info@topstudents.ru</a>
                    <a class="minor__link" href="#">Политика обработки персональных данных</a>
                    <a class="minor__link" href="#">Политика конфиденциальности</a>
                </div>
                <div class="col-md-4 footer-logo">
                    <a href="/"><img style="    width: 269px;height: 47px;" src="/images/footer-logo.png"></a>
                </div>
                <div class="col-md-4 footer_socials">
                    <a href="#email" data-fancybox class="socials-button">Подписаться на рассылку</a>
                    <ul class="socials">
                        <li><a target="_blank" href="https://vk.com/studentsmoscow"><img src="/images/vk.png"></a></li>
                        <li><a target="_blank" href="https://instagram.com/studentsmoscow"><img src="/images/insta.png"></a></li>
                    </ul>
                </div>
            </div>
            <div class=" row desktop-hidden">
                <div class="footer-wrapper-mobile">
                    <div class="logo-mob">
                        <img src="/images/footer-mobile.png">
                    </div>
                    <div class="socials-mobile">
                        <div class="socials-mobile-item">
                            <a target="_blank" class="icon" style="position: relative; top: 5px; background-image: url('images/vk-mob.png')"
                               href="https://vk.com/studentsmoscow"></a>
                            <a class="link" href="tel:+7 964 770 59 70">+7 964 770 59 70</a>

                        </div>
                        <div class="socials-mobile-item">
                            <a target="_blank" class="icon" href="https://instagram.com/studentsmoscow"><img src="/images/insta.png"></a>
                            <a class="link" href="mailto:info@topstudents.ru">info@topstudents.ru</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="footer-form desktop-hidden">
        <form class="email-form">
            <div class="form-input">
                <input placeholder="Введите почту" type="email" name="email">
            </div>
            <button class="form-submit" type="submit">Быть в теме</button>

        </form>
        <div style="text-align: center;width: 100%" class="hidden"></div>
    </div>

    <?php echo \Yii::$app->view->renderFile('@app/views/components/modals.php'); ?>

</div>
<?php $this->endContent() ?>
