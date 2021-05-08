<?php
namespace crud\app;

/**
 * added admin class
 *
 * @since 1.0.0
 */
class Admin {
    public $name = 'Admin';

    /**
     * declared constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        $address = new Admin\Address();
        new Admin\Menu( $address );
        $this->dispatch_action( $address );
    }

    /**
     * declared function to dispatch
     * 
     * @param object $address
     *
     * @since 1.0.0
     */
    public function dispatch_action( $address ) {
        add_action( 'admin_init', array( $address, 'form_handler' ) );
        add_action( 'admin_post_wd-delete-address', array( $address, 'delete_address' ) );
    }
}
