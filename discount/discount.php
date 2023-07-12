<?php
/*
 * Plugin Name: Discount
 * Description: Discount for Product
 * Version: 1.0
 */

if(!defined('ABSPATH')){
    header("Location: /");
    die("");
}

function discount_activation(){
    //
}

function discount_deactivation() {

//
}


register_activation_hook(
	__FILE__,
	'discount_activation'
);

register_deactivation_hook(
	__FILE__,
	'discount_deactivation'
);

function discount_func (){
    include 'admin/discount.php' ;
}


function discount_menu() {
    add_menu_page('Discount', 'Discount Option' , 'manage_options', 'discountPage','discount_func','',6);
}
add_action( 'admin_menu', 'discount_menu');

function woocommerce_discount_display(){
    $id = get_the_ID();
    $discount = get_post_meta($id,"WooDiscount");
    if ($discount != NULL) {
        echo "<p>Discount : ".$discount[0]."%</p>";
    }
    
    

}
add_action( 'woocommerce_single_product_summary', 'woocommerce_discount_display', 15 );



    
?>