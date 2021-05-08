<?php
/**
 * Insert data to custom database created by us
 *
 * @since 1.0.0
 *
 * @param array $args
 *
 * @return int|object
 */
function wd_insert_address( $args = array() ) {
    global $wpdb;

    if ( empty( $args['first_name'] ) ) {
        return new WP_Error( 'no-name', __( 'You must provide functions first name', 'capp' ) );
    }

    $defaults = array(
        'first_name' => '',
        'last_name'  => '',
        'phone'      => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time( 'mysql' ),
    );

    $data = wp_parse_args( $args, $defaults );

    if ( isset( $data['id'] ) ) {
        $id = $data['id'];
        unset( $data['id'] );

        $updated = $wpdb->update(
            "{$wpdb->prefix}wd_address",
            $data,
            array( 'id' => $id ),
            array(
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            ),
            array( '%d' )
        );

        return $updated;

    } else {
        $inserted = $wpdb->insert(
            "{$wpdb->prefix}wd_address",
            $data,
            array(
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            )
        );

        if ( ! $inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'failed to insert data', 'capp' ) );
        }

        return $wpdb->insert_id;
    }
}

/**
 * fetched data
 *
 * @since 1.0.0
 *
 * @param
 *
 * @return array
 */
function wd_get_address( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'numbers' => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC',
    );

    $args = wp_parse_args( $args, $defaults );

    $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wd_address order by {$args['orderby']}
            {$args['order']} LIMIT %d, %d", $args['offset'], $args['numbers'] );

    $items = $wpdb->get_results( $sql );
    return $items;
}

/**
 * count total inserts in this table
 *
 * @since 1.0.0
 *
 * @param null
 *
 * @return int
 */
function wd_address_count() {
    global $wpdb;

    return (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wd_address" );
}

/**
 * Fetch a single contact from the DB
 *
 * @param  int $id
 *
 * @return object
 */
function wd_get_addresses( $id ) {
    global $wpdb;

    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wd_address WHERE id = %d", $id )
    );
}

/**
 * Delete an address
 *
 * @param  int $id
 *
 * @return int|boolean
 */
function wd_delete_address( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'wd_address',
        array( 'id' => $id ),
        array( '%d' )
    );
}
