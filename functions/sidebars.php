<?php
add_action('widgets_init','crtdiu_sidebars_init');
function crtdiu_sidebars_init(){
    register_sidebar([
        'name' => 'Главная страница',
        'id' => 'home',
        'class' => 'home-sidebar',
        'description' => 'Сайдбар на главной странице',
        'before_widget' => '<div id="%1$s" class="%2$s widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>'
    ]);

    register_sidebar([
        'name' => 'Подвал сайта',
        'id' => 'footer',
        'class' => 'footer-sidebar',
        'description' => 'Сайдбар в подвале сайта',
        'before_widget' => '<div id="%1$s" class="%2$s widget  widget--footer">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2><hr class="widget-hr">'
    ]);

    register_sidebar([
        'name' => 'Шапка сайта',
        'id' => 'header',
        'class' => 'header-sidebar',
        'description' => 'Сайдбар над кнопкой войти в шапке сайта',
//        'before_widget' => '<div id="%1$s" class="%2$s widget  widget--footer">',
//        'after_widget' => '</div>',
//        'before_title' => '<h2 class="widget-title">',
//        'after_title' => '</h2><hr class="widget-hr">'
    ]);
}