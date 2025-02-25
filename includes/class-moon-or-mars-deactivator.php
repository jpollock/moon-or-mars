<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/includes
 * @author     Cline
 */
class Moon_Or_Mars_Deactivator {

    /**
     * Deactivation function.
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        // We don't delete the tables or options on deactivation
        // This ensures that data is preserved if the plugin is reactivated
        
        // If you want to clean up everything on deactivation, uncomment the following code
        /*
        global $wpdb;
        $table_name_votes = $wpdb->prefix . 'moon_or_mars_votes';
        $table_name_segments = $wpdb->prefix . 'moon_or_mars_segments';
        
        $wpdb->query("DROP TABLE IF EXISTS $table_name_votes");
        $wpdb->query("DROP TABLE IF EXISTS $table_name_segments");
        
        delete_option('moon_or_mars_db_version');
        delete_option('moon_or_mars_allow_multiple_votes');
        */
    }
}
