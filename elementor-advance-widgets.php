<?php
/**
 * Plugin Name: Elementor Advance Widgets
 * Description: Custom widgets collection for Elementor page builder
 * Version: 1.0.0
 * Author: Nitya Saha
 * Author URI: https://yourwebsite.com
 * Text Domain: elementor-advance-widgets
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Elementor tested up to: 3.18.0
 * Elementor Pro tested up to: 3.18.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('ECW_VERSION', '1.0.0');
define('ECW_PLUGIN_FILE', __FILE__);
define('ECW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ECW_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ECW_WIDGETS_DIR', ECW_PLUGIN_DIR . 'includes/widgets/');

// Load the main plugin class
require_once ECW_PLUGIN_DIR . 'includes/class-plugin.php';

// Initialize the plugin
function ecw_init() {

    // Check dependency
    if ( ! \ECW\Plugin::is_elementor_active() ) {

        add_action( 'admin_notices', function () {
            ?>
            <div class="notice notice-error">
                <p>
                    <strong>Elementor Advance Widgets</strong> requires <strong>Elementor</strong> plugin to be installed and activated.
                </p>
            </div>
            <?php
        });
        
        return;
    }


    \ECW\Plugin::instance();
}
add_action('plugins_loaded', 'ecw_init');