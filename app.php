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

        // Check Compatibility
        if ( version_compare( ATBDP_VERSION, '7.2', '<' ) ) {
            add_action( 'admin_notices', [ $this, 'show_incompatibility_notice' ], 1, 1 );
            return;
        }

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
            self::$instance = new Directorist_WPML_Integration();
        }

        return self::$instance;
    }

    /**
	 * Get Controllers
	 * 
     * @return array $controllers
	 */
    protected function get_controllers() {
        return [
            Controller\Setup\Init::class,
            Controller\Asset\Init::class,
            Controller\Ajax\Init::class,
            Controller\Hook\Init::class,
        ];
    }

    /**
	 * Show Incompatibility Notice
	 * 
     * @return void
	 */
    public function show_incompatibility_notice() {
        $title   = __( 'Directorist Update is Incomplete', 'directorist-wpml-integration' );
        $message = __( '<b>Directorist WPML Integration</b> extension requires <b>Directorist 7.2</b> or higher to work', 'directorist-wpml-integration' );

        ?>
        <div class="notice notice-error">
            <h3><?php echo $title; ?></h3>
            <p><?php echo $message; ?></p>
        </div>
        <?php
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