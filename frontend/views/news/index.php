        <?php if ($banner['object_title5']) : ?>
<div class="slider-wrapper" style="background-image: url('images/bgc.png')">
    <div class="content__slider">
            <?php foreach ($banner['object_title5'] as $key => $item) : ?>
                <div class="content__slider-item">
                    <div class="content__slider-item-wrapper">

                        <div class="content__slider-item-description">
                            <a class="content__slider-item-title" href="<?php echo $banner['object_link5'][$key] ?>">
                                <?php echo $item ?>
                            </a>
                            <a  class="content__slider-item-text" href="<?php echo $banner['object_link5'][$key] ?>">
                                <?php echo $banner['object_text5'][$key] ?>
                            </a>
                            <?php if (\Yii::$app->user->identity->type == 1) : ?>
                                <a class="content__slider-item-add" href="/profile/news/create">Предложить новость</a>
                            <?php elseif (\Yii::$app->user->isGuest) : ?>
                                <a class="content__slider-item-add" data-fancybox href="#registration_organization">Предложить новость</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach;   ?>
    </div>
</div>
        <?php    endif;   ?>

<div class="context-box">
    <div class="context-box__header">
        <div class="context-box__header-left">
            <div class="context-box__header-title">
                <a href="#">Новости</a>
            </div>
            <?php echo \Yii::$app->view->renderFile('@frontend/views/components/filter.php',
                [
                    'type'=> 'news',
                    'is_main' => 0,
                    'company_id' => 0,
                    'is_news' => true
                ]); ?>
            <div class="context-box__header-add">
                <?php if (\Yii::$app->user->identity->type == 1) : ?>
                    <a href="/profile/news/create">Добавить новость</a>
                <?php elseif (\Yii::$app->user->isGuest) : ?>
                    <a data-fancybox href="#registration_organization">Добавить новость</a>
                <?php endif; ?>

            </div>
        </div>
        <div class="context-box__header-right">
            <div href="#sort_popup" class="context-box__header-filter popup-box2">
                <span>Сортировка</span>
                <div id="sort_popup" class="hidden popup-block">
                    <a href="#" data-type="news" data-sort="date">По дате</a><br>
                    <a href="#" data-type="news" data-sort="like">По популярности</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($newsCategory)  : ?>
        <div class="context-box-tags">
            <?php foreach ($newsCategory as $key => $item) : ?>
                <a href="#" data-category="<?php echo $item->id ?>" data-type="news" class="context-box-tags-item">#<?php echo $item->name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="context-box-wrapper row">
        <?php if ($news) : ?>
            <?php foreach ($news as $key => $item) :
                echo \Yii::$app->view->renderFile('@frontend/views/news/item.php', ['item'=> $item]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
<style>
    .preview-link {
        position: relative;
        width: 100%;
        height: 100%;
    }
</style>
