<?php
namespace ECW\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit;

class Slider_1 extends Widget_Base {

    public function get_name() {
        return 'advance-slider-1';
    }

    public function get_title() {
        return __('Advance Slider 1', 'elementor-advance-widgets');
    }

    public function get_icon() {
        return 'eicon-slider-full-screen';
    }

    public function get_keywords() {
        return ['slider', 'advance', 'custom', 'widget'];
    }

    public function get_categories() {
        return ['advance-widgets'];
    }

    protected function register_controls() {

        /*
        |--------------------------------------------------------------------------
        | CONTENT SECTION
        |--------------------------------------------------------------------------
        */
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'elementor-advance-widgets'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text_wrapper_text',
            [
                'label'       => __('Top Small Text', 'elementor-advance-widgets'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Your Small Text Here', 'elementor-advance-widgets'),
                'label_block' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | REPEATER
        |--------------------------------------------------------------------------
        */
        $repeater = new Repeater();

        $repeater->add_control(
            'slide_heading',
            [
                'label'   => __('Heading', 'elementor-advance-widgets'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Slide Title', 'elementor-advance-widgets'),
            ]
        );

        $repeater->add_control(
            'slide_description',
            [
                'label'   => __('Description', 'elementor-advance-widgets'),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __('Description for this slide.', 'elementor-advance-widgets'),
            ]
        );

        $repeater->add_control(
            'slide_image',
            [
                'label'   => __('Image', 'elementor-advance-widgets'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src()
                ],
            ]
        );

        // Image width
        $repeater->add_control(
            'image_width',
            [
                'label'      => __('Image Width', 'elementor-advance-widgets'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'    => ['size' => 100, 'unit' => '%'],
            ]
        );

        // Max Width
        $repeater->add_control(
            'image_max_width',
            [
                'label'      => __('Image Max Width', 'elementor-advance-widgets'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'    => ['size' => 600, 'unit' => 'px'],
            ]
        );

        // Height
        $repeater->add_control(
            'image_height',
            [
                'label'      => __('Image Height', 'elementor-advance-widgets'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'    => ['size' => 300, 'unit' => 'px'],
            ]
        );

        // Border Radius
        $repeater->add_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'elementor-advance-widgets'),
                'type'       => Controls_Manager::DIMENSIONS,
                'default'    => [
                    'top'    => 10,
                    'right'  => 10,
                    'bottom' => 10,
                    'left'   => 10,
                    'unit'   => 'px',
                ],
            ]
        );

        $this->add_control(
            'slides',
            [
                'label'       => __('Slider Items', 'elementor-advance-widgets'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ slide_heading }}}',
            ]
        );

        $this->end_controls_section();

        /*
        |--------------------------------------------------------------------------
        | LAYOUT SECTION
        |--------------------------------------------------------------------------
        */
        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Layout', 'elementor-advance-widgets'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label'     => __('Content Alignment', 'elementor-advance-widgets'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => ['title' => __('Left', 'elementor-advance-widgets'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => __('Center', 'elementor-advance-widgets'), 'icon' => 'eicon-text-align-center'],
                    'right'  => ['title' => __('Right', 'elementor-advance-widgets'), 'icon' => 'eicon-text-align-right'],
                ],
                'default'   => 'left',
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .text-slider-container' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /*
    |--------------------------------------------------------------------------
    | RENDER OUTPUT
    |--------------------------------------------------------------------------
    */
    protected function render() {
        $s = $this->get_settings_for_display();

        if (empty($s['slides'])) return;

        ?>

        <div class="slider-container">

            <div class="image-wrapper">
                <img id="slider-image"
                     src="<?php echo esc_url($s['slides'][0]['slide_image']['url']); ?>"
                     alt=""
                >
            </div>

            <div class="text-slider-container">

                <div class="text-wrapper">
                    <p><?php echo esc_html($s['text_wrapper_text']); ?></p>
                </div>

                <div class="slider-wrapper">
                    <div class="fraction" id="fraction-number">
                        01 / <?php echo count($s['slides']); ?>
                    </div>

                    <div class="text-slider owl-carousel owl-theme">

                        <?php foreach ($s['slides'] as $index => $slide): ?>
                            <?php
                            $radius = $slide['image_border_radius'];
                            $border_radius = $radius['top'] . $radius['unit'] . ' ' .
                                            $radius['right'] . $radius['unit'] . ' ' .
                                            $radius['bottom'] . $radius['unit'] . ' ' .
                                            $radius['left'] . $radius['unit'];
                            ?>

                            <div class="item"
                                 data-image="<?php echo esc_url($slide['slide_image']['url']); ?>"
                                 data-index="<?php printf('%02d', $index + 1); ?> / <?php echo count($s['slides']); ?>"
                                 data-width="<?php echo $slide['image_width']['size'] . $slide['image_width']['unit']; ?>"
                                 data-max-width="<?php echo $slide['image_max_width']['size'] . $slide['image_max_width']['unit']; ?>"
                                 data-height="<?php echo $slide['image_height']['size'] . $slide['image_height']['unit']; ?>"
                                 data-radius="<?php echo esc_attr($border_radius); ?>">

                                <h3><?php echo esc_html($slide['slide_heading']); ?></h3>
                                <p><?php echo esc_html($slide['slide_description']); ?></p>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

            </div>
        </div>

        <?php
    }
}
