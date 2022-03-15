<?php

namespace Directorist_WPML_Integration\Controller\Hook;

class Directory_Builder_Actions {

    public static $instance = null;

     /**
     * Constuctor
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'directorist_before_set_default_directory_type', [ $this, 'before_set_default_directory_type' ], 20, 2 );
        add_action( 'directorist_after_set_default_directory_type', [ $this, 'after_set_default_directory_type' ], 20, 3 );
    }


    /**
     * Before set default directory type
     * 
     * @param int $directory_type_id
     * @return void
     */
    public function before_set_default_directory_type( $directory_type_id = 0, $current_language ) {

        do_action( 'wpml_switch_language', 'all' );

    }

    /**
     * After set default directory type
     * 
     * @param int $directory_type_id
     * @return void
     */
    public function after_set_default_directory_type( $directory_type_id = 0, $all_directory_types, $current_language ) {
        
        do_action( 'wpml_switch_language', $current_language );

        $element_type   = apply_filters( 'wpml_element_type', ATBDP_DIRECTORY_TYPE );
        $translation_id = apply_filters( 'wpml_element_trid', NULL, $directory_type_id, $element_type );
        $translations   = apply_filters( 'wpml_get_element_translations', NULL, $translation_id, $element_type );

        if ( empty( $translations ) ) {
            return;
        }

        foreach( $translations as $translation ) {
            update_term_meta( $translation->term_id, '_default', true );
        }
    }
}
