<?php
namespace ECW\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Example_Widget_2 extends Widget_Base {
    
    public function get_name() {
        return 'example-widget-2';
    }
    
    public function get_title() {
        return __('Example Widget 2', 'elementor-custom-widgets');
    }
    
    public function get_icon() {
        return 'eicon-button';
    }
    
    public function get_categories() {
        return ['custom-widgets'];
    }
    
    protected function register_controls() {
        
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'elementor-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'elementor-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Click Me', 'elementor-custom-widgets'),
            ]
        );
        
        $this->add_control(
            'button_link',
            [
                'label' => __('Link', 'elementor-custom-widgets'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'elementor-custom-widgets'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        $target = $settings['button_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['button_link']['nofollow'] ? ' rel="nofollow"' : '';
        
        ?>
        <div class="ecw-example-widget-2">
            <a href="<?php echo esc_url($settings['button_link']['url']); ?>" 
               class="custom-button"<?php echo $target . $nofollow; ?>>
                <?php echo esc_html($settings['button_text']); ?>
            </a>
        </div>
        <?php
    }
}
