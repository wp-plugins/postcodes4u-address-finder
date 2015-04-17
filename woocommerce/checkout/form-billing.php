<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 * 
 * MODIFIED BY 3x SW For Postcodes 4u Lookup. 15/04/2015
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}



/** @global WC_Checkout $checkout */

global $pc4u_options;
$extra_content = '<p><form action="post" name="" target="#">';


?>
<div class="woocommerce-billing-fields">
<?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'Billing Details', 'woocommerce' ); ?></h3>

	<?php endif; ?>

    
	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout );     
                   
      if($pc4u_options['woointegrate'] == true || $pc4u_options['woointegrate'] == '1') { 
            // Do Special Postcode4u Lookup Stuff - Add Postcode Lookup Field 
    ?>
           <label for="billing_postcode" class="">Billing Postcode</label>
           <input type="text" class="input-text " name="billing_postcode" id="billing_postcode" placeholder=""  value=""  /></p>          
           <input onclick="Pc4uWooSearchBookingBegin(); return false;" type="submit" value="Postcode Lookup" id="Pc4uLookup" name="wooBilling" />
           <select id="pc4uWooBillingDropdown" style="display: none;" onchange="Pc4uSearchIdBegin('pc4uWooBilling')"><option>Select an address:</option></select>    
           <div id="postcodes4ukey" style="display: none;" ><?php echo $pc4u_options['user_key'];?></div>
            <div id="postcodes4uuser" style="display: none;" ><?php echo $pc4u_options['user_name'];?> </div>           
   <?php
            foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : 
                if( $key != "billing_postcode" ) {
                    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); 
                }
            endforeach;            
        } else {
            // Normal Billing Form          
           foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : 
               woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); 
           endforeach;
        }
    ?>

	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>

	<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

		<?php if ( $checkout->enable_guest_checkout ) : ?>

			<p class="form-row form-row-wide create-account">
				<input class="input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>


			<div class="create-account">

				<p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>

				<?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?>

					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

				<?php endforeach; ?>

				<div class="clear"></div>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

	<?php endif; ?>
</div>

<script>
    jQuery(document).ready(function ($) {
        var currVal = $('.currency .wcml_currency_switcher option:selected').val();
        $('.woocommerce-billing-fields').addClass(currVal);
        if (currVal == 'CHF') {
            //Switzerland+ENG
            $('.chosen-results li').removeClass('result-selected');
            $('.chosen-results li:eq(76)').addClass('result-selected');
            $('.chosen-container-single .chosen-single span').text($('.chosen-results li:eq(76)').text());
            $('#billing_country option:eq(32)').attr('selected', true).change();

        }

        else if (currVal == 'GBP') {
            //UK+ENG
            $('.chosen-results li').removeClass('result-selected');
            $('.chosen-results li:eq(76)').addClass('result-selected');
            $('.chosen-container-single .chosen-single span').text($('.chosen-results li:eq(76)').text());
            $('#billing_country option:eq(33)').attr('selected', true).change();
        }

        else {
            //Rest of the world + EMG
            $('.chosen-results li').removeClass('result-selected');
            $('.chosen-results li:eq(76)').addClass('result-selected');
            $('.chosen-container-single .chosen-single span').text($('.chosen-results li:eq(76)').text());
            $('#billing_country option:eq(0)').attr('selected', true).change();
        }
    });
    </script>
