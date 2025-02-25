<?php
/**
 * Provide a admin area view for the plugin vote data
 *
 * This file is used to markup the admin-facing vote data aspects of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/admin/partials
 */

// Get segments with votes
$segments = $this->db->get_segments_with_votes();
?>

<div class="wrap moon-or-mars-admin">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="moon-or-mars-admin-header">
        <div class="moon-or-mars-logo">
            <div class="moon-or-mars-stars"></div>
            <h2>Vote Data</h2>
            <p>Analyze your cosmic poll results</p>
        </div>
    </div>
    
    <div class="moon-or-mars-admin-content">
        <div class="moon-or-mars-admin-card">
            <h2>Current Segment Results</h2>
            <div id="moon-or-mars-current-results">
                <div class="moon-or-mars-loading">
                    <div class="moon-or-mars-loading-spinner"></div>
                    <p>Loading results...</p>
                </div>
            </div>
        </div>
        
        <div class="moon-or-mars-admin-card">
            <h2>Historical Vote Segments</h2>
            <div id="moon-or-mars-segments">
                <div class="moon-or-mars-loading">
                    <div class="moon-or-mars-loading-spinner"></div>
                    <p>Loading segments...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    // Function to load vote data
    function loadVoteData() {
        $.ajax({
            url: moon_or_mars_admin.ajax_url,
            type: 'POST',
            data: {
                action: 'moon_or_mars_get_vote_data',
                nonce: moon_or_mars_admin.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update current results
                    var currentResults = response.data.current_results;
                    var resultsHtml = '<div class="moon-or-mars-results">';
                    
                    // Moon results
                    resultsHtml += '<div class="moon-or-mars-result-item">';
                    resultsHtml += '<div class="moon-or-mars-result-label">Moon</div>';
                    resultsHtml += '<div class="moon-or-mars-result-bar">';
                    resultsHtml += '<div class="moon-or-mars-result-progress moon" style="width: ' + currentResults.moon.percentage + '%;">';
                    resultsHtml += '<div class="moon-or-mars-result-stars"></div>';
                    resultsHtml += '</div>';
                    resultsHtml += '</div>';
                    resultsHtml += '<div class="moon-or-mars-result-percentage">' + currentResults.moon.percentage + '%</div>';
                    resultsHtml += '<div class="moon-or-mars-result-count">(' + currentResults.moon.votes + ' votes)</div>';
                    resultsHtml += '</div>';
                    
                    // Mars results
                    resultsHtml += '<div class="moon-or-mars-result-item">';
                    resultsHtml += '<div class="moon-or-mars-result-label">Mars</div>';
                    resultsHtml += '<div class="moon-or-mars-result-bar">';
                    resultsHtml += '<div class="moon-or-mars-result-progress mars" style="width: ' + currentResults.mars.percentage + '%;">';
                    resultsHtml += '<div class="moon-or-mars-result-stars"></div>';
                    resultsHtml += '</div>';
                    resultsHtml += '</div>';
                    resultsHtml += '<div class="moon-or-mars-result-percentage">' + currentResults.mars.percentage + '%</div>';
                    resultsHtml += '<div class="moon-or-mars-result-count">(' + currentResults.mars.votes + ' votes)</div>';
                    resultsHtml += '</div>';
                    
                    // Total votes
                    resultsHtml += '<div class="moon-or-mars-total-votes">';
                    resultsHtml += 'Total Votes: <span>' + currentResults.total + '</span>';
                    resultsHtml += '</div>';
                    
                    resultsHtml += '</div>';
                    
                    $('#moon-or-mars-current-results').html(resultsHtml);
                    
                    // Update segments
                    var segments = response.data.segments;
                    var segmentsHtml = '';
                    
                    if (segments.length > 0) {
                        segmentsHtml += '<div class="moon-or-mars-segments-table-wrapper">';
                        segmentsHtml += '<table class="moon-or-mars-segments-table widefat">';
                        segmentsHtml += '<thead>';
                        segmentsHtml += '<tr>';
                        segmentsHtml += '<th>Segment</th>';
                        segmentsHtml += '<th>Description</th>';
                        segmentsHtml += '<th>Start Date</th>';
                        segmentsHtml += '<th>End Date</th>';
                        segmentsHtml += '<th>Moon Votes</th>';
                        segmentsHtml += '<th>Mars Votes</th>';
                        segmentsHtml += '<th>Total Votes</th>';
                        segmentsHtml += '</tr>';
                        segmentsHtml += '</thead>';
                        segmentsHtml += '<tbody>';
                        
                        $.each(segments, function(index, segment) {
                            var totalVotes = parseInt(segment.moon_votes) + parseInt(segment.mars_votes);
                            var moonPercentage = totalVotes > 0 ? Math.round((segment.moon_votes / totalVotes) * 100) : 0;
                            var marsPercentage = totalVotes > 0 ? Math.round((segment.mars_votes / totalVotes) * 100) : 0;
                            
                            segmentsHtml += '<tr>';
                            segmentsHtml += '<td>' + segment.id + '</td>';
                            segmentsHtml += '<td>' + (segment.description || 'N/A') + '</td>';
                            segmentsHtml += '<td>' + segment.start_date + '</td>';
                            segmentsHtml += '<td>' + (segment.end_date || 'Active') + '</td>';
                            segmentsHtml += '<td>' + segment.moon_votes + ' (' + moonPercentage + '%)</td>';
                            segmentsHtml += '<td>' + segment.mars_votes + ' (' + marsPercentage + '%)</td>';
                            segmentsHtml += '<td>' + totalVotes + '</td>';
                            segmentsHtml += '</tr>';
                        });
                        
                        segmentsHtml += '</tbody>';
                        segmentsHtml += '</table>';
                        segmentsHtml += '</div>';
                    } else {
                        segmentsHtml += '<p>No vote segments found.</p>';
                    }
                    
                    $('#moon-or-mars-segments').html(segmentsHtml);
                } else {
                    $('#moon-or-mars-current-results').html('<div class="notice notice-error"><p>' + response.data + '</p></div>');
                    $('#moon-or-mars-segments').html('<div class="notice notice-error"><p>' + response.data + '</p></div>');
                }
            },
            error: function() {
                $('#moon-or-mars-current-results').html('<div class="notice notice-error"><p>An error occurred. Please try again.</p></div>');
                $('#moon-or-mars-segments').html('<div class="notice notice-error"><p>An error occurred. Please try again.</p></div>');
            }
        });
    }
    
    // Load vote data on page load
    loadVoteData();
    
    // Refresh data every 30 seconds
    setInterval(loadVoteData, 30000);
});
</script>
