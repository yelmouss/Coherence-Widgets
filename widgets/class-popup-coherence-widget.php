<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Popup Coherence Widget for Elementor
 */
class Coherence_Popup_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coherence_popup';
    }

    public function get_title() {
        return esc_html__( 'Popup Coherence', 'coherence-widgets' );
    }

    public function get_icon() {
        return 'eicon-popup';
    }

    public function get_categories() {
        return [ 'coherence' ];
    }

    public function get_script_depends() {
        return [ 'coherence-popup' ];
    }

    public function get_style_depends() {
        return [ 'coherence-popup-style' ];
    }

    protected function register_controls() {
        // Content Section – Repeater for inner blocks
        $this->start_controls_section( 'section_content', [
            'label' => esc_html__( 'Contenu', 'coherence-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'title', [
            'label'   => esc_html__( 'Titre', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'Titre du popup', 'coherence-widgets' ),
        ] );
        $repeater->add_control( 'description', [
            'label'   => esc_html__( 'Description', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__( 'Contenu du popup', 'coherence-widgets' ),
        ] );
        $repeater->add_control( 'image', [
            'label'   => esc_html__( 'Image', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );
        $repeater->add_control( 'button_text', [
            'label'   => esc_html__( 'Texte du bouton', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'En savoir plus', 'coherence-widgets' ),
        ] );
        $repeater->add_control( 'button_link', [
            'label'   => esc_html__( 'Lien du bouton', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::URL,
            'placeholder' => esc_html__( 'https://exemple.com', 'coherence-widgets' ),
            'default' => [ 'url' => '#' ],
        ] );

        $this->add_control( 'slides', [
            'label'       => esc_html__( 'Slides du popup', 'coherence-widgets' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();

        // Trigger Section
        $this->start_controls_section( 'section_trigger', [
            'label' => esc_html__( 'Déclencheur', 'coherence-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'trigger_type', [
            'label'   => esc_html__( 'Type de déclencheur', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'click',
            'options' => [
                'click'  => esc_html__( 'Clique sur un élément', 'coherence-widgets' ),
                'load'   => esc_html__( 'Au chargement de la page', 'coherence-widgets' ),
                'scroll' => esc_html__( 'Au défilement', 'coherence-widgets' ),
                'exit'   => esc_html__( 'Intent d\'sortie', 'coherence-widgets' ),
            ],
        ] );
        $this->add_control( 'trigger_selector', [
            'label'       => esc_html__( 'Sélecteur CSS (pour click)', 'coherence-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'placeholder' => '.my-button',
            'condition'   => [ 'trigger_type' => 'click' ],
        ] );
        $this->add_control( 'delay', [
            'label'   => esc_html__( 'Délai (ms, pour load)', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 0,
            'step'    => 100,
            'default' => 0,
            'condition' => [ 'trigger_type' => 'load' ],
        ] );
        $this->add_control( 'scroll_offset', [
            'label'   => esc_html__( 'Offset de défilement (%)', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 100,
            'step'    => 5,
            'default' => 50,
            'condition' => [ 'trigger_type' => 'scroll' ],
        ] );
        $this->end_controls_section();

        // Style Section
        $this->start_controls_section( 'section_style', [
            'label' => esc_html__( 'Style', 'coherence-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'overlay_color', [
            'label'   => esc_html__( 'Couleur de l\'overlay', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(0,0,0,0.5)',
            'selectors' => [
                '{{WRAPPER}} .coherence-popup-overlay' => 'background-color: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'popup_bg_color', [
            'label'   => esc_html__( 'Couleur de fond du popup', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .coherence-popup-content' => 'background-color: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'text_color', [
            'label'   => esc_html__( 'Couleur du texte', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#333333',
            'selectors' => [
                '{{WRAPPER}} .coherence-popup-content' => 'color: {{VALUE}};',
            ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .coherence-popup-content',
        ] );
        $this->add_control( 'animation', [
            'label'   => esc_html__( 'Animation d\'entrée', 'coherence-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'fade',
            'options' => [
                'fade' => esc_html__( 'Fondu', 'coherence-widgets' ),
                'slide' => esc_html__( 'Glissement', 'coherence-widgets' ),
                'zoom' => esc_html__( 'Zoom', 'coherence-widgets' ),
            ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        // Prepare data attributes for JS
        $trigger_type = $settings['trigger_type'];
        $trigger_selector = esc_attr( $settings['trigger_selector'] );
        $delay = intval( $settings['delay'] );
        $offset = intval( $settings['scroll_offset'] );
        $animation = esc_attr( $settings['animation'] );
        ?>
        <div class="coherence-popup-overlay" style="display:none;"></div>
        <div class="coherence-popup" data-trigger="<?php echo $trigger_type; ?>" data-selector="<?php echo $trigger_selector; ?>" data-delay="<?php echo $delay; ?>" data-offset="<?php echo $offset; ?>" data-animation="<?php echo $animation; ?>" style="display:none;">
            <div class="coherence-popup-content">
                <?php if ( ! empty( $settings['slides'] ) ) : ?>
                    <?php foreach ( $settings['slides'] as $slide ) : ?>
                        <div class="coherence-popup-slide">
                            <?php if ( ! empty( $slide['image']['url'] ) ) : ?>
                                <img src="<?php echo esc_url( $slide['image']['url'] ); ?>" alt="" class="coherence-popup-image"/>
                            <?php endif; ?>
                            <h2 class="coherence-popup-title"><?php echo esc_html( $slide['title'] ); ?></h2>
                            <p class="coherence-popup-description"><?php echo esc_html( $slide['description'] ); ?></p>
                            <?php if ( ! empty( $slide['button_text'] ) && ! empty( $slide['button_link']['url'] ) ) : ?>
                                <a href="<?php echo esc_url( $slide['button_link']['url'] ); ?>" class="coherence-popup-button"><?php echo esc_html( $slide['button_text'] ); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button class="coherence-popup-close" aria-label="<?php esc_attr_e( 'Fermer le popup', 'coherence-widgets' ); ?>">&times;</button>
            </div>
        </div>
        <?php
    }
}
?>
