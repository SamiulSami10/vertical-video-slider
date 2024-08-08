<?php
/*
Plugin Name: Video Slider
Description: A simple plugin to display videos vertically with sliding functionality.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Enqueue necessary scripts and styles
function video_slider_enqueue_scripts() {
    wp_enqueue_style('video-slider-style', plugin_dir_url(__FILE__) . 'css/video-slider.css');
    wp_enqueue_script('video-slider-script', plugin_dir_url(__FILE__) . 'js/video-slider.js', array('jquery'), null, true);

    // Enqueue admin script
    if (is_admin()) {
        wp_enqueue_script('video-slider-admin-script', plugin_dir_url(__FILE__) . 'js/video-slider-admin.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'video_slider_enqueue_scripts');

// Create settings menu
function video_slider_menu() {
    add_menu_page('Video Slider Settings', 'Video Slider', 'manage_options', 'video-slider-settings', 'video_slider_settings_page', 'dashicons-video-alt3', 81);
}
add_action('admin_menu', 'video_slider_menu');

// Settings page content
function video_slider_settings_page() {
    ?>
    <div class="wrap">
        <h1>Video Slider Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('video_slider_settings_group');
            do_settings_sections('video-slider-settings');
            ?>
            <table id="video-slides-table" class="form-table">
                <?php
                $videos = get_option('video_slider_videos', []);
                if (empty($videos)) {
                    $videos = [['title' => '', 'link' => '', 'thumbnail' => '']];
                }
                foreach ($videos as $index => $video) {
                    ?>
                    <tr>
                        <td>
                            <label for="video_slider_videos[<?php echo $index; ?>][title]">Title:</label>
                            <input type="text" id="video_slider_videos[<?php echo $index; ?>][title]" name="video_slider_videos[<?php echo $index; ?>][title]" value="<?php echo esc_attr($video['title']); ?>" />
                        </td>
                        <td>
                            <label for="video_slider_videos[<?php echo $index; ?>][link]">Link:</label>
                            <input type="text" id="video_slider_videos[<?php echo $index; ?>][link]" name="video_slider_videos[<?php echo $index; ?>][link]" value="<?php echo esc_attr($video['link']); ?>" />
                        </td>
                        <td>
                            <label for="video_slider_videos[<?php echo $index; ?>][thumbnail]">Thumbnail URL:</label>
                            <input type="text" id="video_slider_videos[<?php echo $index; ?>][thumbnail]" name="video_slider_videos[<?php echo $index; ?>][thumbnail]" value="<?php echo esc_attr($video['thumbnail']); ?>" />
                        </td>
                        <td>
                            <button type="button" class="remove-video-slide button">Remove</button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <button type="button" id="add-video-slide" class="button">Add Video</button>
            <?php
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function video_slider_settings_init() {
    register_setting('video_slider_settings_group', 'video_slider_videos', 'video_slider_sanitize');

    add_settings_section('video_slider_section', 'Videos', null, 'video-slider-settings');
}
add_action('admin_init', 'video_slider_settings_init');

function video_slider_sanitize($videos) {
    foreach ($videos as &$video) {
        $video['title'] = sanitize_text_field($video['title']);
        $video['link'] = esc_url_raw($video['link']);
        $video['thumbnail'] = esc_url_raw($video['thumbnail']);
    }
    return $videos;
}

// Display videos
function video_slider_display() {
    $videos = get_option('video_slider_videos', []);
    if (!empty($videos)) {
        ?>
        <div class="video-slider-container">
            <div class="video-slider">
                <?php foreach ($videos as $video) { ?>
                    <div class="video-slide">
                        <img src="<?php echo esc_url($video['thumbnail']); ?>" alt="<?php echo esc_attr($video['title']); ?>" />
                        <h3 class="video-slider-title"><?php echo esc_html($video['title']); ?></h3>
                        <a href="<?php echo esc_url($video['link']); ?>" target="_blank">Watch Video</a>
                    </div>
                <?php } ?>
            </div>
            <div class="video-slider-button"><button class="prev-slide">Prev</button>
            <button class="next-slide">Next</button></div>
            
        </div>
        <?php
    }
}
add_shortcode('video_slider', 'video_slider_display');
