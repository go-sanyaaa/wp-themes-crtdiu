<div class="post post--single associations associations--single">
    <?php if(is_single()): the_post()?>
        <figure class="associations__card">
            <img src="<?= apply_filters('crtdiu_get_post_thumbnail',get_the_post_thumbnail_url()) ?>" alt="<?= get_the_post_thumbnail_caption()?>" class="associations__card-img">
            <div class="associations__card-after"></div>
            <div class="associations__card-data">
                <div class="associations__header">
                    <h2 class="associations__title"><?= get_the_title();?></h2>
                </div>
                <div class="associations__data">
                    <p class="associations__desc"><?= get_the_excerpt();?></p>
                </div>
                <div class="associations__links">
                    <c-assoc-rec :assoc-name="`<?= get_the_title();?>`" :assoc-id="<?=get_the_ID()?>"></c-assoc-rec>
                </div>
            </div>
        </figure>
        <div class="post__container">
            <div class="post__content">
                <?php the_content() ?>
            </div>
            <div class="post__hr"></div>
        </div>
        <Comments :post="<?=get_the_ID()?>"></Comments>
    <?php endif;?>
</div>