<?php
/**
 * Plugin Name: Dynamic URL Button With Get Parameters
 * Description: A custom Elementor widget for creating buttons with dynamic GET parameters and style customization.
 * Version: 1.0.0
 * Author: Indranil Mondal
 * Author URI: https://www.linkedin.com/in/indranil-mondal-26b053a7/
 * Plugin URI: https://github.com/Indranil-Mondal
 * Text Domain: dynamic-url-button-with-get-parameters
 * Requires PHP: 7.0
 * Requires at least: 5.6
 * Tested up to: 6.6
 * Requires Elementor: 3.0
 * License: GPLv2 or later


*/


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function elementor_custom_button_add_donate_link( $links ) {
    $donate_link = '<a href="https://buymeacoffee.com/indranil_devstudio" target="_blank">' . __( 'Donate Us', 'dynamic-url-button-with-get-parameters-for-elementor' ) . '</a>';
    array_push( $links, $donate_link );
    return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'elementor_custom_button_add_donate_link' );

/**
 * Check if Elementor is active and required version is installed
 */
function elementor_custom_button_check_requirements() {
    // Check if Elementor is installed and activated
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'elementor_custom_button_fail_notice' );
        return false;
    }

    // Check Elementor version
    if ( version_compare( ELEMENTOR_VERSION, '3.0', '<' ) ) {
        add_action( 'admin_notices', 'elementor_custom_button_fail_notice_version' );
        return false;
    }

    // Check PHP version
    if ( version_compare( PHP_VERSION, '7.0', '<' ) ) {
        add_action( 'admin_notices', 'elementor_custom_button_php_fail_notice' );
        return false;
    }

    return true;
}

/**
 * Display admin notice if Elementor is not active
 */
function elementor_custom_button_fail_notice() {
    echo '<div class="notice notice-error"><p>';
    esc_html_e( 'Elementor Custom Button requires Elementor to be installed and activated.', 'dynamic-url-button-with-get-parameters-for-elementor' );
    echo '</p></div>';
}

/**
 * Display admin notice for Elementor version failure
 */
function elementor_custom_button_fail_notice_version() {
    echo '<div class="notice notice-error"><p>';
    esc_html_e( 'Elementor Custom Button requires Elementor 3.0 or higher.', 'dynamic-url-button-with-get-parameters-for-elementor' );
    echo '</p></div>';
}

/**
 * Display admin notice for PHP version failure
 */
function elementor_custom_button_php_fail_notice() {
    echo '<div class="notice notice-error"><p>';
    esc_html_e( 'Elementor Custom Button requires PHP 7.0 or higher. Please update your PHP version.', 'dynamic-url-button-with-get-parameters-for-elementor' );
    echo '</p></div>';
}

/**
 * Initialize the custom widget only if Elementor is loaded and requirements are met
 */
function elementor_custom_button_init() {
    // Check if requirements are met
    if ( ! elementor_custom_button_check_requirements() ) {
        return;
    }

    // Hook the widget registration to the correct action
    add_action( 'elementor/widgets/widgets_registered', 'elementor_custom_button_register_widget' );
}

/**
 * Register the custom widget with Elementor
 */
function elementor_custom_button_register_widget() {
    // Include the widget file
    require_once( __DIR__ . '/widgets/custom-button-widget.php' );

    // Register the widget
    \Elementor\Plugin::instance()->widgets_manager->register( new \Elementor_Custom_Button_Widget() );
}

add_action( 'plugins_loaded', 'elementor_custom_button_init' );

