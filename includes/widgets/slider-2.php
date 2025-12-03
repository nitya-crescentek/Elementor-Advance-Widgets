<?php
namespace ECW\Widgets;
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Slider_2 extends Widget_Base {

    public function get_name() {
        return 'advance-slider-2';
    }

    public function get_title() {
        return __( 'Advance Slider 2', 'elementor-advance-widgets' );
    }

    public function get_icon() {
        return 'eicon-slider-full-screen';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function register_controls() {
         $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Slides', 'elementor-advance-widgets' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'slide_image',
            [
                'label'   => __( 'Image', 'elementor-advance-widgets' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'slide_alt',
            [
                'label'   => __( 'Alt Text', 'elementor-advance-widgets' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Slide Image', 'elementor-advance-widgets' ),
            ]
        );

        $this->add_control(
            'slides',
            [
                'label'       => __( 'Slides', 'elementor-advance-widgets' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [],
                'title_field' => '{{{ slide_alt }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
         $settings = $this->get_settings_for_display();

        if ( empty( $settings['slides'] ) ) {
            return;
        }

        $total_slides = count( $settings['slides'] );
        ?>
        <div class="slider-container">
            <div class="slides-wrapper">
                <?php foreach ( $settings['slides'] as $index => $slide ) : 
                    $position_class = $index === 2 ? 'center' : ($index === 1 ? 'left-1' : ($index === 0 ? 'left-2' : ($index === 3 ? 'right-1' : ($index === 4 ? 'right-2' : ''))));
                ?>
                    <div class="slide <?php echo esc_attr( $position_class ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
                        <img src="<?php echo esc_url( $slide['slide_image']['url'] ); ?>" alt="<?php echo esc_attr( $slide['slide_alt'] ); ?>">
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="navigation-wrapper">
                <button class="nav-btn prev" onclick="previousSlide()"><span><img src="<?php echo ECW_PLUGIN_URL .'/assets/images/Arrow.svg'; ?>" alt="icon"></span></button>
                <button class="nav-btn next" onclick="nextSlide()"><span><img src="<?php echo ECW_PLUGIN_URL .'/assets/images/Arrow.svg'; ?>" alt="icon"></span></button>

                <div class="indicators">
                    <?php foreach ( $settings['slides'] as $index => $slide ) : ?>
                        <div class="indicator <?php echo $index === 2 ? 'active' : ''; ?>" onclick="goToSlide(<?php echo esc_attr( $index ); ?>)"></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Lightbox -->
        <div class="lightbox" id="lightbox">
            <div class="lightbox-content">
                <img id="lightboxImage" src="" alt="">
                <button class="lightbox-close" onclick="closeLightbox()">×</button>
                <button class="lightbox-nav lightbox-prev" onclick="lightboxPrev()">‹</button>
                <button class="lightbox-nav lightbox-next" onclick="lightboxNext()">›</button>
                <div class="lightbox-counter">
                    <span id="lightboxCounter">1 / <?php echo esc_html( $total_slides ); ?></span>
                </div>
            </div>
        </div>
        <?php
        $image_sources = [];

        if ( ! empty( $settings['slides'] ) && is_array( $settings['slides'] ) ) {
            foreach ( $settings['slides'] as $slide ) {
                if ( ! empty( $slide['slide_image']['url'] ) ) {
                    $image_sources[] = $slide['slide_image']['url'];
                }
            }
        }
        ?>
        <script>
            let currentIndex = 2; // Start with middle slide as center
            const totalSlides = 5;
            const slides = document.querySelectorAll('.slide');
            const indicators = document.querySelectorAll('.indicator');
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightboxImage');
            const lightboxCounter = document.getElementById('lightboxCounter');
            let currentLightboxIndex = 0;

            // Image sources array for lightbox
            const imageSources = <?php echo wp_json_encode( $image_sources ); ?>;
            function updateSlider() {
                slides.forEach((slide, index) => {
                    // Remove all position classes
                    slide.classList.remove('left-2', 'left-1', 'center', 'right-1', 'right-2');
                    
                    // Calculate relative position from current center
                    let position = index - currentIndex;
                    
                    // Handle wrapping
                    if (position < -2) position += totalSlides;
                    if (position > 2) position -= totalSlides;
                    
                    // Apply appropriate class based on position
                    switch(position) {
                        case -2:
                            slide.classList.add('left-2');
                            break;
                        case -1:
                            slide.classList.add('left-1');
                            break;
                        case 0:
                            slide.classList.add('center');
                            break;
                        case 1:
                            slide.classList.add('right-1');
                            break;
                        case 2:
                            slide.classList.add('right-2');
                            break;
                    }
                });

                // Update indicators
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentIndex);
                });
            }

            // Lightbox functions
            function openLightbox(index) {
                currentLightboxIndex = index;
                lightboxImage.src = imageSources[index];
                lightboxCounter.textContent = `${index + 1} / ${totalSlides}`;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent body scroll
            }

            function closeLightbox() {
                lightbox.classList.remove('active');
                document.body.style.overflow = ''; // Restore body scroll
            }

            function lightboxNext() {
                currentLightboxIndex = (currentLightboxIndex + 1) % totalSlides;
                lightboxImage.src = imageSources[currentLightboxIndex];
                lightboxCounter.textContent = `${currentLightboxIndex + 1} / ${totalSlides}`;
            }

            function lightboxPrev() {
                currentLightboxIndex = (currentLightboxIndex - 1 + totalSlides) % totalSlides;
                lightboxImage.src = imageSources[currentLightboxIndex];
                lightboxCounter.textContent = `${currentLightboxIndex + 1} / ${totalSlides}`;
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlider();
            }

            function previousSlide() {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateSlider();
            }

            function goToSlide(index) {
                currentIndex = index;
                updateSlider();
            }

            // Click on slides to center them or open lightbox
            slides.forEach((slide, index) => {
                slide.addEventListener('click', (e) => {
                    if (!isDragging) {
                        if (index === currentIndex) {
                            // If clicking on center slide, open lightbox
                            openLightbox(index);
                        } else {
                            // If clicking on side slide, center it
                            goToSlide(index);
                        }
                    }
                });
            });

            // Auto-play
            let autoPlay = setInterval(nextSlide, 4000);

            const sliderContainer = document.querySelector('.slider-container');
            sliderContainer.addEventListener('mouseenter', () => clearInterval(autoPlay));
            sliderContainer.addEventListener('mouseleave', () => {
                autoPlay = setInterval(nextSlide, 4000);
            });

            // Enhanced touch and mouse drag support
            let startX = 0;
            let startY = 0;
            let isDragging = false;
            let isMouseDown = false;

            // Mouse drag events
            sliderContainer.addEventListener('mousedown', (e) => {
                e.preventDefault();
                startX = e.clientX;
                startY = e.clientY;
                isMouseDown = true;
                isDragging = false;
                sliderContainer.style.cursor = 'grabbing';
            });

            sliderContainer.addEventListener('mousemove', (e) => {
                if (!isMouseDown) return;
                
                const currentX = e.clientX;
                const currentY = e.clientY;
                const diffX = Math.abs(currentX - startX);
                const diffY = Math.abs(currentY - startY);
                
                // Start dragging if moved more than 5px horizontally
                if (diffX > 5) {
                    isDragging = true;
                    e.preventDefault();
                }
            });

            sliderContainer.addEventListener('mouseup', (e) => {
                if (!isMouseDown) return;
                isMouseDown = false;
                sliderContainer.style.cursor = 'grab';
                
                if (isDragging) {
                    const endX = e.clientX;
                    const diff = startX - endX;
                    
                    // Minimum drag distance to trigger slide change
                    if (Math.abs(diff) > 50) {
                        if (diff > 0) {
                            nextSlide();
                        } else {
                            previousSlide();
                        }
                    }
                }
                isDragging = false;
            });

            sliderContainer.addEventListener('mouseleave', () => {
                if (isMouseDown) {
                    isMouseDown = false;
                    isDragging = false;
                    sliderContainer.style.cursor = 'grab';
                }
            });

            // Touch events
            sliderContainer.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                isDragging = false;
            }, { passive: true });

            sliderContainer.addEventListener('touchmove', (e) => {
                const currentX = e.touches[0].clientX;
                const currentY = e.touches[0].clientY;
                const diffX = Math.abs(currentX - startX);
                const diffY = Math.abs(currentY - startY);
                
                // Start dragging if moved more than 5px horizontally
                if (diffX > 5) {
                    isDragging = true;
                }
                
                // Prevent vertical scrolling when swiping horizontally
                if (isDragging && diffX > diffY) {
                    e.preventDefault();
                }
            }, { passive: false });

            sliderContainer.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                
                const endX = e.changedTouches[0].clientX;
                const diff = startX - endX;
                
                // Minimum swipe distance to trigger slide change
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        nextSlide();
                    } else {
                        previousSlide();
                    }
                }
                isDragging = false;
            }, { passive: true });

            // Keyboard navigation for both slider and lightbox
            document.addEventListener('keydown', (e) => {
                if (lightbox.classList.contains('active')) {
                    // Lightbox navigation
                    if (e.key === 'ArrowLeft') {
                        lightboxPrev();
                    } else if (e.key === 'ArrowRight') {
                        lightboxNext();
                    } else if (e.key === 'Escape') {
                        closeLightbox();
                    }
                } else {
                    // Slider navigation
                    if (e.key === 'ArrowLeft') {
                        previousSlide();
                    } else if (e.key === 'ArrowRight') {
                        nextSlide();
                    }
                }
            });

            // Close lightbox when clicking outside image
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });

            // Initialize
            updateSlider();
        </script>
        <?php
    }
}
