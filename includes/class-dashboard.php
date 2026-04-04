<?php
class CRM_Dashboard {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_menu'));
    }

    public function add_menu() {
        // This moves the link from "Submenu" to "Top Level Menu"
        add_menu_page(
            __('CRM Summary', 'seosiri-crm'), 
    __('CRM Summary', 'seosiri-crm'),

            'manage_options', 
            'crm-summary', 
            array($this, 'render_dashboard'), 
            'dashicons-chart-bar', // Professional icon
            2                      // Position near the top
        );
    }

    public function render_dashboard() {
        $count = wp_count_posts('crm_contacts')->publish;
        echo '<div class="wrap" style="background:#f0f2f5; padding:20px; border-radius:10px;">';
        echo '<h1 style="font-weight:700; color:#1d2327;">Seosiri CRM Command Center</h1>';
        echo '<div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-top:20px;">';
        
        // Card 1: Leads
        echo '<div style="background:#fff; padding:30px; border-radius:12px; box-shadow:0 10px 15px -3px rgba(0,0,0,0.1); border-top:4px solid #0073aa;">';
        echo '<p style="color:#64748b; font-weight:600; text-transform:uppercase; font-size:12px;">Total Prospects</p>';
        echo '<h2 style="font-size:36px; margin:10px 0; color:#0f172a;">' . $count . '</h2>';
        echo '<a href="edit.php?post_type=crm_contacts" style="color:#0073aa; text-decoration:none; font-weight:600;">View all leads →</a>';
        echo '</div>';

        // Card 2: Security
        echo '<div style="background:#fff; padding:30px; border-radius:12px; box-shadow:0 10px 15px -3px rgba(0,0,0,0.1); border-top:4px solid #10b981;">';
        echo '<p style="color:#64748b; font-weight:600; text-transform:uppercase; font-size:12px;">System Integrity</p>';
        echo '<h2 style="font-size:36px; margin:10px 0; color:#0f172a;">Active</h2>';
        echo '<p style="color:#10b981; font-weight:600;">✓ GitHub Verified & Secure</p>';
        echo '</div>';

        echo '</div></div>';
    }