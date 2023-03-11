<?php
/**
 * Register view count into database
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AK_View_Counter {
	public static function init() {
		add_action( 'kvq_view_count', array( __CLASS__, 'show_views' ) );
		add_action( 'wp_footer', array( __CLASS__, 'count_up' ) );
        add_action( 'before_delete_post', array( __CLASS__, 'remove_view_count' ) );
    }

	/**
	 * Increase views when page load
	 */
	public static function count_up( int $post_id ) {
	}

    /**
     * Display html code to show view count in front end
     * @return void
     */
	public static function show_views() {
	}

    /**
     * Delete the view count data together with the deletion of a post
     * @return void
     */
	public static function remove_view_count() {

	}
}

AK_View_Counter::init();
