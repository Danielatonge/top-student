<div class="context-box">
    <div class="row">
        <div class="col-md-12">
             <h1>О нас</h1>
        </div>
        <div class="col-md-6">
            <?php echo nl2br($data['text']) ?>
        </div>
        <div class="col-md-6">
                <a data-fancybox href="<?php echo $data['link'] ?>">
            <div class="preview-link">
                    <img style="border-radius: 15px" src="<?php echo str_replace('\\', '/', $data['image']['base_url'] . $data['image']['path']) ?>" >
            </div>
                </a>
        </div>
        <div class="col-md-8  mt-5">
            <a href="#idea" data-fancybox class="btn btn-red">Предложить идею</a>
            <a href="#team" data-fancybox class="btn btn-white">Вступить в команду</a>
        </div>
    </div>
</div>
<style>
    .context-box > .row > div {
        padding-left: 0 !important;
    }
</style>
