<?php

function pc4u_options_page() {

global $pc4u_options;
	ob_start(); ?>
	<div class="wrap">
		<h2>Postcodes4U Plugin Options</h2>
        <form method="post" action="options.php">
 
            
        
			<?php settings_fields('pc4u_settings_group');
            
            // Process Current/Default settings
            
            $currentSettings = get_option('pc4u_settings');
            $currentPc4uEnable = '0';
            $currentWoocommerce = '0';
            $currentPc4uUserName = '';
            $currentPc4uUserKey = '';
            
            if(isset($currentSettings['enable']) ) {
                $currentPc4uEnable = $currentSettings['enable'] ;
            }
              if(isset($currentSettings['woointegrate']) ) {
                // Only Allow If Postcode Integration Enabled Commerce Integration Enabled
                if($currentPc4uEnable == '1') {
                    $currentWoocommerce = $currentSettings['woointegrate'] ;
                }
            }
           
            if(isset($currentSettings['user_name']) ) {
                $currentPc4uUserName = $currentSettings['user_name'] ;
            }
            if(isset($currentSettings['user_key']) ) {
                $currentPc4uUserKey = $currentSettings['user_key'] ;
            }
            ?>

               <h4><?php _e('Enable Postodes4u Integration in WooCommerce Checkout', 'pc4u_domain'); ?></h4>
				<p>
					<input id="pc4u_settings[woointegrate]" name="pc4u_settings[woointegrate]" type="checkbox" value="1" <?php checked('1', $currentWoocommerce); ?> />
					<label class="description" for="pc4u_settings[woointegrate]"><?php _e('Enable the postcodes4U Lookup in WooCommerce Checkout', 'pc4u_domain'); ?></label>				
				</p>
            
			<h4><?php _e('Enable Test LookUp Form', 'pc4u_domain'); ?></h4>
				<p>
					<input id="pc4u_settings[enable]" name="pc4u_settings[enable]" type="checkbox" value="1" <?php checked('1',$currentPc4uEnable); ?> />
					<label class="description" for="pc4u_settings[enable]"><?php _e('Enable the postcodes4U Lookup Form', 'pc4u_domain'); ?></label>				
				</p>
           	                                     
                <h4>Enter your Postcodes4U key and Username to link to your postcodes4U account. Login to your account at <a href="http://www.postcodes4u.co.uk"  target="_blank">Postcodes4U</a> for your account details.</h4>
			
			<h4><?php _e('Postcodes4U Key', 'pc4u_domain'); ?></h4>
			
				<p>
					<input id="pc4u_settings[user_key]" name="pc4u_settings[user_key]" type="text" value="<?php echo $currentPc4uUserKey; ?>"/>
					<label class="description" for="pc4u_settings[user_key]"><?php _e('Enter your Postcodes4U Key', 'pc4u_domain'); ?></label>
				
				</p>                     
 
			<h4><?php _e('Postcodes4U Username', 'pc4u_domain'); ?></h4>
				<p>
					<input id="pc4u_settings[user_name]" name="pc4u_settings[user_name]" type="text" value="<?php echo $currentPc4uUserName; ?>"/>
					<label class="description" for="pc4u_settings[user_name]"><?php _e('Enter your Postcodes4U Username', 'pc4u_domain'); ?></label>
				
				</p>		
					
 
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Options', 'pc4u_domain'); ?>" />
				</p>
 
		</form>
	</div>
	<?php
	echo ob_get_clean();
}

function pc4u_validate_settings( $pc4uInput ) {
    // If No User Details Then mark Postcodes4u as not enabled
    if( trim($pc4uInput['user_name']) === '' || trim($pc4uInput['user_key'] === '')) {
        // NO User Details - DISABLE POSTCODES 4u
         $pc4uInput['enable'] = '0';
         $pc4uInput['woointegrate'] = '0';
         add_settings_error( 'pc4u_settings',  esc_attr( 'settings_updated' ),
                                'You cannot enable the Postcodes4u Postcode Lookup without entering a Username and Key', 'pc4u_domain' );      
     }
     return $pc4uInput;
}

function pc4u_add_options_link() {
	add_options_page('PC4U Plugin Options', 'Postcodes4U', 'manage_options', 'pc4u-options', 'pc4u_options_page');
}
add_action('admin_menu', 'pc4u_add_options_link');

function pc4u_register_settings() {

	register_setting('pc4u_settings_group', 'pc4u_settings', 'pc4u_validate_settings');
}
add_action('admin_init', 'pc4u_register_settings');

