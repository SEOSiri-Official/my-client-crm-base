<?php
/* Template Name: Client Portal */
if (!is_user_logged_in()) { wp_redirect(wp_login_url()); exit; }

$current_user = wp_get_current_user();
// Find the contact post belonging to this user
$args = array('post_type' => 'crm_contacts', 'title' => $current_user->display_name);
$contact = get_posts($args);

echo "<h1>Welcome, " . esc_html($current_user->display_name) . "</h1>";
// Display form for file uploads
echo do_shortcode('[wpforms id="YOUR_FORM_ID_WITH_FILE_UPLOAD"]');
?>