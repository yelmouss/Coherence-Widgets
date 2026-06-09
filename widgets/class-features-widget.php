<?php
/**
 * Features Grid Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Coherence_Features_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coherence_features';
    }

    public function get_title() {
        return esc_html__( 'Grille de Fonctionnalités', 'coherence-widgets' );
    }

    public function get_icon() {
        return 'eicon-grid';
    }

    public function get_categories() {
        return array( 'coherence' );
    }

    public function get_keywords() {
        return array( 'features', 'grid', 'services', 'box', 'icon' );
    }

    public function get_style_depends() {
        return array( 'coherence-features' );
    }

    protected function register_controls() {
        // --- SECTION CONTENU: LISTE ---
        $this->start_controls_section(
            'section_features',
            array(
                'label' => esc_html__( 'Fonctionnalités', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            array(
                'label'       => esc_html__( 'Titre', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Super Rapidité',
                'placeholder' => esc_html__( 'Entrez un titre...', 'coherence-widgets' ),
            )
        );

        $repeater->add_control(
            'item_description',
            array(
                'label'       => esc_html__( 'Description', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => 'Optimisé pour charger en un clin d\'œil avec les meilleures technologies web.',
                'placeholder' => esc_html__( 'Description...', 'coherence-widgets' ),
            )
        );

        $repeater->add_control(
            'item_icon',
            array(
                'label'   => esc_html__( 'Icône', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::ICONS,
                'default' => array(
                    'value'   => 'fas fa-bolt',
                    'library' => 'solid',
                ),
            )
        );

        $repeater->add_control(
            'item_link',
            array(
                'label'       => esc_html__( 'Lien (Optionnel)', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://votre-lien.com', 'coherence-widgets' ),
            )
        );

        $repeater->add_control(
            'item_badge',
            array(
                'label'       => esc_html__( 'Badge (ex: Nouveau)', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'ex: PRO', 'coherence-widgets' ),
            )
        );

        $repeater->add_control(
            'override_colors',
            array(
                'label'        => esc_html__( 'Personnaliser les couleurs', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $repeater->add_control(
            'custom_icon_color',
            array(
                'label'     => esc_html__( 'Couleur de l\'icône', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#007BFF',
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .coherence-features-icon' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'override_colors' => 'yes',
                ),
            )
        );

        $repeater->add_control(
            'custom_icon_bg',
            array(
                'label'     => esc_html__( 'Couleur de fond d\'icône', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(0, 123, 255, 0.1)',
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .coherence-features-icon-box' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'override_colors' => 'yes',
                ),
            )
        );

        $repeater->add_control(
            'custom_accent_color',
            array(
                'label'     => esc_html__( 'Couleur d\'accent (bordure)', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#007BFF',
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}}::before' => 'background: {{VALUE}};',
                ),
                'condition' => array(
                    'override_colors' => 'yes',
                ),
            )
        );

        $this->add_control(
            'features_list',
            array(
                'label'       => esc_html__( 'Liste des cases', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'item_title'       => 'Vitesse Éclair',
                        'item_description' => 'Optimisé pour charger en un clin d\'œil avec les meilleures technologies web.',
                        'item_icon'        => array(
                            'value'   => 'fas fa-bolt',
                            'library' => 'solid',
                        ),
                    ),
                    array(
                        'item_title'       => 'Design Réactif',
                        'item_description' => 'S\'adapte parfaitement à tous les types d\'écrans (mobiles, tablettes et ordinateurs).',
                        'item_icon'        => array(
                            'value'   => 'fas fa-mobile-alt',
                            'library' => 'solid',
                        ),
                    ),
                    array(
                        'item_title'       => 'Sécurité Avancée',
                        'item_description' => 'Protégez vos données et celles de vos clients grâce à un chiffrement fort.',
                        'item_icon'        => array(
                            'value'   => 'fas fa-shield-alt',
                            'library' => 'solid',
                        ),
                    ),
                ),
                'title_field' => '{{{ item_title }}}',
            )
        );

        $this->end_controls_section();

        // --- SECTION CONTENU: CONFIGURATION ---
        $this->start_controls_section(
            'section_layout',
            array(
                'label' => esc_html__( 'Disposition', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'columns',
            array(
                'label'   => esc_html__( 'Colonnes', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
            )
        );

        $this->add_control(
            'content_align',
            array(
                'label'     => esc_html__( 'Alignement du contenu', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'default'   => 'left',
                'options'   => array(
                    'left'   => array(
                        'title' => esc_html__( 'Gauche', 'coherence-widgets' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Centre', 'coherence-widgets' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'title' => esc_html__( 'Droite', 'coherence-widgets' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .coherence-features-card' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .coherence-features-icon-box' => 'margin-left: {{ALIGN_MARGIN_L}}; margin-right: {{ALIGN_MARGIN_R}};',
                ),
                'selectors_dictionary' => array(
                    'left'   => array(
                        'ALIGN_MARGIN_L' => '0',
                        'ALIGN_MARGIN_R' => 'auto',
                    ),
                    'center' => array(
                        'ALIGN_MARGIN_L' => 'auto',
                        'ALIGN_MARGIN_R' => 'auto',
                    ),
                    'right'  => array(
                        'ALIGN_MARGIN_L' => 'auto',
                        'ALIGN_MARGIN_R' => '0',
                    ),
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: GRILLE & CARTE ---
        $this->start_controls_section(
            'section_style_cards',
            array(
                'label' => esc_html__( 'Style des Cases', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'card_theme',
            array(
                'label'   => esc_html__( 'Thème visuel', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'classic',
                'options' => array(
                    'classic' => esc_html__( 'Classique / Blanc', 'coherence-widgets' ),
                    'glass'   => esc_html__( 'Effet Verre Dépoli (Glass)', 'coherence-widgets' ),
                    'border'  => esc_html__( 'Ligne d\'accentuation seule', 'coherence-widgets' ),
                ),
            )
        );

        $this->add_control(
            'bg_color',
            array(
                'label'     => esc_html__( 'Couleur de fond', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-features-card' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'card_theme' => array( 'classic', 'border' ),
                ),
            )
        );

        $this->add_control(
            'card_padding',
            array(
                'label'      => esc_html__( 'Espacement interne', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'default'    => array(
                    'top'    => 35,
                    'right'  => 35,
                    'bottom' => 35,
                    'left'   => 35,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-features-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'card_border_radius',
            array(
                'label'      => esc_html__( 'Rayon de bordure', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'default'    => array(
                    'top'    => 12,
                    'right'  => 12,
                    'bottom' => 12,
                    'left'   => 12,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-features-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'card_shadow',
                'selector' => '{{WRAPPER}} .coherence-features-card',
            )
        );

        $this->add_control(
            'card_hover_effect',
            array(
                'label'   => esc_html__( 'Effet au survol', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'translate3d',
                'options' => array(
                    'none'        => esc_html__( 'Aucun', 'coherence-widgets' ),
                    'translate3d' => esc_html__( 'Effet 3D (Élévation + Ombre)', 'coherence-widgets' ),
                    'zoom'        => esc_html__( 'Zoom doux', 'coherence-widgets' ),
                    'border-grow' => esc_html__( 'Expansion de bordure', 'coherence-widgets' ),
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: ICÔNES ---
        $this->start_controls_section(
            'section_style_icons',
            array(
                'label' => esc_html__( 'Style des Icônes', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'global_icon_color',
            array(
                'label'     => esc_html__( 'Couleur globale', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#007BFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-features-icon' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'global_icon_bg',
            array(
                'label'     => esc_html__( 'Couleur de fond globale', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'rgba(0, 123, 255, 0.08)',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-features-icon-box' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'icon_size',
            array(
                'label'      => esc_html__( 'Taille de l\'icône', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 16,
                        'max' => 64,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 24,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-features-icon' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .coherence-features-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'icon_box_size',
            array(
                'label'      => esc_html__( 'Taille du conteneur', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 40,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 60,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-features-icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'icon_border_radius',
            array(
                'label'      => esc_html__( 'Rayon de bordure du conteneur', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'default'    => array(
                    'unit' => '%',
                    'size' => 50,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-features-icon-box' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'icon_hover_animation',
            array(
                'label'   => esc_html__( 'Animation au survol', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'rotate',
                'options' => array(
                    'none'   => esc_html__( 'Aucune', 'coherence-widgets' ),
                    'rotate' => esc_html__( 'Rotation', 'coherence-widgets' ),
                    'scale'  => esc_html__( 'Agrandissement', 'coherence-widgets' ),
                    'bounce' => esc_html__( 'Rebond', 'coherence-widgets' ),
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: TEXTES ---
        $this->start_controls_section(
            'section_style_text',
            array(
                'label' => esc_html__( 'Typographie & Textes', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'     => esc_html__( 'Couleur du Titre', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1f2937',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-features-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .coherence-features-title',
            )
        );

        $this->add_control(
            'desc_color',
            array(
                'label'     => esc_html__( 'Couleur du texte de description', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#4b5563',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-features-description' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'desc_typography',
                'selector' => '{{WRAPPER}} .coherence-features-description',
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $features = isset( $settings['features_list'] ) ? $settings['features_list'] : array();
        $columns = isset( $settings['columns'] ) ? intval( $settings['columns'] ) : 3;
        $card_theme = isset( $settings['card_theme'] ) ? sanitize_text_field( $settings['card_theme'] ) : 'classic';
        $card_hover = isset( $settings['card_hover_effect'] ) ? sanitize_text_field( $settings['card_hover_effect'] ) : 'translate3d';
        $icon_hover = isset( $settings['icon_hover_animation'] ) ? sanitize_text_field( $settings['icon_hover_animation'] ) : 'rotate';

        $grid_class = 'coherence-features-grid coherence-features-cols-' . $columns;
        ?>
        <div class="<?php echo esc_attr( $grid_class ); ?>">
            <?php foreach ( $features as $feature ) : 
                $title = isset( $feature['item_title'] ) ? sanitize_text_field( $feature['item_title'] ) : '';
                $description = isset( $feature['item_description'] ) ? wp_kses_post( $feature['item_description'] ) : '';
                $icon = isset( $feature['item_icon'] ) ? $feature['item_icon'] : array();
                $link = isset( $feature['item_link'] ) ? $feature['item_link'] : array();
                $badge = isset( $feature['item_badge'] ) ? sanitize_text_field( $feature['item_badge'] ) : '';

                $card_class = 'coherence-features-card coherence-features-theme-' . $card_theme . ' coherence-features-hover-' . $card_hover;
                if ( $badge ) {
                    $card_class .= ' coherence-features-has-badge';
                }

                // If link is provided, render card as anchor
                $has_link = ! empty( $link['url'] );
                $card_tag = $has_link ? 'a' : 'div';
                
                if ( $has_link ) {
                    $this->add_link_attributes( 'card_link_' . $feature['_id'], $link );
                    $this->add_render_attribute( 'card_link_' . $feature['_id'], 'class', $card_class );
                } else {
                    $this->add_render_attribute( 'card_div_' . $feature['_id'], 'class', $card_class );
                }

                $render_attr = $has_link ? $this->get_render_attribute_string( 'card_link_' . $feature['_id'] ) : $this->get_render_attribute_string( 'card_div_' . $feature['_id'] );
            ?>
                <<?php echo $card_tag; ?> <?php echo $render_attr; ?> class="elementor-repeater-item-<?php echo esc_attr( $feature['_id'] ); ?>">
                    
                    <?php if ( $badge ) : ?>
                        <span class="coherence-features-badge"><?php echo esc_html( $badge ); ?></span>
                    <?php endif; ?>

                    <?php if ( ! empty( $icon['value'] ) ) : ?>
                        <div class="coherence-features-icon-box coherence-features-icon-hover-<?php echo esc_attr( $icon_hover ); ?>">
                            <span class="coherence-features-icon">
                                <?php \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if ( $title ) : ?>
                        <h4 class="coherence-features-title"><?php echo esc_html( $title ); ?></h4>
                    <?php endif; ?>

                    <?php if ( $description ) : ?>
                        <p class="coherence-features-description"><?php echo $description; ?></p>
                    <?php endif; ?>

                </<?php echo $card_tag; ?>>
            <?php endforeach; ?>
        </div>
        <?php
    }
}

// Enregistrer le widget
\Elementor\Plugin::instance()->widgets_manager->register( new Coherence_Features_Widget() );
