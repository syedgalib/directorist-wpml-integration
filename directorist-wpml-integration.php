<?php
/**
 * Directorist_WPML_Integration
 *
 * @package           Directorist_WPML_Integration
 * @author            wpWax
 * @copyright         2022 wpWax
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Directorist WPML Integration
 * Plugin URI:        https://directorist.com/product/directorist-wpml-integration
 * Description:       A WPML integration plugin for Directorist
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            wpWax
 * Author URI:        https://directorist.com/about-us
 * Text Domain:       directorist-wpml-integration
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://github.com/sovware/directorist-wpml-integration
 */

require dirname( __FILE__ ) . '/vendor/autoload.php';
require dirname( __FILE__ ) . '/app.php';

if ( ! function_exists( 'Directorist_WPML_Integration' ) ) {
    function Directorist_WPML_Integration() {
        return Directorist_WPML_Integration::get_instance();
    }
}

if ( ! function_exists( 'setup_directorist_wpml_integration' ) ) {
    function setup_directorist_wpml_integration() {

        if ( version_compare( ATBDP_VERSION, '7.2', '<' ) ) {
            return;
        }
    
        add_action( 'wpml_loaded', 'Directorist_WPML_Integration' );
    }
}

add_action( 'directorist_loaded', 'setup_directorist_wpml_integration' );


// add_action( 'init', 'debug' );
add_action( 'wp_loaded', 'debug' );

function debug() {
    $listing_id = 257;
    $directory_type_term = get_the_terms( $listing_id, ATBDP_DIRECTORY_TYPE );
    $directory_type_term_id = ( ! is_wp_error( $directory_type_term ) && ! empty( $directory_type_term ) ) ? $directory_type_term[0]->term_id : 0;

    // update_post_meta( $listing_id, '_directory_type', 24 );

    $listing_language_info = Directorist_WPML_Integration\Helper\WPML_Helper::get_element_language_info( $listing_id, ATBDP_POST_TYPE );

    // $directory_type_meta = get_post_meta( $listing_id, '_directory_type', true );

    // $directory_types = get_terms([
    //     'taxonomy'   => ATBDP_DIRECTORY_TYPE,
    //     'hide_empty' => false,
    // ]);


    $log = [
        // 'listing_language_info' => $listing_language_info,
        // 'ATBDP_DIRECTORY_TYPE' => ATBDP_DIRECTORY_TYPE,
        // 'directory_type_meta'  => $directory_type_meta,
        // 'directory_type_term'  => $directory_type_term,
        // 'directory_type_term_id'  => $directory_type_term_id,
        // 'directory_types'      => $directory_types,
    ];
        
    // var_dump( $log );
}



