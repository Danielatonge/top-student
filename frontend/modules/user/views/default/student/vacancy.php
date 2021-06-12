<div class="row">
    <div class="col-md-12">
        <h1>Личный кабинет студента</h1>
    </div>
    <div class="col-md-2 sidebar">
        <div class="sidebar__menu">
            <ul>
                <li ><a href="/profile/events">Мероприятия</a></li>
                <li class="active"><a href="/profile/vacancies">Вакансии</a></li>
                <li ><a href="/profile">Профиль</a></li>
                <li><a href="/logout">Выйти</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-10 account__box">
        <div class="main-menu-mobile" style="padding: 0;">
            <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'events')) echo 'active' ?>" href="/profile/events"><span>Мои мероприятия</span></a>
            <a class="<?php if (strstr($_SERVER['REQUEST_URI'], 'vacancies')) echo 'active' ?>" href="/profile/vacancies"><span>Мои вакансии</span></a>
            <a href="/logout"><span>Выйти</span></a>
        </div>
        <div class="element__box">
            <?php if ($vacancies) :
                foreach ($vacancies as $key => $item) : ?>
                    <div class="element__box_item">
                        <a target="_blank" href="/<?php echo $item->parentSlug ?>/vacancies/<?php echo $item->slug ?>" class="element_image" style="background-image: url('<?php echo $item->image ?>')">
                            <?php if ($item->salary) : ?>
                                <div class="price"><?php echo $item->salary ?></div>
                            <?php endif; ?>
                            <div class="tag">#<?php echo $item->firstCategory ?></div>
                        </a>
                        <div class="element__box-item-content">
                            <div class="element__box-item-content-top">
                                <h3><?php echo $item->title ?></h3>
                                <p><?php echo $item->getExcerpt(175) ?></p>
                                <div class="icon-box">
                                    <div <?php if (!$item->allMetro) : ?> style="opacity: 0;" <?php endif; ?> class="address"><?php echo $item->allMetro ?></div>
                                    <div class="like"></div>
                                </div>
                            </div>
                            <div class="edit-box">
                                <a class="user-list-btn"  href="/profile/disapprove?id=<?php echo $item->id ?>&type=vacancies">Отказать от вакансии</a>
                                <div class="edit-box-icons">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php    endforeach;   ?>
            <?php else : ?>
                <div class="element__box_item">
                    <div class="element__box-item-content">
                        <div class="element__box-item-content-top">
                            <h3>У вас пока нету вакансий</h3>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
