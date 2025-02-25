<?php
/**
 * MoonOrMars
 *
 * @package           MoonOrMars
 * @author            Cline
 * @copyright         2025 Cline
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       MoonOrMars
 * Plugin URI:        https://example.com/plugins/moon-or-mars
 * Description:       Plugin that shows a poll to the user, do you want to go to the Moon or Mars?
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Cline
 * Author URI:        https://example.com
 * Text Domain:       moon-or-mars
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://example.com/moon-or-mars/
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Current plugin version.
 */
define('MOON_OR_MARS_VERSION', '1.0.0');
define('MOON_OR_MARS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MOON_OR_MARS_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 */
function activate_moon_or_mars() {
    require_once MOON_OR_MARS_PLUGIN_DIR . 'includes/class-moon-or-mars-activator.php';
    Moon_Or_Mars_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_moon_or_mars() {
    require_once MOON_OR_MARS_PLUGIN_DIR . 'includes/class-moon-or-mars-deactivator.php';
    Moon_Or_Mars_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_moon_or_mars');
register_deactivation_hook(__FILE__, 'deactivate_moon_or_mars');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require MOON_OR_MARS_PLUGIN_DIR . 'includes/class-moon-or-mars.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_moon_or_mars() {
    $plugin = new Moon_Or_Mars();
    $plugin->run();
}
run_moon_or_mars();
