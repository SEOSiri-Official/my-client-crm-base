<?php
class CRM_Tone_Engine {
    public static function get_email_content($tone, $user_name) {
        $tones = array(
            'professional' => "Dear {$user_name}, we are pleased to update you on our progress.",
            'casual'       => "Hey {$user_name}! Just wanted to share a quick update with you.",
            'urgent'       => "IMPORTANT: {$user_name}, we need your attention regarding your account."
        );
        return $tones[$tone] ?? $tones['professional'];
    }

    // Programmatic Trigger: Select tone based on CRM tag
    public static function send_auto_reply($post_id, $tone) {
        $contact = get_post($post_id);
        $subject = "Update regarding your file";
        $body = self::get_email_content($tone, $contact->post_title);
        CRM_Email_Config::send_branded_email($contact->post_excerpt, $subject, $body);
    }
}