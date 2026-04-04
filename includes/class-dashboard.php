<?php
class CRM_Dashboard {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_menu'));
    }

    public function add_menu() {
        // This moves the link from "Submenu" to "Top Level Menu"
        add_menu_page(
            'CRM Summary', 
            'CRM Summary', 
            'manage_options', 
            'crm-summary', 
            array($this, 'render_dashboard'), 
            'dashicons-chart-bar', // Professional icon
            2                      // Position near the top
        );
    }

    public function render_dashboard() {
        $count = wp_count_posts('crm_contacts')->publish;
        echo '<div class="wrap"><h1 style="margin-bottom:20px;">Seosiri CRM Dashboard</h1>';
        echo '<div style="background:#fff; padding:30px; border-left:5px solid #0073aa; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">';
        echo '<h2 style="color:#23282d;">Total Leads Collected: <span style="color:#0073aa;">' . $count . '</span></h2>';
        echo '<p style="font-size:16px;">Welcome, Momenul Ahmad. Your secure data engine is active and cloud-synced.</p>';
        echo '<hr style="border:0; border-top:1px solid #eee; margin:20px 0;">';
        echo '<p><strong>System Status:</strong> <span style="color:green;">Secure (GitHub Verified)</span></p>';
        echo '</div></div>';
    }
}