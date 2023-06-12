<?php

/**
 * WooCommerce Social Login Google
 *
 * WooCommerce social login and register using Google with Google's OAuth2.
 *
 * Text Domain:       woocommerce-social-login
 *
 * @class             WooCommerce_Social_Login_Google
 * @package           WooCommerce_Social_Login\Google
 * @version           1.0.0
 * @since             1.0.0
 */

namespace WooCommerce_Social_Login;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce_Social_Login_Google' ) ) {

	class WooCommerce_Social_Login_Google {

        public function __construct() {
            // Add Gmail Login button to WooCommerce Login Form
            add_action( 'woocommerce_login_form_end', array( $this, 'add_gmail_login_button' ) );
    
            // Handle Gmail Login
            add_action( 'init', array( $this, 'process_gmail_login' ) );
    
            // Add Gmail Signup button to WooCommerce Registration Form
            add_action( 'woocommerce_register_form_end', array( $this, 'add_gmail_signup_button' ) );
    
            // Handle Gmail Signup
            add_action( 'init', array( $this, 'process_gmail_signup' ) );
        }
    
        // Add Gmail Login button to WooCommerce Login Form
        public function add_gmail_login_button() {
            ?>
        <div class="form-row social-login">
            <span class="hr social-login-hr">OR</span>
            
            <a href="<?php echo esc_url( $this->get_gmail_login_url() ); ?>" id ="google-oauth2" class="button social-login-button">
            <img src="<?php echo plugin_dir_url('woo-gmail-login-registration/assets/images/google-icon.svg', __FILE__); ?>google-icon.svg" loading="eager" alt="Google logo" aria-hidden="false" class="icon social-login-icon">
                <span><?php esc_html_e( 'Continue with Google', 'woocommerce-social-login' ); ?></span>
            </a>
    
        </div>
            <?php
        }
    
        // Get Gmail Login URL
        public function get_gmail_login_url() {
            // Gmail client ID
            $client_id = esc_attr( get_option( 'wslr_client_id' ) );
    
            // Redirect URL after successful Gmail login
            $redirect_url = esc_url( get_option( 'wslr_redirect_url' ) );
    
            $url = 'https://accounts.google.com/o/oauth2/auth';
            $url .= '?client_id=' . $client_id;
            $url .= '&redirect_uri=' . urlencode( $redirect_url );
            $url .= '&response_type=code';
            $url .= '&scope=email%20profile';
    
            return $url;
        }
    
        // Handle Gmail Login
        public function process_gmail_login() {
            if ( isset( $_GET['code'] ) ) {
                // Gmail client ID
                $client_id = esc_attr( get_option( 'wslr_client_id' ) );
    
                // Gmail client secret
                $client_secret = esc_attr( get_option( 'wslr_client_secret' ) );
    
                // Redirect URL after successful Gmail login
                $redirect_url = esc_url( get_option( 'wslr_redirect_url' ) );
    
                $token_url = 'https://accounts.google.com/o/oauth2/token';
                $token_params = array(
                    'code' => $_GET['code'],
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                    'redirect_uri' => $redirect_url,
                    'grant_type' => 'authorization_code',
                );
    
                $response = wp_remote_post( $token_url, array(
                    'body' => $token_params,
                ) );
    
                if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
                    $token_data = json_decode( wp_remote_retrieve_body( $response ) );
    
                    $access_token = $token_data->access_token;
                    $user_info_url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $access_token;
    
                    $user_info = wp_remote_get( $user_info_url );
    
                    if ( ! is_wp_error( $user_info ) && wp_remote_retrieve_response_code( $user_info ) === 200 ) {
                        $user_data = json_decode( wp_remote_retrieve_body( $user_info ) );
    
                        // Check if the Gmail email exists in the WordPress database
                        $user = get_user_by( 'email', $user_data->email );
    
                        if ( $user ) {
                            // Log in the user
                            wp_set_auth_cookie( $user->ID );
                            wp_redirect( home_url() );
                            exit;
                        } else {
                            // User doesn't exist, create a new account
                            $username = $this->generate_unique_username( $user_data->email );
    
                            $new_user_id = wp_insert_user( array(
                                'user_login' => $username,
                                'user_email' => $user_data->email,
                                'first_name' => $user_data->given_name,
                                'last_name' => $user_data->family_name,
                                'user_pass' => wp_generate_password(),
                                'display_name' => $user_data->name,
                                'role' => 'customer',
                            ) );
    
                            if ( ! is_wp_error( $new_user_id ) ) {
                                // Log in the newly created user
                                wp_set_auth_cookie( $new_user_id );
                                wp_redirect( home_url() );
                                exit;
                            }
                        }
                    }
                }
            }
        }
    
        // Add Gmail Signup button to WooCommerce Registration Form
        public function add_gmail_signup_button() {
            ?>
            <div class="form-row social-login">
            <span class="hr social-login-hr">OR</span>
    
            <a href="<?php echo esc_url( $this->get_gmail_login_url() ); ?>" id ="google-oauth2" class="button social-login-button">
                <img src="<?php echo plugin_dir_url('woo-gmail-login-registration/assets/images/google-icon.svg', __FILE__); ?>google-icon.svg" loading="eager" alt="Google logo" aria-hidden="false" class="icon social-login-icon">
                <span><?php esc_html_e( 'Continue with Google', 'woocommerce-social-login' ); ?></span>
            </a>
    
        </div>
            <?php
        }
    
        // Handle Gmail Signup
        public function process_gmail_signup() {
            if ( isset( $_GET['code'] ) ) {
                // Similar to the process_gmail_login() function above
                // Implement the logic to create a new user account using Gmail credentials
            }
        }
    
        // Generate a unique username based on the Gmail email
        public function generate_unique_username( $email ) {
            $username = strtolower( sanitize_user( current( explode( '@', $email ) ) ) );
            $username = preg_replace( '/[^a-z0-9]/', '', $username );
    
            // Check if the generated username already exists
            $suffix = 1;
            $original_username = $username;
    
            while ( username_exists( $username ) ) {
                $username = $original_username . $suffix;
                $suffix++;
            }
    
            return $username;
        }
        
    }

}

new WooCommerce_Social_Login_Google();