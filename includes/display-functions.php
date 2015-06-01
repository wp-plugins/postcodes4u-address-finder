<?php

// Postcodes 4u Test Page Code
// ----------------------------
//
function pc4u_add_content($content) {

global $pc4u_options;

	if(is_page('postcodes4u') && $pc4u_options['enable'] ==true) {
        
		$extra_content = '<p><form action="post" name="" target="#">
<p><form action="post" name="" target="#">
<h2>Postcode Look-up</h2>
<div id="postcodes4ukey" style="display: none;">';
		$extra_content .=  $pc4u_options['user_key'] . '</div>
<div id="postcodes4uuser" style="display: none;">';
		$extra_content .= $pc4u_options['user_name'] . '</div>
<div id="WooInt" style="display: none;">';
		$extra_content .= $pc4u_options['woointegrate'] . '</div>
<table>
<tbody>
<tr>
<td>Postcode</td>
<td><input id="pc4uPostcode" type="text" value="" /></td>
<td><input onclick="Pc4uSearchBegin();return false;" type="submit" value="Lookup" />

<select id="pc4uDropdown" style="display: none;" onchange="Pc4uSearchIdBegin()"><option>Select an address:</option></select></td>
</tr>
<tr>
<td>Company</td>
<td><input id="pc4uCompany" type="text" value="" /></td>
</tr>
<tr>
<td>Address 1</td>
<td><input id="pc4uAddress1" type="text" value="" /></td>
</tr>
<tr>
<td>Address 2</td>
<td><input id="pc4uAddress2" type="text" value="" /></td>
</tr>
<tr>
<td>Town</td>
<td><input id="pc4uTown" type="text" value="" /></td>
</tr>
<tr>
<td>County</td>
<td><input id="pc4uCounty" type="text" value="" /></td>
</tr>
</tbody>
</table>
</form></p>';
      $content .= $extra_content;
	}
	return $content;
}
add_filter('the_content', 'pc4u_add_content');




// -----------------------------------------------------------------------------

// Postcodes 4u CONTACT FORM
// ==========================

// Global Variables
$contactMustHaveTelephone = true; 
$contactMustHaveAddress = true ;


// Activate PC4u Shortcode
function pc4u_shortcode($shortcode_atts ) {
    ob_start();
    pc4u_contactform_send();
    pc4u_contactform_html($shortcode_atts);
 
    return ob_get_clean();
}



