<?php
class CRM_Automation {
    public function __construct() {
        add_action('wp_footer', array($this, 'trigger_smart_notification'));
    }

    public function trigger_smart_notification() {
        if (is_user_logged_in()) {
            $product = Product_Recommendations::get_suggested_product(get_current_user_id());
            echo "<script>console.log('CRM Recommendation: " . esc_js($product) . "');</script>";
        }
    }

    public function send_webhook_notification($data) {
        $webhook_url = get_option('crm_webhook_url');
        if (!$webhook_url) return;
        
        wp_remote_post($webhook_url, array(
            'body' => json_encode(array('text' => 'New Lead: ' . $data['name']))
        ));
    }

    public function process_automated_email($post_id) {
        $status = get_post_meta($post_id, 'status', true);
        $tone = ($status == 'urgent') ? 'urgent' : 'professional';
        
        // Use the Tone Engine
        CRM_Tone_Engine::send_auto_reply($post_id, $tone);
    }
}