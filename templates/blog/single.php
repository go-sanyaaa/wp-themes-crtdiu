<div class="post post--single">
    <?php if(is_single()): the_post()?>
    <figure class="post__thumbnail">
        <img src="<?= apply_filters('crtdiu_get_post_thumbnail',get_the_post_thumbnail_url()) ?>" alt="<?= get_the_post_thumbnail_caption()?>" class="post__thumbnail-img">
    </figure>
    <div class="post__container">
        <header class="post__header">
            <h1 class="post__title"><?= get_the_title() ?></h1>
            <div class="post__meta meta">
                <span class="meta__field">
                    <i class="fas fa-clock post__date-icon meta__icon"></i>
                    <?= get_the_date(); ?>
                </span>
            </div>
        </header>
        <div class="post__infopanel">
            <div class="post-info post-info__cats">Рубрики:
                <?php the_category(', ','multiple'); ?>
            </div>
            <div class="post-info post-info__comments">
                <a href="<?= get_the_permalink(); ?>#comments" class="post-info__link">
                    <i class="far fa-comment post-info__icon post-info__icon-comments"></i>
                    Комментарии: <?= ' '.get_comments_number() ?>
                </a>
            </div>
        </div>
        <div class="post__content">
            <?php the_content() ?>
        </div>
        <?php if(!empty(get_the_tags())): ?>
            <?php foreach (get_the_tags() as $tag):?>
                <ul class="post__tags tag-list">
                    <li class="tag-item"><a class="tag" href="/tags"><?=$tag->name ?></a></li>
                </ul>
            <?php endforeach;?>
        <?php endif; ?>
        <div class="post__hr"></div>
    </div>
    <Comments :post="<?=get_the_ID()?>"></Comments>
    <?php endif;?>
</div>