// Postcodes 4u CONTACT FORM HTML
// ==============================
function pc4u_contactform_html($atts) {

    global $pc4u_options;

    // Process Attributes - Set Defaults
    // No Prefilled Subject & Message, Show Telephone & Address - But Not Compulsary
       
    extract( shortcode_atts( array(
        'contacttitle' => 'Contact Us',
        'subjecttitle' => 'Subject',
        'messagetitle' => 'Your Message',
        'showtelephone' => '',
        'musthavetelephone' => '',
        'showaddress' => '',
        'musthaveaddress' => ''      
    ), $atts ) );

    $contactShowTelephone = true;
    $contactShowAddress = true;
    
    $GLOBALS['contactMustHaveTelephone'] = false ;
    $GLOBALS['contactMustHaveAddress'] = false ;
    
    // Process Telephone Flags
    if(!empty($showtelephone)){
      // Show Telephone Default True
      $showtelephone = strtoupper(trim($showtelephone));
      if($showtelephone !== "YES" && $showtelephone !== "TRUE") {
        $contactShowTelephone = false ;
      }
    }
    
     // If MUST HAVE Telephone is true then make sure it is displayed
    if(!empty($musthavetelephone)){
       // Must Have Telephone Default False
        $musthavetelephone = strtoupper(trim($musthavetelephone));
        if($musthavetelephone == "YES" || $musthavetelephone == "TRUE") {
            $GLOBALS['contactMustHaveTelephone']= true ;
            $contactShowTelephone = true;  // If 'Must Have' Make Sure Displayed
        }      
    }
  
    // Process Address Flags
    if(!empty($showaddress)){
        // Show Address Default True
        $showaddress = strtoupper(trim($showaddress));
        if($showaddress !== "YES" && $showaddress !== "TRUE") {
            $contactShowAddress = false ;
        }
    }
    // If MUST HAVE Address is true then make sure it is displayed

    if(!empty($musthaveaddress)){
     // Must Have Address Default False
      $musthaveaddress = strtoupper(trim($musthaveaddress));
      if($musthaveaddress == "YES" || $musthaveaddress == "TRUE") {
        $GLOBALS['contactMustHaveAddress'] = true ;
        $contactShowAddress = true ; // If 'Must Have' Make Sure Displayed
      }
    }
    
    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<div id=Pc4uContact >';
    echo '<h2>'. $contacttitle. '</h2>';
    echo '<div id="postcodes4ukey" style="display: none;">' . $pc4u_options['user_key'] . '</div>';
    echo '<div id="postcodes4uuser" style="display: none;">'. $pc4u_options['user_name'] . '</div>';
    echo '<div id="WooInt" style="display: none;">' . $pc4u_options['woointegrate'] . '</div>';
    echo '<table><tbody>';
    echo '<tr><p><strong>Your Name*</strong><br/>';
    echo '<input name="pc4uName" type="text"  pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["pc4uName"] ) ? esc_attr( $_POST["pc4uName"] ) : "" ) . '" size="40" />';
    echo '</p> </tr>';
    echo '<tr><p><strong>'. $subjecttitle.'* <br/>';
    echo '<input name="pc4uSubject" type="text" value="' . ( isset( $_POST["pc4uSubject"] ) ? esc_attr( $_POST["pc4uSubject"] ) :'' ) . '" size="40" />';
    echo '</p></tr>';
    echo '<tr><p><strong>'.$messagetitle. '*</strong> <br/>';
    echo '<textarea rows="5" cols="35" name="pc4uMessage">' . ( isset( $_POST["pc4uMessage"] ) ? esc_attr( $_POST["pc4uMessage"] ) : '') . '</textarea>';
    echo '</p></tr>';
    echo '<tr><p><strong>Email Address*</strong><br/>';
    echo '<input name="pc4uEmail" type="text" value="' . ( isset( $_POST["pc4uEmail"] ) ? esc_attr( $_POST["pc4uEmail"] ) : "" ) . '" size="40" />';
    echo '<p></tr>';

    // Display Telephone If Required
    if($contactShowTelephone) {
        echo '<tr><p><strong>Telephone Number';
        echo '</strong><br/>';
        echo '<input name="pc4uTelephone" type="text" value="' . ( isset( $_POST["pc4uTelephone"] ) ? esc_attr( $_POST["pc4uTelephone"] ) : "" ) . '" size="40" />';
        echo '</p></tr>';
    }
               
    // Display Address If Required
    if($contactShowAddress) {
        echo '<tr><strong>Postal Address';
        
        echo '</strong><br/>';
        echo '<tr><td><strong>Postcode</strong></td>';
        echo '<td><input id="pc4uPostcode" name="pc4uPostcode"type="text" value="' . ( isset( $_POST["pc4uPostcode"] ) ? esc_attr( $_POST["pc4uPostcode"] ) : "" ) . '" size="12"/>&nbsp&nbsp';
        echo '<input onclick="Pc4uSearchBegin();return false;" type="submit" value="Lookup Postcode" /></td></tr>';
        echo '<tr><td> </td><td><select id="pc4uDropdown" name="pc4uDropdown" style="display: none;" onchange="Pc4uSearchIdBegin()"><option>Select an address:</option></select></td></tr>';
        echo '<tr><td><strong>Company</strong></td>';
        echo '<td><input id="pc4uCompany" name="pc4uCompany" type="text" value="' . ( isset( $_POST["pc4uCompany"] ) ? esc_attr( $_POST["pc4uCompany"] ) : "" ) . '" />';
        echo '</td></tr>';
        echo '<tr><td><strong>Address 1</strong></td>';
        echo '<td><input id="pc4uAddress1" name="pc4uAddress1" type="text"value="' . ( isset( $_POST["pc4uAddress1"] ) ? esc_attr( $_POST["pc4uAddress1"] ) : "" ) . '" />';
        echo '</td></tr>' ;
        echo '<tr><td><strong>Address 2</strong></td>';
        echo '<td><input id="pc4uAddress2" name="pc4uAddress2" type="text" value="' . ( isset( $_POST["pc4uAddress2"] ) ? esc_attr( $_POST["pc4uAddress2"] ) : "" ) . '" />';
        echo '</td></tr>';
        echo '<tr><td><strong>Town</strong></td>';
        echo '<td><input id="pc4uTown" name="pc4uTown" type="text"value="' . ( isset( $_POST["pc4uTown"] ) ? esc_attr( $_POST["pc4uTown"] ) : "" ) . '" />';
        echo '</td></tr>';
        echo '<tr><td><strong>County</strong></td>';
        echo '<td><input id="pc4uCounty" name="pc4uCounty" type="text"value="' . ( isset( $_POST["pc4uCounty"] ) ? esc_attr( $_POST["pc4uCounty"] ) : "" ) . '" />';
        echo '</td></tr>';
    }
    echo '<tr><td colspan=2><strong>* Required Field</strong></td></tr>';
    echo '<tr><td colspan=2><input type="submit" name="pc4u-submitted" value="Send Message" style="font-weight: bold;"/></td></tr>';
    echo '</tbody></table>';
    echo '</div></form>';
}


