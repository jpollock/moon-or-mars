<?php
/**
 * Database operations for the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/includes
 */

/**
 * Database operations for the plugin.
 *
 * This class handles all database operations for the plugin.
 *
 * @since      1.0.0
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/includes
 * @author     Cline
 */
class Moon_Or_Mars_DB {

    /**
     * The table name for votes.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $table_votes    The table name for votes.
     */
    private $table_votes;

    /**
     * The table name for segments.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $table_segments    The table name for segments.
     */
    private $table_segments;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        global $wpdb;
        $this->table_votes = $wpdb->prefix . 'moon_or_mars_votes';
        $this->table_segments = $wpdb->prefix . 'moon_or_mars_segments';
    }

    /**
     * Get the current active segment.
     *
     * @since    1.0.0
     * @return   int       The ID of the current active segment.
     */
    public function get_current_segment() {
        global $wpdb;
        
        // Get the most recent segment without an end date
        $segment = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT id FROM {$this->table_segments} WHERE end_date IS NULL ORDER BY id DESC LIMIT 1"
            )
        );
        
        if ($segment) {
            return $segment->id;
        }
        
        // If no active segment, create one
        $wpdb->insert(
            $this->table_segments,
            array(
                'description' => 'New Segment ' . date('Y-m-d H:i:s'),
            )
        );
        
        return $wpdb->insert_id;
    }

    /**
     * Record a vote.
     *
     * @since    1.0.0
     * @param    string    $vote_type    The type of vote (moon or mars).
     * @return   bool                    Whether the vote was recorded successfully.
     */
    public function record_vote($vote_type) {
        global $wpdb;
        
        // Validate vote type
        if ($vote_type !== 'moon' && $vote_type !== 'mars') {
            return false;
        }
        
        // Get current segment
        $segment_id = $this->get_current_segment();
        
        // Get user IP and session ID
        $ip_address = $this->get_user_ip();
        $session_id = $this->get_session_id();
        
        // Check if multiple votes are allowed
        $allow_multiple_votes = get_option('moon_or_mars_allow_multiple_votes', 0);
        
        if (!$allow_multiple_votes) {
            // Check if user has already voted in this segment
            $existing_vote = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$this->table_votes} 
                    WHERE segment_id = %d AND (ip_address = %s OR session_id = %s)",
                    $segment_id, $ip_address, $session_id
                )
            );
            
            if ($existing_vote > 0) {
                return false; // User has already voted
            }
        }
        
        // Record the vote
        $result = $wpdb->insert(
            $this->table_votes,
            array(
                'vote_type' => $vote_type,
                'segment_id' => $segment_id,
                'ip_address' => $ip_address,
                'session_id' => $session_id,
            )
        );
        
        return $result !== false;
    }

    /**
     * Get vote results for the current segment.
     *
     * @since    1.0.0
     * @return   array     The vote results.
     */
    public function get_vote_results() {
        global $wpdb;
        
        $segment_id = $this->get_current_segment();
        
        // Get total votes for each type
        $moon_votes = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$this->table_votes} 
                WHERE segment_id = %d AND vote_type = 'moon'",
                $segment_id
            )
        );
        
        $mars_votes = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$this->table_votes} 
                WHERE segment_id = %d AND vote_type = 'mars'",
                $segment_id
            )
        );
        
        $total_votes = $moon_votes + $mars_votes;
        
        // Calculate percentages
        $moon_percentage = $total_votes > 0 ? round(($moon_votes / $total_votes) * 100) : 0;
        $mars_percentage = $total_votes > 0 ? round(($mars_votes / $total_votes) * 100) : 0;
        
        return array(
            'moon' => array(
                'votes' => $moon_votes,
                'percentage' => $moon_percentage,
            ),
            'mars' => array(
                'votes' => $mars_votes,
                'percentage' => $mars_percentage,
            ),
            'total' => $total_votes,
        );
    }

    /**
     * Clear votes by creating a new segment.
     *
     * @since    1.0.0
     * @param    string    $description    Optional. Description for the new segment.
     * @return   bool                      Whether the votes were cleared successfully.
     */
    public function clear_votes($description = '') {
        global $wpdb;
        
        // Get current segment
        $current_segment_id = $this->get_current_segment();
        
        // Close current segment
        $wpdb->update(
            $this->table_segments,
            array('end_date' => current_time('mysql')),
            array('id' => $current_segment_id)
        );
        
        // Create new segment
        if (empty($description)) {
            $description = 'New Segment ' . date('Y-m-d H:i:s');
        }
        
        $wpdb->insert(
            $this->table_segments,
            array('description' => $description)
        );
        
        return $wpdb->insert_id > 0;
    }

    /**
     * Get all segments with vote counts.
     *
     * @since    1.0.0
     * @return   array     The segments with vote counts.
     */
    public function get_segments_with_votes() {
        global $wpdb;
        
        $segments = $wpdb->get_results(
            "SELECT s.*, 
            (SELECT COUNT(*) FROM {$this->table_votes} v WHERE v.segment_id = s.id AND v.vote_type = 'moon') as moon_votes,
            (SELECT COUNT(*) FROM {$this->table_votes} v WHERE v.segment_id = s.id AND v.vote_type = 'mars') as mars_votes
            FROM {$this->table_segments} s
            ORDER BY s.id DESC"
        );
        
        return $segments;
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
}
