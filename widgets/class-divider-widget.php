<?php
/**
 * Creative Divider Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Coherence_Divider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coherence_divider';
    }

    public function get_title() {
        return esc_html__( 'Séparateur Créatif', 'coherence-widgets' );
    }

    public function get_icon() {
        return 'eicon-divider';
    }

    public function get_categories() {
        return array( 'coherence' );
    }

    public function get_keywords() {
        return array( 'divider', 'separator', 'line', 'creative', 'ornament' );
    }

    public function get_style_depends() {
        return array( 'coherence-divider' );
    }

    protected function register_controls() {
        // --- SECTION CONTENU: GENERAL ---
        $this->start_controls_section(
            'section_general',
            array(
                'label' => esc_html__( 'Général', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'line_style',
            array(
                'label'   => esc_html__( 'Style de Ligne', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'gradient',
                'options' => array(
                    'solid'    => esc_html__( 'Continue (Solid)', 'coherence-widgets' ),
                    'dashed'   => esc_html__( 'Tirets (Dashed)', 'coherence-widgets' ),
                    'dotted'   => esc_html__( 'Points (Dotted)', 'coherence-widgets' ),
                    'gradient' => esc_html__( 'Dégradé (Gradient)', 'coherence-widgets' ),
                ),
            )
        );

        $this->add_responsive_control(
            'align',
            array(
                'label'   => esc_html__( 'Alignement', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Gauche', 'coherence-widgets' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center'  => array(
                        'title' => esc_html__( 'Centre', 'coherence-widgets' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'   => array(
                        'title' => esc_html__( 'Droite', 'coherence-widgets' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .coherence-divider-container' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};',
                ),
                'selectors_dictionary' => array(
                    'left'   => 'flex-start',
                    'center' => 'center',
                    'right'  => 'flex-end',
                ),
            )
        );

        $this->add_responsive_control(
            'width',
            array(
                'label'      => esc_html__( 'Largeur', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( '%', 'px' ),
                'range'      => array(
                    '%' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                    'px' => array(
                        'min' => 50,
                        'max' => 1200,
                    ),
                ),
                'default'    => array(
                    'unit' => '%',
                    'size' => 100,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-divider-container' => 'width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION CONTENU: ORNEMENT ---
        $this->start_controls_section(
            'section_ornament',
            array(
                'label' => esc_html__( 'Ornement', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'ornament_type',
            array(
                'label'   => esc_html__( 'Type d\'ornement', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => array(
                    'none'  => esc_html__( 'Aucun', 'coherence-widgets' ),
                    'icon'  => esc_html__( 'Icône', 'coherence-widgets' ),
                    'text'  => esc_html__( 'Texte', 'coherence-widgets' ),
                    'both'  => esc_html__( 'Icône & Texte', 'coherence-widgets' ),
                ),
            )
        );

        $this->add_control(
            'ornament_icon',
            array(
                'label'     => esc_html__( 'Icône', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::ICONS,
                'default'   => array(
                    'value'   => 'fas fa-star',
                    'library' => 'solid',
                ),
                'condition' => array(
                    'ornament_type' => array( 'icon', 'both' ),
                ),
            )
        );

        $this->add_control(
            'ornament_text',
            array(
                'label'       => esc_html__( 'Texte', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Section',
                'placeholder' => esc_html__( 'Entrez un texte...', 'coherence-widgets' ),
                'condition'   => array(
                    'ornament_type' => array( 'text', 'both' ),
                ),
            )
        );

        $this->add_control(
            'has_badge_shape',
            array(
                'label'        => esc_html__( 'Ajouter un conteneur (Pill)', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => array(
                    'ornament_type!' => 'none',
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: LIGNE ---
        $this->start_controls_section(
            'section_style_line',
            array(
                'label' => esc_html__( 'Ligne du Séparateur', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'thickness',
            array(
                'label'      => esc_html__( 'Épaisseur', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 15,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 2,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-divider-line' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'line_color',
            array(
                'label'     => esc_html__( 'Couleur de Ligne', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#e5e7eb',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-divider-line' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'line_style!' => 'gradient',
                ),
            )
        );

        $this->add_control(
            'line_grad_start',
            array(
                'label'     => esc_html__( 'Départ du Dégradé', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#007BFF',
                'condition' => array(
                    'line_style' => 'gradient',
                ),
            )
        );

        $this->add_control(
            'line_grad_end',
            array(
                'label'     => esc_html__( 'Fin du Dégradé', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6f42c1',
                'condition' => array(
                    'line_style' => 'gradient',
                ),
            )
        );

        $this->add_responsive_control(
            'spacing',
            array(
                'label'      => esc_html__( 'Espacement (Marges)', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 30,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-divider-wrapper' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: ORNEMENT ---
        $this->start_controls_section(
            'section_style_ornament',
            array(
                'label'     => esc_html__( 'Style d\'Ornement', 'coherence-widgets' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'ornament_type!' => 'none',
                ),
            )
        );

        $this->add_control(
            'ornament_color',
            array(
                'label'     => esc_html__( 'Couleur', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-divider-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .coherence-divider-icon' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'      => 'ornament_typography',
                'selector'  => '{{WRAPPER}} .coherence-divider-text',
                'condition' => array(
                    'ornament_type' => array( 'text', 'both' ),
                ),
            )
        );

        $this->add_control(
            'ornament_size',
            array(
                'label'      => esc_html__( 'Taille de l\'icône', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 12,
                        'max' => 48,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 18,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-divider-icon' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .coherence-divider-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'ornament_type' => array( 'icon', 'both' ),
                ),
            )
        );

        $this->add_control(
            'shape_bg_color',
            array(
                'label'     => esc_html__( 'Couleur de fond du conteneur', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#007BFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-divider-badge' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ),
                'condition' => array(
                    'has_badge_shape' => 'yes',
                ),
            )
        );

        $this->add_control(
            'shape_text_color',
            array(
                'label'     => esc_html__( 'Couleur du texte de conteneur', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-divider-badge .coherence-divider-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .coherence-divider-badge .coherence-divider-icon' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'has_badge_shape' => 'yes',
                ),
            )
        );

        $this->add_control(
            'ornament_animation',
            array(
                'label'   => esc_html__( 'Animation de l\'ornement', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => array(
                    'none'   => esc_html__( 'Aucune', 'coherence-widgets' ),
                    'pulse'  => esc_html__( 'Effet pulsant (Glow)', 'coherence-widgets' ),
                    'rotate' => esc_html__( 'Rotation au survol', 'coherence-widgets' ),
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $line_style = isset( $settings['line_style'] ) ? sanitize_text_field( $settings['line_style'] ) : 'solid';
        $ornament_type = isset( $settings['ornament_type'] ) ? sanitize_text_field( $settings['ornament_type'] ) : 'none';
        $icon = isset( $settings['ornament_icon'] ) ? $settings['ornament_icon'] : array();
        $text = isset( $settings['ornament_text'] ) ? sanitize_text_field( $settings['ornament_text'] ) : '';
        $has_shape = isset( $settings['has_badge_shape'] ) && 'yes' === $settings['has_badge_shape'];
        $animation = isset( $settings['ornament_animation'] ) ? sanitize_text_field( $settings['ornament_animation'] ) : 'none';

        // Background styling inline if gradient
        $line_style_inline = '';
        if ( 'gradient' === $line_style ) {
            $start = isset( $settings['line_grad_start'] ) ? esc_html( $settings['line_grad_start'] ) : '#007BFF';
            $end = isset( $settings['line_grad_end'] ) ? esc_html( $settings['line_grad_end'] ) : '#6f42c1';
            $line_style_inline = 'background: linear-gradient(90deg, ' . $start . ' 0%, ' . $end . ' 100%);';
        }

        $wrapper_class = 'coherence-divider-wrapper coherence-divider-style-' . $line_style;
        if ( 'none' !== $ornament_type ) {
            $wrapper_class .= ' coherence-divider-has-ornament';
        }
        if ( $has_shape ) {
            $wrapper_class .= ' coherence-divider-badge-enabled';
        }

        $ornament_class = 'coherence-divider-ornament coherence-divider-anim-' . $animation;
        if ( $has_shape ) {
            $ornament_class .= ' coherence-divider-badge';
        }
        ?>
        <div class="<?php echo esc_attr( $wrapper_class ); ?>">
            <div class="coherence-divider-container">
                
                <!-- Left Line -->
                <div class="coherence-divider-line coherence-divider-line-left" style="<?php echo esc_attr( $line_style_inline ); ?>"></div>

                <!-- Center Ornament -->
                <?php if ( 'none' !== $ornament_type ) : ?>
                    <div class="<?php echo esc_attr( $ornament_class ); ?>">
                        
                        <?php if ( in_array( $ornament_type, array( 'icon', 'both' ) ) && ! empty( $icon['value'] ) ) : ?>
                            <span class="coherence-divider-icon">
                                <?php \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ( in_array( $ornament_type, array( 'text', 'both' ) ) && $text ) : ?>
                            <span class="coherence-divider-text"><?php echo esc_html( $text ); ?></span>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <!-- Right Line -->
                <div class="coherence-divider-line coherence-divider-line-right" style="<?php echo esc_attr( $line_style_inline ); ?>"></div>

            </div>
        </div>
        <?php
    }
}

// Enregistrer le widget
\Elementor\Plugin::instance()->widgets_manager->register( new Coherence_Divider_Widget() );
