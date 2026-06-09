<?php
/**
 * SliderCoherence Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Coherence_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coherence_slider';
    }

    public function get_title() {
        return esc_html__( 'Slider Coherence', 'coherence-widgets' );
    }

    public function get_icon() {
        return 'eicon-slider-album';
    }

    public function get_categories() {
        return array( 'coherence' );
    }

    public function get_keywords() {
        return array( 'slider', 'hero', 'carousel', 'aceternity' );
    }

    public function get_script_depends() {
        return array( 'coherence-slider' );
    }

    public function get_style_depends() {
        return array( 'coherence-slider' );
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Contenu', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );
        // Slides Repeater
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'slide_image',
            [
                'label' => esc_html__( 'Image de fond', 'coherence-widgets' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'slide_title',
            [
                'label' => esc_html__( 'Titre', 'coherence-widgets' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Titre du slide', 'coherence-widgets' ),
            ]
        );

        $repeater->add_control(
            'slide_subtitle',
            [
                'label' => esc_html__( 'Sous‑titre', 'coherence-widgets' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Description du slide.', 'coherence-widgets' ),
            ]
        );

        $repeater->add_control(
            'slide_button_text',
            [
                'label' => esc_html__( 'Texte du bouton', 'coherence-widgets' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'En savoir plus', 'coherence-widgets' ),
            ]
        );

        $repeater->add_control(
            'slide_button_link',
            [
                'label' => esc_html__( 'Lien du bouton', 'coherence-widgets' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://exemple.com', 'coherence-widgets' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $repeater->add_control(
            'position',
            [
                'label' => esc_html__( 'Position du texte', 'coherence-widgets' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'left' => esc_html__( 'Gauche', 'coherence-widgets' ),
                    'center' => esc_html__( 'Centre', 'coherence-widgets' ),
                    'right' => esc_html__( 'Droite', 'coherence-widgets' ),
                ],
            ]
        );

        $repeater->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Couleur du texte', 'coherence-widgets' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $repeater->add_control(
            'bg_color',
            [
                'label' => esc_html__( 'Couleur de fond', 'coherence-widgets' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.4)',
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => esc_html__( 'Slides', 'coherence-widgets' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ slide_title }}}',
            ]
        );
        // End of Slides Repeater

        $this->add_control(
            'bg_image',
            array(
                'label'   => esc_html__( 'Image de fond', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
            )
        );

        $this->add_control(
            'overlay_color',
            array(
                'label'   => esc_html__( 'Couleur de superposition', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.4)',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-slider-overlay' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'title',
            array(
                'label'   => esc_html__( 'Titre', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Titre héroïque', 'coherence-widgets' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'subtitle',
            array(
                'label'   => esc_html__( 'Sous‑titre', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Une description captivante pour votre hero.', 'coherence-widgets' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'button_text',
            array(
                'label'   => esc_html__( 'Texte du bouton', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'En savoir plus', 'coherence-widgets' ),
            )
        );

        $this->add_control(
            'button_link',
            array(
                'label'   => esc_html__( 'Lien du bouton', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://exemple.com', 'coherence-widgets' ),
                'default' => array(
                    'url' => '#',
                ),
            )
        );

        $this->end_controls_section();

        // Settings Section
        $this->start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__( 'Paramètres', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_SETTINGS,
            )
        );

        $this->add_control(
            'autoplay',
            array(
                'label'   => esc_html__( 'Lecture automatique', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Oui', 'coherence-widgets' ),
                'label_off' => esc_html__( 'Non', 'coherence-widgets' ),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'autoplay_speed',
            array(
                'label' => esc_html__( 'Vitesse (ms)', 'coherence-widgets' ),
                'type'  => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => array( 'autoplay' => 'yes' ),
                'min' => 1000,
                'step' => 500,
            )
        );

        $this->end_controls_section();
    }


        protected function render() {
            $settings = $this->get_settings_for_display();
            $autoplay = $settings['autoplay'] === 'yes';
            $speed = intval( $settings['autoplay_speed'] );
            ?>
            <div class="coherence-slider" data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>" data-speed="<?php echo $speed; ?>">
                <?php if ( !empty( $settings['slides'] ) ) : ?>
                    <?php foreach ( $settings['slides'] as $slide ) : ?>
                        <?php
                        $bg_url = esc_url( $slide['slide_image']['url'] );
                        $title = esc_html( $slide['slide_title'] );
                        $subtitle = esc_html( $slide['slide_subtitle'] );
                        $button_text = esc_html( $slide['slide_button_text'] );
                        $button_link = esc_url( $slide['slide_button_link']['url'] );
                        $position = $slide['position'];
                        $text_color = $slide['text_color'];
                        $bg_color = $slide['bg_color'];
                        ?>
                        <div class="coherence-slide" style="background-image: url('<?php echo $bg_url; ?>');">
                            <div class="coherence-slider-overlay" style="background-color: <?php echo $bg_color; ?>;"></div>
                            <div class="coherence-slider-content" style="text-align: <?php echo $position; ?>; color: <?php echo $text_color; ?>;">
                                <h2 class="coherence-slider-title"><?php echo $title; ?></h2>
                                <p class="coherence-slider-subtitle"><?php echo $subtitle; ?></p>
                                <?php if ( $button_text && $button_link ) : ?>
                                    <a href="<?php echo $button_link; ?>" class="coherence-slider-btn"><?php echo $button_text; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php
        }
    }
