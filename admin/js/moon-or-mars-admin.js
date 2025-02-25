/**
 * All of the JavaScript for your admin-specific functionality should be
 * included in this file.
 */

(function($) {
    'use strict';

    /**
     * Initialize admin functionality when the DOM is ready
     */
    $(document).ready(function() {
        // Add cosmic particle effects to the admin header
        initCosmicParticles();
        
        // Add animation to result bars
        animateResultBars();
    });

    /**
     * Initialize cosmic particle effects
     */
    function initCosmicParticles() {
        const header = $('.moon-or-mars-admin-header');
        
        if (header.length === 0) {
            return;
        }
        
        // Create stars
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
                animation: `twinkle ${duration}s infinite ${delay}s`
            });
            
            header.append(star);
        }
    }

    /**
     * Animate result bars with cosmic effects
     */
    function animateResultBars() {
        $('.moon-or-mars-result-progress').each(function() {
            const bar = $(this);
            const width = bar.attr('style').replace('width: ', '').replace('%;', '');
            
            // Reset width to 0 and then animate to the actual width
            bar.css('width', '0%');
            
            setTimeout(function() {
                bar.css('width', width + '%');
                
                // Add star particles
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
                        animation: `float ${duration}s infinite ${delay}s`
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
        .moon-or-mars-star {
            position: absolute;
            background-color: #fff;
            border-radius: 50%;
            z-index: 1;
        }
        
        .moon-or-mars-particle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            z-index: 2;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 1;
            }
            50% {
                transform: translateY(-10px) translateX(5px);
                opacity: 0.7;
            }
            100% {
                transform: translateY(0) translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);

})(jQuery);
