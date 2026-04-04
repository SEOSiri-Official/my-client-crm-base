<?php
class Memory_Sync {
    public static function cache_client_data($user_id, $data) {
        // Swap to memory for 1 hour to reduce DB load
        set_transient('client_mem_' . $user_id, $data, HOUR_IN_SECONDS);
    }
    public static function get_client_data($user_id) {
        return get_transient('client_mem_' . $user_id);
    }
}