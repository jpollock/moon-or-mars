<?php
/**
 * Provide a admin area view for the plugin settings
 *
 * This file is used to markup the admin-facing settings aspects of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/admin/partials
 */

// Get current settings
$allow_multiple_votes = get_option('moon_or_mars_allow_multiple_votes', 0);
?>

<div class="wrap moon-or-mars-admin">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="moon-or-mars-admin-header">
        <div class="moon-or-mars-logo">
            <div class="moon-or-mars-stars"></div>
            <h2>Settings</h2>
            <p>Configure your cosmic poll</p>
        </div>
    </div>
    
    <div class="moon-or-mars-admin-content">
        <div class="moon-or-mars-admin-card">
            <h2>Poll Settings</h2>
            
            <form method="post" action="options.php" class="moon-or-mars-settings-form">
                <?php
                settings_fields($this->plugin_name);
                do_settings_sections($this->plugin_name);
                ?>
                
                <div class="moon-or-mars-setting-row">
                    <div class="moon-or-mars-setting-label">
                        <label for="moon_or_mars_allow_multiple_votes">Allow Multiple Votes</label>
                    </div>
                    <div class="moon-or-mars-setting-field">
                        <label class="moon-or-mars-toggle">
                            <input type="checkbox" name="moon_or_mars_allow_multiple_votes" id="moon_or_mars_allow_multiple_votes" value="1" <?php checked($allow_multiple_votes, 1); ?>>
                            <span class="moon-or-mars-toggle-slider"></span>
                        </label>
                        <p class="description">If enabled, users can vote multiple times in the same session.</p>
                    </div>
                </div>
                
                <div class="moon-or-mars-setting-row">
                    <div class="moon-or-mars-setting-label">
                        <label>Clear Votes</label>
                    </div>
                    <div class="moon-or-mars-setting-field">
                        <div class="moon-or-mars-clear-votes">
                            <input type="text" id="moon_or_mars_segment_description" placeholder="New segment description (optional)">
                            <button type="button" id="moon_or_mars_clear_votes" class="button button-primary">Clear Votes</button>
                            <div id="moon_or_mars_clear_votes_message"></div>
                            <p class="description">This will create a new vote segment. Previous votes will be preserved for historical data.</p>
                        </div>
                    </div>
                </div>
                
                <?php submit_button('Save Settings', 'primary', 'submit', true); ?>
            </form>
        </div>
        
        <div class="moon-or-mars-admin-card">
            <h2>Shortcode Usage</h2>
            <div class="moon-or-mars-shortcode-info">
                <p>Use the following shortcode to display the poll on any post or page:</p>
                <code>[moon_or_mars]</code>
            </div>
        </div>
        
        <div class="moon-or-mars-admin-card">
            <h2>Block Usage</h2>
            <div class="moon-or-mars-block-info">
                <p>In the block editor, search for "Moon or Mars" and add the block to your content.</p>
                <img src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/block-preview.png'); ?>" alt="Block Preview" class="moon-or-mars-block-preview">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#moon_or_mars_clear_votes').on('click', function() {
        var description = $('#moon_or_mars_segment_description').val();
        var confirmClear = confirm('Are you sure you want to clear the votes? This will create a new vote segment.');
        
        if (confirmClear) {
            $('#moon_or_mars_clear_votes_message').html('<span class="spinner is-active"></span> Clearing votes...');
            
            $.ajax({
                url: moon_or_mars_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'moon_or_mars_clear_votes',
                    nonce: moon_or_mars_admin.nonce,
                    description: description
                },
                success: function(response) {
                    if (response.success) {
                        $('#moon_or_mars_clear_votes_message').html('<div class="notice notice-success inline"><p>' + response.data + '</p></div>');
                    } else {
                        $('#moon_or_mars_clear_votes_message').html('<div class="notice notice-error inline"><p>' + response.data + '</p></div>');
                    }
                },
                error: function() {
                    $('#moon_or_mars_clear_votes_message').html('<div class="notice notice-error inline"><p>An error occurred. Please try again.</p></div>');
                }
            });
        }
    });
});
</script>
