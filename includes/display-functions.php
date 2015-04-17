<?php

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



?>