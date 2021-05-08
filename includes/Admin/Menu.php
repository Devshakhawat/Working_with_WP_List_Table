<?php
namespace crud\app\Admin;
/**
 * declared menu class
 *
 * @since 1.0.0
 */
class Menu {

    public $address;

    /**
     * constructor declared
     *
     * @since 1.0.0
     */
    public function __construct( $address ) {
        $this->address = $address;
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * declared admin menu to show on admin panel
     *
     * @since 1.0.0
     *
     * @param null
     *
     * @return void
     */
    public function admin_menu() {
        $capability  = 'manage_options';
        $parent_slug = 'crud-operation';

        add_menu_page( __( 'Crud Operation', 'capp' ), __( 'Crud Operation', 'capp' ), $capability, $parent_slug, array( $this->address, 'update_operation' ), 'dashicons-yes' );
        add_submenu_page( $parent_slug, __( 'show crud operation', 'capp' ), __( 'Address Book', 'capp' ), $capability, $parent_slug, array( $this->address, 'update_operation' ) );
        add_submenu_page( $parent_slug, __( 'show settings operation', 'capp' ), __( 'Settings Operation', 'capp' ), $capability, 'crud-settings', array( $this, 'settings_operation' ) );
    }

    /**
     * added callback of settings field
     *
     * @since 1.0.0
     *
     * @param null
     *
     * @return void
     */
    public function settings_operation() {
        echo "hello from crud settings";
    }
}
