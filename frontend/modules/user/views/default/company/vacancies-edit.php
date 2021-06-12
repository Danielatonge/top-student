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
                <li><a href="/profile/events">Мероприятия</a></li>
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
        <div class="small-title-box small-title-box-form">
            <h2><?php echo $vacancy->title ?></h2>
        </div>
        <div class="element__box">
            <form class="form-page" method="POST" enctype="multipart/form-data">
                <div class="form-input">
                    <label>Название работы</label>
                    <input maxlength="45" type="text" placeholder="Введите название работы" value="<?php echo $vacancy->title ?>"
                           required name="title">
                    <label class="error-input"></label>
                </div>

                <div class="form-input">
                    <label>Заработная плата</label>
                    <input type="text" placeholder="Введите заработную плату" value="<?php echo $vacancy->salary ?>"
                           name="number">
                </div>
                <div class="form-input">
                    <label>Категория</label>
                    <select class="custom-select" name="category" required>
                        <?php foreach ($category as $key => $item) : ?>
                            <option <?php if ($item->id == $vacancy->category_id) echo ' selected '; ?>
                                    value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-input">
                    <label>Описание</label>
                    <textarea required placeholder="Введите описания вакансии"
                              name="text"><?php echo $vacancy->text ?></textarea>
                </div>
                <?php
                $address = json_decode($vacancy->address, true);
                $metro = json_decode($vacancy->metro, true);
                $coords = json_decode($vacancy->coords, true);
                ?>
                <div class="row address-box">
                    <?php if ($address) : ?>
                        <?php foreach ($address as $key => $item) : ?>
                            <div class="col-md-6">
                                <div class="form-input">
                                    <label>Метро</label>
                                    <select class="custom-select" name="metro[]">
                                        <option></option>
                                        <?php echo \Yii::$app->helper->getMetro( $metro[$key]); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-input">
                                    <label>Адрес (без метро)</label>
                                    <input type="text" placeholder="Введите адрес" value="<?php echo $item ?>"
                                           name="address[]">
                                    <input type="hidden" value="<?php echo $coords[$key] ?>" name="coords[]">
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="file-repeater"> + Добавить адрес</div>
                <div class="form-input">
                    <div class="file-btn">Изменить обложку</div>
                    <input style="display: none" type="file" name="image">
                    <input  type="text" class="hidden-preview-input" value="<?php echo $vacancy->preview ?>" required  name="preview">
                    <input type="hidden" value="<?php echo $vacancy->image ?>" name="image_file">
                    <img class="profile-image" src="<?php echo $vacancy->preview ?>"
                         id="image_cropper" <?php if (!$vacancy->preview) : ?> style="display: none;" <?php endif; ?> ">
                    <div style="display: none" class="crop-image">Обрезать</div>
                </div>
                <div class="form-input-submit">
                    <button type="submit">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>
