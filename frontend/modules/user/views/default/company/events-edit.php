<?php if ($event->category_id != 3) : ?>
    <style>
        .vol-field {
            display: none;
        }
    </style>
<?php endif; ?>
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
        <div class="small-title-box small-title-box-form">
            <h2><?php echo $event->title ?></h2>
        </div>

        <div class="element__box">
            <form class="form-page events-form" method="POST" enctype="multipart/form-data">
                <div class="form-input">
                    <label>Название мероприятия</label>
                    <input maxlength="45" type="text" value="<?php echo $event->title ?>" placeholder="Введите название мероприятия"
                           required name="title">
                    <label class="error-input"></label>
                </div>

                <div class="form-input">
                    <label>Категория</label>
                    <select class="custom-select vol-select" name="category" required>
                        <?php foreach ($category as $key => $item) : ?>
                            <option <?php if ($item->id == $event->category_id) echo ' selected '; ?>
                                    value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-input ">
                    <label>Онлайн</label>
                    <select class="custom-select" name="online" required>
                        <option value="0">Нет</option>
                        <option <?php if ($event->is_online) echo ' selected ' ?> value="1">Да</option>
                    </select>
                </div>

                <?php
                $address = json_decode($event->address, true);
                $metro = json_decode($event->metro, true);
                $coords = json_decode($event->coords, true);
                ?>
                <div <?php if ($event->is_online) : ?> style="display: none" <?php endif; ?> class="address-wrapper">
                    <div class="row address-box">
                        <?php if ($address) : ?>
                            <?php foreach ($address as $key => $item) : ?>
                                <div class="col-md-6">
                                    <div class="form-input">
                                        <label>Метро</label>
                                        <select class="custom-select" name="metro[]">
                                            <option></option>
                                            <?php echo \Yii::$app->helper->getMetro($metro[$key]); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input">
                                        <label>Адрес (без метро)</label>
                                        <input type="text" <?php if (!$event->is_online) echo ' required ' ?>
                                               placeholder="Введите адрес" value="<?php echo $item ?>" name="address[]">
                                        <input type="hidden" value="<?php echo $coords[$key] ?>" name="coords[]">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
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
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-input ">
                    <label>Многодневное событие</label>
                    <select class="custom-select" name="multi_day" required>
                        <option value="0">Нет</option>
                        <option <?php if ($event->multi_day) echo ' selected ' ?> value="1">Да</option>
                    </select>
                </div>
                <div class="form-input">
                    <label>Дата и время начала</label>
                    <input required type="text" placeholder="Введите дату мероприятия" data-date-format="yyyy-mm-dd"
                           value="<?php echo $event->date_start ?>" data-timepicker="true" name="date_start">
                </div>
                <div <?php if (!$event->multi_day) : ?> style="display: none" <?php endif; ?> class="form-input">
                    <label>Дата и время окончания</label>
                    <input type="text" placeholder="Введите дату мероприятия" data-date-format="yyyy-mm-dd"
                           value="<?php echo $event->date_end ?>" data-timepicker="true" name="date_end">
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
                    <input <?php if ($event->free): echo ' disabled '; else : echo 'required'; endif; ?> type="text"
                                                                                                         placeholder="Укажите стоимость"
                                                                                                         value="<?php echo $event->price ?>"
                                                                                                         name="price">
                </div>
                <div class="form-input">
                    <label>Стоимость со скидкой <span>минимум 30%</span></label>
                    <input <?php if ($event->free): echo ' disabled '; else : echo 'required'; endif; ?> type="text"
                                                                                                         placeholder="Укажите стоимость"
                                                                                                         value="<?php echo $event->price_sale ?>"
                                                                                                         name="price_sale">
                </div>
                <div class="form-input">
                    <label>Описание мероприятия</label>
                    <textarea required placeholder="Введите описания мероприятия"
                              name="text"><?php echo $event->text ?></textarea>
                </div>
                <div class="form-input">
                    <label class="control control-checkbox">
                        Не публиковать на портале (мероприятие доступно только по ссылке)
                        <input type="checkbox" <?php if ($event->closed) echo ' checked ' ?> name="closed"/>
                        <div class="control_indicator"></div>
                    </label>
                </div>
                <div class="form-input">
                    <label class="control control-checkbox">
                        Кнопка “Участвовать” <span> не создает таблицу с участниками, доступную для скачивания в вашем личном кабинете, а переводит по вашей ссылке</span>
                        <input type="checkbox" <?php if ($event->closed_registration) echo ' checked ' ?>
                               name="closed_registration"/>
                        <div class="control_indicator"></div>
                    </label>
                </div>
                <div <?php if (!$event->closed_registration) : ?> style="display: none" <?php else : ?> required <?php endif; ?>
                        class="closed-event form-input">
                    <label>Ссылка на мероприятие <span>(если есть)</span></label>
                    <input type="text" value="<?php echo $event->link ?>" placeholder="Укажите ссылку на мероприятие"
                           name="link">
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
                    <div class="file-btn">Изменить обложку</div>
                    <input style="display: none" type="file" name="image">
                    <input type="text" class="hidden-preview-input" value="<?php echo $event->preview ?>" required
                           name="preview">
                    <input type="hidden" value="<?php echo $event->image ?>" name="image_file">
                    <img class="profile-image" src="<?php echo $event->preview ?>"
                         id="image_cropper" <?php if (!$event->preview) : ?> style="display: none;" <?php endif; ?> ">
                    <div style="display: none" class="crop-image">Обрезать</div>
                </div>
                <div class="form-input vol-field">
                    <label>Форма поощрения</label>
                    <input type="text" name="encouraging" value="<?php echo $event->encouraging ?>"
                           placeholder="Напишите форму поощрения для волонтеров">
                </div>
                <div class="form-input vol-field">
                    <label>Предусмотрено ли питание</label>
                    <div class="checkbox-box">
                        <label class="control control-checkbox">
                            да
                            <input type="radio" name="food" value="1" <?php if ($event->food) echo ' checked ' ?> />
                            <div class="control_indicator"></div>
                        </label>
                        <label class="control control-checkbox">
                            нет
                            <input type="radio" name="food" value="0" <?php if (!$event->food) echo ' checked ' ?>>
                            <div class="control_indicator"></div>
                        </label>
                    </div>
                </div>
                <div class="form-input-submit">
                    <button type="submit">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
