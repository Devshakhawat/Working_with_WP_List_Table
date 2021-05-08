<?php
namespace crud\app\Admin;
use crud\app\Traits\Form_Error;

/**
 * declared address class
 *
 * @since 1.0.0
 */
class Address {

    use Form_Error;

    /**
     * update operation
     *
     * @since 1.0.0
     *
     * @param null
     *
     * @return void
     */
    public function update_operation() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
        case 'new':
            $template = __DIR__ . '/views/address-new.php';
            break;
        case 'edit':
            $address  = wd_get_addresses( $id );
            $template = __DIR__ . '/views/address-edit.php';
            break;
        case 'view':
            $template = __DIR__ . '/views/address-view.php';
            break;
        default:
            $template = __DIR__ . '/views/address-list.php';
            break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * form handler declared
     *
     * @since 1.0.0
     *
     * @param null
     *
     * @return void
     */
    public function form_handler() {

        if ( ! isset( $_POST['submit_button'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-address' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        $id    = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
        $fname = isset( $_POST['fname'] ) ? sanitize_text_field( $_POST['fname'] ) : '';
        $lname = isset( $_POST['lname'] ) ? sanitize_text_field( $_POST['lname'] ) : '';
        $phnno = isset( $_POST['phnno'] ) ? sanitize_text_field( $_POST['phnno'] ) : '';

        if ( empty( $fname ) ) {
            $this->errors['fname'] = __( 'Please provide first name', 'capp' );
        }

        if ( empty( $lname ) ) {
            $this->errors['lname'] = __( 'Please provide a last name', 'capp' );
        }

        if ( empty( $phnno ) ) {
            $this->errors['phnno'] = __( 'Please provide phone number', 'capp' );
        }

        if ( ! empty( $this->errors ) ) {
            return;
        }

        $args = array(
            'first_name' => $fname,
            'last_name'  => $lname,
            'phone'      => $phnno,
        );

        $insert_id = wd_insert_address( $args );

        if ( is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        if ( $id ) {
            $redirect_to = admin_url( 'admin.php?page=crud-operation&action=edit&address-updated=true&id=' . $id );
        } else {
            $redirect_to = admin_url( 'admin.php?page=crud-operation&inserted=true' );
        }

        wp_redirect( $redirect_to );
        exit;
    }

    /**
     * delete form values
     *
     * @since 1.0.0
     *
     * @param null
     *
     * @return void
     */
    public function delete_address() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wd-delete-address' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

        if ( wd_delete_address( $id ) ) {
            $redirected_to = admin_url( 'admin.php?page=crud-operation&address-deleted=true' );
        } else {
            $redirected_to = admin_url( 'admin.php?page=crud-operation&address-deleted=false' );
        }

        wp_redirect( $redirected_to );
        exit;
    }
}
