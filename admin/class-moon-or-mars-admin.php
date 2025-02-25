<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks for
 * enqueuing the admin-specific stylesheet and JavaScript.
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/admin
 * @author     Cline
 */
class Moon_Or_Mars_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The database handler.
     *
     * @since    1.0.0
     * @access   private
     * @var      Moon_Or_Mars_DB    $db    The database handler.
     */
    private $db;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name       The name of this plugin.
     * @param    string    $version           The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->db = new Moon_Or_Mars_DB();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/moon-or-mars-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/moon-or-mars-admin.js', array('jquery', 'wp-util'), $this->version, false);
        
        // Localize the script with data for AJAX
        wp_localize_script($this->plugin_name, 'moon_or_mars_admin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('moon_or_mars_admin_nonce'),
        ));
    }

    /**
     * Add menu items to the admin menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {
        // Top level menu
        add_menu_page(
            'MoonOrMars Settings',
            'MoonOrMars',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_admin_dashboard'),
            'dashicons-chart-pie',
            26
        );
        
        // Settings submenu
        add_submenu_page(
            $this->plugin_name,
            'MoonOrMars Settings',
            'Settings',
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_admin_settings')
        );
        
        // Vote Data submenu
        add_submenu_page(
            $this->plugin_name,
            'MoonOrMars Vote Data',
            'Vote Data',
            'manage_options',
            $this->plugin_name . '-vote-data',
            array($this, 'display_plugin_admin_vote_data')
        );
    }

    /**
     * Add action links to the plugins page.
     *
     * @since    1.0.0
     * @param    array    $links    The existing action links.
     * @return   array              The modified action links.
     */
    public function add_action_links($links) {
        $settings_link = array(
            '<a href="' . admin_url('admin.php?page=' . $this->plugin_name . '-settings') . '">' . __('Settings', 'moon-or-mars') . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    /**
     * Render the dashboard page.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_dashboard() {
        include_once('partials/moon-or-mars-admin-display.php');
    }

    /**
     * Render the settings page.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_settings() {
        include_once('partials/moon-or-mars-admin-settings.php');
    }

    /**
     * Render the vote data page.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_vote_data() {
        include_once('partials/moon-or-mars-admin-vote-data.php');
    }

    /**
     * Register settings.
     *
     * @since    1.0.0
     */
    public function options_update() {
        register_setting(
            $this->plugin_name,
            'moon_or_mars_allow_multiple_votes',
            array(
                'type' => 'boolean',
                'description' => 'Allow users to vote multiple times',
                'sanitize_callback' => 'absint',
                'default' => 0,
            )
        );
    }

    /**
     * AJAX handler for clearing votes.
     *
     * @since    1.0.0
     */
    public function clear_votes() {
        // Check nonce
        check_ajax_referer('moon_or_mars_admin_nonce', 'nonce');
        
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
            return;
        }
        
        // Get description from request
        $description = isset($_POST['description']) ? sanitize_text_field($_POST['description']) : '';
        
        // Clear votes
        $result = $this->db->clear_votes($description);
        
        if ($result) {
            wp_send_json_success('Votes cleared successfully');
        } else {
            wp_send_json_error('Failed to clear votes');
        }
    }

    /**
     * AJAX handler for getting vote data.
     *
     * @since    1.0.0
     */
    public function get_vote_data() {
        // Check nonce
        check_ajax_referer('moon_or_mars_admin_nonce', 'nonce');
        
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
            return;
        }
        
        // Get segments with votes
        $segments = $this->db->get_segments_with_votes();
        
        // Get current results
        $current_results = $this->db->get_vote_results();
        
        wp_send_json_success(array(
            'segments' => $segments,
            'current_results' => $current_results,
        ));
    }
}
