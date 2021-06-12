<div class="modal" id="registration_student">
    <div class="modal-wrapper">
        <form class="form-modal registration-form">
            <input type="hidden" name="redirect_from" value="<?php echo "http://" .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <h3>Регистрация студента</h3>
            <div class="form-input-socials">
                <label>Войти через</label>
                <div class="socials-item-wrapper">
                    <div class="socials-item">
                        <a href="https://oauth.vk.com/authorize?client_id=7630081&display=page&redirect_uri=https://topstudents.ru/vkAuth&scope=email&response_type=code&v=5.59"><img src="/images/vk.png"></a>
                    </div>
                    <div class="socials-item">
                        <a href="https://www.facebook.com/v9.0/dialog/oauth?client_id=379131016840288&redirect_uri=https://topstudents.ru/fbAuth&scope=email&response_type=code&state="{day='+ current_share_day +', time=123123123}""><img src="/images/fb.png"></a>
                    </div>
                </div>

            </div>
            <div class="form-input">
                <label>Почта</label>
                <input type="email" required placeholder="Введите почту" name="email">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Пароль</label>
                <input type="password" required placeholder="Придумайте пароль" name="password">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Фамилия</label>
                <input type="text" placeholder="Введите фамилию" required name="surname">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Имя</label>
                <input type="text" placeholder="Введите имя" required name="name">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Телефон</label>
                <input type="text" placeholder="Введите номер" required name="phone">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Ссылка на Вконтакте<span>(если есть)</span></label>
                <input type="text" placeholder="Введите название Вуза" value="vk.com/" name="vkProfile">
                <label class="error-input"></label>
            </div>
            <input type="hidden" name="type" value="2">
            <div class="form-input-submit">
                <button type="submit">Зарегистрироваться</button>
            </div>
            <div class="form-information">
                Регистрируясь на сайте, я соглашаюсь с условиями договора<br>
                <a href="#">Публичной оферты</a> и <a href="#">Пользовательским соглашением</a>
            </div>
        </form>
    </div>

</div>
<div class="modal" id="registration_organization">
    <div class="modal-wrapper">
        <form class="form-modal registration-form">
            <h3>Регистрация организации</h3>
            <div class="form-input">
                <label>Почта организации</label>
                <input type="email" required placeholder="Введите почту" name="email">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Пароль</label>
                <input type="password" required placeholder="Придумайте пароль" name="password">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Повторите пароль</label>
                <input type="password" required placeholder="Повторите пароль" name="passwordConfirm">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Наименования организации</label>
                <input type="text" required placeholder="Введите наименование" name="name">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Телефон</label>
                <input type="text" required placeholder="Введите номер" name="phone">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Ссылка на сайт <span>(если есть)</span></label>
                <input type="text" placeholder="Вставьте ссылку" name="website">
            </div>
            <div class="form-input-submit">
                <button type="submit">Зарегистрироваться</button>
            </div>
            <input type="hidden" name="type" value="1">
            <div class="form-information">
                Регистрируясь на сайте, я соглашаюсь с условиями договора<br>
                <a href="#">Публичной оферты</a> и <a href="#">Пользовательским соглашением</a>
            </div>
        </form>
    </div>
</div>
<div class="modal" id="auth">
    <div class="modal-wrapper">

        <form class="form-modal auth-form" >
            <h3>Авторизация</h3>
            <div class="form-input-socials">
                <label>Войти через</label>
                <div class="socials-item-wrapper">
                    <div class="socials-item">
                        <a href="https://oauth.vk.com/authorize?client_id=7630081&display=page&redirect_uri=https://topstudents.ru/vkAuth&scope=email&response_type=code&v=5.59"><img src="/images/vk.png"></a>
                    </div>
                    <div class="socials-item">
                        <a href="https://www.facebook.com/v9.0/dialog/oauth?client_id=379131016840288&redirect_uri=https://topstudents.ru/fbAuth&scope=email&response_type=code&state="{day='+ current_share_day +', time=123123123}""><img src="/images/fb.png"></a>
                    </div>
                </div>

            </div>
            <div class="form-input">
                <label>Email</label>
                <input type="email" required name="email">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Пароль</label>
                <input type="password" required name="password">
                <label class="error-input"></label>
            </div>
            <div class="form-input-submit">
                <button type="submit">Войти</button>
            </div>
                <a class="restore" href="#restore_password" data-fancybox>Забыли пароль?</a>

        </form>
    </div>

</div>
<div class="modal" id="restore_password">
    <div class="modal-wrapper">
        <form class="form-modal restore-form" >
            <h3>Восстановления пароля</h3>
            <div class="form-input">
                <label>Email</label>
                <input type="email" required name="email">
                <label class="error-input"></label>
            </div>
            <div class="form-input-submit">
                <button type="submit">Выслать новый пароль</button>
            </div>
        </form>
        <div class="hidden">
            <h3>Для восстановления пароля следуйте инструкции в письме!</h3>
        </div>
    </div>

</div>
<div class="modal modal-map" id="map">
    <div class="modal-wrapper-map">
        <div id="map_item" style="width: 100%; height: 700px"></div>
    </div>
</div>
<div class="modal modal-map" id="map_events">
    <div class="modal-wrapper-map">
        <div id="map_item_events" style="width: 100%; height: 700px"></div>
    </div>
</div>
<div class="modal modal-map" id="map_vacancies">
    <div class="modal-wrapper-map">
        <div id="map_item_vacancies" style="width: 100%; height: 700px"></div>
    </div>
</div>
<div class="modal modal-map" id="map_discount">
    <div class="modal-wrapper-map">
        <div id="map_item_discounts" style="width: 100%; height: 700px"></div>
    </div>
</div>
<div class="modal" id="email">
    <div class="modal-wrapper">
            <form class="form-modal email-form" >
                <h3>Подписка на рассылку</h3>
                <div class="form-input">
                    <label>Email</label>
                    <input type="email" required name="email">
                    <label class="error-input"></label>
                </div>
                <div class="form-input-submit">
                    <button type="submit">Подписаться</button>
                </div>
            </form>
            <div class="hidden" style="height: 200px; padding: 60px 15px;  text-align: center; font-size: 22px; color: #ff4545;">
            </div>
    </div>
</div>
<div class="modal" id="idea">
    <div class="modal-wrapper">
        <form class="form-modal info-form" >
            <h3>Предложить идею</h3>
            <div class="form-input">
                <label>Имя</label>
                <input type="text" required name="name">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Email</label>
                <input type="email" required name="email">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Идея</label>
                <textarea name="idea"></textarea>
            </div>
            <div class="form-input-submit">
                <button type="submit">Отправить</button>
            </div>
        </form>
        <div class="hidden" style="height: 200px; padding: 60px 15px;  text-align: center; font-size: 22px; color: #ff4545;">
        </div>
    </div>
</div>
<div class="modal" id="team">
    <div class="modal-wrapper">
        <form class="form-modal info-form" >
            <h3>Вступить в команду</h3>
            <div class="form-input">
                <label>Имя</label>
                <input type="text" required name="name">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Фамилия</label>
                <input type="text" required name="surname">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Email</label>
                <input type="email" required name="email">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Телефон</label>
                <input type="text" required name="phone">
                <label class="error-input"></label>
            </div>
            <div class="form-input-submit">
                <button type="submit">Отправить</button>
            </div>
        </form>
        <div class="hidden" style="height: 200px; padding: 60px 15px;  text-align: center; font-size: 22px; color: #ff4545;">
        </div>
    </div>
</div>
