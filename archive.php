<?php get_header(); ?>
<div class="wrapper__body">
    <div class="container block">
        <div class="layout">
            <div class="main-content">
                <div class="content">
                    <?php if(function_exists('kama_breadcrumbs')) kama_breadcrumbs('<i class="fas fa-angle-right"></i>'); ?>
                    <header class="content__header"><h2 class="content__title"><?= single_term_title() ?></h2></header>
                    <?php get_template_part( './templates/blog/posts' );?>
                    <?php the_posts_pagination([
                        'prev_text' => '<i class="fas fa-angle-left"></i>',
                        'next_text' => '<i class="fas fa-angle-right"></i>',
                        'screen_reader_text' => __( 'Навигация по страницам:' )
                    ])?>
                </div>
            </div>
            <?php get_sidebar('home')?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
