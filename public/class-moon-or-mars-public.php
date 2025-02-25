<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks for
 * enqueuing the public-facing stylesheet and JavaScript.
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/public
 * @author     Cline
 */
class Moon_Or_Mars_Public {

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
     * @param    string    $plugin_name       The name of the plugin.
     * @param    string    $version           The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->db = new Moon_Or_Mars_DB();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/moon-or-mars-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/moon-or-mars-public.js', array('jquery'), $this->version, false);
        
        // Localize the script with data for AJAX
        wp_localize_script($this->plugin_name, 'moon_or_mars_public', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('moon_or_mars_public_nonce'),
        ));
    }

    /**
     * Display the poll.
     *
     * @since    1.0.0
     * @param    array    $atts    The shortcode attributes.
     * @return   string            The HTML for the poll.
     */
    public function display_poll($atts = array()) {
        // Start output buffering
        ob_start();
        
        // Get current vote results
        $results = $this->db->get_vote_results();
        
        // Check if user has already voted
        $allow_multiple_votes = get_option('moon_or_mars_allow_multiple_votes', 0);
        $has_voted = $this->has_user_voted();
        
        // Include the template
        include plugin_dir_path(__FILE__) . 'partials/moon-or-mars-public-display.php';
        
        // Return the buffered content
        return ob_get_clean();
    }

    /**
     * Check if the user has already voted.
     *
     * @since    1.0.0
     * @return   bool    Whether the user has already voted.
     */
    private function has_user_voted() {
        global $wpdb;
        
        // Get current segment
        $segment_id = $this->db->get_current_segment();
        
        // Get user IP and session ID
        $ip_address = $this->get_user_ip();
        $session_id = $this->get_session_id();
        
        // Check if user has already voted in this segment
        $existing_vote = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}moon_or_mars_votes 
                WHERE segment_id = %d AND (ip_address = %s OR session_id = %s)",
                $segment_id, $ip_address, $session_id
            )
        );
        
        return $existing_vote > 0;
    }

    /**
     * Get the user's IP address.
     *
     * @since    1.0.0
     * @return   string    The user's IP address.
     */
    private function get_user_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Get or create a session ID.
     *
     * @since    1.0.0
     * @return   string    The session ID.
     */
    private function get_session_id() {
        if (!session_id()) {
            session_start();
        }
        
        if (!isset($_SESSION['moon_or_mars_session_id'])) {
            $_SESSION['moon_or_mars_session_id'] = md5(uniqid(rand(), true));
        }
        
        return $_SESSION['moon_or_mars_session_id'];
    }

    /**
     * AJAX handler for processing votes.
     *
     * @since    1.0.0
     */
    public function process_vote() {
        // Check nonce
        check_ajax_referer('moon_or_mars_public_nonce', 'nonce');
        
        // Get vote type from request
        $vote_type = isset($_POST['vote_type']) ? sanitize_text_field($_POST['vote_type']) : '';
        
        // Validate vote type
        if ($vote_type !== 'moon' && $vote_type !== 'mars') {
            wp_send_json_error('Invalid vote type');
            return;
        }
        
        // Check if multiple votes are allowed
        $allow_multiple_votes = get_option('moon_or_mars_allow_multiple_votes', 0);
        
        // Check if user has already voted
        if (!$allow_multiple_votes && $this->has_user_voted()) {
            wp_send_json_error('You have already voted');
            return;
        }
        
        // Record the vote
        $result = $this->db->record_vote($vote_type);
        
        if ($result) {
            // Get updated results
            $results = $this->db->get_vote_results();
            
            wp_send_json_success(array(
                'message' => 'Vote recorded successfully',
                'results' => $results,
            ));
        } else {
            wp_send_json_error('Failed to record vote');
        }
    }

    /**
     * AJAX handler for getting results.
     *
     * @since    1.0.0
     */
    public function get_results() {
        // Check nonce
        check_ajax_referer('moon_or_mars_public_nonce', 'nonce');
        
        // Get results
        $results = $this->db->get_vote_results();
        
        wp_send_json_success($results);
    }
}
