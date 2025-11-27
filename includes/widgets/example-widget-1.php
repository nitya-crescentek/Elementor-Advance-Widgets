<?php
namespace ECW\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Example_Widget_1 extends Widget_Base {
    
    /**
     * Widget name
     */
    public function get_name() {
        return 'example-widget-1';
    }
    
    /**
     * Widget title
     */
    public function get_title() {
        return __('Example Widget 1', 'elementor-custom-widgets');
    }
    
    /**
     * Widget icon
     */
    public function get_icon() {
        return 'eicon-code';
    }
    
    /**
     * Widget categories
     */
    public function get_categories() {
        return ['custom-widgets'];
    }
    
    /**
     * Widget keywords
     */
    public function get_keywords() {
        return ['example', 'custom', 'widget'];
    }
    
    /**
     * Register widget controls
     */
    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'elementor-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'elementor-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Default Title', 'elementor-custom-widgets'),
                'placeholder' => __('Enter your title', 'elementor-custom-widgets'),
            ]
        );
        
        $this->add_control(
            'description',
            [
                'label' => __('Description', 'elementor-custom-widgets'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Default description', 'elementor-custom-widgets'),
                'placeholder' => __('Enter your description', 'elementor-custom-widgets'),
            ]
        );
        
        $this->end_controls_section();
        
        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'elementor-custom-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'elementor-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    
    /**
     * Render widget output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        ?>
        <div class="ecw-example-widget-1">
            <h2 class="widget-title"><?php echo esc_html($settings['title']); ?></h2>
            <div class="widget-description"><?php echo esc_html($settings['description']); ?></div>
        </div>
        <?php
    }
    
    /**
     * Render widget output in the editor (optional)
     */
    protected function content_template() {
        ?>
        <div class="ecw-example-widget-1">
            <h2 class="widget-title">{{{ settings.title }}}</h2>
            <div class="widget-description">{{{ settings.description }}}</div>
        </div>
        <?php
    }
}