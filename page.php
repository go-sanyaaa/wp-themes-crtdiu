<?php get_header(); ?>
    <div class="wrapper__body">
        <div class="container block">
            <div class="layout">
                <div class="main-content">
                    <div class="content">
                        <?php if(function_exists('kama_breadcrumbs')) kama_breadcrumbs('<i class="fas fa-angle-right"></i>'); ?>
                        <header class="content__header"><h2 class="content__title"><?php the_title() ?></h2></header>
                        <div class="page__container">
                            <div class="page__content">
	                            <?php
	                            the_post();
	                            $more = 1; // отображаем полностью всё содержимое поста
	                            the_content(); // выводим контент
	                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php get_sidebar('home')?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>