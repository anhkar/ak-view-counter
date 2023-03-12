<?php
/**
 * Handling admin area settings
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class AK_View_Counter_Settings {
    public static function init() {
        add_action('admin_menu', array(__CLASS__, 'add_view_count_option_page'));
    }

    /**
     * Add an option page that user can select the location of the view counter
     */
    public static function add_view_count_option_page() {
        add_submenu_page(
            'tools.php',
            'AK View Counter',
            'AVC Settings',
            'administrator',
            'ak-view-counter-settings',
	        array(__CLASS__, 'register_counter_settings')
        );
    }

    /**
     * Settings page display
     */
    public static function register_counter_settings() {
        include_once(AK_VIEW_COUNTER_DIR . '/templates/settings.php');
    }
}

AK_View_Counter_Settings::init();
