<?php

/*
Plugin Name: Our Test Plugin
Description: A truly amazing plugin
Version: 1.0
Author: Brad
Author URI: https://author.com/1234
*/

add_filter('the_content', 'addToEndOfPost');

function addToEndOfPost($content)
{
    if (is_single() && is_main_query()) {
        return $content . '<p>My Name Is Brad</p>';
    }
    return $content;
}
