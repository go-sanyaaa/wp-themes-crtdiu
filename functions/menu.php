<?php

add_action('after_setup_theme',function (){
    register_nav_menus([
        'header-menu' => 'Главное меню',
    ]);
});

add_filter('wp_nav_menu_args','filter_wp_menu_args');
function filter_wp_menu_args($args){
    $args['container'] = 'nav-menu';
    $args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
    $args['menu_class'] = 'menu menu--main';
    if($args['theme_location'] === 'header-menu'){
        $args['items_wrap'] = '<ul class="%2$s" ref="main-menu">%3$s</ul>';
        $args['menu_class'] .= ' menu--horizontal';
        $args['menu_id'] = 'main-menu';
    }elseif ($args['theme_location'] === 'sidebar-menu'){
        $args['menu_class'] .= ' menu--vertical';
    }
    return $args;
}


add_filter('nav_menu_item_id','filter_menu_item_css_id',10,4);
function filter_menu_item_css_id($menu_id, $item, $args, $depth){
//    return $args->theme_location === 'header-menu' ? '' : $menu_id;
    return '';
};

add_filter('nav_menu_css_class','filter_nav_menu_css_classes',10,4);
function filter_nav_menu_css_classes( $classes, $item, $args, $depth){
    $classes = [
        'menu-node',
        'menu-node--main-lvl-' . ($depth + 1)
    ];

    if($args->theme_location === 'sidebar-menu'){
        $classes[] = 'menu-node--underline';
    }

    if($item->current && $args->theme_location === 'header-menu'){
        $classes[] = 'menu-node--active';
    }
    return $classes;
}

add_filter('nav_menu_submenu_css_class','filter_nav_menu_submenu_css_class',10,3);
function filter_nav_menu_submenu_css_class( $classes, $args, $depth){
    $classes = [
        'menu',
        'menu--dropdown',
        'menu--vertical'
    ];
    if($args->theme_location === 'header-menu'){
        $classes[] = 'menu--vertical';
    }elseif($args['theme_location'] === 'sidebar-menu'){
        $classes[] = 'menu--vertical';
    }

    return $classes;
}

add_filter('nav_menu_link_attributes','filter_nav_menu_link_attributes',10,4);
function filter_nav_menu_link_attributes($atts, $item, $args, $depth){
    $atts['class'] = 'menu-link';

    if($item->current && $args->theme_location === 'header-menu'){
        $atts['class'] .= ' menu-link--active';
    }

    return $atts;
}

add_filter('widget_nav_menu_args','filter_widget_nav_menu_args',10,4);
function filter_widget_nav_menu_args($nav_menu_args, $nav_menu, $args, $instance ){
//    $nav_menu_args['theme_location'] = 'header-menu';

    return $nav_menu_args + ['theme_location' => 'sidebar-menu'];
}