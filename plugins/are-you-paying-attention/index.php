<?php

/*
Plugin Name: Are You Paying Attention Quiz
Description: Give your readers a multiple choice question.
Version: 1.0
Author: Brad
Author URI: https://author.com/1234
Text Domain: wcpdomain
Domain Path: /languages

*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class AreYouPayingAttention
{
    function __construct()
    {
        add_action('enqueue_block_editor_assets', array($this, 'adminAssets'));
    }

    function adminAssets()
    {
        wp_enqueue_script('ournewblocktype', plugin_dir_url(__FILE__) . "build/index.js", array('wp-blocks', 'wp-element'));
    }
}

$areYouPayingAttention = new AreYouPayingAttention();
