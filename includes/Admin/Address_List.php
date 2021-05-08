<?php

namespace crud\app\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
/**
 * used wp_list_table to create a table
 *
 * @since 1.0.0
 */
class Address_list extends \WP_List_Table {
    public function __construct() {
        parent::__construct(
            array(
                'singular' => 'contact',
                'plural'   => 'contacts',
                'ajax'     => false,
                'screen'   => null,
            )
        );
    }

    /**
     * Message to show if no designation found
     * 
     * @since 1.0.0
     *
     * @return void
     */
    function no_items() {
        esc_html_e( 'No address found', 'capp' );
    }

    /**
     * get columns
     *
     * @since 1.0.0
     */
    public function get_columns() {
        return array(
            'cb'         => '<input type="checkbox" />',
            'first_name' => __( 'Name', 'capp' ),
            'phone'      => __( 'Phone', 'capp' ),
            'created_at' => __( 'Date', 'capp' ),
        );
    }

    /**
     * declared sortable column
     *
     * @since 1.0.0
     *
     * @param null
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'first_name' => array( 'first_name', true ),
            'created_at' => array( 'created_at', true ),
        );

        return $sortable_columns;
    }
    /**
     * default column values
     *
     * @since
     *
     * @param mixed|mixed
     *
     * @return string
     */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
        case 'value':
            break;

        default:
            return isset( $item->$column_name ) ? $item->$column_name : '';
        }

    }

    /**
    * added checkbox
    *
    * @since 1.0.0
    *
    * @param mixed
    *
    * @return string
    */
    protected function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="address_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Render the "name" column
     *
     * @param  object $item
     *
     * @return string
     */
    public function column_first_name( $item ) {
        $actions = array();

        $actions['edit']   = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=crud-operation&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'capp' ), __( 'Edit', 'capp' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=wd-delete-address&id=' . $item->id ), 'wd-delete-address' ), $item->id, __( 'Delete', 'capp' ), __( 'Delete', 'capp' ) );

        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=crud-operation&action=view&id' . $item->id ), $item->first_name ." ". $item->last_name, $this->row_actions( $actions )
        );
    }

    /**
     * prepared items
     * 
     * @return void
     */
    public function prepare_items() {
        $column   = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $column, $hidden, $sortable );

        $per_page     = 20;
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;

        $args = array(
            'number' => $per_page,
            'offset' => $offset,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'];
        }
        $this->items = wd_get_address( $args );

        /**
         * added pagination in per page
         *
         * @since 1.0.0
         */
        $this->set_pagination_args(
            array(
                'total_items' => wd_address_count(),
                'per_page'    => $per_page,
            )
        );

    }
}