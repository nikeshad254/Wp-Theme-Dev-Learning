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
        add_action('init', array($this, 'adminAssets'));
    }

    function adminAssets()
    {
        wp_register_style('quizeditcss', plugin_dir_url(__FILE__) . "build/index.css");
        wp_register_script('ournewblocktype', plugin_dir_url(__FILE__) . "build/index.js", array('wp-blocks', 'wp-element', 'wp-editor'));
        register_block_type('ourplugin/are-you-paying-attention', array(
            'editor_script' => 'ournewblocktype',
            'editor_style' => 'quizeditcss',
            'render_callback' => array($this, 'theHTML')
        ));
    }

    function theHTML($attributes)
    {
        if (!is_admin()) {
            wp_enqueue_script("attentionFrontend", plugin_dir_url(__FILE__) . "build/frontend.js", array("react-jsx-runtime", "wp-element"), '1.0', true);
            wp_enqueue_style("attentionFrontendCss", plugin_dir_url(__FILE__) . "build/frontend.css");
        }
        ob_start(); ?>
        <div class="paying-attention-update-me">Remove Me PLZ</div>
<?php return ob_get_clean();
    }
}

$areYouPayingAttention = new AreYouPayingAttention();
