<?php

function pc4u_options_page() {

global $pc4u_options;
	ob_start(); ?>
	<div class="wrap">
		<h2>Postcodes4U Plugin Options</h2>
		<form method="post" action="options.php">
 
			<?php settings_fields('pc4u_settings_group'); ?>

			<h4><?php _e('Enable LookUp', 'pc4u_domain'); ?></h4>
				<p>
					<input id="pc4u_settings[enable]" name="pc4u_settings[enable]" type="checkbox" value="1" <?php checked('1', $pc4u_options['enable']); ?> />
					<label class="description" for="pc4u_settings[enable]"><?php _e('Enable the postcodes4U Lookup Form', 'pc4u_domain'); ?></label>
				
				</p>

			<p>Enter your Postcodes4U key and Username to link to your postcodes4U account. Login to your account at <a href="http://www.postcodes4u.co.uk"  target="_blank">Postcodes4U</a> for your account details.</p>
			
			<h4><?php _e('Postcodes4U Key', 'pc4u_domain'); ?></h4>
			
				<p>
					<input id="pc4u_settings[user_key]" name="pc4u_settings[user_key]" type="text" value="<?php echo $pc4u_options['user_key']; ?>"/>
					<label class="description" for="pc4u_settings[user_key]"><?php _e('Enter your Postcodes4U Key', 'pc4u_domain'); ?></label>
				
				</p>                     
 
			<h4><?php _e('Postcodes4U Username', 'pc4u_domain'); ?></h4>
				<p>
					<input id="pc4u_settings[user_name]" name="pc4u_settings[user_name]" type="text" value="<?php echo $pc4u_options['user_name']; ?>"/>
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

function pc4u_add_options_link() {
	add_options_page('PC4U Plugin Options', 'Postcodes4U', 'manage_options', 'pc4u-options', 'pc4u_options_page');
}
add_action('admin_menu', 'pc4u_add_options_link');

function pc4u_register_settings() {

	register_setting('pc4u_settings_group', 'pc4u_settings');
}
add_action('admin_init', 'pc4u_register_settings');

