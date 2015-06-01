=== Postcodes4U Address Finder ===
Contributors: 3X Software
Tags: postcode, lookup, address finder, address verification, woocommerce
Requires at least: 3.0.1
Tested up to: 4.2.2
Requires WooCommerce at least: 2.2.3
Tested WooCommerce up to: 2.3.9
Stable tag: trunk

"Postcodes4U Address Finder" lets you look up an address using a UK Postcode. 
Includes WooCommerce Integration and a Postcode Lookup Contact Form.


== Description ==

"Postcodes4U Address Finder" Lets you look up an address using a UK Postcode. 
If you are using WooCommerce on your site you can add postcode lookup to the checkout form.
A customisable Contact Form with Postcode lookup can be added to any of your pages. 

= Please Note =

THIS POSTCODE LOOKUP IS A UK ONLY SERVICE SO WILL NOT WORK FOR ANY OTHER COUNTRY.

THIS PLUGIN REQUIRES YOU TO REGISTER AT: http://www.postcodes4u.co.uk WHERE YOU WILL RECIEVE 30 FREE CREDITS ON REGISTRATION

ADDITIONAL LOOKUP CREDITS CAN BE PURCHASED FROM 1.4P PER LOOKUP UP TO 5P PER LOOKUP DEPENDING ON THE VOLUME PURCHASED

CREDITS CAN BE PURCHASED VIA THE LINKS PROVIDED WITHIN THE PLUGIN.



= Technical features: =

* 100% user friendly, easy to install & remove
* Lightweight, clean code
* Works with WooCommerce 2.2.3 - 2.3.9
   
   
== Installation ==

= To Install The Postcodes4u Plugin =

1. Install the plugin from your wordpress admin panel.

OR

1. Upload the Postcodes4U plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

Once Installed enter your Postcodes4U key and username.

Once the plugin has been activated and you have entered your key and username you can use the postcode lookup form on the newly created postcodes4u page. (visible to admins only)

If you have WooCommerce installed and have enabled 'WooCommerce Integration' on the settings page your customers can use post code lookups in the checkout billing and shipping addresses to ensure accurate entry details.

The Postcode Lookup Contact form can be added by simply placing a short code '[pc4u_contact_form]' on the required page. Full details on the customisation settings for the contact form are described in 'Other Notes'.

== Postcodes4u Contact Form ==

To Add the Postcode Lookup Contact form use the following shortcode:

' [pc4u_contact_form] '

By default the short code will display the telephone and postal address fields but does not require them be be entered when the contact form is submitted.

To add a Contact Form that requires the telephone number and postal address to be present use the short code with attributes shown below:

' [pc4u_contact_form musthavetelephone="YES" musthaveaddress="YES] '
   

= Postcodes4u Contact Form Customisation =

A full list of the contact form attributes 

**contacttitle**  - Name of Contact Form - defaults to "Contact Us"

**subjecttitle**  - Contact Form Subject Title - defaults to "Subject"

**messagetitle**  - Contact Form Message Title - defaults to "Your Message"

**showtelephone** - Set to "TRUE" or "YES" to display telephone number input area, "FALSE" or "NO" to not display - Default is "YES"

**musthavetelephone** - Set to "TRUE" or "YES" if a telephone number must be included in the message,"FALSE" or "NO" to not display  -  Default is "NO"

**showaddress**   - Set to "TRUE" or "YES" to display postal address input area, "FALSE" or "NO" to not display - Default is "YES"

**musthaveaddress** - Set to "TRUE" or "YES" if a postal address must be included in the message,"FALSE" or "NO" to not display  -  Default is "NO"

	
A Contact Form Shortcode example that sets all of the parameters follows:

' [pc4u_contact_form contacttitle="Send Us A Message" subjecttitle="Message Subject" messagetitle="Message" showtelephone="YES" musthavetelephone="YES" showaddress="YES" musthaveaddress="YES"] '




== Frequently Asked Questions ==

= Do I need a Postcodes4U account to use this plugin? =

Yes, you will need a Postcodes4U account in order to obtain your key and username. Once you have registered you will then receive 30 free credits. 


= How do I get free credits =

Register for an account at <http://www.postcodes4u.co.uk> for 30 free credits. 

= Do you offer address look-ups for other countries? =

Currently we only offer address look ups to the UK.#

= Woo Commerce Compatibility =
Works,and tested with,  WooCommerce 2.2.3 - 2.3.9 (The Current Version)

= Contact Form With Postcode Lookup =
The Plugin Contact form short code and customisation settings are described in 'Other Notes'.

== Screenshots ==

1. Simple interface to add your Postcodes4U details

2. Contact form with Postcodes4U Postcode Lookup

3. Integrates into WooCommerce Checkout 

4. Simple address look up form for Postcodes4U 


== Changelog ==

= Version 1.2 =
* Added Shortcode customisable Contact Form with Postcode Lookup.

= Version 1.1 =
* Added WooCommerce Checkout Billing and Shipping Postcode Lookup Integration.

= Version 1.0 =
* Original 'Blog' form verion.





== Upgrade Notice ==
