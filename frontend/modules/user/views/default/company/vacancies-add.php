<script>
    var selectMetro =  '<?php    echo \Yii::$app->helper->getMetroSelect()   ?>'
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
            <span><?php echo $user->userInfo->organizationName;  ?></span>
            <?php if ($user->userInfo->vkProfile) :
                $vk = str_replace('https://', '',  $user->userInfo->vkProfile);
                $vk = str_replace('http://', '',  $vk);
                ?>
                <a target="_blank" href="https://<?php echo $vk;  ?>"><?php echo $vk;  ?></a>
            <?php endif; ?>
        </div>
        <div class="sidebar__menu">
            <ul>
                <li><a href="/profile/events">скидки</a></li>
                <li><a href="/profile/discounts">Скидки</a></li>
                <li class="active"><a href="/profile/vacancies">Вакансии</a></li>
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
            <a href="#" class="btn account__box_buttons-btn btn-red b">Добавить вакансию</a>
            <a href="/profile/vacancies" class="btn account__box_buttons-btn btn-white">Вакансии организации</a>
        </div>
        <div class="element__box">
            <form class="form-page" method="POST" enctype="multipart/form-data">
                <div class="form-input">
                    <label>Название работы</label>
                    <input maxlength="45" type="text" placeholder="Введите название работы" required name="title">
                    <label class="error-input"></label>
                </div>

                <div class="form-input">
                    <label>Заработная плата</label>
                    <input type="number" placeholder="Введите заработную плату" name="salary">
                </div>
                <div class="form-input">
                    <label>Категория</label>
                    <select class="custom-select" name="category" required>
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
                <div class="form-input">
                    <label>Описание</label>
                    <textarea required placeholder="Введите описания вакансии" name="text"></textarea>
                </div>
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
                            <input type="text" placeholder="Введите адрес" name="address[]">
                            <input type="hidden" name="coords[]">
                        </div>
                    </div>

                </div>
                <div class="file-repeater"> + Добавить адрес</div>

                <div class="form-input">
                    <label>Загрузить обложку</label>
                    <div class="file-btn">Добавить обложку</div>
                    <input style="display: none" type="file" name="image">
                    <input  type="text" class="hidden-preview-input" required  name="preview">
                    <input type="hidden" name="image_file">
                    <img class="profile-image" id="image_cropper" style="display: none;" ">
                    <div style="display: none" class="crop-image">Обрезать</div>
                </div>
                <div class="form-input-submit">
                    <button type="submit">Опубликовать вакансию</button>
                </div>
            </form>
        </div>
    </div>
</div>
