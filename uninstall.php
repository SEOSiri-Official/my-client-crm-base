<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// 1. Delete all CRM Contacts when the plugin is deleted
$contacts = get_posts(array('post_type' => 'crm_contacts', 'numberposts' => -1));

foreach ($contacts as $contact) {
    wp_delete_post($contact->ID, true);
}

// 2. Delete version metadata
delete_option('seosiri_crm_version');