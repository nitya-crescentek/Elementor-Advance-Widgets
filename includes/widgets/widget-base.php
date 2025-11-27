<?php
namespace ECW\Widgets;

use Elementor\Widget_Base as Elementor_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Base class for all custom widgets
 */
abstract class Widget_Base extends Elementor_Widget_Base {
    
    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['advance-widgets'];
    }
    
    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['advance', 'custom'];
    }
    
    /**
     * Add common style controls for any element
     */
    protected function add_common_style_controls($id_prefix, $selector, $label = 'Style') {
        
        $this->start_controls_section(
            $id_prefix . '_style_section',
            [
                'label' => $label,
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => $id_prefix . '_typography',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );
        
        // Color
        $this->add_control(
            $id_prefix . '_color',
            [
                'label' => __('Color', 'elementor-advance-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}}',
                ],
            ]
        );
        
        // Background
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => $id_prefix . '_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );
        
        // Margin
        $this->add_responsive_control(
            $id_prefix . '_margin',
            [
                'label' => __('Margin', 'elementor-advance-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        // Padding
        $this->add_responsive_control(
            $id_prefix . '_padding',
            [
                'label' => __('Padding', 'elementor-advance-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => $id_prefix . '_border',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );
        
        // Border Radius
        $this->add_responsive_control(
            $id_prefix . '_border_radius',
            [
                'label' => __('Border Radius', 'elementor-advance-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        // Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $id_prefix . '_box_shadow',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );
        
        $this->end_controls_section();
    }
    
    /**
     * Add responsive alignment control
     */
    protected function add_alignment_control($id, $selector, $label = 'Alignment') {
        $this->add_responsive_control(
            $id,
            [
                'label' => $label,
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'elementor-advance-widgets'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'elementor-advance-widgets'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'elementor-advance-widgets'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'elementor-advance-widgets'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'text-align: {{VALUE}};',
                ],
            ]
        );
    }
}