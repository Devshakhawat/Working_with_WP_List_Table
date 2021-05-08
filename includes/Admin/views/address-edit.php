<div class='wrap'>
    <h1 class="wp-heading-inline"><?php esc_html_e( 'Edit Address', 'capp' ) ?></h1>
    <?php if ( isset( $_GET['address-updated'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php esc_html_e( 'Address has been updated successfully!', 'capp' ); ?></p>
        </div>
    <?php } ?>

    <form method= "post">
        <table class= "form-table">
            <tr>
                <th><label for="fname"><?php esc_html_e('first name', 'capp') ?></label></th>
                <td><input type="text" id="fname" name="fname" value="<?php 
                if( 
                    !empty( esc_attr($address->first_name) ) ) {
                        echo esc_attr( $address->first_name );
                    } 
                    ?>">

                    <?php if ( $this->has_error( 'fname' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error( 'fname' ); ?></p>
                        <?php } ?>
                </td>
            </tr>
            <tr>
                <th><label for="lname"><?php esc_html_e('last name', 'capp') ?></label></th>
                <td><input type="text" id="lname" name="lname" value="<?php 
                if( 
                    !empty( esc_attr($address->last_name) ) ) {
                        echo esc_attr( $address->last_name );
                    } 

                    ?>"></td>
            </tr>
            <tr>
                <th><label for="phn"><?php esc_html_e('Phone', 'capp') ?></label></th>
                <td><input type="phone" id="phn" name="phnno" value="<?php 
                if( 
                    !empty( esc_attr($address->phone) ) ) {
                        echo esc_attr( $address->phone );
                    } 

                    ?>"></td>
            </tr>
        </table>
        <input type="hidden" name="id" value="<?php echo esc_attr( $address->id ); ?>">            
        <?php wp_nonce_field( 'new-address' ); ?>
        <?php submit_button( __('Update', 'capp' ), 'primary', 'submit_button'); ?>
    </form>

</div>