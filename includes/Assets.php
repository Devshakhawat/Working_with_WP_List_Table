<?php
namespace crud\app;

class Assets {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets'] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets'] );
    }

    public function enqueue_assets() {
        wp_register_script( 'wd-load-script', CRUD_APP_ASSETS . '/js/frontend.js', false, filemtime( CRUD_APP_PATH . '/assets/js/frontend.js' ), true);
        wp_register_style( 'wd-load-style', CRUD_APP_ASSETS . '/css/frontend.css', false, filemtime( CRUD_APP_PATH . '/assets/css/frontend.css' ), true);
        
        wp_enqueue_script('wd-load-script');
        wp_enqueue_style('wd-load-style');
    }
}
