<?php

// our custom function
function university_files(){
    wp_enqueue_script( "main-university-js", get_theme_file_uri("/js/scripts-bundled.js"), NULL, "1.0", true );
    // a wordpress function that loads css file
    wp_enqueue_style('custom-google-fonts', "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
    wp_enqueue_style('font-awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
}

// function needs to be called to work (hooks is movement to call the function)
// right before the page is loaded, this function will be called by wordpress at the reight movement.
add_action('wp_enqueue_scripts', 'university_files');


function university_features(){
    register_nav_menu( 'headerMenuLocation', 'Header Menu Location' );
    register_nav_menu( 'footerLocationOne', 'Footer Location One' );
    register_nav_menu( 'footerLocationTwo', 'Footer Location Two' );

    // this function will add a title tag to the head of the page
    add_theme_support('title-tag');
}

// call the function after the theme is setup
add_action("after_setup_theme", "university_features");

?>