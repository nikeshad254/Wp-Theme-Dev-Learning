<?php

/*
Plugin Name: Our Test Plugin
Description: A truly amazing plugin
Version: 1.0
Author: Brad
Author URI: https://author.com/1234
*/


// -- 23-06

class WordCountAndTimePlugin
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
    }

    function settings()
    {
        add_settings_section(
            'wcp_first_section',
            null,
            null,
            'word-count-settings-page'
        );

        //  For Location
        add_settings_field(
            'wcp_location',
            'Display Location',
            array($this, 'locationHTML'),
            'word-count-settings-page',
            'wcp_first_section'
        );

        register_setting(
            'wordcountplugin',
            'wcp_location',
            array(
                'sanitize_callback' => array($this, 'sanitizeLocation'),
                'default' => '0'
            )
        );

        // For Headline Text
        add_settings_field(
            'wcp_headline',
            'Headline Text',
            array($this, 'headlineHTML'),
            'word-count-settings-page',
            'wcp_first_section'
        );

        register_setting(
            'wordcountplugin',
            'wcp_headline',
            array(
                'sanitize_callback' => 'sanitize_text_field',
                'default' => 'Post Statistics'
            )
        );

        // For Showing WordCount
        add_settings_field(
            'wcp_wordcount',
            'Word Count',
            array($this, 'checkboxHTML'),
            'word-count-settings-page',
            'wcp_first_section',
            array('theName' => 'wcp_wordcount')
        );

        register_setting(
            'wordcountplugin',
            'wcp_wordcount',
            array(
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '1'
            )
        );

        // For Showing Character Count
        add_settings_field(
            'wcp_charactercount',
            'Character Count',
            array($this, 'checkboxHTML'),
            'word-count-settings-page',
            'wcp_first_section',
            array('theName' => 'wcp_charactercount')
        );

        register_setting(
            'wordcountplugin',
            'wcp_charactercount',
            array(
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '1'
            )
        );

        // For Showing Read Time
        add_settings_field(
            'wcp_showreadtime',
            'Read Time',
            array($this, 'checkboxHTML'),
            'word-count-settings-page',
            'wcp_first_section',
            array('theName' => 'wcp_showreadtime')
        );

        register_setting(
            'wordcountplugin',
            'wcp_showreadtime',
            array(
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '1'
            )
        );
    }

    function sanitizeLocation($input)
    {
        if ($input != 0 and $input != 1) {
            add_settings_error(
                'wcp_locaion',
                'wcp_location_error',
                'Display Location Must Be Either Beginning OR End'
            );
            return get_option('wcp_location');
        }
        return $input;
    }


    function checkboxHTML($args)
    {
?>
        <input type="checkbox" name="<?= $args['theName']; ?>" value="1" <?php checked(get_option($args['theName'], '1')) ?>>
    <?php
    }

    function headlineHTML()
    { ?>
        <input type="text" name="wcp_headline" value="<?= esc_attr(get_option('wcp_headline')); ?>">
    <?php
    }

    function locationHTML()
    { ?>
        <select name="wcp_location">
            <option value="0" <?php selected(get_option('wcp_location', '0')) ?>>Beginning of Post</option>
            <option value="1" <?php selected(get_option('wcp_location', '1')) ?>>End of Post</option>
        </select>
    <?php
    }

    function adminPage()
    {
        add_options_page(
            'Word Count Settings',
            'Word Count',
            'manage_options',
            'word-count-settings-page',
            array($this, 'ourHTML')
        );
    }

    function ourHTML()
    {
    ?>
        <div class="wrap">
            <h1>Word Count Settings</h1>
            <form action="options.php" method="POST">
                <?php
                settings_fields('wordcountplugin'); // Adds the hidden fields
                do_settings_sections('word-count-settings-page'); // Adds the Form
                submit_button(); // Actual Submit button
                ?>
            </form>
        </div>
<?php
    }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();
