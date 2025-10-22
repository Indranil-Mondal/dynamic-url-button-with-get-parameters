<?php
/**
 * Plugin Name: Dynamic URL Button With Get Parameters
 * Description: A custom Elementor widget for creating buttons with dynamic GET parameters and style customization.
 * Version: 1.0.0
 * Author: Indranil Mondal
 * Author URI: https://www.linkedin.com/in/indranil-mondal-26b053a7/
 * Plugin URI: https://github.com/Indranil-Mondal/dynamic-url-button-with-get-parameters/
 * Text Domain: dynamic-url-button-with-get-parameters
 * Requires PHP: 7.0
 * Requires at least: 5.6
 * Tested up to: 6.6
 * Requires Elementor: 3.0
 * License: GPLv2 or later


*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Final class for the Dynamic URL Button plugin.
 */
final class Dynamic_URL_Button {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var \Dynamic_URL_Button The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return \Dynamic_URL_Button An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if on WordPress dashboard.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		// Check if Elementor is installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ $this, 'add_donate_link' ] );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'dynamic-url-button-with-get-parameters' ),
			'<strong>' . esc_html__( 'Dynamic URL Button', 'dynamic-url-button-with-get-parameters' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'dynamic-url-button-with-get-parameters' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'dynamic-url-button-with-get-parameters' ),
			'<strong>' . esc_html__( 'Dynamic URL Button', 'dynamic-url-button-with-get-parameters' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'dynamic-url-button-with-get-parameters' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'dynamic-url-button-with-get-parameters' ),
			'<strong>' . esc_html__( 'Dynamic URL Button', 'dynamic-url-button-with-get-parameters' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'dynamic-url-button-with-get-parameters' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init_widgets() {
		require_once __DIR__ . '/widgets/custom-button-widget.php';
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor_Custom_Button_Widget() );
	}

	/**
	 * Add donate link to plugin actions.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param array $links An array of plugin action links.
	 * @return array An array of plugin action links.
	 */
	public function add_donate_link( $links ) {
		$donate_link = '<a href="https://buymeacoffee.com/indranil_devstudio" target="_blank">' . esc_html__( 'Donate Us', 'dynamic-url-button-with-get-parameters' ) . '</a>';
		array_push( $links, $donate_link );
		return $links;
	}
}

Dynamic_URL_Button::instance();

