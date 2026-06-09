<?php
/**
 * Plugin Name: Coherence Widgets Bundle
 * Plugin URI: https://coherence.fr
 * Description: Bibliothèque complète de widgets Elementor personnalisés pour Coherence
 * Version: 1.0.0
 * Author: Coherence Agency
 * Author URI: https://coherence.fr
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
require_once COHERENCE_WIDGETS_PLUGIN_DIR . 'includes/helpers.php';

/**
 * Enregistrer les widgets
 */
function register_coherence_widgets( $widgets_manager ) {
    $widgets_dir = COHERENCE_WIDGETS_PLUGIN_DIR . 'widgets/';
    
    $widget_files = array(
        'class-before-after-widget.php',
        'class-testimonial-widget.php',
        'class-pricing-widget.php',
        'class-features-widget.php',
        'class-divider-widget.php',
        'class-slider-coherence-widget.php',
    );

    foreach ( $widget_files as $widget_file ) {
        $widget_path = $widgets_dir . $widget_file;
        
        if ( file_exists( $widget_path ) ) {
            require_once $widget_path;
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
