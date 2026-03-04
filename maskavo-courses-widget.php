<?php
/**
 * Plugin Name: Maskavo Courses Widget
 * Description: Widget Elementor personalizado para exibir cursos do Tutor LMS em carrossel.
 * Version: 1.5
 * Author: Elisson Rodrigues
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('plugins_loaded', function() {
    if ( ! did_action('elementor/loaded') || ! function_exists('tutor') ) return;

    add_action('wp_enqueue_scripts', function() {
        wp_register_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css');
        wp_register_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', [], null, true);
        wp_register_style('maskavo-courses-style', plugins_url('assets/style.css', __FILE__));
        wp_register_script('maskavo-courses-js', plugins_url('assets/script.js', __FILE__), ['swiper-js'], null, true);
    });

    add_action('elementor/widgets/register', function($widgets_manager){
        require_once __DIR__.'/includes/class-maskavo-widget.php';
        $widgets_manager->register(new \Maskavo_Courses_Widget());
    });
});
