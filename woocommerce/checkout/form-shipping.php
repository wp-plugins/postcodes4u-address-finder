<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 * MODIFIED BY 3x SW For Postcodes 4u Lookup. 15/04/2015
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

global $pc4u_options;
$extra_content = '<p><form action="post" name="" target="#">';


?>
<div class="woocommerce-shipping-fields">
	<?php if ( WC()->cart->needs_shipping_address() === true ) : ?>

		<?php
			if ( empty( $_POST ) ) {

				$ship_to_different_address = get_option( 'woocommerce_ship_to_destination' ) === 'shipping' ? 1 : 0;
				$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

			} else {

				$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

			}
		?>

		<h3 id="ship-to-different-address">
			<label for="ship-to-different-address-checkbox" class="checkbox"><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></label>
			<input id="ship-to-different-address-checkbox" class="input-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
		</h3>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout );
                  if($pc4u_options['woointegrate'] == true || $pc4u_options['woointegrate'] == '1') { 
                // Do Special Postcode4u Lookup Stuff - Manually Add Postcode Field 
            ?>
                <label for="shipping_postcode" class="">Shipping Postcode</label>
                <input type="text" class="input-text" name="shipping_postcode" id="shipping_postcode" placeholder=""  value=""  /></p>          
                <input onclick="Pc4uWooSearchShippingBegin(); return false;" type="submit" value="Postcode Lookup"/>
                <select id="pc4uWooShippingDropdown" style="display: none;" onchange="Pc4uSearchIdBegin('pc4uWooShipping')"><option>Select an address:</option></select>    
                <div id="postcodes4ukey" style="display: none;" ><?php echo $pc4u_options['user_key'];?></div>
                <div id="postcodes4uuser" style="display: none;" ><?php echo $pc4u_options['user_name'];?> </div>           
         <?php
                foreach ( $checkout->checkout_fields['shipping'] as $key => $field ) : 
                    if( $key != "shippingpostcode" ) {
                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); 
                    }
                endforeach;            
            } else {
                // Normal Shipping Form          
                foreach ( $checkout->checkout_fields['shipping'] as $key => $field ) : 
                    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); 
                endforeach;
            }
        ?>

     	    <?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) : ?>

			<h3><?php _e( 'Additional Information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>