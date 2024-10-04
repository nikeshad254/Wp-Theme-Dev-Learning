<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    // wp-json/university/v1/search   - a new custom route
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, // or GET
        'callback' => 'universitySearchResults'
    ));
}

function universitySearchResults($data)
{
    $professors = new WP_Query(array(
        'post_type' => 'professor',
        's' => sanitize_text_field($data['term']) // at end of url if ?term=professor it will be searched
    ));

    $professorResults = array();

    while ($professors->have_posts()) {
        $professors->the_post();
        array_push($professorResults, array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink()
        ));
    }

    return $professorResults;
}
