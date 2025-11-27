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
            'custom-widgets',
            [
                'title' => __('Advanced Widgets', 'elementor-advance-widgets'),
                'icon' => 'fa fa-plug',
            ]
        );
    }
    
    /**
     * Register all widgets
     * Add your widget files here
     */
    public function register_widgets($widgets_manager) {
        
        // Check if Elementor is active
        if (!did_action('elementor/loaded')) {
            return;
        }
        
        // List of widget files to load
        $widgets = [
            'example-widget-1.php',
            'example-widget-2.php',
            // Add more widget files here
        ];
        
        // Load and register each widget
        foreach ($widgets as $widget_file) {
            $widget_path = ECW_WIDGETS_DIR . $widget_file;
            
            if (file_exists($widget_path)) {
                require_once $widget_path;
                
                // Convert filename to class name
                // example-widget-1.php -> Example_Widget_1
                $class_name = str_replace('.php', '', $widget_file);
                $class_name = str_replace('-', '_', $class_name);
                $class_name = ucwords($class_name, '_');
                $full_class_name = '\\ECW\\Widgets\\' . $class_name;
                
                if (class_exists($full_class_name)) {
                    $widgets_manager->register(new $full_class_name());
                }
            }
        }
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
