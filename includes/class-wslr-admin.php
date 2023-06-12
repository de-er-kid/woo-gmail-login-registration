<?php

/**
 * WooCommerce Social Login Admin
 *
 * WooCommerce Social Login Admin settings page for managing options, API credentials and redirect URLs.
 *
 * Text Domain:       woocommerce-social-login
 *
 * @class             WooCommerce_Social_Login_Admin
 * @package           WooCommerce_Social_Login\Admin
 * @version           1.0.0
 * @since             1.5.0
 */

namespace WooCommerce_Social_Login;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce_Social_Login_Admin' ) ) {

	class WooCommerce_Social_Login_Admin {
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
			add_action( 'admin_init', array( $this, 'register_settings' ) );
		}

		public function add_settings_page() {
			add_options_page(
				__( 'Social Login Settings', 'woocommerce-social-login' ),
				__( 'Social Login', 'woocommerce-social-login' ),
				'manage_options',
				'social-login.php',
				array( $this, 'render_settings_page' )
			);
		}

		public function register_settings() {
            if (current_user_can('manage_options')) {
                register_setting('social-login-settings-group', 'wslr_client_id');
                register_setting('social-login-settings-group', 'wslr_client_secret');
                register_setting('social-login-settings-group', 'wslr_redirect_url');
            }
        }        

		public function render_settings_page() {
			?>
			<div class="wrap">
				<h2><?php esc_html_e( 'Social Login Settings', 'woocommerce-social-login' ); ?></h2>
				<div>
					<h3><?php esc_html_e( 'Google OAuth2', 'woocommerce-social-login' ); ?></h3>
					<form method="post" action="options.php">
						<?php settings_fields( 'social-login-settings-group' ); ?>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">
									<label for="wslr_client_id"><?php esc_html_e( 'Client ID', 'woocommerce-social-login' ); ?></label>
								</th>
								<td>
									<input type="text" id="wslr_client_id" name="wslr_client_id" value="<?php echo esc_attr( get_option( 'wslr_client_id' ) ); ?>" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="wslr_client_secret"><?php esc_html_e( 'Client Secret', 'woocommerce-social-login' ); ?></label>
								</th>
								<td>
									<input type="password" id="wslr_client_secret" name="wslr_client_secret" value="<?php echo esc_attr( get_option( 'wslr_client_secret' ) ); ?>" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="wslr_redirect_url"><?php esc_html_e( 'Redirect URL', 'woocommerce-social-login' ); ?></label>
								</th>
								<td>
									<input type="url" id="wslr_redirect_url" name="wslr_redirect_url" value="<?php echo esc_url( get_option( 'wslr_redirect_url' ) ); ?>" />
								</td>
							</tr>
						</table>
						<?php submit_button( esc_html__( 'Save Social Login Settings', 'woocommerce-social-login' ) ); ?>
					</form>
				</div>
			</div>
			<?php
		}
	}
}

new WooCommerce_Social_Login_Admin();