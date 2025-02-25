/**
 * Front-end JavaScript for the Moon or Mars voting block.
 * 
 * This script is loaded only on the front-end when the block is present.
 * It initializes any client-side functionality needed for the block.
 * 
 * Note: Most of the interactive functionality is already handled by the
 * plugin's main public JavaScript file, so this is mostly a placeholder
 * that could be expanded for block-specific functionality if needed.
 */

(function() {
    'use strict';

    // When the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Find all instances of our block on the page
        const votingBlocks = document.querySelectorAll('.moon-or-mars-container');
        
        if (votingBlocks.length === 0) {
            return;
        }
        
        // For each block instance, we could initialize block-specific functionality
        votingBlocks.forEach(function(block) {
            // The main public.js file already handles most functionality,
            // but we could add block-specific enhancements here if needed
            
            // For example, we could add a class to indicate the block is ready
            block.classList.add('moon-or-mars-block-initialized');
        });
    });
})();
