<?php
namespace ECW\Widgets;

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Example_Widget_1 extends Widget_Base {
    
    public function get_name() {
        return 'advance-example-widget-1';
    }
    
    public function get_title() {
        return __('Advance Example 1', 'elementor-advance-widgets');
    }
    
    public function get_icon() {
        return 'eicon-code';
    }
    
    public function get_keywords() {
        return ['advance', 'example', 'custom', 'widget'];
    }
    
    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'elementor-advance-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'elementor-advance-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Advance Widget Title', 'elementor-advance-widgets'),
                'placeholder' => __('Enter your title', 'elementor-advance-widgets'),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'description',
            [
                'label' => __('Description', 'elementor-advance-widgets'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('This is an advance widget with full styling options.', 'elementor-advance-widgets'),
                'placeholder' => __('Enter your description', 'elementor-advance-widgets'),
                'rows' => 5,
            ]
        );
        
        $this->add_control(
            'title_tag',
            [
                'label' => __('Title HTML Tag', 'elementor-advance-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                ],
                'default' => 'h2',
            ]
        );
        
        $this->end_controls_section();
        
        // Layout Section
        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Layout', 'elementor-advance-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_alignment_control(
            'content_alignment',
            '.ecw-widget-content',
            __('Content Alignment', 'elementor-advance-widgets')
        );
        
        $this->end_controls_section();
        
        // Container Style
        $this->add_common_style_controls(
            'container',
            '.ecw-advance-widget-1',
            __('Container Style', 'elementor-advance-widgets')
        );
        
        // Title Style
        $this->add_common_style_controls(
            'title',
            '.ecw-widget-title',
            __('Title Style', 'elementor-advance-widgets')
        );
        
        // Description Style
        $this->add_common_style_controls(
            'description',
            '.ecw-widget-description',
            __('Description Style', 'elementor-advance-widgets')
        );
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        $title_tag = $settings['title_tag'];
        ?>
        <div class="ecw-advance-widget-1">
            <div class="ecw-widget-content">
                <?php if (!empty($settings['title'])) : ?>
                    <<?php echo esc_attr($title_tag); ?> class="ecw-widget-title">
                        <?php echo esc_html($settings['title']); ?>
                    </<?php echo esc_attr($title_tag); ?>>
                <?php endif; ?>
                
                <?php if (!empty($settings['description'])) : ?>
                    <div class="ecw-widget-description">
                        <?php echo wp_kses_post($settings['description']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    protected function content_template() {
        ?>
        <div class="ecw-advance-widget-1">
            <div class="ecw-widget-content">
                <# if (settings.title) { #>
                    <{{{ settings.title_tag }}} class="ecw-widget-title">
                        {{{ settings.title }}}
                    </{{{ settings.title_tag }}}>
                <# } #>
                
                <# if (settings.description) { #>
                    <div class="ecw-widget-description">
                        {{{ settings.description }}}
                    </div>
                <# } #>
            </div>
        </div>
        <?php
    }
}