// Validate Contact Form
function pc4u_contactform_valid() {
    
    $pc4uForm_errors = array();
     
    // Ensure Name, Email Address, Subject and Message Present
     $name    =  !empty( $_POST["pc4uName"]) ?sanitize_text_field( $_POST["pc4uName"] ): '';
     $email    =  !empty( $_POST["pc4uEmail"]) ?sanitize_text_field( $_POST["pc4uEmail"] ): '';
     $subject    =  !empty( $_POST["pc4uSubject"]) ?sanitize_text_field( $_POST["pc4uSubject"] ): '';
     $message    =  !empty( $_POST["pc4uMessage"]) ?sanitize_text_field( $_POST["pc4uMessage"] ): '';
    
     $AddTelephone =  !empty( $_POST["pc4uTelephone"]) ?sanitize_text_field( $_POST["pc4uTelephone"] ): '';
     
     $AddCompany =  !empty( $_POST["pc4uCompany"]) ?trim(sanitize_text_field( $_POST["pc4uCompany"] )): '';
     $AddLine1    =  !empty( $_POST["pc4uAddress1"]) ?trim(sanitize_text_field( $_POST["pc4uAddress1"] )): '';
     $AddLine2    =  !empty( $_POST["pc4uAddress2"]) ?trim(sanitize_text_field( $_POST["pc4uAddress2"] )): '';
     $AddTown     =  !empty( $_POST["pc4uTown"]) ?trim(sanitize_text_field( $_POST["pc4uTown"] )): '';
     $AddCounty   =  !empty( $_POST["pc4uCounty"]) ?trim(sanitize_text_field( $_POST["pc4uCounty"] )): '';
     $AddPostcode   =  !empty( $_POST["pc4uPostcode"]) ?trim(sanitize_text_field( $_POST["pc4uPostcode"] )): '';
          
     
     if(empty($name)){
        array_push($pc4uForm_errors,"A Contact Name Must Be Specified");
     } else {
        if(strlen($name) < 4 ) {
            array_push($pc4uForm_errors,"A Contact Name Must be at least 4 character") ;
        }
     }
    if(empty($email)){
        array_push($pc4uForm_errors,"A Contact Email Address Must Be Specified");
    }
    if(empty($subject)){
        array_push($pc4uForm_errors,"A Message Subject Must Be Specified");
    }
    
    if(empty($message)){
        array_push($pc4uForm_errors,"A Message Must Be Specified");
    }
    
     // Check For No Telephone Number but MUST BE PRESENT
    if($GLOBALS['contactMustHaveTelephone'] && empty($AddTelephone) ) {
        array_push($pc4uForm_errors,"You MUST specify a Telephone Number");
    }
    
    // Check For No Address but MUST BE PRESENT
    if($GLOBALS['contactMustHaveAddress'] && ($AddLine1 === "" && $AddPostcode === "")) {
        array_push($pc4uForm_errors,"You MUST specify an Address");
    } 
    
    // Check For Invalid Address
    if(empty($AddLine1) && !empty($AddPostcode)) {
        //   Check For Invalid Address Fields
        if(!empty($AddLine2) || !empty($AddTown) || !empty($AddCounty)) {
            array_push($pc4uForm_errors,"Invalid Contact Address- Address1 or Postcode Must Be Specified");
        }
    }  
    return $pc4uForm_errors;
}
        
