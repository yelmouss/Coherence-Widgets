<?php
/**
 * Helpers et fonctions utiles pour les widgets Coherence
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Retourner les options de contrôle communes
 */
function coherence_get_common_controls() {
    return array(
        'margin'    => true,
        'padding'   => true,
        'background' => true,
        'border'    => true,
        'box_shadow' => true,
    );
}

/**
 * Générer un ID unique pour les widgets
 */
function coherence_generate_widget_id( $prefix = 'cw' ) {
    return $prefix . '_' . uniqid();
}

/**
 * Obtenir les breakpoints réactifs
 */
function coherence_get_breakpoints() {
    return array(
        'desktop' => 'Desktop',
        'tablet'  => 'Tablet',
        'mobile'  => 'Mobile',
    );
}

/**
 * Enregistrer les classes widget
 */
function coherence_register_widget_class( $widget_class ) {
    if ( class_exists( '\\Elementor\\Widget_Base' ) ) {
        \Elementor\Plugin::instance()->widgets_manager->register( new $widget_class() );
    }
}

/**
 * Enqueue un script conditionnellement
 */
function coherence_enqueue_widget_script( $handle, $condition = true ) {
    if ( $condition ) {
        wp_enqueue_script( $handle );
    }
}

/**
 * Enqueue un style conditionnellement
 */
function coherence_enqueue_widget_style( $handle, $condition = true ) {
    if ( $condition ) {
        wp_enqueue_style( $handle );
    }
}

/**
 * Obtenir les couleurs du thème personnalisé
 */
function coherence_get_theme_colors() {
    return array(
        'primary'   => '#007BFF',
        'secondary' => '#6C757D',
        'success'   => '#28A745',
        'danger'    => '#DC3545',
        'warning'   => '#FFC107',
        'info'      => '#17A2B8',
        'light'     => '#F8F9FA',
        'dark'      => '#343A40',
    );
}

/**
 * Obtenir les classes CSS de typo Elementor
 */
function coherence_get_typography_classes() {
    return array(
        'heading-1'   => 'Heading 1',
        'heading-2'   => 'Heading 2',
        'heading-3'   => 'Heading 3',
        'body-text'   => 'Body Text',
        'small-text'  => 'Small Text',
    );
}
