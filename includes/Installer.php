<?php
namespace crud\app;

/**
* declared installer class
*
* @since 1.0.0
*/
class Installer {
    public function run() {
        $this->create_tables();
    }

    /**
     * created necessary DB function
     *
     * @since 1.0.0
     *
     * @param null
     *
     * @return void
     */
    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE if not exists `{$wpdb->prefix}wd_address` ( `id` INT(20) NOT NULL AUTO_INCREMENT , `first_name` VARCHAR(100) NOT NULL , `last_name` VARCHAR(100) NOT NULL , `phone` VARCHAR(30) NOT NULL , `created_by` BIGINT(30) NOT NULL , `created_at` INT(30) NOT NULL , PRIMARY KEY (`id`)) $charset_collate";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }
}