function pc4u_contactform_send() {
 
    // if the submit button is clicked, send the email
    if ( isset( $_POST['pc4u-submitted'] ) ) {

            // Validate Form - 
        $ErrorList = pc4u_contactform_valid();
        if(count($ErrorList)< 1) {
            // Form Valid - Send
            //
            // sanitize form values
            $name    = sanitize_text_field( $_POST["pc4uName"] );
            $email   = sanitize_email( $_POST["pc4uEmail"] );
            $subject = sanitize_text_field( $_POST["pc4uSubject"] );
            $message = esc_textarea( $_POST["pc4uMessage"] );
            
            $AddCompany =  !empty( $_POST["pc4uCompany"]) ?sanitize_text_field( $_POST["pc4uCompany"] ): '';
            $telno = !empty( $_POST["pc4uTelephone"]) ?sanitize_text_field( $_POST["pc4uTelephone"] ): '';
            
            // Append Contact Details to Message
            $message .= "\r\n\r\nContact Details\r\n";
            $message .= "Name:\t". $name."\r\n";
            if(!empty($AddCompany)) {
                $message .= "Company:\t". (!empty($AddCompany)?$AddCompany:'')."\r\n";
            }
            
            // If Telephone Details Included Then Append to Message
            if(!empty( $telno)) {
                $message .= "Telephone No:\t". $telno."\r\n";           
            }
            
            // If Address Details Included Then Append to Message
            $AddLine1    =  !empty( $_POST["pc4uAddress1"]) ?sanitize_text_field( $_POST["pc4uAddress1"] ): '';
            $AddLine2    =  !empty( $_POST["pc4uAddress2"]) ?sanitize_text_field( $_POST["pc4uAddress2"] ): '';
            $AddTown     =  !empty( $_POST["pc4uTown"]) ?sanitize_text_field( $_POST["pc4uTown"] ): '';
            $AddCounty   =  !empty( $_POST["pc4uCounty"]) ?sanitize_text_field( $_POST["pc4uCounty"] ): '';
            $AddPostcode   =  !empty( $_POST["pc4uPostcode"]) ?sanitize_text_field( $_POST["pc4uPostcode"] ): '';
               
            
            if(!empty($AddLine1) || !empty($AddPostcode)) {
                $message .= "\r\n\r\nPostal Address Details\r\n";
               
                $message .= "Address1:\t". (!empty($AddLine1)?$AddLine1:'')."\r\n";
                $message .= "Address2:\t". (!empty($AddLine2)?$AddLine2:'')."\r\n";
                $message .= "Town/City:\t". (!empty($AddTown)?$AddTown:'')."\r\n";
                $message .= "County: \t". (!empty($AddCounty)?$AddCounty:'')."\r\n";
                $message .= "Postcode:\t". (!empty($AddPostcode)?$AddPostcode:'')."\r\n";
            }
            // Add Sender IP
            $message .= "\r\n\r\nSender IP: " . wptuts_get_the_ip();
            
            // get the blog administrator's email address
            $to = get_option( 'admin_email' );
 
            $headers = "From: $name <$email>" . "\r\n";
             // If email has been process for sending, display a success message
            if ( wp_mail( $to, $subject, $message, $headers ) ) {
                echo '<div>';
                echo '<p><h2>Your Message Has Been Sent.<br>';
                echo 'We will get back to you as soon as possible.</h2></p>';
                echo '</div>';
            } else {
                echo 'An unexpected error occurred whilst sending message';               
            }
        } else {
            // Show Validation Errors
            echo '<strong>CONTACT FORM VALIDATION ERRORS</strong>: ';
            foreach ($ErrorList as $error) {
                echo '<div>';
                echo '    '. $error . '<br/>';
                echo '</div>';
            }
            echo '<p></p>';
        }
    }
}

function wptuts_get_the_ip() {
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    else {
        return $_SERVER["REMOTE_ADDR"];
    }
}


?>