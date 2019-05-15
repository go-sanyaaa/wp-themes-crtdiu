<?php get_header(); ?>
<div class="wrapper__body">
    <div class="container block">
        <div class="layout">
            <div class="main-content">
                <div class="content">
                    <?php if(function_exists('kama_breadcrumbs')) kama_breadcrumbs('<i class="fas fa-angle-right"></i>'); ?>
                    <?php
                        $current_event_cat = get_queried_object()->term_id | 0;
                    ?>
                    <div class="content__wrapper">
                        <header class="content__header"><h2 class="content__title">Мероприятия</h2></header>
                        <c-events-archive class="content__body" cat-id="<?=$current_event_cat?>"></c-events-archive>
                    </div>
                </div>
            </div>
            <?php get_sidebar('home')?>
        </div>
    </div>
</div>
<?php get_footer(); ?>