<?php get_header(); ?>
<div class="wrapper__body">
    <div class="container">
        <div class="layout">
            <div class="main-content">
                <div class="content">
                    <?php if(function_exists('kama_breadcrumbs')) kama_breadcrumbs('<i class="fas fa-angle-right"></i>'); ?>
                    <header class="content__header"><h2 class="content__title">Результаты поиска</h2></header>
                    <?php get_template_part( './templates/blog/posts' );?>
                </div>
            </div>
            <div class="main-sidebar">
                <?php get_sidebar('home')?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
