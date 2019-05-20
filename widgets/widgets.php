<?php
require_once __DIR__ . '/widgets-about.php';
require_once __DIR__ . '/widget-search.php';
require_once __DIR__ . '/widget-social-networks.php';
require_once __DIR__ . '/widget-req-assoc.php';
require_once __DIR__ . '/widget-kuzbass.php';

add_action('widgets_init','crtdiu_widgets_init');
function crtdiu_widgets_init(){

    unregister_widget('WP_Widget_Archives'); // Архивы
    unregister_widget('WP_Widget_Calendar'); // Календарь
    unregister_widget('WP_Widget_Categories'); // Рубрики
    unregister_widget('WP_Widget_Meta'); // Мета
    unregister_widget('WP_Widget_Pages'); // Страницы
//    unregister_widget('WP_Widget_Recent_Comments'); // Свежие комментарии
    unregister_widget('WP_Widget_Recent_Posts'); // Свежие записи
    unregister_widget('WP_Widget_RSS'); // RSS
    unregister_widget('WP_Widget_Search'); // Поиск
    unregister_widget('WP_Widget_Tag_Cloud'); // Облако меток
    unregister_widget('WP_Widget_Text'); // Текст
//    unregister_widget('WP_Nav_Menu_Widget'); // Произвольное меню
    unregister_widget('BP_Groups_Widget'); // Произвольное меню
    unregister_widget('BP_Core_Login_Widget'); // Произвольное меню
    unregister_widget('BP_Core_Friends_Widget'); // Произвольное меню
    unregister_widget('BP_Core_Members_Widget'); // Произвольное меню
    unregister_widget('BP_Core_Whos_Online_Widget'); // Произвольное меню
    unregister_widget('BP_Core_Recently_Active_Widget'); // Произвольное меню
    unregister_widget('BP_Blogs_Recent_Posts_Widget'); // Произвольное меню
    unregister_widget('BP_Messages_Sitewide_Notices_Widget'); // Произвольное меню

    register_widget('about_widget');
    register_widget('crtdiu_widget_search');
    register_widget('crtdiu_widget_social_networks');
    register_widget('crtdiu_widget_req_assoc');
    register_widget('crtdiu_widget_kuzbass');
}

