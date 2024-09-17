<?php

// our custom function
function university_files(){
    // a wordpress function that loads css file
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
}

// function needs to be called to work (hooks is movement to call the function)
// right before the page is loaded, this function will be called by wordpress at the reight movement.
add_action('wp_enqueue_scripts', 'university_files');

?>