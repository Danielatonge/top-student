<?php  $image = $item->preview ? $item->preview : $item->image;
$image = str_replace('https://storage.topstudents.ru/source/1', '/image', $image . '?q=90&w=720&h=440');
?>
<div class="context-box-wrapper_item col-sm-12 col-md-6 col-lg-4">
    <a href="/<?php echo $item->parentSlug ?>/discounts/<?php echo $item->id ?>" class="element_image"
       style="background-image: url('<?php echo $image ?>')">
        <?php
            $str = '';
            if ($item->sales) {
                if (mb_strlen($item->sales) >= 18) {
                    $str = 'style="font-size: 10px"';
                } elseif (mb_strlen($item->sales) > 15) {
                    $str = 'style="font-size: 11px"';
                } else if (mb_strlen($item->sales) > 10) {
                    $str = 'style="font-size: 13px"';
                }
            }
            if (is_numeric($item->sales)) {
                $item->sales .= '%';
            }
        ?>
        <div <?php echo $str ?> class="price">  <?php echo $item->free ? 'Бесплатно' : $item->sales ; ?></div>
        <div class="tag">#<?php echo $item->firstCategory ?></div>
        <div class="hover__block">
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
            <h3><a href="/<?php echo $item->parentSlug ?>/discounts/<?php echo $item->id ?>"><?php echo $item->excerptTitle ?></a></h3>
            <a href="/<?php echo $item->parentSlug ?>/discounts/<?php echo $item->id ?>">
                <p><?php echo $item->excerpt ?></p>
            </a>
            <div class="icon-box">
                <div <?php if (!$item->allMetro) : ?> style="opacity: 0;" <?php endif; ?> class="address"><?php echo $item->allMetro; ?></div>
                <div data-type="discounts" data-id="<?php echo $item->id ?>"
                     class="like <?php if ($item->isLike(\Yii::$app->user->id)) echo 'active'; ?>"></div>
            </div>
        </div>
    </div>
</div>
