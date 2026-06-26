<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Coherence Gallery Tabs Widget for Elementor
 */
class Coherence_Gallery_Tabs_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coherence_gallery_tabs';
    }

    public function get_title() {
        return esc_html__( 'Galerie à Onglets (Tabs)', 'coherence-widgets' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return [ 'coherence' ];
    }

    public function get_script_depends() {
        return [ 'fancybox', 'coherence-gallery-tabs' ];
    }

    public function get_style_depends() {
        return [ 'fancybox', 'coherence-gallery-tabs' ];
    }

    protected function register_controls() {
        // --- SECTION CONTENU ---
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Tabs & Éléments', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Repeater for Items (Photos / Portfolios)
        $repeater_items = new \Elementor\Repeater();

        $repeater_items->add_control(
            'item_type',
            [
                'label'   => esc_html__( 'Type d\'élément', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'photo',
                'options' => [
                    'photo'     => esc_html__( 'Photo normale', 'coherence-widgets' ),
                    'portfolio' => esc_html__( 'Portfolio (Projet)', 'coherence-widgets' ),
                ],
            ]
        );

        // Photo Controls
        $repeater_items->add_control(
            'photo_image',
            [
                'label'     => esc_html__( 'Image', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'default'   => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'item_type' => 'photo',
                ],
            ]
        );

        $repeater_items->add_control(
            'photo_caption',
            [
                'label'       => esc_html__( 'Légende (optionnelle)', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Ex: Villa en bord de mer', 'coherence-widgets' ),
                'condition'   => [
                    'item_type' => 'photo',
                ],
            ]
        );

        // Portfolio Controls
        $repeater_items->add_control(
            'portfolio_title',
            [
                'label'       => esc_html__( 'Titre du projet', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Projet Résidentiel', 'coherence-widgets' ),
                'condition'   => [
                    'item_type' => 'portfolio',
                ],
            ]
        );

        $repeater_items->add_control(
            'portfolio_subtitle',
            [
                'label'       => esc_html__( 'Sous-titre', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Architecture / Design', 'coherence-widgets' ),
                'condition'   => [
                    'item_type' => 'portfolio',
                ],
            ]
        );

        $repeater_items->add_control(
            'portfolio_cover',
            [
                'label'     => esc_html__( 'Image de couverture', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'default'   => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'item_type' => 'portfolio',
                ],
            ]
        );

        $repeater_items->add_control(
            'portfolio_gallery',
            [
                'label'     => esc_html__( 'Galerie d\'images du projet', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::GALLERY,
                'default'   => [],
                'condition' => [
                    'item_type' => 'portfolio',
                ],
            ]
        );

        // Repeater for Tabs
        $repeater_tabs = new \Elementor\Repeater();

        $repeater_tabs->add_control(
            'tab_title',
            [
                'label'   => esc_html__( 'Titre de l\'onglet', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Nouvel Onglet', 'coherence-widgets' ),
            ]
        );

        $repeater_tabs->add_control(
            'tab_items',
            [
                'label'       => esc_html__( 'Éléments de l\'onglet', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater_items->get_controls(),
                'default'     => [],
                'title_field' => '{{{ item_type === "portfolio" ? "📁 " + portfolio_title : "📷 Photo" }}}',
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'       => esc_html__( 'Onglets de la Galerie', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater_tabs->get_controls(),
                'default'     => [
                    [
                        'tab_title' => esc_html__( 'Tout', 'coherence-widgets' ),
                    ]
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->end_controls_section();

        // --- SECTION STYLE ---
        $this->start_controls_section(
            'section_style_layout',
            [
                'label' => esc_html__( 'Mise en page & Grille', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'           => esc_html__( 'Nombre de colonnes', 'coherence-widgets' ),
                'type'            => \Elementor\Controls_Manager::SELECT,
                'default'         => '3',
                'tablet_default'  => '2',
                'mobile_default'  => '1',
                'options'         => [
                    '1' => esc_html__( '1 Colonne', 'coherence-widgets' ),
                    '2' => esc_html__( '2 Colonnes', 'coherence-widgets' ),
                    '3' => esc_html__( '3 Colonnes', 'coherence-widgets' ),
                    '4' => esc_html__( '4 Colonnes', 'coherence-widgets' ),
                ],
                'prefix_class'    => 'coherence-grid-columns%s-',
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label'      => esc_html__( 'Espacement (Gap)', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', '%' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .coherence-gallery-grid' => 'grid-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => esc_html__( 'Border Radius des images', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .gallery-tabs-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => esc_html__( 'Navigation (Onglets)', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tab_nav_gap',
            [
                'label'      => esc_html__( 'Espacement entre les boutons', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'size' => 12,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gallery-tabs-navigation' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_nav_padding',
            [
                'label'      => esc_html__( 'Padding interne', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'top' => '10',
                    'bottom' => '10',
                    'left' => '24',
                    'right' => '24',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tab_nav_border_radius',
            [
                'label'      => esc_html__( 'Border Radius (Arrondi)', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'top' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'right' => '30',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tab_nav_typography',
                'label'    => esc_html__( 'Typographie', 'coherence-widgets' ),
                'selector' => '{{WRAPPER}} .gallery-tabs-nav-btn',
            ]
        );

        // TAB NORMAL / HOVER / ACTIVE
        $this->start_controls_tabs( 'tabs_button_style' );

        // STATE NORMAL
        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__( 'Normal', 'coherence-widgets' ),
            ]
        );

        $this->add_control(
            'tab_nav_bg_color_normal',
            [
                'label'     => esc_html__( 'Couleur de fond', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#f3f4f6',
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_nav_text_color_normal',
            [
                'label'     => esc_html__( 'Couleur du texte', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tab_nav_border_normal',
                'label' => esc_html__( 'Bordure', 'coherence-widgets' ),
                'selector' => '{{WRAPPER}} .gallery-tabs-nav-btn',
            ]
        );

        $this->end_controls_tab();

        // STATE HOVER
        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__( 'Au survol', 'coherence-widgets' ),
            ]
        );

        $this->add_control(
            'tab_nav_bg_color_hover',
            [
                'label'     => esc_html__( 'Couleur de fond', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#005ffc',
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_nav_text_color_hover',
            [
                'label'     => esc_html__( 'Couleur du texte', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_nav_border_color_hover',
            [
                'label'     => esc_html__( 'Couleur de bordure', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // STATE ACTIVE
        $this->start_controls_tab(
            'tab_button_active',
            [
                'label' => esc_html__( 'Actif', 'coherence-widgets' ),
            ]
        );

        $this->add_control(
            'tab_nav_bg_color_active',
            [
                'label'     => esc_html__( 'Couleur de fond', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#005ffc',
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_nav_text_color_active',
            [
                'label'     => esc_html__( 'Couleur du texte', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_nav_border_color_active',
            [
                'label'     => esc_html__( 'Couleur de bordure', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-nav-btn.active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_typography',
            [
                'label' => esc_html__( 'Titres & Textes', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Couleur des titres', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1f2937',
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-card-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .project-overlay-title'  => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__( 'Typographie des titres', 'coherence-widgets' ),
                'selector' => '{{WRAPPER}} .gallery-tabs-card-title, {{WRAPPER}} .project-overlay-title',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'     => esc_html__( 'Couleur des sous-titres', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .gallery-tabs-card-subtitle' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .project-overlay-subtitle'  => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'subtitle_typography',
                'label'    => esc_html__( 'Typographie des sous-titres', 'coherence-widgets' ),
                'selector' => '{{WRAPPER}} .gallery-tabs-card-subtitle, {{WRAPPER}} .project-overlay-subtitle',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $tabs     = $settings['tabs'];

        if ( empty( $tabs ) ) {
            return;
        }

        $widget_id = $this->get_id();
        ?>
        <div class="coherence-gallery-tabs-wrapper" id="gallery-tabs-<?php echo esc_attr( $widget_id ); ?>">
            
            <!-- Navigation -->
            <div class="gallery-tabs-navigation">
                <?php foreach ( $tabs as $index => $tab ) : 
                    $active_class = $index === 0 ? 'active' : '';
                    ?>
                    <button class="gallery-tabs-nav-btn <?php echo esc_attr( $active_class ); ?>" data-tab-target="tab-<?php echo esc_attr( $widget_id . '-' . $index ); ?>">
                        <?php echo esc_html( $tab['tab_title'] ); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Grids Container -->
            <div class="gallery-tabs-content">
                <?php foreach ( $tabs as $tab_index => $tab ) : 
                    $active_class = $tab_index === 0 ? 'active' : '';
                    $tab_items    = isset( $tab['tab_items'] ) ? $tab['tab_items'] : [];
                    ?>
                    <div class="gallery-tabs-grid-pane <?php echo esc_attr( $active_class ); ?>" id="tab-<?php echo esc_attr( $widget_id . '-' . $tab_index ); ?>">
                        <div class="coherence-gallery-grid">
                            <?php if ( ! empty( $tab_items ) ) : ?>
                                <?php foreach ( $tab_items as $item_index => $item ) : ?>
                                    
                                    <?php if ( 'photo' === $item['item_type'] ) : 
                                        $image_url = isset( $item['photo_image']['url'] ) ? $item['photo_image']['url'] : '';
                                        $caption   = isset( $item['photo_caption'] ) ? $item['photo_caption'] : '';
                                        ?>
                                        <div class="gallery-tabs-card type-photo">
                                            <a href="<?php echo esc_url( $image_url ); ?>" data-fancybox="gallery-<?php echo esc_attr( $widget_id . '-' . $tab_index ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>" class="gallery-tabs-card-link">
                                                <div class="gallery-tabs-image-wrapper">
                                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $caption ); ?>" loading="lazy">
                                                    <span class="gallery-tabs-badge badge-photo"><?php esc_html_e( 'Photo', 'coherence-widgets' ); ?></span>
                                                    <div class="gallery-tabs-card-hover">
                                                        <span class="gallery-tabs-icon-zoom"></span>
                                                    </div>
                                                </div>
                                                <?php if ( ! empty( $caption ) ) : ?>
                                                    <div class="gallery-tabs-card-info">
                                                        <h4 class="gallery-tabs-card-title"><?php echo esc_html( $caption ); ?></h4>
                                                    </div>
                                                <?php endif; ?>
                                            </a>
                                        </div>

                                    <?php elseif ( 'portfolio' === $item['item_type'] ) : 
                                        $cover_url = isset( $item['portfolio_cover']['url'] ) ? $item['portfolio_cover']['url'] : '';
                                        $title     = isset( $item['portfolio_title'] ) ? $item['portfolio_title'] : '';
                                        $subtitle  = isset( $item['portfolio_subtitle'] ) ? $item['portfolio_subtitle'] : '';
                                        $gallery   = isset( $item['portfolio_gallery'] ) ? $item['portfolio_gallery'] : [];
                                        
                                        // Collect gallery image URLs and tags
                                        $gallery_data = [];
                                        foreach ( $gallery as $gal_img ) {
                                            if ( isset( $gal_img['url'] ) ) {
                                                $gallery_data[] = [
                                                    'url' => $gal_img['url'],
                                                    'alt' => isset( $gal_img['alt'] ) ? $gal_img['alt'] : ''
                                                ];
                                            }
                                        }
                                        
                                        $project_id = esc_attr( $widget_id . '-' . $tab_index . '-' . $item_index );
                                        ?>
                                        <div class="gallery-tabs-card type-portfolio" data-project-trigger="<?php echo $project_id; ?>">
                                            <!-- Store project details as JSON inside a script tag -->
                                            <script type="application/json" class="project-details-json">
                                                {
                                                    "id": "<?php echo $project_id; ?>",
                                                    "title": <?php echo wp_json_encode( $title ); ?>,
                                                    "subtitle": <?php echo wp_json_encode( $subtitle ); ?>,
                                                    "gallery": <?php echo wp_json_encode( $gallery_data ); ?>
                                                }
                                            </script>
                                            
                                            <div class="gallery-tabs-image-wrapper">
                                                <img src="<?php echo esc_url( $cover_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
                                                <span class="gallery-tabs-badge badge-portfolio"><?php esc_html_e( 'Projet', 'coherence-widgets' ); ?></span>
                                                <div class="gallery-tabs-card-hover">
                                                    <span class="gallery-tabs-icon-open"></span>
                                                </div>
                                            </div>
                                            <div class="gallery-tabs-card-info">
                                                <h4 class="gallery-tabs-card-title"><?php echo esc_html( $title ); ?></h4>
                                                <?php if ( ! empty( $subtitle ) ) : ?>
                                                    <p class="gallery-tabs-card-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            <?php else : ?>
                                <p class="gallery-tabs-no-items"><?php esc_html_e( 'Aucun élément dans cet onglet.', 'coherence-widgets' ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Single Global Premium Overlay/Modal for Portfolios -->
            <div class="project-details-overlay" aria-hidden="true">
                <div class="project-overlay-backdrop"></div>
                <div class="project-overlay-container">
                    <button class="project-overlay-close-btn" aria-label="<?php esc_attr_e( 'Fermer', 'coherence-widgets' ); ?>">&times;</button>
                    <div class="project-overlay-content">
                        <!-- Content dynamically loaded by JS -->
                    </div>
                </div>
            </div>

            <!-- Inline script to guarantee instant activation in Elementor Editor and on page load -->
            <script>
                (function() {
                    const initWidget = function() {
                        if (window.CoherenceGalleryTabs) {
                            const wrapper = document.getElementById("gallery-tabs-<?php echo esc_attr( $widget_id ); ?>");
                            if (wrapper && !wrapper.classList.contains('js-initialized')) {
                                new window.CoherenceGalleryTabs(wrapper);
                                wrapper.classList.add('js-initialized');
                            }
                        }
                    };
                    
                    // Run immediately if DOM is loaded or if inside the Elementor editor frame
                    if (document.readyState !== 'loading' || window.elementorFrontend) {
                        initWidget();
                    } else {
                        document.addEventListener('DOMContentLoaded', initWidget);
                    }
                })();
            </script>

        </div>
        <?php
    }
}
