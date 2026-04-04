<?php
class CRM_Importer {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_import_page'));
    }

    public function add_import_page() {
        add_submenu_page('edit.php?post_type=crm_contacts', 'Import CSV', 'Import Contacts', 'manage_options', 'crm-import', array($this, 'render_import_form'));
    }

    public function render_import_form() {
        if (isset($_FILES['csv_file'])) {
            $handle = fopen($_FILES['csv_file']['tmp_name'], 'r');
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                wp_insert_post(array(
                    'post_title' => $data[0], // Assumes Name in first column
                    'post_type'  => 'crm_contacts',
                    'post_status'=> 'publish'
                ));
            }
            echo '<div class="updated"><p>Contacts imported successfully!</p></div>';
        }
        echo '<form method="post" enctype="multipart/form-data">
                <input type="file" name="csv_file">
                <input type="submit" value="Upload CSV" class="button button-primary">
              </form>';
    }
}