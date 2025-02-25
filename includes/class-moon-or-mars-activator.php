<?php
/**
 * Fired during plugin activation
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/includes
 * @author     Cline
 */
class Moon_Or_Mars_Activator {

    /**
     * Create the necessary database tables for the plugin.
     *
     * @since    1.0.0
     */
    public static function activate() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Table for storing votes
        $table_name_votes = $wpdb->prefix . 'moon_or_mars_votes';
        
        $sql_votes = "CREATE TABLE $table_name_votes (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            vote_type varchar(10) NOT NULL,
            segment_id bigint(20) NOT NULL,
            ip_address varchar(45),
            session_id varchar(32),
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        // Table for storing segments
        $table_name_segments = $wpdb->prefix . 'moon_or_mars_segments';
        
        $sql_segments = "CREATE TABLE $table_name_segments (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            start_date datetime DEFAULT CURRENT_TIMESTAMP,
            end_date datetime,
            description varchar(255),
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_votes);
        dbDelta($sql_segments);
        
        // Create initial segment
        $wpdb->insert(
            $table_name_segments,
            array(
                'description' => 'Initial Segment',
            )
        );
        
        // Add version to options
        add_option('moon_or_mars_db_version', MOON_OR_MARS_VERSION);
        
        // Add default settings
        add_option('moon_or_mars_allow_multiple_votes', 0); // 0 = false, 1 = true
    }
}
