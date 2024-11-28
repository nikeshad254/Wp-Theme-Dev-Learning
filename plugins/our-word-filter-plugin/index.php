<?php

/*
Plugin Name: Our Word Filter Plugin
Description: A truly amazing plugin
Version: 1.0
Author: Brad
Author URI: https://author.com/1234
Text Domain: wcpdomain
Domain Path: /languages

*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class OurWordFilterPlugin
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'ourMenu'));
    }

    function ourMenu()
    {

        // using svg file for icon instead of ascii
        // add_menu_page(
        //     "Words To Filter",
        //     "Word Filter",
        //     "manage_options",
        //     "ourwordfilter",
        //     array($this, "wordFilterPage"),
        //     plugin_dir_url(__FILE__) . '/custom.svg',
        //     100
        // );

        // uses btoa function in console to generate svg to ascii value for icon below
        $mainPageHook = add_menu_page(
            "Words To Filter",
            "Word Filter",
            "manage_options",
            "ourwordfilter",
            array($this, "wordFilterPage"),
            "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iY3VycmVudENvbG9yIiBjbGFzcz0ic2l6ZS02Ij4KICA8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMC43ODggMy4yMWMuNDQ4LTEuMDc3IDEuOTc2LTEuMDc3IDIuNDI0IDBsMi4wODIgNS4wMDYgNS40MDQuNDM0YzEuMTY0LjA5MyAxLjYzNiAxLjU0NS43NDkgMi4zMDVsLTQuMTE3IDMuNTI3IDEuMjU3IDUuMjczYy4yNzEgMS4xMzYtLjk2NCAyLjAzMy0xLjk2IDEuNDI1TDEyIDE4LjM1NCA3LjM3MyAyMS4xOGMtLjk5Ni42MDgtMi4yMzEtLjI5LTEuOTYtMS40MjVsMS4yNTctNS4yNzMtNC4xMTctMy41MjdjLS44ODctLjc2LS40MTUtMi4yMTIuNzQ5LTIuMzA1bDUuNDA0LS40MzQgMi4wODItNS4wMDVaIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIC8+Cjwvc3ZnPgo=",
            100
        );

        add_submenu_page(
            "ourwordfilter",
            "Word To Filter",
            "Words List",
            "manage_options",
            "ourwordfilter",
            array($this, "wordFilterPage")
        );

        add_submenu_page(
            "ourwordfilter",
            "Word Filter Options",
            "Options",
            "manage_options",
            "word-filter-options",
            array($this, "optionsSubPage")
        );

        add_action("load-{$mainPageHook}", array($this, 'mainPageAssets'));
    }

    function mainPageAssets()
    {
        wp_enqueue_style('filterAdminCss', plugin_dir_url(__FILE__) . 'styles.css');
    }

    function handleForm()
    {
        if (wp_verify_nonce($_POST['ourNonce'], 'saveFilterWords') and current_user_can('manage_options')) {
            update_option('plugin_words_to_filter', sanitize_text_field($_POST['plugin_words_to_filter']));
?>
            <div class="updated">
                <p>Your Filtered Words were saved.</p>
            </div>
        <?php
        } else {
        ?>
            <div class="error">
                <p>You don't Have Permission to do that!</p>
            </div>
        <?php
        }
    }

    function wordFilterPage()
    { ?>
        <div class="wrap">
            <h1>Word Filter</h1>
            <?php if (isset($_POST['justsubmitted'])  and $_POST['justsubmitted'] == "true") $this->handleForm(); ?>
            <form method="POST">
                <input type="hidden" name="justsubmitted" value="true">
                <?php wp_nonce_field('saveFilterWords', 'ourNonce'); ?>
                <label for="plugin_words_to_filter">
                    <p>Enter a <strong>comma-separated</strong> list of words to filter.</p>
                </label>
                <div class="word-filter__flex-container">
                    <textarea name="plugin_words_to_filter" id="plugin_words_to_filter" placeholder="bad, mean, awful, horrible" class=""><?= esc_textarea(get_option('plugin_words_to_filter')); ?></textarea>
                </div>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </form>
        </div>
    <?php
    }

    function optionsSubPage()
    { ?>
        HEllo JI
<?php
    }
}


$ourWordFilterPlugin =  new OurWordFilterPlugin();
