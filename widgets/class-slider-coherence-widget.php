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
        $bg_url = esc_url( $settings['bg_image']['url'] );
        $title = esc_html( $settings['title'] );
        $subtitle = esc_html( $settings['subtitle'] );
        $button_text = esc_html( $settings['button_text'] );
        $button_link = esc_url( $settings['button_link']['url'] );
        $autoplay = $settings['autoplay'] === 'yes';
        $speed = intval( $settings['autoplay_speed'] );
        ?>
        <div class="coherence-slider" data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>" data-speed="<?php echo $speed; ?>" style="background-image: url('<?php echo $bg_url; ?>');">
            <div class="coherence-slider-overlay"></div>
            <div class="coherence-slider-content">
                <h2 class="coherence-slider-title"><?php echo $title; ?></h2>
                <p class="coherence-slider-subtitle"><?php echo $subtitle; ?></p>
                <?php if ( $button_text && $button_link ) : ?>
                    <a href="<?php echo $button_link; ?>" class="coherence-slider-btn"><?php echo $button_text; ?></a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register( new Coherence_Slider_Widget() );
?>
