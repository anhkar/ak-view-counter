<?php
/**
 * Register view count into database
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AK_View_Counter {
	public static function init() {
        add_action( 'wp', array( __CLASS__, 'count_up' ) );
        add_action( 'deleted_post', array( __CLASS__, 'remove_view_count' ) );

        add_filter( 'the_content', array( __CLASS__, 'show_views' ) );
    }

	/**
	 * Increase views
     * Happens after WP environment has finished setup and is deciding which template to load
     * Post ID and post type are accessible at this point
	 */
	public static function count_up() {
        // Do not count if this is admin area or not single page
        if(is_admin() || ! is_singular()) return;

        $post_id = get_the_ID();
        if(!$post_id) return;

        // Do not count if page author or admin is visiting
        $post_author = get_post_field('post_author', $post_id);
        $current_user_id = get_current_user_id();

        if($current_user_id == $post_author) return;

        // Do not count posts that are not published
        $post_status = get_post_status();

        if($post_status !== 'publish') return;

        $post_type = get_post_type();

        AK_View_Counter_Db::count_up($post_id, $post_type);
	}

    /**
     * Display html code to show view count in front end
     */
	public static function show_views($content) {
		// Don't show if it is not a single page
        if(!is_singular()) return $content;

		// Don't show if user selects so
        $is_display = get_option('ak_view_count_display');
		if(!$is_display) return $content;

        $location = get_option('ak_view_count_location');
        $views = AK_View_Counter_Db::get_view_count(get_the_ID());

        $view_count_text = "<div class='ak-view-counter'>Views: " . $views . '</div>';

        if($location) {
           if($location === 'top') {
               return $view_count_text . $content;
           } else {
               return $content . $view_count_text;
           }
        }

        return $content;
	}

    /**
     * Delete the view count data together with the deletion of a post
     */
	public static function remove_view_count($post_id) {
        AK_View_Counter_Db::delete_view_count_row($post_id);
	}
}

AK_View_Counter::init();
