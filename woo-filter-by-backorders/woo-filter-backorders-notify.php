<?php
/**
 * Plugin Name: Woo Filter By Backorders
 * Description: Add a filter by backorders to the product list page in WooCommerce.
 * Version: 1.0
 * Author: Leonid Tushov
 * Author URI: http://tushov.ru
 */
add_action( 'restrict_manage_posts', function ( $post_type ) {
	if ( $post_type == 'product' ) {
		echo '<select class="backorders" name="_backorders">';
		echo '<option value="">' . esc_html__( 'Filter by', 'woocommerce' ) . ': ' . esc_html__( 'Backorders?', 'woocommerce' ) . '</option>';
		foreach ( wc_get_product_backorder_options() as $key => $value ) {
			echo '<option value="' . esc_attr( $key ) . '"' . ( $_GET['_backorders']==$key ? ' selected' : '' ) . '>' . $value . '</option>';
		}
		echo '</select>';
	}
} );


add_action( 'pre_get_posts', function ( $query ) {
	global $pagenow;
	if ( $query->is_admin && $pagenow == 'edit.php' && isset( $_GET['_backorders'] ) && $_GET['_backorders'] != '' && $_GET['post_type'] == 'product' ) {
	  $query->set( 'meta_query', array(
	    array(
	      'key'     => '_backorders',
	      'value'   => esc_attr( $_GET['_backorders'] ),
	    )
	  ));
	}
});