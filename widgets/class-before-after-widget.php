<?php
/**
 * Before After Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Coherence_Before_After_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coherence_before_after';
    }

    public function get_title() {
        return esc_html__( 'Before After', 'coherence-widgets' );
    }

    public function get_icon() {
        return 'eicon-image-before-after';
    }

    public function get_categories() {
        return array( 'coherence' );
    }

    public function get_keywords() {
        return array( 'before', 'after', 'comparison', 'image' );
    }

    public function get_script_depends() {
        return array( 'coherence-before-after' );
    }

    public function get_style_depends() {
        return array( 'coherence-before-after' );
    }

    protected function register_controls() {
        // Section Images
        $this->start_controls_section(
            'section_images',
            array(
                'label' => esc_html__( 'Images', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'before_image',
            array(
                'label'   => esc_html__( 'Image Avant', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
            )
        );

        $this->add_control(
            'after_image',
            array(
                'label'   => esc_html__( 'Image Après', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
            )
        );

        $this->add_control(
            'initial_position',
            array(
                'label'       => esc_html__( 'Position initiale (%)', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::SLIDER,
                'default'     => array( 'size' => 50 ),
                'min'         => 0,
                'max'         => 100,
                'step'        => 1,
            )
        );

        $this->end_controls_section();

        // Section Labels
        $this->start_controls_section(
            'section_labels',
            array(
                'label' => esc_html__( 'Étiquettes', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'enable_labels',
            array(
                'label'        => esc_html__( 'Afficher les étiquettes', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'before_label',
            array(
                'label'       => esc_html__( 'Texte Avant', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Avant',
                'condition'   => array(
                    'enable_labels' => 'yes',
                ),
            )
        );

        $this->add_control(
            'after_label',
            array(
                'label'       => esc_html__( 'Texte Après', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Après',
                'condition'   => array(
                    'enable_labels' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // Section Interactions
        $this->start_controls_section(
            'section_interactions',
            array(
                'label' => esc_html__( 'Interactions', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'interaction_type',
            array(
                'label'   => esc_html__( 'Type d\'interaction', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'drag',
                'options' => array(
                    'mouse'  => esc_html__( 'Survol de la souris', 'coherence-widgets' ),
                    'click'  => esc_html__( 'Glissement à la souris', 'coherence-widgets' ),
                    'drag'   => esc_html__( 'Glissement sur tactile', 'coherence-widgets' ),
                ),
            )
        );

        $this->add_control(
            'handle_type',
            array(
                'label'   => esc_html__( 'Style du curseur', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'arrows',
                'options' => array(
                    'line'    => esc_html__( 'Ligne', 'coherence-widgets' ),
                    'circle'  => esc_html__( 'Cercle', 'coherence-widgets' ),
                    'arrows'  => esc_html__( 'Flèches', 'coherence-widgets' ),
                    'none'    => esc_html__( 'Aucun', 'coherence-widgets' ),
                ),
            )
        );

        $this->end_controls_section();

        // Section Styles - Conteneur
        $this->start_controls_section(
            'section_style_container',
            array(
                'label' => esc_html__( 'Style du conteneur', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'container_height',
            array(
                'label'      => esc_html__( 'Hauteur', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'default'    => array( 'size' => 400 ),
                'min'        => 100,
                'max'        => 800,
                'unit'       => 'px',
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-ba-container' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'container_border_radius',
            array(
                'label'      => esc_html__( 'Rayon de bordure', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-ba-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'container_shadow',
                'selector' => '{{WRAPPER}} .coherence-ba-container',
            )
        );

        $this->end_controls_section();

        // Section Styles - Poignée
        $this->start_controls_section(
            'section_style_handle',
            array(
                'label' => esc_html__( 'Style de la poignée & Ligne', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'line_color',
            array(
                'label'     => esc_html__( 'Couleur de la ligne', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-ba-handle' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'line_width',
            array(
                'label'      => esc_html__( 'Épaisseur de la ligne', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'default'    => array( 'size' => 3 ),
                'min'        => 1,
                'max'        => 10,
                'unit'       => 'px',
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-ba-handle' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'grabber_heading',
            array(
                'label'     => esc_html__( 'Curseur de glissement', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'handle_type!' => 'none',
                ),
            )
        );

        $this->add_control(
            'grabber_bg_color',
            array(
                'label'     => esc_html__( 'Couleur de fond du curseur', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-ba-handle-grabber' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'handle_type!' => 'none',
                ),
            )
        );

        $this->add_control(
            'grabber_icon_color',
            array(
                'label'     => esc_html__( 'Couleur de l\'icône', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-ba-grip-line' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .coherence-ba-arrow-left' => 'border-right-color: {{VALUE}};',
                    '{{WRAPPER}} .coherence-ba-arrow-right' => 'border-left-color: {{VALUE}};',
                ),
                'condition' => array(
                    'handle_type!' => 'none',
                ),
            )
        );

        $this->add_responsive_control(
            'grabber_size',
            array(
                'label'      => esc_html__( 'Taille du curseur', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'default'    => array( 'size' => 50 ),
                'min'        => 30,
                'max'        => 100,
                'unit'       => 'px',
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-ba-handle-grabber' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'handle_type!' => 'none',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'grabber_shadow',
                'selector' => '{{WRAPPER}} .coherence-ba-handle-grabber',
                'condition' => array(
                    'handle_type!' => 'none',
                ),
            )
        );

        $this->add_control(
            'grabber_glow',
            array(
                'label'        => esc_html__( 'Effet de lueur pulsante', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => array(
                    'handle_type!' => 'none',
                ),
            )
        );

        $this->end_controls_section();

        // Section Styles - Étiquettes
        $this->start_controls_section(
            'section_style_labels',
            array(
                'label'     => esc_html__( 'Style des étiquettes', 'coherence-widgets' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'enable_labels' => 'yes',
                ),
            )
        );

        $this->add_control(
            'label_color',
            array(
                'label'     => esc_html__( 'Couleur du texte', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-ba-label' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'label_bg_color',
            array(
                'label'     => esc_html__( 'Couleur de fond', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(0, 0, 0, 0.5)',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-ba-label' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'label_typography',
                'selector' => '{{WRAPPER}} .coherence-ba-label',
            )
        );

        $this->add_control(
            'label_padding',
            array(
                'label'      => esc_html__( 'Espacement', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => 10,
                    'right'  => 15,
                    'bottom' => 10,
                    'left'   => 15,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-ba-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'label_border_radius',
            array(
                'label'      => esc_html__( 'Rayon de bordure', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-ba-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $before_url = isset( $settings['before_image']['url'] ) ? esc_url( $settings['before_image']['url'] ) : '';
        $after_url  = isset( $settings['after_image']['url'] ) ? esc_url( $settings['after_image']['url'] ) : '';
        $initial_pos = isset( $settings['initial_position']['size'] ) ? intval( $settings['initial_position']['size'] ) : 50;
        $interaction = isset( $settings['interaction_type'] ) ? sanitize_text_field( $settings['interaction_type'] ) : 'mouse';
        $handle_type = isset( $settings['handle_type'] ) ? sanitize_text_field( $settings['handle_type'] ) : 'line';
        $enable_labels = isset( $settings['enable_labels'] ) ? $settings['enable_labels'] : 'yes';
        $before_label = isset( $settings['before_label'] ) ? sanitize_text_field( $settings['before_label'] ) : 'Avant';
        $after_label = isset( $settings['after_label'] ) ? sanitize_text_field( $settings['after_label'] ) : 'Après';
        $grabber_glow = isset( $settings['grabber_glow'] ) && 'yes' === $settings['grabber_glow'] ? 'coherence-ba-glow' : '';

        $widget_id = 'coherence_ba_' . uniqid();
        ?>
        <div class="coherence-ba-wrapper" id="<?php echo esc_attr( $widget_id ); ?>" 
             data-interaction="<?php echo esc_attr( $interaction ); ?>"
             data-handle-type="<?php echo esc_attr( $handle_type ); ?>"
             data-initial-position="<?php echo esc_attr( $initial_pos ); ?>">
            
            <div class="coherence-ba-container">
                <!-- Image After -->
                <img src="<?php echo esc_url( $after_url ); ?>" 
                     alt="<?php echo esc_attr( $after_label ); ?>" 
                     class="coherence-ba-img coherence-ba-after">
                
                <!-- Before Layer -->
                <div class="coherence-ba-before">
                    <img src="<?php echo esc_url( $before_url ); ?>" 
                         alt="<?php echo esc_attr( $before_label ); ?>" 
                         class="coherence-ba-img">
                </div>

                <!-- Handle -->
                <div class="coherence-ba-handle">
                    <?php if ( 'none' !== $handle_type ) : ?>
                        <div class="coherence-ba-handle-grabber coherence-ba-handle-<?php echo esc_attr( $handle_type ); ?> <?php echo esc_attr( $grabber_glow ); ?>">
                            <?php if ( 'circle' === $handle_type ) : ?>
                                <span class="coherence-ba-grip-line"></span>
                                <span class="coherence-ba-grip-line"></span>
                            <?php elseif ( 'arrows' === $handle_type ) : ?>
                                <span class="coherence-ba-arrow-left"></span>
                                <span class="coherence-ba-arrow-right"></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Labels -->
                <?php if ( 'yes' === $enable_labels ) : ?>
                    <div class="coherence-ba-label coherence-ba-before-label">
                        <?php echo esc_html( $before_label ); ?>
                    </div>
                    <div class="coherence-ba-label coherence-ba-after-label">
                        <?php echo esc_html( $after_label ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <# 
        var glowClass = settings.grabber_glow === 'yes' ? 'coherence-ba-glow' : ''; 
        #>
        <div class="coherence-ba-wrapper" 
             data-interaction="{{{ settings.interaction_type }}}"
             data-handle-type="{{{ settings.handle_type }}}"
             data-initial-position="{{{ settings.initial_position.size }}}">
            
            <div class="coherence-ba-container">
                <img src="{{{ settings.after_image.url }}}" class="coherence-ba-img coherence-ba-after">
                
                <div class="coherence-ba-before">
                    <img src="{{{ settings.before_image.url }}}" class="coherence-ba-img">
                </div>

                <div class="coherence-ba-handle">
                    <# if ( settings.handle_type !== 'none' ) { #>
                        <div class="coherence-ba-handle-grabber coherence-ba-handle-{{{ settings.handle_type }}} {{{ glowClass }}}">
                            <# if ( settings.handle_type === 'circle' ) { #>
                                <span class="coherence-ba-grip-line"></span>
                                <span class="coherence-ba-grip-line"></span>
                            <# } else if ( settings.handle_type === 'arrows' ) { #>
                                <span class="coherence-ba-arrow-left"></span>
                                <span class="coherence-ba-arrow-right"></span>
                            <# } #>
                        </div>
                    <# } #>
                </div>

                <# if ( settings.enable_labels === 'yes' ) { #>
                    <div class="coherence-ba-label coherence-ba-before-label">
                        {{{ settings.before_label }}}
                    </div>
                    <div class="coherence-ba-label coherence-ba-after-label">
                        {{{ settings.after_label }}}
                    </div>
                <# } #>
            </div>
        </div>
        <?php
    }
}

// Enregistrer le widget
\Elementor\Plugin::instance()->widgets_manager->register( new Coherence_Before_After_Widget() );
