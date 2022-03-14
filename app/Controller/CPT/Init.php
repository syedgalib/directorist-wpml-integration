<?php

namespace Directorist_WPML_Integration\Controller\CPT;

use Directorist_WPML_Integration\Helper;

class Init {
    
    /**
	 * Constuctor
	 * 
     * @return void
	 */
	function __construct() {

		// Register CPT Controllers
        $cpt_controllers = $this->get_controllers();
        Helper\Serve::register_services( $cpt_controllers );

	}

    /**
     * Get CPT Controllers
     * 
     * @return array $cpt_controllers
     */
	private function get_controllers() {
        return [
            // To_Do::class,
        ];
    }

}