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
                <li class="active"><a href="/profile/news">Новости</a></li>
                <li ><a href="/profile">Профиль</a></li>
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
        <div class="account__box_buttons">
            <a href="/profile/news/create" class="btn account__box_buttons-btn btn-white">Добавить новость</a>
            <a href="#" class="btn account__box_buttons-btn btn-red">Новости организации</a>
        </div>
        <div class="element__box">
            <?php if ($news) :
                foreach ($news as $key => $item) :
                    $image = $item->preview ? $item->preview : $item->image
                    ?>
                    <div class="element__box_item">
                        <a href="/<?php echo $item->parentSlug ?>/news/<?php echo $item->id ?>" class="element_image" style="background-image: url('<?php echo $image ?>')">
                            <?php if ($item->date_start) : ?>
                                <div class="price"><?php echo date('d.m.Y', strtotime($item->date_start)) ?></div>
                            <?php endif; ?>
                            <div class="tag">#<?php echo $item->firstCategory ?></div>
                        </a>
                        <div class="element__box-item-content">
                            <div class="element__box-item-content-top">
                                <h3><a href="/<?php echo $item->parentSlug ?>/news/<?php echo $item->id ?>"><?php echo $item->title ?></a></h3>
                                <p><?php echo $item->excerpt ?></p>
                                <div class="icon-box">
                                    <div class="like"></div>
                                </div>
                                <style>
                                    .icon-box {
                                        justify-content: flex-end;
                                    }
                                </style>
                            </div>
                            <div class="edit-box">
                                <a class="user-list-btn" ></a>
                                <div class="edit-box-icons">
                                    <a href="/profile/news/edit?id=<?php echo $item->id ?>" class="edit">Редактировать</a>
                                    <a href="/profile/news/delete?id=<?php echo $item->id ?>" class="remove">Удалить</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php    endforeach;   ?>
            <?php else : ?>
                <div class="element__box_item">
                    <div class="element__box-item-content">
                        <div class="element__box-item-content-top">
                            <h3>У вас пока нету новостей</h3>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
