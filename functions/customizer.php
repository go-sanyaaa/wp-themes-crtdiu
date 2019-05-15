<?php

add_action('customize_register', 'crtdiu_customize_register');

function crtdiu_customize_register($wp_customize){
    // Header phone
    $wp_customize->add_setting('header_phone_numbers',array(
        'type' => 'theme_mod',
        'default' => '+7 (987) 653-32-10',
        'transport' => 'refresh'
    ));

    $wp_customize->add_section('header_section',array(
        'title' => 'Шапка сайта',
        'description' => 'Заголовок, описание, телефонные номера',
        'priority' => '1'
    ));

    $wp_customize->add_control('header_phone_numbers',array(
        'label' => 'Номера телефонов',
        'section' => 'header_section',
        'settings' => 'header_phone_numbers',
        'type' => 'text'
    ));

    // Footer desc
    $wp_customize->add_setting('footer_my_desc',array(
        'type' => 'theme_mod',
        'default' => 'Центр развития творчества детей и юношества Кировского района города Кемерово © 2019',
        'transport' => 'refresh'
    ));

    $wp_customize->add_section('footer_section',array(
        'title' => 'Подвал сайта',
        'priority' => '2'
    ));

    $wp_customize->add_control('footer_my_desc',array(
        'label' => 'Текст в подвале сайта',
        'section' => 'footer_section',
        'settings' => 'footer_my_desc',
        'type' => 'text'
    ));
}