<?php get_header(); ?>
<div class="wrapper__body">
    <div class="container block">
        <div class="layout">
            <div class="main-content">
                <div class="content">
                    <?php if(function_exists('kama_breadcrumbs')) kama_breadcrumbs('<i class="fas fa-angle-right"></i>'); ?>

                    <?php
                    $terms = get_terms( 'orientation', array(
                        'orderby'    => 'count',
                        'hide_empty' => true,
                        'order' => 'DESC'
                    ) );
                        foreach ($terms as $term):
                        $args = array(
                            'post_type' => 'crtdiu_association',
                            'orientation' => $term->slug
                        );

                        query_posts(array('orientation' =>$term->slug));
                    ?>
                    <div class="content__wrapper">
                        <header class="content__header"><h2 class="content__title"><?= single_term_title() ?></h2></header>
                        <?php get_template_part( './templates/associations/archive' );?>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
            <?php get_sidebar('home')?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
