<?php
/**
 * Plugin Name: Crud App
 * Plugin URI: wedevs.com
 * Description: In this plugin I will show operations with WP database
 * Version: 1.0.0
 * Author: Shakhawat
 * Author URI: shakhawat.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: capp
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Declared class to execute cruds
 *
 * @since 1.0.0
 */
final class crud_app {
    /**
     * call necessary methods
     *
     * @since 1.0.0
     */
    private function __construct() {
        $this->constants_declared();
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        add_action( 'plugins_loaded', array( $this, 'admin_init' ) );

    }

    /**
     * declared admin init
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function admin_init() {
        new \crud\app\Assets();

        if ( is_admin() ) {
            new crud\app\Admin();
        } else {
            new crud\app\Frontend();
        }
    }

    /**
     *
     *
     * @since
     *
     * @param
     *
     * @return
     */
    public function activate() {
        $installer = new crud\app\Installer();
        $installer->run();
    }

    /**
     * constant declaration
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function constants_declared() {
        define( 'CRUD_APP_FILE', __FILE__ );
        define( 'CRUD_APP_PATH', __DIR__ );
        define( 'CRUD_APP_URL', plugins_url( '', CRUD_APP_FILE ) );
        define( 'CRUD_APP_ASSETS', CRUD_APP_URL . '/assets' );

    }

    /**
     * singletone pattern instantiate
     *
     * @since 1.0.0
     *
     * @param null
     *
     * @return obj
     */
    public static function init() {
        static $instantiate = false;

        if ( ! $instantiate ) {
            $instantiate = new self();
        }
        return $instantiate;
    }
}

function execute_insiders() {
    return crud_app::init();
}
execute_insiders();
