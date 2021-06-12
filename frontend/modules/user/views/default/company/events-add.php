<script>
    var selectMetro = '<?php    echo \Yii::$app->helper->getMetroSelect()   ?>'
</script>
<div class="row">
    <div class="col-md-12">
        <h1>Личный кабинет организации</h1>
    </div>
    <div class="col-md-2 sidebar">
        <?php if ($user->userInfo->logoImage) : ?>
            <div class="sidebar__logo">
                <img src="<?php echo $user->userInfo->logoImage; ?>">
            </div>
        <?php endif; ?>
        <div class="sidebar__links">
            <span><?php echo $user->userInfo->organizationName; ?></span>
            <?php if ($user->userInfo->vkProfile) :
                $vk = str_replace('https://', '', $user->userInfo->vkProfile);
                $vk = str_replace('http://', '', $vk);
                ?>
                <a target="_blank" href="https://<?php echo $vk; ?>"><?php echo $vk; ?></a>
            <?php endif; ?>
        </div>
        <div class="sidebar__menu">
            <ul>
                <li class="active"><a href="/profile/events">Мероприятия</a></li>
                <li><a href="/profile/discounts">Скидки</a></li>
                <li><a href="/profile/vacancies">Вакансии</a></li>
                <li><a href="/profile/news">Новости</a></li>
                <li><a href="/profile">Профиль</a></li>
                <li><a href="/logout">Выйти</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-10 account__box">
        <div class="main-menu-mobile">
            <a href="/profile/events"><span>Мероприятия</span></a>
            <a href="/profile/discounts"><span>Скидки</span></a>
            <a href="/profile/vacancies"><span>Вакансии</span></a>
            <a href="/profile/news"><span>Новости</span></a>
        </div>
        <div class="account__box_buttons account__box_buttons-form">
            <a href="#" class="btn account__box_buttons-btn btn-red b">Добавить мероприятие</a>
            <a href="/profile/events" class="btn account__box_buttons-btn btn-white">Мероприятия организации</a>
        </div>
        <div class="element__box">
            <form class="form-page" method="POST" enctype="multipart/form-data">
                <div class="form-input">
                    <label>Название мероприятия</label>
                    <input maxlength="45" type="text" placeholder="Введите название мероприятия" required name="title">
                    <label class="error-input"></label>
                </div>
                <div class="form-input">
                    <label>Категория</label>
                    <select class="custom-select vol-select" name="category" required>
                        <?php foreach ($category as $key => $item) : ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-input ">
                    <label>Онлайн</label>
                    <select class="custom-select" name="online" required>
                        <option value="0">Нет</option>
                        <option value="1">Да</option>
                    </select>
                </div>
                <div class="address-wrapper">
                    <div class="row address-box">
                        <div class="col-md-6">
                            <div class="form-input">
                                <label>Метро</label>
                                <select class="custom-select" name="metro[]">
                                    <option></option>
                                    <?php echo \Yii::$app->helper->getMetro(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-input">
                                <label>Адрес (без метро)</label>
                                <input type="text" required placeholder="Введите адрес" name="address[]">
                                <input type="hidden" name="coords[]">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-input ">
                    <label>Многодневное событие</label>
                    <select class="custom-select" name="multi_day" required>
                        <option value="0">Нет</option>
                        <option value="1">Да</option>
                    </select>
                </div>
                <div class="form-input">
                    <label>Дата и время начала</label>
                    <input required type="text" placeholder="Введите дату мероприятия" data-date-format="yyyy-mm-dd"
                           data-timepicker="true" name="date_start">
                </div>
                <div style="display: none" class="form-input">
                    <label>Дата и время окончания</label>
                    <input type="text" placeholder="Введите дату мероприятия" data-date-format="yyyy-mm-dd"
                           data-timepicker="true" name="date_end">
                </div>
                <div class="form-input">
                    <label class="control control-checkbox">
                        Мероприятие бесплатное
                        <input type="checkbox" <?php if ($event->free) echo ' checked ' ?> name="free"/>
                        <div class="control_indicator"></div>
                    </label>
                </div>
                <div class="form-input">
                    <label>Изначальная стоимость
                    </label>
                    <input required type="number" placeholder="Укажите стоимость" name="price">
                </div>
                <div class="form-input">
                    <label>Стоимость со скидкой <span>минимум 30%</span></label>
                    <input required type="number" placeholder="Укажите стоимость" name="price_sale">
                </div>
                <style>
                    .vol-field {
                        display: none;
                    }
                </style>
                <div class="form-input">
                    <label>Описание мероприятия</label>
                    <textarea required placeholder="Введите описания мероприятия" name="text"></textarea>
                </div>


                <div class="form-input">
                    <label class="control control-checkbox">
                        Не публиковать на портале (мероприятие доступно только по ссылке)
                        <input type="checkbox" value="1" name="closed"/>
                        <div class="control_indicator"></div>
                    </label>
                </div>
                <div class="form-input">
                    <label class="control control-checkbox">
                        Кнопка “Участвовать” <span> не создает таблицу с участниками, доступную для скачивания в вашем личном кабинете, а переводит по вашей ссылке</span>
                        <input type="checkbox" value="1" name="closed_registration"/>
                        <div class="control_indicator"></div>
                    </label>
                </div>
                <div style="display: none" class="form-input closed-event">
                    <label>Ссылка на мероприятие <span>(если есть)</span></label>
                    <input type="text" placeholder="Укажите ссылку на мероприятие" name="link">
                </div>

                <div class="form-input">
                    <label>Название организации</label>
                    <input type="text" placeholder="Введите адрес сайта"
                           value="<?php echo \Yii::$app->user->identity->userInfo->organizationName ?>"
                           name="organizationName">
                </div>
                <div class="form-input">
                    <label>Описание организации</label>
                    <textarea required placeholder="Введите описание организации"
                              name="org_description"><?php echo \Yii::$app->user->identity->userInfo->description ?></textarea>
                </div>
                <div class="form-input">
                    <label>Сайт</label>
                    <input type="text" placeholder="Введите адрес сайта"
                           value="<?php echo \Yii::$app->user->identity->userInfo->website ?>" name="website">
                </div>
                <div class="form-input">
                    <label>Телефон организации</label>
                    <input type="text" placeholder="Введите телефон"
                           value="<?php echo \Yii::$app->user->identity->userInfo->phoneNumber ?>" name="phone">
                </div>
                <div class="form-input">
                    <label>Вконтакте организации</label>
                    <input type="text" placeholder="Введите ссылку на соц сети"
                           value="<?php echo \Yii::$app->user->identity->userInfo->vkProfile ?>" name="vk">
                </div>

                <div class="form-input">
                    <label>Загрузить фото мероприятия</label>
                    <div class="file-btn">Добавить обложку</div>
                    <input style="display: none" type="file" name="image">
                    <input type="text" class="hidden-preview-input" value="<?php echo $event->preview ?>" required
                           name="preview">
                    <input type="hidden" required name="image_file">
                    <img class="profile-image" id="image_cropper" style="display: none;" ">
                    <div style="display: none" class="crop-image">Обрезать</div>
                </div>
                <div class="form-input vol-field">
                    <label>Форма поощрения</label>
                    <input type="text" name="encouraging" placeholder="Напишите форму поощрения для волонтеров">
                </div>
                <div class="form-input vol-field">
                    <label>Предусмотрено ли питание</label>
                    <div class="checkbox-box">
                        <label class="control control-checkbox">
                            да
                            <input type="radio" name="food" value="1" checked="checked"/>
                            <div class="control_indicator"></div>
                        </label>
                        <label class="control control-checkbox">
                            нет
                            <input type="radio" name="food" value="0">
                            <div class="control_indicator"></div>
                        </label>
                    </div>
                </div>
                <div class="form-input-submit">
                    <button type="submit">Опубликовать мероприятие</button>
                </div>
            </form>
        </div>
    </div>
</div>
