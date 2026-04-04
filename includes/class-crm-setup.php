<?php
class CRM_Setup {
    public function __construct() {
        add_action('init', array($this, 'register_crm_cpt'));
    }

    public function register_crm_cpt() {
        register_post_type('crm_contacts', array(
            'labels' => array('name' => 'Contacts', 'singular_name' => 'Contact'),
            'public' => true,
            'show_in_rest' => false, // SECURITY: Hides contacts from API scraping
            'supports' => array('title', 'editor', 'custom-fields'),
            'menu_icon' => 'dashicons-businessperson',
            'capabilities' => array(
                'edit_post'          => 'manage_options',
                'read_post'          => 'manage_options',
                'delete_post'        => 'manage_options',
                'edit_posts'         => 'manage_options',
                'edit_others_posts'  => 'manage_options',
                'publish_posts'      => 'manage_options',
                'read_private_posts' => 'manage_options'
            ),
            'map_meta_cap' => true
        ));
    }
}