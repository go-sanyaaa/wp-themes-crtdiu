<?php get_header(); ?>
<div class="wrapper__body">
    <div class="container">
        <div class="content">
            <header class="content__header container block">
                <h2 class="content__title">
                    События ближайшей недели
                </h2>
            </header>
            <div class="content__body block block--slider">
                <event-slider></event-slider>
            </div>
        </div>
    </div>
    <div class="container block">
        <div class="layout">
            <div class="main-content">
                <div class="content">
                    <header class="content__header"><h2 class="content__title">Последние новости</h2></header>
                    <?php
                    global $query_string;
                    query_posts( $query_string .'&posts_per_page=5');
                    get_template_part( './templates/blog/posts' );
                    wp_reset_query(); ?>
                </div>
            </div>
            <?php get_sidebar('home')?>
        </div>
    </div>
    <div class="container block">
        <div class="content">
            <header class="content__header"><h2 class="content__title">О нас</h2></header>
            <div class="layout">
                <div class="about about-front">
                    <div class="about__section">
                        <h3 class="about__header">Наша цель</h3>
                        <p class="about__p">Создание необходимых социальных и управленческих условий для устойчивого развития воспитательно-образовательной системы учреждения, через реализацию дополнитеьных общеразвивающих программ и услуг в интересах личности, общества, государства, содействующих формированию творческой духовно-нравственной личности, готовой нести ответственность за себя и за общество, способной к созидательной деятельности</p>
                    </div>
                    <div class="about__section">
                        <h3 class="about__header">В цифрах</h3>
                        <div class="about__block">
                            <div class="about__achieve">
                                <span class="about__achieve-number">1770</span>
                                <span class="about__achieve-title">Учащихся</span>
                            </div>
                            <div class="about__achieve">
                                <span class="about__achieve-number">19</span>
                                <span class="about__achieve-title">Объединений</span>
                            </div>
                            <div class="about__achieve">
                                <span class="about__achieve-number">25</span>
                                <span class="about__achieve-title">Общеобразовательных программ</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-history">
                    <a href="/history" class="about__history-link">
                        <div class="about__history-header">
                            <p class="about__history-title">Наша история</p>
                            <i class="about__history-icon fas fa-long-arrow-alt-right"></i>
                        </div>
                        <img src="<?= get_template_directory_uri() . '/img/history.jpg'; ?>" alt="" class="about__history-link-img">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
