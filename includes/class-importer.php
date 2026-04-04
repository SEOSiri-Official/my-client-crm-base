<?php
class CRM_Importer {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_import_page'));
    }

    public function add_import_page() {
        add_submenu_page(
            'edit.php?post_type=crm_contacts',
            'Import CSV',
            'Import Contacts',
            'manage_options',
            'crm-import',
            array($this, 'render_import_form')
        );
    }

    public function render_import_form() {
        // 1. Security Check: Ensure user has permission
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized access');
        }

        // 2. Process File Upload
        if (isset($_POST['crm_import_nonce']) && wp_verify_nonce($_POST['crm_import_nonce'], 'crm_csv_upload')) {
            if (!empty($_FILES['csv_file']['tmp_name'])) {
                
                // 3. Validate File Extension
                $file_info = pathinfo($_FILES['csv_file']['name']);
                if ($file_info['extension'] !== 'csv') {
                    echo '<div class="error"><p>Please upload a valid CSV file.</p></div>';
                } else {
                    $handle = fopen($_FILES['csv_file']['tmp_name'], 'r');
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        wp_insert_post(array(
                            'post_title'   => sanitize_text_field($data[0]),
                            'post_type'    => 'crm_contacts',
                            'post_status'  => 'publish',
                        ));
                    }
                    fclose($handle);
                    echo '<div class="updated"><p>Contacts Imported Successfully!</p></div>';
                }
            }
        }

        // 4. Render Form with Security Nonce
        echo '<div class="wrap"><h1>Import Contacts</h1><form method="post" enctype="multipart/form-data">';
        wp_nonce_field('crm_csv_upload', 'crm_import_nonce'); // THIS PROTECTS THE SITE
        echo '<input type="file" name="csv_file" required>';
        submit_button('Upload and Import');
        echo '</form></div>';
    }
}