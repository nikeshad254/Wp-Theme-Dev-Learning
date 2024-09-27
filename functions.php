<?php

/**
 * This function will add a custom page banner to the page
 */
function pageBanner($args = array())
{
    if (!isset($args['title']) || !$args['title']) {
        $args['title'] = get_the_title();
    }

    if (!isset($args['subtitle']) || !$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!isset($args['photo']) || !$args['photo']) {
        if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?= $args['photo'] ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?= $args['subtitle']; ?></p>
            </div>
        </div>
    </div>
<?php
}

// our custom function
function university_files()
{
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=yourkeygoeshere', NULL, '1.0', true);
    wp_enqueue_script('axios', '//cdnjs.cloudflare.com/ajax/libs/axios/1.7.7/axios.min.js', NULL, '1.0', true);
    wp_enqueue_script('glidejs', '//cdn.jsdelivr.net/npm/@glidejs/glide', NULL, '1.0', true);

    wp_enqueue_script('main-university-js', get_theme_file_uri('/scripts.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());

    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}

// function needs to be called to work (hooks is movement to call the function)
// right before the page is loaded, this function will be called by wordpress at the reight movement.
add_action('wp_enqueue_scripts', 'university_files');


function university_features()
{
    // this function will add a title tag to the head of the page
    add_theme_support('title-tag');
    // enable the feature of the post thumbnail for the theme
    add_theme_support('post-thumbnails');

    // custom sizes for any features uploaded
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

// call the function after the theme is setup
add_action("after_setup_theme", "university_features");

function university_adjust_queries($query)
{
    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }
}

add_action('pre_get_posts', 'university_adjust_queries');
