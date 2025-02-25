<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/public/partials
 */

// Variables available:
// $results - The current vote results
// $allow_multiple_votes - Whether multiple votes are allowed
// $has_voted - Whether the user has already voted
?>

<div class="moon-or-mars-container">
    <div class="moon-or-mars-space-background">
        <div class="moon-or-mars-stars"></div>
        <div class="moon-or-mars-shooting-stars"></div>
    </div>
    
    <div class="moon-or-mars-header">
        <h2>Where would you rather go?</h2>
        <p>Cast your vote in this cosmic poll</p>
    </div>
    
    <?php if (!$has_voted || $allow_multiple_votes): ?>
    <!-- Voting Interface -->
    <div class="moon-or-mars-voting" id="moon-or-mars-voting">
        <div class="moon-or-mars-options">
            <div class="moon-or-mars-option moon" data-vote="moon">
                <div class="moon-or-mars-option-image">
                    <svg class="moon-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="90" fill="#E6E6E6" />
                        <circle cx="70" cy="80" r="15" fill="#D3D3D3" />
                        <circle cx="130" cy="60" r="20" fill="#D3D3D3" />
                        <circle cx="110" cy="120" r="25" fill="#D3D3D3" />
                        <circle cx="50" cy="130" r="10" fill="#D3D3D3" />
                        <circle cx="160" cy="100" r="12" fill="#D3D3D3" />
                    </svg>
                </div>
                <h3>The Moon</h3>
                <p>Earth's closest neighbor</p>
                <button class="moon-or-mars-vote-btn moon-btn">Vote Moon</button>
            </div>
            
            <div class="moon-or-mars-option mars" data-vote="mars">
                <div class="moon-or-mars-option-image">
                    <svg class="mars-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="90" fill="#CF3A24" />
                        <ellipse cx="70" cy="80" rx="25" ry="15" fill="#A52A2A" />
                        <ellipse cx="130" cy="60" rx="20" ry="10" fill="#A52A2A" />
                        <circle cx="110" cy="120" r="25" fill="#A52A2A" />
                        <circle cx="50" cy="130" r="10" fill="#A52A2A" />
                        <circle cx="160" cy="100" r="12" fill="#A52A2A" />
                        <circle cx="90" cy="40" r="30" fill="#B22222" />
                    </svg>
                </div>
                <h3>Mars</h3>
                <p>The red planet</p>
                <button class="moon-or-mars-vote-btn mars-btn">Vote Mars</button>
            </div>
        </div>
        
        <div class="moon-or-mars-voting-message" id="moon-or-mars-voting-message"></div>
    </div>
    <?php endif; ?>
    
    <!-- Results Interface -->
    <div class="moon-or-mars-results <?php echo (!$has_voted && !$allow_multiple_votes) ? 'hidden' : ''; ?>" id="moon-or-mars-results">
        <h3>Current Results</h3>
        
        <div class="moon-or-mars-result-item">
            <div class="moon-or-mars-result-label">
                <span class="moon-or-mars-result-icon moon"></span>
                Moon
            </div>
            <div class="moon-or-mars-result-bar">
                <div class="moon-or-mars-result-progress moon" style="width: <?php echo esc_attr($results['moon']['percentage']); ?>%;">
                    <div class="moon-or-mars-result-stars"></div>
                </div>
            </div>
            <div class="moon-or-mars-result-percentage"><?php echo esc_html($results['moon']['percentage']); ?>%</div>
            <div class="moon-or-mars-result-count">(<?php echo esc_html($results['moon']['votes']); ?> votes)</div>
        </div>
        
        <div class="moon-or-mars-result-item">
            <div class="moon-or-mars-result-label">
                <span class="moon-or-mars-result-icon mars"></span>
                Mars
            </div>
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
        
        <?php if ($has_voted && !$allow_multiple_votes): ?>
        <div class="moon-or-mars-already-voted">
            <p>You have already voted. Thank you for participating!</p>
        </div>
        <?php endif; ?>
        
        <?php if ($allow_multiple_votes && $has_voted): ?>
        <div class="moon-or-mars-vote-again">
            <button id="moon-or-mars-vote-again-btn" class="moon-or-mars-btn">Vote Again</button>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="moon-or-mars-footer">
        <p>Powered by <a href="https://example.com/moon-or-mars" target="_blank">MoonOrMars</a></p>
    </div>
</div>
