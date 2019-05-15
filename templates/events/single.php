<div class="post post--single event event--single">
    <?php if(is_single()): the_post()?>
        <figure class="event__thumbnail">
            <img class="event__thumbnail-img"
                 src="<?= apply_filters('crtdiu_get_post_thumbnail',get_the_post_thumbnail_url()) ?>"
                 alt="<?= get_the_post_thumbnail_caption()?>"
            >
        </figure>
        <div class="event__container">
            <header class="post__header">
                <?php
                    $taxonomy = 'event_cat';
                    $terms = get_the_terms(get_the_ID(),$taxonomy);
                    if(!empty($terms)):
                ?>
                <div class="event__cats tag-list">
                    <?php foreach ($terms as $key=>$term): ?>
                        <a class="tag-item tag" href="<?=get_term_link($term->term_id,$term->taxonomy)?>" >
                            <?= $term->name ?>
                        </a>
                    <?php endforeach;?>
                </div>
                <?php endif;?>

                <h1 class="event__title"><?= get_the_title() ?></h1>
                <div class="event__infopanel">
                    <div class="event__meta meta">
                        <span class="meta__field meta__field--chips meta__field--blue">
                            <span class="text--bold"></span>
                            <span class="text--regular"><?= get_the_date(); ?></span>
                        </span>
                        <span class="meta__field meta__field--chips">
                            <i class="fas fa-clock meta__icon"></i>
                            <?= get_the_date(); ?>
                        </span>
                    </div>
                    <div class="event__actions">
                        <event-subscribe event-id="<?= get_the_ID()?>" is-register="true"></event-subscribe>
                    </div>
                </div>
                <div class="event__infopanel">
                    <div class="event__meta meta">
                        <span class="meta__field">
                            <i class="fas fa-clock meta__icon"></i>
                            <?= get_the_date(); ?>
                        </span>
                        <span class="meta__field">
                            <i class="fas fa-users meta__icon"></i>
                            50
                        </span>
                    </div>
                </div>
            </header>
            <hr class="post__hr">
            <div class="content__header">
                <h2 class="content__title">Описание:</h2>
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
        </div>
        <hr class="post__hr">
        <div id="comments" class="post__container comments__container">
            <div class="content__header">
                <h2 class="content__title"><?= get_comments_number_text()?></h2>
            </div>
        </div>
    <?php endif;?>
</div>