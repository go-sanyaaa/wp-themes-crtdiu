<?php
add_filter('crtdiu_get_post_thumbnail','filter_get_post_thumbnail');
function filter_get_post_thumbnail($url){
    return $url ? $url : get_template_directory_uri().'/img/news-default.png';
}