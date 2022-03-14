<?php

namespace Directorist_WPML_Integration\Controller\Rest_API;

use Directorist_WPML_Integration\Helper;

class Init {
    
    /**
	 * Constuctor
	 * 
     * @return void
	 */
	function __construct() {

		// Register REST API Controllers
        $rest_api_controllers = $this->get_controllers();
        Helper\Serve::register_services( $rest_api_controllers );

	}

    /**
     * Get REST API Controllers
     * 
     * @return array $rest_api_controllers
     */
	private function get_controllers() {
        return [
            // Rest_Request_Handler::class,
        ];
    }

}