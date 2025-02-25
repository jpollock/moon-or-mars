<?php
/**
 * Server-side rendering of the `moon-or-mars/voting-block` block.
 *
 * @package Moon_Or_Mars
 */

/**
 * Renders the `moon-or-mars/voting-block` block on the server.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 * @return string Returns the post content with the moon or mars poll added.
 */
function render_block_moon_or_mars_voting_block($attributes, $content, $block) {
    // Create an instance of the public class to access the display_poll method
    $plugin_public = new Moon_Or_Mars_Public('moon-or-mars', '1.0.0');
    
    // Return the poll HTML
    return $plugin_public->display_poll($attributes);
}
