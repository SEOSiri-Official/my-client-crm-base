<?php
class GDPR_Compliance {
    public static function has_consent($user_id) {
        return get_user_meta($user_id, 'tracking_consent', true) === 'yes';
    }
    public static function set_consent($user_id, $status) {
        update_user_meta($user_id, 'tracking_consent', $status ? 'yes' : 'no');
    }
}