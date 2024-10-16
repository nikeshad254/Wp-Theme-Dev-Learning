<?php
add_action('rest_api_init', 'university_like_routes');

function university_like_routes()
{
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));

    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}

function createLike()
{
    return 'Like created';
}

function deleteLike()
{
    return 'Like deleted';
}
