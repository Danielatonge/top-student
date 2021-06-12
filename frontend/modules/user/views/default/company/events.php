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
                <li class="active"><a href="/profile/events">Мероприятия</a></li>
                <li><a href="/profile/discounts">Скидки</a></li>
                <li><a href="/profile/vacancies">Вакансии</a></li>
                <li ><a href="/profile/news">Новости</a></li>
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
            <a href="/profile/events/create" class="btn account__box_buttons-btn btn-white">Добавить мероприятие</a>
            <a href="#" class="btn account__box_buttons-btn btn-red">Мероприятия организации</a>
        </div>
        <div class="element__box">
            <?php if ($events) : 
                foreach ($events as $key => $item) :
                    $image = $item->preview ? $item->preview : $item->image
                    ?>
            <div class="element__box_item">
                <a target="_blank" href="/<?php echo $item->parentSlug ?>/events/<?php echo $item->id ?>" class="element_image" style="background-image: url('<?php echo $image ?>')">
                    <div class="price"><?php echo date('d.m.Y', strtotime($item->date_start)); ?></div>
                    <div class="tag">#<?php echo $item->firstCategory ?></div>
                </a>
                <div class="element__box-item-content">
                    <div class="element__box-item-content-top">
                        <h3><a href="/<?php echo $item->parentSlug ?>/events/<?php echo $item->id ?>"><?php echo $item->title ?></a></h3>
                        <p><?php echo $item->getExcerpt(175) ?></p>
                        <div class="icon-box">
                            <div <?php if (!$item->allMetro) : ?> style="opacity: 0;" <?php endif; ?> class="address"><?php echo $item->allMetro ?></div>
                            <div class="like"></div>
                        </div>
                    </div>
                    <div class="edit-box">
                        <?php if ($item->closed_registration) : ?>
                            <a class="user-list-btn" style="font-size: 16px"
                               >
                                Регистрация на сайте организации
                            </a>
                        <?php else: ?>
                        <a class="user-list-btn"
                            <?php if ($item->booking) : ?> href="/profile/export?id=<?php echo $item->id ?>&type=events" <?php endif; ?>>
                            Список участников (<?php echo $item->booking ?>)
                        </a>
                        <?php endif; ?>
                        <div class="edit-box-icons">
                            <a href="/profile/events/edit?id=<?php echo $item->id ?>" class="edit">Редактировать</a>
                            <a href="/profile/events/delete?id=<?php echo $item->id ?>" class="remove">Удалить</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php    endforeach;   ?>
            <?php else : ?>
                <div class="element__box_item">
                    <div class="element__box-item-content">
                        <div class="element__box-item-content-top">
                            <h3>У вас пока нету мероприятий</h3>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
