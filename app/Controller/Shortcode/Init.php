<?php

namespace Directorist_WPML_Integration\Controller\Shortcode;

use Directorist_WPML_Integration\Helper;

class Init {
    
    /**
	 * Constuctor
	 * 
     * @return void
	 */
	function __construct() {

		// Register Shortcode Controllers
        $shortcode_controllers = $this->get_controllers();
        Helper\Serve::register_services( $shortcode_controllers );

	}

    /**
     * Get Shortcode Controllers
     * 
     * @return array $shortcode_controllers
     */
	private function get_controllers() {
        return [
            // To_Do::class,
        ];
    }

}