<div class="content__body posts">
    <?php if( have_posts() ){
        while( have_posts() ){ the_post(); ?>
            <div class="post post--item">
                <div class="post-main">
                    <a class="post__thumbnail" href="<?= get_the_permalink(); ?>">
                        <img src="<?= apply_filters('crtdiu_get_post_thumbnail',get_the_post_thumbnail_url()) ?>" alt="<?= get_the_post_thumbnail_caption()?>" class="post__thumbnail-img">
                    </a>
                    <div class="post__content">
                        <div class="post__header">
                            <a href="<?= get_the_permalink(); ?>" class="post__title-link">
                                <h2 class="post__title"><?= get_the_title();?></h2>
                            </a>
                            <div class="post__meta meta">
                                <span class="meta__field">
                                    <i class="fas fa-clock post__date-icon meta__icon"></i>
                                    <?= get_the_date(); ?>
                                </span>
                            </div>
                        </div>
                        <div class="post__body">
                            <p class="post__desc"><?= get_the_excerpt();?></p>
                        </div>
                        <?php if(!empty(get_the_tags()) & false): ?>
                            <?php foreach (get_the_tags() as $tag):?>
                                <ul class="post__tags tag-list">
                                    <li class="tag-item"><a class="tag" href="/tags"><?=$tag->name ?></a></li>
                                </ul>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="post__footer">
                    <div class="post__infopanel">
                        <div class="post-info post-info__cats">Рубрики:
                            <?php the_category(', ','multiple'); ?>
                        </div>
                        <div class="post-info post-info__comments">
                            <i class="far fa-comment post-info__icon post-info__icon-comments"></i>
                            Комментарии: <a href="<?= get_the_permalink(); ?>#comments" class="post-info__link"><?= ' '.get_comments_number() ?></a>
                        </div>
                    </div>
                    <a href="<?= get_the_permalink(); ?>" class="post-link">Перейти</a>
                </div>
            </div>
        <?php }}?>
</div>