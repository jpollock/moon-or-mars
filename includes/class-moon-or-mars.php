<?php
/**
 * The core plugin class.
 *
 * @since      1.0.0
 * @package    Moon_Or_Mars
 * @subpackage Moon_Or_Mars/includes
 * @author     Cline
 */

class Moon_Or_Mars {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Moon_Or_Mars_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if (defined('MOON_OR_MARS_VERSION')) {
            $this->version = MOON_OR_MARS_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'moon-or-mars';

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_block_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-moon-or-mars-loader.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-moon-or-mars-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-moon-or-mars-public.php';

        /**
         * The class responsible for database operations.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-moon-or-mars-db.php';

        $this->loader = new Moon_Or_Mars_Loader();
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        $plugin_admin = new Moon_Or_Mars_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        
        // Add menu item
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
        
        // Add Settings link to the plugin
        $plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->plugin_name . '.php');
        $this->loader->add_filter('plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links');
        
        // Save/Update our plugin options
        $this->loader->add_action('admin_init', $plugin_admin, 'options_update');
        
        // AJAX handlers for admin
        $this->loader->add_action('wp_ajax_moon_or_mars_clear_votes', $plugin_admin, 'clear_votes');
        $this->loader->add_action('wp_ajax_moon_or_mars_get_vote_data', $plugin_admin, 'get_vote_data');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        $plugin_public = new Moon_Or_Mars_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        
        // Add shortcode
        $this->loader->add_shortcode('moon_or_mars', $plugin_public, 'display_poll');
        
        // AJAX handlers for public
        $this->loader->add_action('wp_ajax_moon_or_mars_vote', $plugin_public, 'process_vote');
        $this->loader->add_action('wp_ajax_nopriv_moon_or_mars_vote', $plugin_public, 'process_vote');
        $this->loader->add_action('wp_ajax_moon_or_mars_get_results', $plugin_public, 'get_results');
        $this->loader->add_action('wp_ajax_nopriv_moon_or_mars_get_results', $plugin_public, 'get_results');
    }

    /**
     * Register all of the hooks related to the Gutenberg blocks
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_block_hooks() {
        // Register block using the loader
        $this->loader->add_action('init', $this, 'register_blocks');
    }

    /**
     * Register the Gutenberg blocks.
     *
     * @since    1.0.0
     */
    public function register_blocks() {
        // Check if Gutenberg is active
        if (!function_exists('register_block_type')) {
            return;
        }

        // Register editor script
        wp_register_script(
            'moon-or-mars-block-editor',
            MOON_OR_MARS_PLUGIN_URL . 'blocks/voting-block/index.js',
            array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'),
            $this->version,
            false
        );

        // Register editor style
        wp_register_style(
            'moon-or-mars-block-editor',
            MOON_OR_MARS_PLUGIN_URL . 'blocks/voting-block/editor.css',
            array(),
            $this->version
        );

        // Register block style
        wp_register_style(
            'moon-or-mars-block',
            MOON_OR_MARS_PLUGIN_URL . 'blocks/voting-block/style.css',
            array(),
            $this->version
        );

        // Register the block directly (not using block.json)
        register_block_type('moon-or-mars/voting-block', array(
            'editor_script' => 'moon-or-mars-block-editor',
            'editor_style' => 'moon-or-mars-block-editor',
            'style' => 'moon-or-mars-block',
            'render_callback' => array($this, 'render_voting_block')
        ));
    }

    /**
     * Render the voting block.
     *
     * @since    1.0.0
     * @param    array    $attributes    The block attributes.
     * @return   string                  The block HTML.
     */
    public function render_voting_block($attributes) {
        $plugin_public = new Moon_Or_Mars_Public($this->get_plugin_name(), $this->get_version());
        return $plugin_public->display_poll($attributes);
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Moon_Or_Mars_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
}
