<?php
/**
 * The plugin updater class.
 *
 * This class integrates with the YahnisElsts/plugin-update-checker library
 * to enable automatic updates from GitHub releases.
 *
 * @since      1.0.0
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/includes
 * @author     Cline
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The plugin updater class.
 */
class Moon_Or_Mars_Updater {

    /**
     * The plugin name.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The name of this plugin.
     */
    private $plugin_name;

    /**
     * The plugin version.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The update checker instance.
     *
     * @since    1.0.0
     * @access   private
     * @var      Puc_v4_Factory    $update_checker    The update checker instance.
     */
    private $update_checker;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name    The name of this plugin.
     * @param    string    $version        The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        // Include the plugin update checker library
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/plugin-update-checker/plugin-update-checker.php';

        // Initialize the update checker
        $this->init_update_checker();
    }

    /**
     * Initialize the update checker.
     *
     * @since    1.0.0
     */
    private function init_update_checker() {
        // Replace 'jpollock' with your actual GitHub username
        $github_username = 'jpollock';
        $github_repo = 'moon-or-mars';

        // Create the update checker
        $this->update_checker = Puc_v4_Factory::buildUpdateChecker(
            "https://github.com/{$github_username}/{$github_repo}/",
            MOON_OR_MARS_PLUGIN_FILE,
            'moon-or-mars'
        );

        // Set the branch that contains the stable release
        $this->update_checker->setBranch('main');

        // Use GitHub releases
        $this->update_checker->getVcsApi()->enableReleaseAssets();

        // Add filters to customize the update checker
        add_filter('puc_request_info_result-moon-or-mars', array($this, 'customize_update_info'), 10, 2);
    }

    /**
     * Customize the update information.
     *
     * @since    1.0.0
     * @param    object    $info        The update info.
     * @param    array     $result      The result of the API request.
     * @return   object                 The modified update info.
     */
    public function customize_update_info($info, $result) {
        // Customize the update information if needed
        return $info;
    }
}
