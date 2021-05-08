<div class='wrap'>
    <h1 class="wp-heading-inline"><?php esc_html_e( 'New Address', 'capp' ) ?></h1>
    <a class="page-title-action" href="<?php echo admin_url( 'admin.php?page=crud-operation&action=new') ?>"><?php _e('Add New', 'capp') ?></a>
    <form method= "post">
        <table class= "form-table">
            <tr>
                <th><label for="fname"><?php esc_html_e('first name', 'capp') ?></label></th>
                <td><input type="text" id="fname" name="fname">
                    <?php if ( $this->has_error( 'fname' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error( 'fname' ); ?></p>
                        <?php } ?>
                </td>
            </tr>

            <tr>
                <th><label for="lname"><?php esc_html_e('last name', 'capp') ?></label></th>
                <td><input type="text" id="lname" name="lname"></td>
            </tr>

            <tr>
                <th><label for="phn"><?php esc_html_e('Phone', 'capp') ?></label></th>
                <td><input type="phone" id="phn" name="phnno"></td>
            </tr>
        </table>

        <?php wp_nonce_field( 'new-address' ); ?>
        <?php submit_button( __('Submit', 'capp' ), 'primary', 'submit_button'); ?>
    </form>
</div>
