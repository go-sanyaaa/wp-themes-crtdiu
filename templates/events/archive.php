<div class="content__body associations">
    <?php if( have_posts() ){
        while( have_posts() ){ the_post(); ?>
            <a  href="<?= get_the_permalink(); ?>" class="associations__item">
                <div class="associations__main">
                    <div class="associations__header">
                        <h2 class="associations__title"><?= get_the_title();?></h2>
                    </div>
                    <div class="associations__data">
                        <p class="associations__desc"><?= get_the_excerpt();?></p>
                    </div>
                    <div class="associations__links">
                        <span class="associations__link-more">Страница объединения<i class="fas fa-long-arrow-alt-right associations__link-more-icon"></i></span>
                    </div>
                </div>
            </a>
        <?php }}?>
</div>