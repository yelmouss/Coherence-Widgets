<?php
/**
 * Pricing Table Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Coherence_Pricing_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coherence_pricing';
    }

    public function get_title() {
        return esc_html__( 'Table de Prix', 'coherence-widgets' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return array( 'coherence' );
    }

    public function get_keywords() {
        return array( 'pricing', 'table', 'price', 'plan', 'card' );
    }

    public function get_script_depends() {
        return array( 'coherence-pricing' );
    }

    public function get_style_depends() {
        return array( 'coherence-pricing' );
    }

    protected function register_controls() {
        // --- SECTION CONTENU: EN-TÊTE ---
        $this->start_controls_section(
            'section_header',
            array(
                'label' => esc_html__( 'En-tête du Plan', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'plan_title',
            array(
                'label'       => esc_html__( 'Nom du Plan', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Plan Pro',
                'placeholder' => esc_html__( 'ex: Plan Pro', 'coherence-widgets' ),
            )
        );

        $this->add_control(
            'plan_description',
            array(
                'label'       => esc_html__( 'Description', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => 'Idéal pour les petites équipes et créateurs',
                'placeholder' => esc_html__( 'Description du plan...', 'coherence-widgets' ),
                'rows'        => 2,
            )
        );

        $this->add_control(
            'show_badge',
            array(
                'label'        => esc_html__( 'Afficher un Badge', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->add_control(
            'badge_text',
            array(
                'label'       => esc_html__( 'Texte du Badge', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Populaire',
                'condition'   => array(
                    'show_badge' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION CONTENU: TARIFICATION ---
        $this->start_controls_section(
            'section_pricing',
            array(
                'label' => esc_html__( 'Tarification', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'currency',
            array(
                'label'   => esc_html__( 'Devise', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '€',
            )
        );

        $this->add_control(
            'show_toggle',
            array(
                'label'        => esc_html__( 'Toggle Mensuel/Annuel', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'price_monthly',
            array(
                'label'   => esc_html__( 'Prix Mensuel', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 29,
            )
        );

        $this->add_control(
            'price_yearly',
            array(
                'label'     => esc_html__( 'Prix Annuel (par mois)', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 19,
                'condition' => array(
                    'show_toggle' => 'yes',
                ),
            )
        );

        $this->add_control(
            'yearly_billing_info',
            array(
                'label'       => esc_html__( 'Info de facturation annuelle', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Facturé annuellement (228€)',
                'placeholder' => esc_html__( 'ex: Facturé annuellement', 'coherence-widgets' ),
                'condition'   => array(
                    'show_toggle' => 'yes',
                ),
            )
        );

        $this->add_control(
            'period_text',
            array(
                'label'   => esc_html__( 'Texte de période', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '/ mois',
            )
        );

        $this->end_controls_section();

        // --- SECTION CONTENU: FONCTIONNALITÉS ---
        $this->start_controls_section(
            'section_features',
            array(
                'label' => esc_html__( 'Fonctionnalités', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'feature_text',
            array(
                'label'   => esc_html__( 'Fonctionnalité', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Fonctionnalité incluse',
            )
        );

        $repeater->add_control(
            'feature_icon',
            array(
                'label'   => esc_html__( 'Icône', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::ICONS,
                'default' => array(
                    'value'   => 'fas fa-check',
                    'library' => 'solid',
                ),
            )
        );

        $repeater->add_control(
            'feature_icon_color',
            array(
                'label'     => esc_html__( 'Couleur de l\'icône', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#28a745',
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .coherence-pricing-feature-icon' => 'color: {{VALUE}};',
                ),
            )
        );

        $repeater->add_control(
            'feature_is_disabled',
            array(
                'label'        => esc_html__( 'Indisponible (barré)', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->add_control(
            'features_list',
            array(
                'label'       => esc_html__( 'Liste des fonctionnalités', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'feature_text' => 'Utilisateurs illimités',
                    ),
                    array(
                        'feature_text' => 'Support client 24/7',
                    ),
                    array(
                        'feature_text' => 'Intégration d\'API',
                    ),
                    array(
                        'feature_text'        => 'Marque blanche',
                        'feature_is_disabled' => 'yes',
                        'feature_icon'        => array(
                            'value'   => 'fas fa-times',
                            'library' => 'solid',
                        ),
                    ),
                ),
                'title_field' => '{{{ feature_text }}}',
            )
        );

        $this->end_controls_section();

        // --- SECTION CONTENU: BOUTON D'ACTION ---
        $this->start_controls_section(
            'section_cta',
            array(
                'label' => esc_html__( 'Bouton d\'action (CTA)', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'button_text',
            array(
                'label'   => esc_html__( 'Texte du Bouton', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Choisir ce plan',
            )
        );

        $this->add_control(
            'button_link',
            array(
                'label'       => esc_html__( 'Lien', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://votre-lien.com', 'coherence-widgets' ),
                'default'     => array(
                    'url'         => '#',
                    'is_external' => false,
                    'nofollow'    => false,
                ),
            )
        );

        $this->add_control(
            'button_icon',
            array(
                'label' => esc_html__( 'Icône du bouton', 'coherence-widgets' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
            )
        );

        $this->add_control(
            'button_icon_align',
            array(
                'label'     => esc_html__( 'Alignement de l\'icône', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'right',
                'options'   => array(
                    'left'  => esc_html__( 'Avant le texte', 'coherence-widgets' ),
                    'right' => esc_html__( 'Après le texte', 'coherence-widgets' ),
                ),
                'condition' => array(
                    'button_icon[value]!' => '',
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: CARTE ---
        $this->start_controls_section(
            'section_style_card',
            array(
                'label' => esc_html__( 'Style de la Carte', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'card_style_type',
            array(
                'label'   => esc_html__( 'Thème de la carte', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'classic',
                'options' => array(
                    'classic' => esc_html__( 'Classique / Couleur', 'coherence-widgets' ),
                    'glass'   => esc_html__( 'Effet Verre Dépoli (Glassmorphism)', 'coherence-widgets' ),
                ),
            )
        );

        $this->add_control(
            'card_background_color',
            array(
                'label'     => esc_html__( 'Couleur de fond', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-card' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'card_style_type' => 'classic',
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
                    'top'    => 16,
                    'right'  => 16,
                    'bottom' => 16,
                    'left'   => 16,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-pricing-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'card_box_shadow',
                'selector' => '{{WRAPPER}} .coherence-pricing-card',
            )
        );

        $this->add_control(
            'card_hover_animation',
            array(
                'label'   => esc_html__( 'Animation au survol', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'translate',
                'options' => array(
                    'none'      => esc_html__( 'Aucune', 'coherence-widgets' ),
                    'translate' => esc_html__( 'Déplacement vers le haut', 'coherence-widgets' ),
                    'zoom'      => esc_html__( 'Zoom léger', 'coherence-widgets' ),
                    'glow'      => esc_html__( 'Contour brillant', 'coherence-widgets' ),
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: EN-TÊTE & BADGE ---
        $this->start_controls_section(
            'section_style_header',
            array(
                'label' => esc_html__( 'Style En-tête & Badge', 'coherence-widgets' ),
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
                    '{{WRAPPER}} .coherence-pricing-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .coherence-pricing-title',
            )
        );

        $this->add_control(
            'desc_color',
            array(
                'label'     => esc_html__( 'Couleur de la Description', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6b7280',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-desc' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'desc_typography',
                'selector' => '{{WRAPPER}} .coherence-pricing-desc',
            )
        );

        $this->add_control(
            'badge_heading',
            array(
                'label'     => esc_html__( 'Badge', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'show_badge' => 'yes',
                ),
            )
        );

        $this->add_control(
            'badge_bg_color',
            array(
                'label'     => esc_html__( 'Couleur de fond du badge', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#007BFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-badge' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_badge' => 'yes',
                ),
            )
        );

        $this->add_control(
            'badge_text_color',
            array(
                'label'     => esc_html__( 'Couleur du texte du badge', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-badge' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_badge' => 'yes',
                ),
            )
        );

        $this->add_control(
            'badge_pulse',
            array(
                'label'        => esc_html__( 'Effet pulsant (badge)', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => array(
                    'show_badge' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: COMMUTATEUR (TOGGLE) ---
        $this->start_controls_section(
            'section_style_toggle',
            array(
                'label'     => esc_html__( 'Style du Commutateur (Toggle)', 'coherence-widgets' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_toggle' => 'yes',
                ),
            )
        );

        $this->add_control(
            'toggle_bg_color',
            array(
                'label'     => esc_html__( 'Couleur de fond active', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#007BFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-switch-input:checked + .coherence-pricing-switch-label' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'toggle_text_color',
            array(
                'label'     => esc_html__( 'Couleur du texte d\'option', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#4b5563',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-toggle-container' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'toggle_typography',
                'selector' => '{{WRAPPER}} .coherence-pricing-toggle-container',
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: PRIX ---
        $this->start_controls_section(
            'section_style_price',
            array(
                'label' => esc_html__( 'Style des Prix', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'price_color',
            array(
                'label'     => esc_html__( 'Couleur du Prix', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-num, {{WRAPPER}} .coherence-pricing-currency' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'price_typography',
                'selector' => '{{WRAPPER}} .coherence-pricing-num',
            )
        );

        $this->add_control(
            'billing_info_color',
            array(
                'label'     => esc_html__( 'Couleur de l\'info de facturation', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#888888',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-billing-info' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_toggle' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // --- SECTION STYLE: BOUTON D'ACTION ---
        $this->start_controls_section(
            'section_style_cta',
            array(
                'label' => esc_html__( 'Style du Bouton', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'button_bg_color',
            array(
                'label'     => esc_html__( 'Couleur de fond', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#007BFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-btn' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'button_bg_hover_color',
            array(
                'label'     => esc_html__( 'Couleur de fond (Survol)', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0056b3',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-btn:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'button_text_color',
            array(
                'label'     => esc_html__( 'Couleur du texte', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-pricing-btn' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .coherence-pricing-btn',
            )
        );

        $this->add_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Espacement interne', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'default'    => array(
                    'top'    => 14,
                    'right'  => 28,
                    'bottom' => 14,
                    'left'   => 28,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-pricing-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'button_border_radius',
            array(
                'label'      => esc_html__( 'Rayon de bordure', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'default'    => array(
                    'top'    => 8,
                    'right'  => 8,
                    'bottom' => 8,
                    'left'   => 8,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-pricing-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'button_shine',
            array(
                'label'        => esc_html__( 'Effet brillance au survol', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $title = isset( $settings['plan_title'] ) ? sanitize_text_field( $settings['plan_title'] ) : '';
        $desc = isset( $settings['plan_description'] ) ? wp_kses_post( $settings['plan_description'] ) : '';
        $show_badge = isset( $settings['show_badge'] ) && 'yes' === $settings['show_badge'];
        $badge_text = isset( $settings['badge_text'] ) ? sanitize_text_field( $settings['badge_text'] ) : '';
        $badge_pulse = isset( $settings['badge_pulse'] ) && 'yes' === $settings['badge_pulse'] ? 'coherence-badge-pulse' : '';

        $currency = isset( $settings['currency'] ) ? esc_html( $settings['currency'] ) : '€';
        $period = isset( $settings['period_text'] ) ? esc_html( $settings['period_text'] ) : '/ mois';
        $show_toggle = isset( $settings['show_toggle'] ) && 'yes' === $settings['show_toggle'];
        $price_mo = isset( $settings['price_monthly'] ) ? floatval( $settings['price_monthly'] ) : 0;
        $price_yr = isset( $settings['price_yearly'] ) ? floatval( $settings['price_yearly'] ) : 0;
        $billing_info = isset( $settings['yearly_billing_info'] ) ? sanitize_text_field( $settings['yearly_billing_info'] ) : '';

        $features = isset( $settings['features_list'] ) ? $settings['features_list'] : array();

        $btn_text = isset( $settings['button_text'] ) ? sanitize_text_field( $settings['button_text'] ) : '';
        $btn_link = isset( $settings['button_link'] ) ? $settings['button_link'] : array();
        $btn_icon = isset( $settings['button_icon'] ) ? $settings['button_icon'] : array();
        $btn_icon_align = isset( $settings['button_icon_align'] ) ? $settings['button_icon_align'] : 'right';
        $btn_shine = isset( $settings['button_shine'] ) && 'yes' === $settings['button_shine'] ? 'coherence-btn-shine' : '';

        $theme = isset( $settings['card_style_type'] ) ? sanitize_text_field( $settings['card_style_type'] ) : 'classic';
        $hover_anim = isset( $settings['card_hover_animation'] ) ? sanitize_text_field( $settings['card_hover_animation'] ) : 'translate';

        $card_class = 'coherence-pricing-card coherence-pricing-theme-' . $theme . ' coherence-pricing-hover-' . $hover_anim;
        if ( $show_toggle ) {
            $card_class .= ' coherence-pricing-has-toggle';
        }

        // Unique ID for toggle linkage
        $toggle_id = 'coherence_price_toggle_' . uniqid();
        ?>
        <div class="<?php echo esc_attr( $card_class ); ?>">
            
            <?php if ( $show_badge && $badge_text ) : ?>
                <div class="coherence-pricing-badge <?php echo esc_attr( $badge_pulse ); ?>">
                    <?php echo esc_html( $badge_text ); ?>
                </div>
            <?php endif; ?>

            <!-- En-tête -->
            <div class="coherence-pricing-header">
                <?php if ( $title ) : ?>
                    <h3 class="coherence-pricing-title"><?php echo esc_html( $title ); ?></h3>
                <?php endif; ?>
                <?php if ( $desc ) : ?>
                    <p class="coherence-pricing-desc"><?php echo $desc; ?></p>
                <?php endif; ?>
            </div>

            <!-- Commutateur mensuel/annuel -->
            <?php if ( $show_toggle ) : ?>
                <div class="coherence-pricing-toggle-container">
                    <span class="coherence-pricing-toggle-label coherence-pricing-label-mo"><?php esc_html_e( 'Mensuel', 'coherence-widgets' ); ?></span>
                    <div class="coherence-pricing-switch">
                        <input type="checkbox" id="<?php echo esc_attr( $toggle_id ); ?>" class="coherence-pricing-switch-input">
                        <label for="<?php echo esc_attr( $toggle_id ); ?>" class="coherence-pricing-switch-label"></label>
                    </div>
                    <span class="coherence-pricing-toggle-label coherence-pricing-label-yr"><?php esc_html_e( 'Annuel', 'coherence-widgets' ); ?></span>
                </div>
            <?php endif; ?>

            <!-- Section Prix -->
            <div class="coherence-pricing-price-box">
                
                <!-- Tarif Mensuel (Default) -->
                <div class="coherence-pricing-val coherence-pricing-val-monthly">
                    <span class="coherence-pricing-currency"><?php echo esc_html( $currency ); ?></span>
                    <span class="coherence-pricing-num"><?php echo esc_html( $price_mo ); ?></span>
                    <span class="coherence-pricing-period"><?php echo esc_html( $period ); ?></span>
                </div>

                <!-- Tarif Annuel (Caché si pas coché) -->
                <?php if ( $show_toggle ) : ?>
                    <div class="coherence-pricing-val coherence-pricing-val-yearly" style="display: none;">
                        <span class="coherence-pricing-currency"><?php echo esc_html( $currency ); ?></span>
                        <span class="coherence-pricing-num"><?php echo esc_html( $price_yr ); ?></span>
                        <span class="coherence-pricing-period"><?php echo esc_html( $period ); ?></span>
                    </div>
                    
                    <?php if ( $billing_info ) : ?>
                        <div class="coherence-pricing-billing-info" style="display: none;">
                            <?php echo esc_html( $billing_info ); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>

            <!-- Séparateur -->
            <div class="coherence-pricing-divider"></div>

            <!-- Fonctionnalités -->
            <?php if ( ! empty( $features ) ) : ?>
                <ul class="coherence-pricing-features-list">
                    <?php foreach ( $features as $feature ) : 
                        $f_text = isset( $feature['feature_text'] ) ? sanitize_text_field( $feature['feature_text'] ) : '';
                        $f_icon = isset( $feature['feature_icon'] ) ? $feature['feature_icon'] : array();
                        $f_disabled = isset( $feature['feature_is_disabled'] ) && 'yes' === $feature['feature_is_disabled'];
                        
                        $li_class = 'coherence-pricing-feature-item';
                        if ( $f_disabled ) {
                            $li_class .= ' coherence-pricing-feature-disabled';
                        }
                    ?>
                        <li class="<?php echo esc_attr( $li_class ); ?>">
                            <?php if ( ! empty( $f_icon['value'] ) ) : ?>
                                <span class="coherence-pricing-feature-icon">
                                    <?php \Elementor\Icons_Manager::render_icon( $f_icon, array( 'aria-hidden' => 'true' ) ); ?>
                                </span>
                            <?php endif; ?>
                            <span class="coherence-pricing-feature-text"><?php echo esc_html( $f_text ); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <!-- CTA -->
            <?php if ( $btn_text ) : 
                $this->add_link_attributes( 'button', $btn_link );
                $this->add_render_attribute( 'button', 'class', 'coherence-pricing-btn ' . $btn_shine );
            ?>
                <div class="coherence-pricing-cta">
                    <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                        
                        <?php if ( ! empty( $btn_icon['value'] ) && 'left' === $btn_icon_align ) : ?>
                            <span class="coherence-pricing-btn-icon coherence-btn-icon-left">
                                <?php \Elementor\Icons_Manager::render_icon( $btn_icon, array( 'aria-hidden' => 'true' ) ); ?>
                            </span>
                        <?php endif; ?>

                        <span class="coherence-pricing-btn-text"><?php echo esc_html( $btn_text ); ?></span>

                        <?php if ( ! empty( $btn_icon['value'] ) && 'right' === $btn_icon_align ) : ?>
                            <span class="coherence-pricing-btn-icon coherence-btn-icon-right">
                                <?php \Elementor\Icons_Manager::render_icon( $btn_icon, array( 'aria-hidden' => 'true' ) ); ?>
                            </span>
                        <?php endif; ?>

                    </a>
                </div>
            <?php endif; ?>

        </div>
        <?php
    }
}
