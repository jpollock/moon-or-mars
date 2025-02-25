<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete all plugin-related database tables
global $wpdb;
$table_name_votes = $wpdb->prefix . 'moon_or_mars_votes';
$table_name_segments = $wpdb->prefix . 'moon_or_mars_segments';

$wpdb->query("DROP TABLE IF EXISTS $table_name_votes");
$wpdb->query("DROP TABLE IF EXISTS $table_name_segments");

// Delete all plugin-related options
delete_option('moon_or_mars_db_version');
delete_option('moon_or_mars_allow_multiple_votes');

// Clear any cached data that has been stored
wp_cache_flush();
