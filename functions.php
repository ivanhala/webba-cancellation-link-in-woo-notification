add_action('woocommerce_order_item_meta_end', 'email_confirmation_display_order_items', 10, 4);
function email_confirmation_display_order_items($item_id, $item, $order, $plain_text) {
	if( ! (is_admin() || is_wc_endpoint_url() ) ) {
		if( $item->get_product_id() == get_option( 'wbk_woo_product_id', '' ) ){
			$cancel_link_text = get_option( 'wbk_email_landing_text_cancel', '' );
			$cancel_link_url  = get_option( 'wbk_email_landing', '' );
			$app_ids = explode( ',',  wc_get_order_item_meta( $item_id, 'IDs', true ) );
			$token_arr = array();
			foreach( $app_ids as $appointment_id ) {
				$token_arr[] = WBK_Db_Utils::getTokenByAppointmentId( $appointment_id );
			}
			$token = implode( '-', $token_arr );
			echo '<br><a target="_blank" target="_blank" href="' . $cancel_link_url . '?cancelation=' . $token . '">' . trim( $cancel_link_text ) . '</a>';
		}
	}
}
