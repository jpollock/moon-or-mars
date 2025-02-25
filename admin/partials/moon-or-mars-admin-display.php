<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/admin/partials
 */

// Get current vote results
$results = $this->db->get_vote_results();
?>

<div class="wrap moon-or-mars-admin">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="moon-or-mars-admin-header">
        <div class="moon-or-mars-logo">
            <div class="moon-or-mars-stars"></div>
            <h2>Moon or Mars?</h2>
            <p>The cosmic poll plugin</p>
        </div>
    </div>
    
    <div class="moon-or-mars-admin-content">
        <div class="moon-or-mars-admin-card">
            <h2>Current Vote Results</h2>
            <div class="moon-or-mars-results">
                <div class="moon-or-mars-result-item">
                    <div class="moon-or-mars-result-label">Moon</div>
                    <div class="moon-or-mars-result-bar">
                        <div class="moon-or-mars-result-progress moon" style="width: <?php echo esc_attr($results['moon']['percentage']); ?>%;">
                            <div class="moon-or-mars-result-stars"></div>
                        </div>
                    </div>
                    <div class="moon-or-mars-result-percentage"><?php echo esc_html($results['moon']['percentage']); ?>%</div>
                    <div class="moon-or-mars-result-count">(<?php echo esc_html($results['moon']['votes']); ?> votes)</div>
                </div>
                
                <div class="moon-or-mars-result-item">
                    <div class="moon-or-mars-result-label">Mars</div>
                    <div class="moon-or-mars-result-bar">
                        <div class="moon-or-mars-result-progress mars" style="width: <?php echo esc_attr($results['mars']['percentage']); ?>%;">
                            <div class="moon-or-mars-result-stars"></div>
                        </div>
                    </div>
                    <div class="moon-or-mars-result-percentage"><?php echo esc_html($results['mars']['percentage']); ?>%</div>
                    <div class="moon-or-mars-result-count">(<?php echo esc_html($results['mars']['votes']); ?> votes)</div>
                </div>
                
                <div class="moon-or-mars-total-votes">
                    Total Votes: <span><?php echo esc_html($results['total']); ?></span>
                </div>
            </div>
        </div>
        
        <div class="moon-or-mars-admin-card">
            <h2>Quick Links</h2>
            <div class="moon-or-mars-quick-links">
                <a href="<?php echo esc_url(admin_url('admin.php?page=' . $this->plugin_name . '-settings')); ?>" class="moon-or-mars-quick-link">
                    <span class="dashicons dashicons-admin-settings"></span>
                    Settings
                </a>
                <a href="<?php echo esc_url(admin_url('admin.php?page=' . $this->plugin_name . '-vote-data')); ?>" class="moon-or-mars-quick-link">
                    <span class="dashicons dashicons-chart-bar"></span>
                    Vote Data
                </a>
            </div>
        </div>
        
        <div class="moon-or-mars-admin-card">
            <h2>How to Use</h2>
            <div class="moon-or-mars-how-to">
                <p>You can add the Moon or Mars poll to your site in two ways:</p>
                
                <h3>1. Using the Shortcode</h3>
                <p>Add the following shortcode to any post or page:</p>
                <code>[moon_or_mars]</code>
                
                <h3>2. Using the Block</h3>
                <p>In the block editor, search for "Moon or Mars" and add the block to your content.</p>
                
                <h3>Settings</h3>
                <p>Visit the <a href="<?php echo esc_url(admin_url('admin.php?page=' . $this->plugin_name . '-settings')); ?>">Settings page</a> to configure the plugin options.</p>
                
                <h3>Vote Data</h3>
                <p>View and manage vote data on the <a href="<?php echo esc_url(admin_url('admin.php?page=' . $this->plugin_name . '-vote-data')); ?>">Vote Data page</a>.</p>
            </div>
        </div>
    </div>
</div>
