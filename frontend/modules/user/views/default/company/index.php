<div class="row">
    <div class="col-md-12">
        <h1>Личный кабинет организации</h1>
    </div>
    <div class="col-md-2 sidebar">
        <?php if ($user->userInfo->logoImage) : ?>
        <div class="sidebar__logo">
            <img src="<?php echo $user->userInfo->logoImage;  ?>">
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
                <li ><a href="/profile/events">Мероприятия</a></li>
                <li><a href="/profile/discounts">Скидки</a></li>
                <li><a href="/profile/vacancies">Вакансии</a></li>
                <li><a href="/profile/news">Новости</a></li>
                <li class="active"><a href="/profile">Профиль</a></li>
                <li><a href="/logout">Выйти</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-10 account__box">
        <?php if ($_GET['error']) : ?>
            <h2 style="color: #ff4545;"><?php echo $_GET['error']; ?></h2>
        <?php endif; ?>
        <?php if ($_GET['message']) : ?>
            <div class="small-title-box">
                <h2 style="color: green;"><?php echo $_GET['message'] ?></h2>
            </div>
        <?php elseif (!$user->approve_email  && $user->email) : ?>
<!--            <div class="small-title-box">-->
<!--                <h2 style="color: #ff4545;">Ваш профиль не подтвержден</h2>-->
<!--                <h3>Для подтверждения перейдите по ссылке в письме</h3>-->
<!--                <a style="color: #ff4545;" href="/site/send-restore-message">Выслать повторно</a>-->
<!--            </div>-->
        <?php endif; ?>
        <div class="main-menu-mobile">
            <a href="/profile/events"><span>Мероприятия</span></a>
            <a href="/profile/discounts"><span>Скидки</span></a>
            <a href="/profile/vacancies"><span>Вакансии</span></a>
            <a href="/profile/news"><span>Новости</span></a>
        </div>
        <div class="element__box">
            <form class="form-page" enctype="multipart/form-data" method="POST">
                <div class="form-input">
                    <label>Логин</label>
                    <input type="text" required value="<?php echo $user->username; ?>" name="username">
                </div>
                <div class="form-input">
                    <label>Пароль</label>
                    <input type="password" placeholder="********" name="password">
                </div>
                <div class="form-input">
                    <label>Повторите пароль</label>
                    <input type="password" placeholder="********" name="passwordConfirmation">
                </div>
                <div class="form-input">
                    <label>Наименование</label>
                    <input type="text" value="<?php echo $user->userInfo->organizationName;  ?>" name="name">
                </div>
                <div class="form-input">
                    <label>URL</label>
                    <input type="text" required value="<?php echo $user->userInfo->slug;  ?>" name="slug">
                </div>
                <div class="form-input">
                    <label>Описание</label>
                    <textarea name="description"><?php echo $user->userInfo->description;  ?></textarea>
                </div>
                <div class="form-input">
                    <label>Почта</label>
                    <input type="email" value="<?php echo $user->userInfo->email;  ?>" name="email">
                </div>
                <div class="form-input">
                    <label>Телефон</label>
                    <input type="text"  value="<?php echo $user->userInfo->phoneNumber;  ?>" name="phone">
                </div>
                <div class="form-input">
                    <label>Ссылка на сайт <span>(если есть)</span></label>
                    <input placeholder="Вставьте ссылку" type="text" value="<?php echo $user->userInfo->website;  ?>"  name="website">
                </div>
                <div class="form-input">
                    <label>Ссылка на VK <span>(если есть)</span></label>
                    <input placeholder="Вставьте ссылку VK" value="<?php echo $user->userInfo->vkProfile ? $user->userInfo->vkProfile : 'vk.com/';  ?>" type="text" name="vkProfile">
                </div>
                <div class="form-input">
                    <label>Ссылка на Instagram <span>(если есть)</span></label>
                    <input type="text" placeholder="Вставьте ссылку Instagram" value="<?php echo $user->userInfo->instagramProfile;  ?>" name="instagramProfile">
                </div>
                <div class="form-input">
                    <label>Адрес <span>(если есть)</span></label>
                    <input type="text" placeholder="Введите адрес" value="<?php echo $user->userInfo->address;  ?>" name="address">
                </div>
                <?php if ($user->userInfo->filials) :
                        $filials = json_decode($user->userInfo->filials, true);
                    ?>
                <?php endif; ?>
                <div class="row address-box">
                    <?php if ($filials) : ?>
                        <?php foreach ($filials as $key => $item) : ?>
                        <div class="col-md-12">
                            <div class="form-input">
                                <?php if (!$key) : ?><label>Филиалы  <span>(если есть)</span></label><?php endif; ?>
                                <input type="text" value="<?php echo $item ?>" placeholder="Введите адрес филиала" name="filials[]">
                            </div>
                        </div>
                        <?php    endforeach;   ?>
                    <?php else : ?>
                        <div class="col-md-12">
                            <div class="form-input">
                                <label>Филиалы  <span>(если есть)</span></label>
                                <input type="text" placeholder="Введите адрес филиала" name="filials[]">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
               
                <div class="file-repeater1"> + Добавить филиал</div>
                <div class="form-input">
                    <label>Загрузить логотип</label>
                    <div class="file-btn">Добавить логотип</div>
                    <input style="display: none" type="file" name="image">
                    <input style="display: none" type="text" value="<?php echo $user->userInfo->logoImage;  ?>"  name="logoImage">
                    <img class="profile-image" id="image_cropper" style="<?php  if (!$user->userInfo->logoImage) echo ' display: none; ' ?>" src="<?php echo $user->userInfo->logoImage;  ?>">
                    <div style="display: none" class="crop-image">Обрезать</div>
                </div>
                <div class="form-input-submit">
                    <button type="submit">Сохранить информацию</button>
                </div>
            </form>
        </div>
    </div>
</div>
