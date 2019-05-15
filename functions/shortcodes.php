<?php

add_shortcode('short-file-link','rend_shortFileLink');

function rend_shortFileLink($atts){
    $icons = array(
        'pdf' => 'file-pdf',
        'doc' => 'file-word',
        'docx' => 'file-word',
        'ppt' => 'file-powerpoint',
        'pptx' => 'file-powerpoint',
        'xls' => 'file-excel',
        'xlsx' => 'file-excel',
        'jpeg' => 'file-image',
        'jpg' => 'file-image',
        'png' => 'file-image',
        'bmp' => 'file-image'
    );

    $params = shortcode_atts(array(
        'url' => '',
        'name' => '',
        'icon' => false
    ),$atts);

    $info = new SplFileInfo($params['url']);

    return "<a href=".$params['url']." class='file-link'>".$params['name']."<i class='fas file-link-icon fa-".$icons[$info->getExtension()]."'></i></a>";
}
