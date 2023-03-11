<?php
/**
* Plugin Name: AK View Counter
* Description: Dead simple counter for WordPress posts and pages
* Version: 1.0.0
* Author: Anh Karppinen
* Text Domain: ak-view-counter
**/

if (!defined('ABSPATH')) {
	exit;
}

define ( 'KVQ_VIEW_COUNTER_ABS_PATH', WP_PLUGIN_URL . '/' . basename( __DIR__ ) );
define ( 'KVQ_VIEW_COUNTER_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, 'ak_create_view_count_table' );

function ak_create_view_count_table() {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	$page_views = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}ak_viewcount` (
		viewcount_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		post_id bigint(20) UNSIGNED NOT NULL,
    	post_type varchar(100) NOT NULL,
		views bigint(20) UNSIGNED NOT NULL,
		PRIMARY KEY  (viewcount_id),
		KEY `post_id` (post_id),
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($page_views);
}

require_once ( KVQ_VIEW_COUNTER_DIR . '/includes/class-ak-view-counter.php' );
require_once ( KVQ_VIEW_COUNTER_DIR . '/includes/class-ak-view-counter-db.php' );
