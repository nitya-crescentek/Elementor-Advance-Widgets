<?php
namespace ECW\Widgets;

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Example_Widget_2 extends Widget_Base {
    
    public function get_name() {
        return 'advance-example-widget-2';
    }
    
    public function get_title() {
        return __('Advance Button', 'elementor-advance-widgets');
    }
    
    public function get_icon() {
        return 'eicon-button';
    }
    
    public function get_keywords() {
        return ['advance', 'button', 'link', 'cta'];
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
            'button_text',
            [
                'label' => __('Button Text', 'elementor-advance-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Click Me', 'elementor-advance-widgets'),
                'placeholder' => __('Enter button text', 'elementor-advance-widgets'),
            ]
        );
        
        $this->add_control(
            'button_link',
            [
                'label' => __('Link', 'elementor-advance-widgets'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'elementor-advance-widgets'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );
        
        $this->add_control(
            'button_icon',
            [
                'label' => __('Icon', 'elementor-advance-widgets'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'solid',
                ],
            ]
        );
        
        $this->add_control(
            'icon_position',
            [
                'label' => __('Icon Position', 'elementor-advance-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => __('Left', 'elementor-advance-widgets'),
                    'right' => __('Right', 'elementor-advance-widgets'),
                ],
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
            'button_alignment',
            '.ecw-advance-widget-2',
            __('Button Alignment', 'elementor-advance-widgets')
        );
        
        $this->end_controls_section();
        
        // Button Style
        $this->add_common_style_controls(
            'button',
            '.ecw-button',
            __('Button Style', 'elementor-advance-widgets')
        );
        
        // Hover State
        $this->start_controls_section(
            'button_hover_section',
            [
                'label' => __('Button Hover', 'elementor-advance-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Hover Color', 'elementor-advance-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ecw-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'button_hover_bg',
            [
                'label' => __('Hover Background', 'elementor-advance-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ecw-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $this->add_link_attributes('button_link', $settings['button_link']);
        $this->add_render_attribute('button_link', 'class', 'ecw-button');
        
        ?>
        <div class="ecw-advance-widget-2">
            <a <?php echo $this->get_render_attribute_string('button_link'); ?>>
                <?php if ($settings['icon_position'] === 'left' && !empty($settings['button_icon']['value'])) : ?>
                    <span class="ecw-button-icon ecw-icon-left">
                        <?php \Elementor\Icons_Manager::render_icon($settings['button_icon']); ?>
                    </span>
                <?php endif; ?>
                
                <span class="ecw-button-text"><?php echo esc_html($settings['button_text']); ?></span>
                
                <?php if ($settings['icon_position'] === 'right' && !empty($settings['button_icon']['value'])) : ?>
                    <span class="ecw-button-icon ecw-icon-right">
                        <?php \Elementor\Icons_Manager::render_icon($settings['button_icon']); ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
        <?php
    }
}