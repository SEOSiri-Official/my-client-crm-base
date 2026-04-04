<?php
class Product_Recommendations {
    public static function get_suggested_product($user_id) {
        if (!GDPR_Compliance::has_consent($user_id)) return "General Offer";
        
        $device = wp_is_mobile() ? 'Mobile' : 'Desktop';
        return "Premium " . $device . " Optimization Package";
    }
}