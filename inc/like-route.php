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

function createLike($data)
{
    $professorId =  sanitize_text_field($data['professorId']);

    wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => 'Our PHP Like 1',
        'meta_input' => array(
            'liked_professor_id' => $professorId
        )
    ));
}

function deleteLike()
{
    return 'Like deleted';
}
