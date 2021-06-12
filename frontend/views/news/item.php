<?php $image = $item->preview ? $item->preview : $item->image;
$image = str_replace('https://storage.topstudents.ru/source/1', '/image', $image . '?q=90&w=720&h=440');
?>
<div style="margin-bottom: 30px" class="context-box-wrapper_item news-wrapper col-sm-12 col-md-6 col-lg-12">
    <div class="row">
        <div class="context-box-wrapper_item col-sm-12 col-md-6 col-lg-4">
            <a href="/<?php echo $item->parentSlug ?>/news/<?php echo $item->id ?>" class="element_image"
               style="background-image: url('<?php echo $image ?>')">
                <div class="price"><?php echo date('d.m.Y', strtotime($item->created_at)); ?></div>
                <div class="tag">#<?php echo $item->firstCategory ?></div>
                <div class="hover__block">
                    <div class="hover__block-date">
                        <?php echo date('d.m.Y H:i:s', strtotime($item->created_at)); ?>
                    </div>
                    <div class="hover__block-text">
                        <?php echo $item->excerpt ?>
                    </div>
                    <div class="hover__block-organization">
                        Организация: <span href="/<?php echo $item->parentSlug; ?>"><?php echo $item->CompanyName; ?></span>
                    </div>
                </div>
            </a>
        </div>
        <div class="context-box-wrapper_item col-sm-12 col-md-12 col-lg-8">
            <div class="element__box-item-content">
                <div class="element__box-item-content-top">
                    <h3><a href="/<?php echo $item->parentSlug ?>/news/<?php echo $item->id ?>"><?php echo $item->excerptTitle ?></a></h3>
                        <p><?php echo $item->excerpt ?></p>
                    <p style="font-size: 14px; margin-top: 0; margin-bottom: 20px"> Организация: <a href="/<?php echo $item->parentSlug; ?>"><?php echo $item->CompanyName; ?></a>
                    </p>
                    <div class="icon-box">
                        <a href="<?php echo $item->parentSlug ?>/news/<?php echo $item->id ?>" class="user-list-btn">Читать
                            полностью</a>
                        <div data-type="news" data-id="<?php echo $item->id ?>"
                             class="like <?php if ($item->isLike(\Yii::$app->user->id)) echo 'active'; ?>"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
