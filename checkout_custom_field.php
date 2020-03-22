<?php
/*

prescription_fname
prescription_lname
prescription_id
prescription_number

*/

add_action('woocommerce_checkout_process', 'customised_checkout_field_process');

function customised_checkout_field_process(){
    //general fields

    if ( isset( $_POST['billing_phone'] ) && is_user_logged_in() != true) {
        $hasPhoneNumber= get_users('meta_value='.$_POST['billing_phone']);
        if ( !empty($hasPhoneNumber)) {
          //$validation_errors->add( 'billing_phone_error', __( '<strong>Error</strong>: Mobile number is already used!.', 'woocommerce' ) );
          wc_add_notice(__('מספר הטלפון כבר קיים במערכת ') , 'error');
        }
     }


    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            if($_product->get_id() == '3930'){
                if (!$_POST['legal_approval']) wc_add_notice(__('יש לאשר תנאי שימוש ומדיניות הפרטיות') , 'error');
                if (!$_POST['legal_approval_2']) wc_add_notice(__('יש לאשר את תקנון האתיקה') , 'error');
            }
        }
    }
}

/**

* Update the value given in custom field

*/

add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');

function custom_checkout_field_update_order_meta($order_id){
        if (!empty($_POST['license_number'])) {
            update_user_meta( get_current_user_id(), 'license_number', sanitize_text_field($_POST['license_number'])); 
        }

        if (!empty($_POST['billing_phone'])) {
            update_user_meta( get_current_user_id(), 'phone', sanitize_text_field($_POST['billing_phone'])); 
        }
        

        if (!empty($_POST['district'])) {
            update_user_meta( get_current_user_id(), 'district', sanitize_text_field($_POST['district'])); 
        }

        if (!empty($_POST['office_name'])) {
            update_user_meta( get_current_user_id(), 'office_name', sanitize_text_field($_POST['office_name'])); 
        }


        // if (!empty($_POST['legal_approval'])) {
        //     update_post_meta($order_id, 'legal_approval',sanitize_text_field($_POST['legal_approval']));
        // }
}
