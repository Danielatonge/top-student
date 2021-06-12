<?php
//echo '<pre>';
//print_r( $user->userInfo);
//echo '</pre>';
//exit();
?>
<div class="row">
    <div class="col-md-12">
        <h1>Личный кабинет студента</h1>
    </div>
    <div class="col-md-2 sidebar">
        <div class="sidebar__menu">
            <ul>
                <li ><a href="/profile/events">Мероприятия</a></li>
                <li><a href="/profile/vacancies">Вакансии</a></li>
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
        <?php endif; ?>
        <div class="main-menu-mobile" style="padding: 0;">
            <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'events')) echo 'active' ?>" href="/profile/events"><span>Мои мероприятия</span></a>
            <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'vacancies')) echo 'active' ?>" href="/profile/vacancies"><span>Мои вакансии</span></a>
            <a href="/logout"><span>Выйти</span></a>
        </div>
        <div class="element__box">
            <form class="form-page" method="POST">
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
                    <label>Фамилия</label>
                    <input type="text" value="<?php echo $user->userInfo->lastName;  ?>" name="lastName">
                </div>
                <div class="form-input">
                    <label>Имя</label>
                    <input type="text" value="<?php echo $user->userInfo->firstName;  ?>" name="firstName">
                </div>
                <div class="form-input">
                    <label>Отчество</label>
                    <input type="text" value="<?php echo $user->userInfo->patronymic;  ?>" name="patronymic">
                </div>
                <div class="form-input">
                    <label>ВУЗ</label>
                    <input type="text"  value="<?php echo $user->userInfo->university;  ?>" name="university">
                </div>
                <div class="form-input">
                    <label>Почта</label>
                    <input type="email"  value="<?php echo $user->userInfo->email;  ?>" name="email">
                </div>
                <div class="form-input">
                    <label>Телефон</label>
                    <input type="text"  value="<?php echo $user->userInfo->phoneNumber;  ?>" name="phoneNumber">
                </div>
                <div class="form-input">
                    <label>Ссылка на VK <span>(если есть)</span></label>
                    <input placeholder="Вставьте ссылку VK" value="<?php echo $user->userInfo->vkProfile;  ?>" type="text" name="vkProfile">
                </div>
                <div class="form-input-submit">
                    <button type="submit">Сохранить информацию</button>
                </div>
            </form>
        </div>
    </div>
</div>
