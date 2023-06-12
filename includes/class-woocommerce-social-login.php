<?php
/**
 * WooCommerce_Social_Login
 *
 * Main WooCommerce_Social_Login Class
 *
 * @class             WooCommerce_Social_Login
 * @package           WooCommerce_Social_Login
 * @version           1.0.0
 * @since             1.5.0
 * @text-domain       woocommerce-social-login
 */

defined( 'ABSPATH' ) || exit;

final class WooCommerce_Social_Login {

    /**
	 * Plugin version
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Initialize the plugin
	 */
	private function __construct() {
		$this->load_dependencies();
		$this->init();
		// Hook into the 'wp_enqueue_scripts' action
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles_and_scripts'));
	}

	public function enqueue_styles_and_scripts() {
		// Enqueue CSS file
		wp_enqueue_style('style', plugin_dir_url(dirname(__FILE__)) . 'assets/css/style.css', array(), '1.0.0');
		
		// Enqueue JS file
		wp_enqueue_script('script', plugin_dir_url(dirname(__FILE__)) . 'assets/js/script.js', array('jquery'), '1.0.0', true);
	}	
	
	/**
	 * Load the required dependencies for the plugin
	 */
	private function load_dependencies() {
		include_once plugin_dir_path( __FILE__ ) . 'class-wslr-admin.php'; // Include the admin class
		include_once plugin_dir_path( __FILE__ ) . 'class-wslr-google.php'; // Include the Google OAuth2 class
	}

	/**
	 * Initialize the plugin
	 */
	private function init() {
		// Do Initialization tasks
	}

    /**
	 * Run the plugin
	 *
	 * @since 1.0.0
	 */
	public static function run() {
		$instance = new self();

		register_activation_hook( __FILE__, [ $instance, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $instance, 'deactivate' ] );
		register_uninstall_hook( __FILE__, [ __CLASS__, 'uninstall' ] );
	}

	/**
	 * Activate the plugin
	 *
	 * @since 1.0.0
	 */
	public static function activate() {
		// Do activation tasks
	}

	/**
	 * Deactivate the plugin
	 *
	 * @since 1.0.0
	 */
	public static function deactivate() {
		// Do deactivation tasks
	}

	/**
	 * Uninstall the plugin
	 *
	 * @since 1.0.0
	 */
	public static function uninstall() {
		// Delete the options stored by the plugin
		delete_option( 'wslr_client_id' );
		delete_option( 'Ywslr_client_secret' );
		delete_option( 'wslr_redirect_url' );
	}

}

WooCommerce_Social_Login::run();