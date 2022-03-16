<?php

use Directorist_WPML_Integration\Controller;
use Directorist_WPML_Integration\Helper;

final class Directorist_WPML_Integration {

    private static $instance;

    /**
	 * Constuctor
	 * 
     * @return void
	 */
    private function __construct() {

        // Register Controllers
        $controllers = $this->get_controllers();
        Helper\Serve::register_services( $controllers );

    }

    /**
	 * Get Instance
	 * 
     * @return Directorist_WPML_Integration
	 */
    public static function get_instance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
	 * Get Controllers
	 * 
     * @return array $controllers
	 */
    private function get_controllers() {
        return [
            Controller\Asset\Init::class,
            Controller\Ajax\Init::class,
            Controller\Hook\Init::class,
        ];
    }

    /**
	 * __clone
	 * 
     * @return void
	 */
    public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __('Cheatin&#8217; huh?', 'directorist-wpml-integration'), '1.0' );
	}

    /**
	 * __wakeup
	 * 
     * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __('Cheatin&#8217; huh?', 'directorist-wpml-integration'), '1.0' );
	}

}