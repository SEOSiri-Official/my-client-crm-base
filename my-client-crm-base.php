<?php
/**
 * Plugin Name: Client CRM Foundation
 * Description: High-performance CRM with memory-sync and GDPR features.
 * Version: 1.0.0
 */
if (!defined('ABSPATH')) exit;

// 1. Load all the files
require_once plugin_dir_path(__FILE__) . 'includes/class-crm-setup.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-email-config.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-automation.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-importer.php'; // ADD THIS
require_once plugin_dir_path(__FILE__) . 'includes/sync/class-memory-sync.php';
require_once plugin_dir_path(__FILE__) . 'includes/sync/class-gdpr-compliance.php';
require_once plugin_dir_path(__FILE__) . 'includes/sync/class-recommendations.php';
require_once plugin_dir_path(__FILE__) . 'includes/security/class-security-layer.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-dashboard.php';

// 2. Start the components
new CRM_Security_Layer();
new CRM_Setup();
new CRM_Dashboard();
new CRM_Importer(); // ADD THIS - This activates the CSV Import feature!

// 3. License Logic & Piracy Alert
function seosiri_verify_crm_license() {
    $site_url = get_site_url();
    $url = 'https://raw.githubusercontent.com/SEOSiri-Official/crm-license-registry/main/clients.json';    
    $response = wp_remote_get($url, array('timeout' => 5));
    if (is_wp_error($response)) return; 

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['authorized_domains']) && !in_array($site_url, $data['authorized_domains'])) {
        
        // Alert Seosiri of the unauthorized attempt
        $to = 'sales@seosiri.com';
        $subject = 'SECURITY ALERT: Unauthorized CRM Access';
        $message = 'Breach attempt at: ' . $site_url . ' (Time: ' . current_time('mysql') . ')';
        wp_mail($to, $subject, $message);

        wp_die('<h1>Access Denied</h1><p>Please contact Momenul Ahmad at <a href="https://www.seosiri.com">Seosiri.com</a> to activate your license.</p>');
    }
}
add_action('admin_init', 'seosiri_verify_crm_license');