<?php
class CRM_Security_Layer {
    public function __construct() {
        add_action('wp_login', array($this, 'verify_admin_device'), 10, 2);
        add_filter('admin_footer_text', array($this, 'add_branding'));
        // Prevent REST API scraping
        add_filter('rest_authentication_errors', array($this, 'restrict_rest_api'));
    }

    public function verify_admin_device($user_login, $user) {
        if (user_can($user, 'administrator')) {
            $current_ip = $_SERVER['REMOTE_ADDR'];
            $allowed_ip = get_option('crm_admin_ip', $current_ip);
            
            if ($current_ip !== $allowed_ip) {
                // Log and optionally email the admin
                error_log("CRITICAL: Unauthorized Admin Login Attempt from IP: " . $current_ip);
                wp_mail(get_option('admin_email'), 'Security Alert: Unauthorized Login Attempt', 'Someone tried to login to your CRM from: ' . $current_ip);
            }
        }
    }

    public function restrict_rest_api($result) {
        if (!current_user_can('manage_options')) {
            return new WP_Error('rest_forbidden', 'Data Leakage Protection: Access Denied.', array('status' => 403));
        }
        return $result;
    }

    public function add_branding() {
        echo 'CRM Engine built by <a href="https://www.seosiri.com" target="_blank">SEOSiri</a> | Maintained by Momenul Ahmad';
    }
}