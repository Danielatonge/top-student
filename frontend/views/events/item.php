<?php
use common\models\Events;
$image = $item->preview ? $item->preview : $item->image;
$image = str_replace('https://storage.topstudents.ru/source/1', '/image', $image . '?q=90&w=720&h=440');
?>
<div class="context-box-wrapper_item col-sm-12 col-md-6 col-lg-4">
    <a href="/<?php echo $item->parentSlug ?>/events/<?php echo $item->id ?>" class="element_image"
       style="background-image: url('<?php echo $image ?>')">
        <div class="price"><?php echo date('d.m.Y', strtotime($item->date_start)); ?></div>
        <div class="tag">#<?php echo $item->firstCategory ?></div>
        <div class="hover__block">
            <div class="hover__block-date">
                <?php  echo date('d.m.Y H:i:s', strtotime($item->date_start)); ?>
            </div>
            <div class="hover__block-text">
                <?php echo $item->excerpt ?>
            </div>
            <div class="hover__block-organization">
                Организатор: <span href="/<?php echo $item->parentSlug; ?>"><?php echo $item->CompanyName; ?></span>
            </div>
        </div>
    </a>
    <div class="element__box-item-content">
        <div class="element__box-item-content-top">
            <span <?php if ($item->free || !$item->price_sale) : ?> style="font-family: 'BerlingskeSans-Dbd';" <?php endif ?> class="element__box-item-content-top-price"><?php
                if ($item->free) {
                    echo 'Бесплатно';
                } else {
                    echo $item->price_sale ? $item->price_sale . ' руб.' : 'Бесплатно';
                }
                ?></span>
            <?php if ($item->price) : ?>
                <span class="element__box-item-content-top-oldprice"><?php echo is_numeric($item->price) ?  $item->price. ' руб.' : $item->price; ?></span>
            <?php endif; ?>
            <h3><a href="/<?php echo $item->parentSlug ?>/events/<?php echo $item->id ?>"><?php echo $item->excerptTitle ?></a></h3>
            <a href="/<?php echo $item->parentSlug ?>/events/<?php echo $item->id ?>">
                <p><?php echo $item->excerpt ?></p>
            </a>
            <div class="icon-box">
                <div id="event<?php echo $item->id ?>" class="address"><?php if ($item->allMetro) : ?><?php echo $item->allMetro; ?><?php else : ?>
                        <style>
                            #event<?php    echo $item->id   ?>:before {
                                display: none;
                            }
                            #event<?php    echo $item->id   ?> {
                                padding-left : 0;
                            }
                        </style>
                        Онлайн<?php endif; ?></div>
                <div data-type="events" data-id="<?php echo $item->id ?>"
                     class="like <?php if ($item->isLike(\Yii::$app->user->id)) echo 'active'; ?>"></div>
            </div>
        </div>
    </div>
</div>
