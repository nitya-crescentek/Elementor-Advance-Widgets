<?php
namespace ECW;

if (!defined('ABSPATH')) {
    exit;
}

class Plugin {
    
    private static $_instance = null;
    
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function __construct() {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'register_widget_categories']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }
    
    /**
     * Register custom widget category
     */
    public function register_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'advance-widgets',
            [
                'title' => __('Advance Widgets', 'elementor-advance-widgets'),
                'icon' => 'fa fa-plug',
            ]
        );
    }
    
    /**
     * Register all widgets
     */
    public function register_widgets($widgets_manager) {
    
        if (!did_action('elementor/loaded')) {
            return;
        }
        
        // Load base widget class FIRST
        require_once ECW_WIDGETS_DIR . 'widget-base.php';
        
        // Load widget files
        require_once ECW_WIDGETS_DIR . 'example-widget-1.php';
        require_once ECW_WIDGETS_DIR . 'example-widget-2.php';
        
        // Register widgets with their full class names
        $widgets_manager->register(new \ECW\Widgets\Example_Widget_1());
        $widgets_manager->register(new \ECW\Widgets\Example_Widget_2());
    }
    
    /**
     * Enqueue plugin styles and scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_style(
            'ecw-widgets',
            ECW_PLUGIN_URL . 'assets/css/widgets.css',
            [],
            ECW_VERSION
        );
        
        wp_enqueue_script(
            'ecw-widgets',
            ECW_PLUGIN_URL . 'assets/js/widgets.js',
            ['jquery'],
            ECW_VERSION,
            true
        );
    }
    
    /**
     * Check if Elementor is installed and activated
     */
    public static function is_elementor_active() {
        return did_action('elementor/loaded');
    }
}