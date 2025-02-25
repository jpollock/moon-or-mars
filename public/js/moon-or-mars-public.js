/**
 * All of the JavaScript for your public-facing functionality should be
 * included in this file.
 */

(function($) {
    'use strict';

    /**
     * Initialize public functionality when the DOM is ready
     */
    $(document).ready(function() {
        // Initialize cosmic effects
        initCosmicEffects();
        
        // Initialize voting functionality
        initVoting();
        
        // Initialize results animation
        animateResults();
    });

    /**
     * Initialize cosmic effects
     */
    function initCosmicEffects() {
        // Add more stars dynamically
        const container = $('.moon-or-mars-container');
        const starsContainer = $('.moon-or-mars-stars');
        
        if (starsContainer.length === 0) {
            return;
        }
        
        // Create additional stars
        for (let i = 0; i < 50; i++) {
            const star = $('<div class="moon-or-mars-star"></div>');
            const size = Math.random() * 2 + 1;
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            const delay = Math.random() * 5;
            const duration = Math.random() * 3 + 2;
            
            star.css({
                width: size + 'px',
                height: size + 'px',
                left: posX + '%',
                top: posY + '%',
                position: 'absolute',
                backgroundColor: '#fff',
                borderRadius: '50%',
                animation: `twinkle ${duration}s infinite ${delay}s`
            });
            
            starsContainer.append(star);
        }
        
        // Add cosmic particles to the options
        $('.moon-or-mars-option').each(function() {
            const option = $(this);
            
            for (let i = 0; i < 10; i++) {
                const particle = $('<div class="moon-or-mars-particle"></div>');
                const size = Math.random() * 3 + 1;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const delay = Math.random() * 2;
                const duration = Math.random() * 3 + 2;
                
                particle.css({
                    width: size + 'px',
                    height: size + 'px',
                    left: posX + '%',
                    top: posY + '%',
                    position: 'absolute',
                    backgroundColor: 'rgba(255, 255, 255, 0.5)',
                    borderRadius: '50%',
                    animation: `float ${duration}s infinite ${delay}s`
                });
                
                option.append(particle);
            }
        });
    }

    /**
     * Initialize voting functionality
     */
    function initVoting() {
        // Handle vote button clicks
        $('.moon-or-mars-vote-btn').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const voteType = $(this).closest('.moon-or-mars-option').data('vote');
            submitVote(voteType);
        });
        
        // Handle option clicks (the entire card)
        $('.moon-or-mars-option').on('click', function() {
            const voteType = $(this).data('vote');
            submitVote(voteType);
        });
        
        // Handle vote again button
        $('#moon-or-mars-vote-again-btn').on('click', function() {
            $('#moon-or-mars-results').addClass('hidden');
            $('#moon-or-mars-voting').fadeIn();
        });
    }

    /**
     * Submit a vote via AJAX
     */
    function submitVote(voteType) {
        // Show loading state
        $('#moon-or-mars-voting-message').html('<div class="moon-or-mars-loading"><div class="moon-or-mars-loading-spinner"></div><p>Submitting your vote...</p></div>');
        
        // Submit the vote
        $.ajax({
            url: moon_or_mars_public.ajax_url,
            type: 'POST',
            data: {
                action: 'moon_or_mars_vote',
                nonce: moon_or_mars_public.nonce,
                vote_type: voteType
            },
            success: function(response) {
                if (response.success) {
                    // Update results
                    updateResults(response.data.results);
                    
                    // Show success message
                    $('#moon-or-mars-voting-message').html('<div class="moon-or-mars-success">Your vote has been recorded!</div>');
                    
                    // Show results after a short delay
                    setTimeout(function() {
                        $('#moon-or-mars-voting').fadeOut(function() {
                            $('#moon-or-mars-results').removeClass('hidden').hide().fadeIn();
                            animateResults();
                        });
                    }, 1000);
                } else {
                    // Show error message
                    $('#moon-or-mars-voting-message').html('<div class="moon-or-mars-error">' + response.data + '</div>');
                }
            },
            error: function() {
                // Show error message
                $('#moon-or-mars-voting-message').html('<div class="moon-or-mars-error">An error occurred. Please try again.</div>');
            }
        });
    }

    /**
     * Update the results display
     */
    function updateResults(results) {
        // Update Moon results
        $('.moon-or-mars-result-progress.moon').css('width', results.moon.percentage + '%');
        $('.moon-or-mars-result-percentage:eq(0)').text(results.moon.percentage + '%');
        $('.moon-or-mars-result-count:eq(0)').text('(' + results.moon.votes + ' votes)');
        
        // Update Mars results
        $('.moon-or-mars-result-progress.mars').css('width', results.mars.percentage + '%');
        $('.moon-or-mars-result-percentage:eq(1)').text(results.mars.percentage + '%');
        $('.moon-or-mars-result-count:eq(1)').text('(' + results.mars.votes + ' votes)');
        
        // Update total votes
        $('.moon-or-mars-total-votes span').text(results.total);
    }

    /**
     * Animate the results bars
     */
    function animateResults() {
        $('.moon-or-mars-result-progress').each(function() {
            const bar = $(this);
            const width = bar.css('width');
            
            // Reset width to 0 and then animate to the actual width
            bar.css('width', '0');
            
            setTimeout(function() {
                bar.css('width', width);
                
                // Add star particles
                for (let i = 0; i < 5; i++) {
                    const particle = $('<div class="moon-or-mars-result-particle"></div>');
                    const size = Math.random() * 2 + 1;
                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    
                    particle.css({
                        width: size + 'px',
                        height: size + 'px',
                        left: posX + '%',
                        top: posY + '%',
                        position: 'absolute',
                        backgroundColor: 'rgba(255, 255, 255, 0.8)',
                        borderRadius: '50%'
                    });
                    
                    bar.append(particle);
                }
            }, 300);
        });
    }

    /**
     * Add CSS for dynamic elements
     */
    const style = document.createElement('style');
    style.textContent = `
        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0.5;
            }
            50% {
                transform: translateY(-10px) translateX(5px);
                opacity: 1;
            }
            100% {
                transform: translateY(0) translateX(0);
                opacity: 0.5;
            }
        }
        
        .moon-or-mars-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }
        
        .moon-or-mars-loading-spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);

})(jQuery);
