<?php
/**
 * Testimonial Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Coherence_Testimonial_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coherence_testimonial';
    }

    public function get_title() {
        return esc_html__( 'Témoignages', 'coherence-widgets' );
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return array( 'coherence' );
    }

    public function get_keywords() {
        return array( 'testimonial', 'review', 'client', 'feedback' );
    }

    public function get_script_depends() {
        return array( 'coherence-testimonial' );
    }

    public function get_style_depends() {
        return array( 'coherence-testimonial' );
    }

    protected function register_controls() {
        // Section Contenu
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Contenu', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'testimonial_text',
            array(
                'label'       => esc_html__( 'Témoignage', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Texte du témoignage...', 'coherence-widgets' ),
                'default'     => 'Excellent service, très satisfait!',
            )
        );

        $repeater->add_control(
            'client_name',
            array(
                'label'       => esc_html__( 'Nom du client', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Jean Dupont', 'coherence-widgets' ),
                'default'     => 'Jean Dupont',
            )
        );

        $repeater->add_control(
            'client_title',
            array(
                'label'       => esc_html__( 'Titre/Fonction', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'PDG de...', 'coherence-widgets' ),
                'default'     => 'PDG de Entreprise XYZ',
            )
        );

        $repeater->add_control(
            'client_image',
            array(
                'label'   => esc_html__( 'Photo du client', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
            )
        );

        $repeater->add_control(
            'rating',
            array(
                'label'   => esc_html__( 'Notation', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '5',
                'options' => array(
                    '1' => '⭐ 1',
                    '2' => '⭐⭐ 2',
                    '3' => '⭐⭐⭐ 3',
                    '4' => '⭐⭐⭐⭐ 4',
                    '5' => '⭐⭐⭐⭐⭐ 5',
                ),
            )
        );

        $this->add_control(
            'testimonials',
            array(
                'label'       => esc_html__( 'Témoignages', 'coherence-widgets' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'testimonial_text' => 'Excellent service, équipe très professionnelle!',
                        'client_name'      => 'Marie Martin',
                        'client_title'     => 'Directrice Marketing',
                        'rating'           => '5',
                    ),
                    array(
                        'testimonial_text' => 'Résultats impressionnants, je recommande vivement!',
                        'client_name'      => 'Pierre Bernard',
                        'client_title'     => 'Entrepreneur',
                        'rating'           => '5',
                    ),
                ),
                'title_field' => '{{{ client_name }}}',
            )
        );

        $this->end_controls_section();

        // Section Options
        $this->start_controls_section(
            'section_options',
            array(
                'label' => esc_html__( 'Options', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'layout',
            array(
                'label'   => esc_html__( 'Disposition', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => array(
                    'grid'     => esc_html__( 'Grille', 'coherence-widgets' ),
                    'carousel' => esc_html__( 'Carrousel', 'coherence-widgets' ),
                    'single'   => esc_html__( 'Unique', 'coherence-widgets' ),
                ),
            )
        );

        $this->add_control(
            'style_preset',
            array(
                'label'   => esc_html__( 'Style de carte', 'coherence-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'card',
                'options' => array(
                    'card'    => esc_html__( 'Carte Classique', 'coherence-widgets' ),
                    'bubble'  => esc_html__( 'Bulle de texte', 'coherence-widgets' ),
                    'minimal' => esc_html__( 'Minimaliste', 'coherence-widgets' ),
                ),
            )
        );

        $this->add_control(
            'columns',
            array(
                'label'     => esc_html__( 'Colonnes', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => '3',
                'options'   => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'condition' => array(
                    'layout' => array( 'grid', 'carousel' ),
                ),
            )
        );

        $this->add_control(
            'show_rating',
            array(
                'label'        => esc_html__( 'Afficher les étoiles', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'carousel_autoplay',
            array(
                'label'        => esc_html__( 'Défilement automatique', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => array(
                    'layout' => 'carousel',
                ),
            )
        );

        $this->add_control(
            'carousel_loop',
            array(
                'label'        => esc_html__( 'Boucle infinie', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => array(
                    'layout' => 'carousel',
                ),
            )
        );

        $this->add_control(
            'carousel_navigation',
            array(
                'label'        => esc_html__( 'Afficher les flèches', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => array(
                    'layout' => 'carousel',
                ),
            )
        );

        $this->add_control(
            'carousel_pagination',
            array(
                'label'        => esc_html__( 'Afficher les points', 'coherence-widgets' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => 'Oui',
                'label_off'    => 'Non',
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => array(
                    'layout' => 'carousel',
                ),
            )
        );

        $this->end_controls_section();

        // Section Styles
        $this->start_controls_section(
            'section_style',
            array(
                'label' => esc_html__( 'Style', 'coherence-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'card_bg_color',
            array(
                'label'     => esc_html__( 'Couleur de fond de la carte', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-testimonial-card, {{WRAPPER}} .coherence-testimonial-bubble-content' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .coherence-preset-bubble .coherence-testimonial-bubble-content::after' => 'border-top-color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'card_shadow',
                'selector' => '{{WRAPPER}} .coherence-testimonial-card, {{WRAPPER}} .coherence-testimonial-bubble-content',
            )
        );

        $this->add_control(
            'card_padding',
            array(
                'label'      => esc_html__( 'Espacement interne', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => 30,
                    'right'  => 30,
                    'bottom' => 30,
                    'left'   => 30,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-testimonial-card, {{WRAPPER}} .coherence-testimonial-bubble-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'card_border_radius',
            array(
                'label'      => esc_html__( 'Rayon de bordure de la carte', 'coherence-widgets' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .coherence-testimonial-card, {{WRAPPER}} .coherence-testimonial-bubble-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'rating_color',
            array(
                'label'     => esc_html__( 'Couleur des étoiles', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFC107',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-star' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_rating' => 'yes',
                ),
            )
        );

        $this->add_control(
            'text_color',
            array(
                'label'     => esc_html__( 'Couleur du témoignage', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#555555',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-testimonial-text' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'text_typography',
                'label'    => esc_html__( 'Typographie du témoignage', 'coherence-widgets' ),
                'selector' => '{{WRAPPER}} .coherence-testimonial-text',
            )
        );

        $this->add_control(
            'author_name_color',
            array(
                'label'     => esc_html__( 'Couleur du nom', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-testimonial-name' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'author_name_typography',
                'label'    => esc_html__( 'Typographie du nom', 'coherence-widgets' ),
                'selector' => '{{WRAPPER}} .coherence-testimonial-name',
            )
        );

        $this->add_control(
            'author_title_color',
            array(
                'label'     => esc_html__( 'Couleur du titre/fonction', 'coherence-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#999999',
                'selectors' => array(
                    '{{WRAPPER}} .coherence-testimonial-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'author_title_typography',
                'label'    => esc_html__( 'Typographie du titre/fonction', 'coherence-widgets' ),
                'selector' => '{{WRAPPER}} .coherence-testimonial-title',
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $testimonials = isset( $settings['testimonials'] ) ? $settings['testimonials'] : array();
        $layout = isset( $settings['layout'] ) ? sanitize_text_field( $settings['layout'] ) : 'grid';
        $preset = isset( $settings['style_preset'] ) ? sanitize_text_field( $settings['style_preset'] ) : 'card';
        $columns = isset( $settings['columns'] ) ? intval( $settings['columns'] ) : 3;
        $show_rating = isset( $settings['show_rating'] ) ? $settings['show_rating'] : 'yes';

        $wrapper_class = 'coherence-testimonial-wrapper coherence-testimonial-' . $layout . ' coherence-testimonial-preset-' . $preset;
        
        $carousel_data = '';
        if ( 'carousel' === $layout ) {
            $wrapper_class .= ' swiper-container';
            $autoplay = isset( $settings['carousel_autoplay'] ) && 'yes' === $settings['carousel_autoplay'] ? 'true' : 'false';
            $loop = isset( $settings['carousel_loop'] ) && 'yes' === $settings['carousel_loop'] ? 'true' : 'false';
            $nav = isset( $settings['carousel_navigation'] ) && 'yes' === $settings['carousel_navigation'] ? 'true' : 'false';
            $dots = isset( $settings['carousel_pagination'] ) && 'yes' === $settings['carousel_pagination'] ? 'true' : 'false';

            $carousel_data .= ' data-autoplay="' . esc_attr( $autoplay ) . '"';
            $carousel_data .= ' data-loop="' . esc_attr( $loop ) . '"';
            $carousel_data .= ' data-arrows="' . esc_attr( $nav ) . '"';
            $carousel_data .= ' data-dots="' . esc_attr( $dots ) . '"';
            $carousel_data .= ' data-cols="' . esc_attr( $columns ) . '"';
        } elseif ( 'grid' === $layout ) {
            $wrapper_class .= ' coherence-testimonial-cols-' . $columns;
        }
        ?>
        <div class="<?php echo esc_attr( $wrapper_class ); ?>"<?php echo $carousel_data; ?>>
            
            <?php if ( 'carousel' === $layout ) : ?>
                <div class="swiper-wrapper">
            <?php endif; ?>

            <?php foreach ( $testimonials as $testimonial ) : 
                $image_url = isset( $testimonial['client_image']['url'] ) ? esc_url( $testimonial['client_image']['url'] ) : '';
                $text = isset( $testimonial['testimonial_text'] ) ? wp_kses_post( $testimonial['testimonial_text'] ) : '';
                $name = isset( $testimonial['client_name'] ) ? sanitize_text_field( $testimonial['client_name'] ) : '';
                $title = isset( $testimonial['client_title'] ) ? sanitize_text_field( $testimonial['client_title'] ) : '';
                $rating = isset( $testimonial['rating'] ) ? intval( $testimonial['rating'] ) : 5;

                $card_class = 'coherence-testimonial-card coherence-preset-' . $preset;
                if ( 'carousel' === $layout ) {
                    $card_class .= ' swiper-slide';
                }
            ?>
                <div class="<?php echo esc_attr( $card_class ); ?>">
                    
                    <?php if ( 'card' === $preset ) : ?>
                        <!-- PRESET: CARD -->
                        <?php if ( $image_url ) : ?>
                            <div class="coherence-testimonial-avatar">
                                <img src="<?php echo esc_url( $image_url ); ?>" 
                                     alt="<?php echo esc_attr( $name ); ?>"
                                     class="coherence-testimonial-image">
                            </div>
                        <?php endif; ?>

                        <?php if ( 'yes' === $show_rating ) : ?>
                            <div class="coherence-testimonial-rating">
                                <?php for ( $i = 0; $i < $rating; $i++ ) : ?>
                                    <span class="coherence-star">★</span>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>

                        <p class="coherence-testimonial-text">
                            "<?php echo $text; ?>"
                        </p>

                        <div class="coherence-testimonial-author">
                            <p class="coherence-testimonial-name"><?php echo esc_html( $name ); ?></p>
                            <?php if ( $title ) : ?>
                                <p class="coherence-testimonial-title"><?php echo esc_html( $title ); ?></p>
                            <?php endif; ?>
                        </div>

                    <?php elseif ( 'bubble' === $preset ) : ?>
                        <!-- PRESET: BUBBLE -->
                        <div class="coherence-testimonial-bubble-content">
                            <?php if ( 'yes' === $show_rating ) : ?>
                                <div class="coherence-testimonial-rating">
                                    <?php for ( $i = 0; $i < $rating; $i++ ) : ?>
                                        <span class="coherence-star">★</span>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>

                            <p class="coherence-testimonial-text">
                                "<?php echo $text; ?>"
                            </p>
                        </div>

                        <div class="coherence-testimonial-author-meta">
                            <?php if ( $image_url ) : ?>
                                <div class="coherence-testimonial-avatar">
                                    <img src="<?php echo esc_url( $image_url ); ?>" 
                                         alt="<?php echo esc_attr( $name ); ?>"
                                         class="coherence-testimonial-image">
                                </div>
                            <?php endif; ?>
                            <div class="coherence-testimonial-author-info">
                                <p class="coherence-testimonial-name"><?php echo esc_html( $name ); ?></p>
                                <?php if ( $title ) : ?>
                                    <p class="coherence-testimonial-title"><?php echo esc_html( $title ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php elseif ( 'minimal' === $preset ) : ?>
                        <!-- PRESET: MINIMAL -->
                        <div class="coherence-testimonial-minimal-wrapper">
                            <?php if ( $image_url ) : ?>
                                <div class="coherence-testimonial-avatar">
                                    <img src="<?php echo esc_url( $image_url ); ?>" 
                                         alt="<?php echo esc_attr( $name ); ?>"
                                         class="coherence-testimonial-image">
                                </div>
                            <?php endif; ?>
                            <div class="coherence-testimonial-content-right">
                                <?php if ( 'yes' === $show_rating ) : ?>
                                    <div class="coherence-testimonial-rating">
                                        <?php for ( $i = 0; $i < $rating; $i++ ) : ?>
                                            <span class="coherence-star">★</span>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>

                                <p class="coherence-testimonial-text">
                                    "<?php echo $text; ?>"
                                </p>

                                <div class="coherence-testimonial-author-inline">
                                    <span class="coherence-testimonial-name"><?php echo esc_html( $name ); ?></span>
                                    <?php if ( $title ) : ?>
                                        <span class="coherence-testimonial-sep"> - </span>
                                        <span class="coherence-testimonial-title"><?php echo esc_html( $title ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

            <?php if ( 'carousel' === $layout ) : ?>
                </div>
                
                <!-- Swiper Dots & Arrows -->
                <?php if ( isset( $settings['carousel_pagination'] ) && 'yes' === $settings['carousel_pagination'] ) : ?>
                    <div class="swiper-pagination coherence-testimonial-pagination"></div>
                <?php endif; ?>

                <?php if ( isset( $settings['carousel_navigation'] ) && 'yes' === $settings['carousel_navigation'] ) : ?>
                    <div class="swiper-button-prev coherence-testimonial-prev"></div>
                    <div class="swiper-button-next coherence-testimonial-next"></div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
        <?php
    }
}

// Enregistrer le widget
\Elementor\Plugin::instance()->widgets_manager->register( new Coherence_Testimonial_Widget() );
