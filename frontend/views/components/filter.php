<div class="mobile-filter hidden">
    <?php if (!$is_news) : ?>
    <div
            data-type="<?php echo $type ?>"
            data-company-id="<?php echo $company_id; ?>"
            data-is-main="<?php echo $is_main ?>"
            class="mobile-filter-btn online"
    >
                    <span>
                        Онлайн
                    </span>
    </div>
    <?php endif; ?>
    <div class="mobile-filter-btn select">
        <span>Сортировка</span>
        <div class="hidden popup-mobile-block">
            <a href="#" data-type="<?php echo $type ?>"
               data-company-id="<?php echo $company_id; ?>"
               data-is-main="<?php echo $is_main ?>"
               data-sort="date"
            >
                По дате
            </a>
            <a data-type="<?php echo $type ?>"
               data-company-id="<?php echo $company_id; ?>"
               data-is-main="<?php echo $is_main ?>"
               data-sort="like"
            >
                По популярности
            </a>
        </div>
    </div>
</div>
