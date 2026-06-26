<?php
/**
 * Plugin Name: Coherence Widgets Bundle
 * Plugin URI: https://www.agence-coherence.fr/
 * Description: Bibliothèque complète de widgets Elementor personnalisés pour Coherence
 * Version: 1.0.0
 * Author: Coherence Agency
 * Author URI: https://www.agence-coherence.fr/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: coherence-widgets
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'COHERENCE_WIDGETS_VERSION', '1.0.0' );
define( 'COHERENCE_WIDGETS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'COHERENCE_WIDGETS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'COHERENCE_WIDGETS_ASSETS_URL', COHERENCE_WIDGETS_PLUGIN_URL . 'assets/' );


/**
 * Vérification de la dépendance Elementor
 */
function coherence_widgets_admin_notice() {
    if ( isset( $_GET['activate'] ) ) {
        unset( $_GET['activate'] );
    }

    $message = sprintf(
        esc_html__( '"%s" requires "%s" to be installed and activated.', 'coherence-widgets' ),
        '<strong>' . esc_html__( 'Coherence Widgets Bundle', 'coherence-widgets' ) . '</strong>',
        '<strong>' . esc_html__( 'Elementor', 'coherence-widgets' ) . '</strong>'
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
}

function coherence_widgets_fail_load() {
    add_action( 'admin_notices', 'coherence_widgets_admin_notice' );
}

// Vérifier la présence d'Elementor après le chargement des plugins
add_action( 'plugins_loaded', function() {
    if ( ! class_exists( '\\Elementor\\Plugin' ) ) {
        add_action( 'admin_notices', 'coherence_widgets_admin_notice' );
    }
} );

/**
 * Charger les fichiers du plugin
 */


/**
 * Enregistrer les widgets
 */
function register_coherence_widgets( $widgets_manager ) {
    $widgets_dir = COHERENCE_WIDGETS_PLUGIN_DIR . 'widgets/';

    // Map: file => class name
    $widgets = array(
        'class-before-after-widget.php'     => 'Coherence_Before_After_Widget',
        'class-testimonial-widget.php'      => 'Coherence_Testimonial_Widget',
        'class-pricing-widget.php'          => 'Coherence_Pricing_Widget',
        'class-features-widget.php'         => 'Coherence_Features_Widget',
        'class-divider-widget.php'          => 'Coherence_Divider_Widget',
        'class-slider-coherence-widget.php' => 'Coherence_Slider_Widget',
        'class-popup-coherence-widget.php'  => 'Coherence_Popup_Widget',
        'widget-gallery-tabs.php'           => 'Coherence_Gallery_Tabs_Widget',
    );

    foreach ( $widgets as $file => $class ) {
        $widget_path = $widgets_dir . $file;
        if ( file_exists( $widget_path ) ) {
            require_once $widget_path;
            if ( class_exists( $class ) ) {
                $widgets_manager->register( new $class() );
            }
        }
    }
}

add_action( 'elementor/widgets/register', 'register_coherence_widgets' );

/**
 * Enregistrer les catégories personnalisées
 */
function register_coherence_widget_category( $elements_manager ) {
    $elements_manager->add_category(
        'coherence',
        array(
            'title' => esc_html__( 'Coherence Widgets', 'coherence-widgets' ),
            'icon'  => 'fa fa-plug',
        )
    );
}

add_action( 'elementor/elements/categories_registered', 'register_coherence_widget_category' );

/**
 * Enregistrer les assets frontend
 */
function coherence_widgets_enqueue_scripts() {
    // Register Fancybox
    wp_register_style(
        'fancybox',
        'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css',
        array(),
        '5.0.0'
    );
    wp_register_script(
        'fancybox',
        'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
        array(),
        '5.0.0',
        true
    );

    // Register Gallery Tabs assets
    wp_register_style(
        'coherence-gallery-tabs',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/gallery-tabs.css',
        array( 'fancybox' ),
        COHERENCE_WIDGETS_VERSION
    );
    wp_register_script(
        'coherence-gallery-tabs',
        COHERENCE_WIDGETS_ASSETS_URL . 'js/gallery-tabs.js',
        array( 'fancybox' ),
        COHERENCE_WIDGETS_VERSION,
        true
    );

    wp_register_script(
        'coherence-before-after',
        COHERENCE_WIDGETS_ASSETS_URL . 'js/before-after.js',
        array(),
        COHERENCE_WIDGETS_VERSION,
        true
    );

    wp_register_script(
        'coherence-testimonial',
        COHERENCE_WIDGETS_ASSETS_URL . 'js/testimonial.js',
        array(),
        COHERENCE_WIDGETS_VERSION,
        true
    );

    wp_register_script(
        'coherence-pricing',
        COHERENCE_WIDGETS_ASSETS_URL . 'js/pricing.js',
        array(),
        COHERENCE_WIDGETS_VERSION,
        true
    );

    wp_register_style(
        'coherence-before-after',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/before-after.css',
        array(),
        COHERENCE_WIDGETS_VERSION
    );

    wp_register_style(
        'coherence-testimonial',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/testimonial.css',
        array(),
        COHERENCE_WIDGETS_VERSION
    );

    wp_register_style(
        'coherence-pricing',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/pricing.css',
        array(),
        COHERENCE_WIDGETS_VERSION
    );

    wp_register_style(
        'coherence-features',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/features.css',
        array(),
        COHERENCE_WIDGETS_VERSION
    );

    wp_register_style(
        'coherence-divider',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/divider.css',
        array(),
        COHERENCE_WIDGETS_VERSION
    );

    wp_register_script(
        'coherence-popup',
        COHERENCE_WIDGETS_ASSETS_URL . 'js/coherence-popup.js',
        array(),
        COHERENCE_WIDGETS_VERSION,
        true
    );

    wp_register_style(
        'coherence-popup-style',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/coherence-popup.css',
        array(),
        COHERENCE_WIDGETS_VERSION
    );
}

add_action( 'wp_enqueue_scripts', 'coherence_widgets_enqueue_scripts' );

/**
 * Enregistrer les assets Elementor editor
 */
function coherence_widgets_editor_scripts() {
    wp_enqueue_style(
        'coherence-editor',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/editor.css',
        array(),
        COHERENCE_WIDGETS_VERSION
    );
    // Enqueue popup assets for editor preview
    wp_enqueue_script(
        'coherence-popup',
        COHERENCE_WIDGETS_ASSETS_URL . 'js/coherence-popup.js',
        array(),
        COHERENCE_WIDGETS_VERSION,
        true
    );
    wp_enqueue_style(
        'coherence-popup-style',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/coherence-popup.css',
        array(),
        COHERENCE_WIDGETS_VERSION
    );

    // Enqueue Fancybox assets for editor preview
    wp_enqueue_style(
        'fancybox',
        'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css',
        array(),
        '5.0.0'
    );
    wp_enqueue_script(
        'fancybox',
        'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
        array(),
        '5.0.0',
        true
    );

    // Enqueue Gallery Tabs assets for editor preview
    wp_enqueue_style(
        'coherence-gallery-tabs',
        COHERENCE_WIDGETS_ASSETS_URL . 'css/gallery-tabs.css',
        array( 'fancybox' ),
        COHERENCE_WIDGETS_VERSION
    );
    wp_enqueue_script(
        'coherence-gallery-tabs',
        COHERENCE_WIDGETS_ASSETS_URL . 'js/gallery-tabs.js',
        array( 'fancybox' ),
        COHERENCE_WIDGETS_VERSION,
        true
    );
}

add_action( 'elementor/editor/before_enqueue_scripts', 'coherence_widgets_editor_scripts' );

/**
 * Activer le plugin
 */
function coherence_widgets_activate() {
    update_option( 'coherence_widgets_activated', true );
}

register_activation_hook( __FILE__, 'coherence_widgets_activate' );

/**
 * Désactiver le plugin
 */
function coherence_widgets_deactivate() {
    delete_option( 'coherence_widgets_activated' );
}

register_deactivation_hook( __FILE__, 'coherence_widgets_deactivate' );
