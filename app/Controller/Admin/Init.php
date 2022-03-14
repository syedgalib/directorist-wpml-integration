<?php

namespace Directorist_WPML_Integration\Controller\Admin;

use Directorist_WPML_Integration\Helper;

class Init {
    
    /**
	 * Constuctor
	 * 
     * @return void
	 */
	function __construct() {

		// Register Admin Controllers
        $admin_controllers = $this->get_controllers();
        Helper\Serve::register_services( $admin_controllers );

	}

    /**
     * Get Admin Controllers
     * 
     * @return array $admin_controllers
     */
	private function get_controllers() {
        return [
            // Admin_Menu::class,
        ];
    }

}