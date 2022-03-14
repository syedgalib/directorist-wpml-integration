<?php

namespace Directorist_WPML_Integration\Helper;

use Directorist_WPML_Integration\Helper\Response;

class WPML_Helper {

    /**
     * Set post translation
     * 
     * @param int $original_post_id 0
     * @param int $translation_post_id 0
     * @param string $language_code en
     * @param string $element_type post
     * @return Response
     */
    public static function set_post_translation( $original_post_id = 0, $translation_post_id = 0, $language_code = 'en', $element_type = 'post' ) {
        $response = new Response;

        $status = [];
        $status['succes']  = false;
        $status['message'] = '';

        // Validation
        if ( empty( $original_post_id ) ) {
            $response->message = __( 'Original post ID is required', 'directorist-wpml-integration' );
            return $response;
        }

        if ( empty( $translation_post_id ) ) {
            $response->message = __( 'Translation post ID is required', 'directorist-wpml-integration' );
            return $response;
        }

        if ( empty( $language_code ) ) {
            $response->message = __( 'Language code is required', 'directorist-wpml-integration' );
            return $response;
        }

        if ( empty( $element_type ) ) {
            $response->message = __( 'Element type is required', 'directorist-wpml-integration' );
            return $response;
        }

        $wpml_element_type = apply_filters( 'wpml_element_type', $element_type );
             
        // get the language info of the original post
        $get_language_args = [ 
            'element_id'   => $original_post_id,
            'element_type' => $element_type
        ];
    
        $original_post_language_info = apply_filters( 'wpml_element_language_details', null, $get_language_args );
        
        if ( empty( $original_post_language_info ) ) {
            $response->message = __( 'Original post ID is not valid', 'directorist-wpml-integration' );
            return $response;
        }

        $set_language_args = [
            'element_id'           => $translation_post_id,
            'element_type'         => $wpml_element_type,
            'trid'                 => $original_post_language_info->trid,
            'language_code'        => $language_code,
            'source_language_code' => $original_post_language_info->language_code
        ];
    
        do_action( 'wpml_set_element_language_details', $set_language_args );

        $response->success = true;
        $response->message = __( 'The translation has been set successfully.', 'directorist-wpml-integration' );

        return $response;
    }

    /**
     * Duplicats a term from given term ID
     * 
     * @param int $term_id 0
     * @param string $taxonomy ''
     * @param string $new_term_name ''
     * @return Response
     */
    public static function create_duplicate_term( $term_id = 0, $taxonomy = '', $new_term_name = '' ) {
        $response = new Response();

        if ( empty( $term_id ) ) {
            $response->message = __( 'The term ID is required.', 'directorist-wpml-integration' );
            return $response;
        }

        if ( empty( $taxonomy ) ) {
            $response->message = __( 'The taxonomy is required.', 'directorist-wpml-integration' );
            return $response;
        }

        $original_term = get_term_by( 'id', $term_id, $taxonomy );

        if ( is_wp_error( $original_term ) ) {
            $response->message = __( 'The term ID or taxonomy is not valid.', 'directorist-wpml-integration' );
            return $response;
        }

	    $new_term = wp_insert_term( $new_term_name, $original_term->taxonomy );

        if ( is_wp_error( $new_term ) ) {
            $response->message = __( 'Couldn\'t duplicate the term, please try again.', 'directorist-wpml-integration' );
            return $response;
        }

        $original_term_meta = get_term_meta( $original_term->term_id );

        // Duplicate the term meta
        if ( ! empty( $original_term_meta ) ) {
            foreach ( $original_term_meta as $original_term_meta_key => $original_term_meta_value ) {
                update_term_meta( $new_term['term_id'], $original_term_meta_key, maybe_unserialize( $original_term_meta_value[0] ) );
            }
        }

        $response->success = true;
        $response->data    = [ 'new_term_id' => $new_term['term_id'] ];
        $response->message = __( 'The term has been duplicated successfully', 'directorist-wpml-integration' );
        
        return $response;
    }

}