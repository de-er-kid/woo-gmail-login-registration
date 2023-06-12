<?php
/**
 * WooCommerce Social Login & Registration
 *
 * @package           WooCommerce_Social_Login
 * @author            Sinan
 * @copyright         2023 Sinan
 * @license           GPL-2.0-or-later
 *
 * This plugin is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 * This plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Social Login & Registration
 * Plugin URI:        https://github.com/de-er-kid/woo-gmail-login-registration
 * Description:       Add Google Social login and registration functionality to WooCommerce.
 * Version:           1.5.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sinan
 * Author URI:        https://github.com/de-er-kid
 * Text Domain:       woocommerce-social-login
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: de-er-kid/woo-gmail-login-registration
 * Update URI:        https://github.com/de-er-kid/woo-gmail-login-registration
 */

 defined( 'ABSPATH' ) || exit;

 // Register activation hook
 register_activation_hook( __FILE__, array( 'WooCommerce_Social_Login', 'activate' ) );
 
 // Register deactivation hook
 register_deactivation_hook( __FILE__, array( 'WooCommerce_Social_Login', 'deactivate' ) );
 
 // Include the main WooCommerce_Social_Login class.
 if ( ! class_exists( 'WooCommerce_Social_Login', false ) ) {
     include_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-social-login.php';
 }
 
 /**
  * Load the plugin text domain for translation.
  */
 function woocommerce_social_login_load_textdomain() {
     load_plugin_textdomain( 'woocommerce-social-login', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
 }
 add_action( 'plugins_loaded', 'woocommerce_social_login_load_textdomain' );

