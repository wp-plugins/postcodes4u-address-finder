<?php

function pc4u_add_content($content) {

global $pc4u_options;
 
	if(is_page('postcodes4u') && $pc4u_options['enable'] ==true) {
		$extra_content = '<p><form action="post" name="" target="#">
<h2>Postcode Look-up</h2>
<div id="postcodes4ukey" style="display: none;">' . $pc4u_options['user_key'] . '</div>
<div id="postcodes4uuser" style="display: none;">' . $pc4u_options['user_name'] . '</div>

<table>
<tbody>
<tr>
<td>Postcode</td>
<td><input id="postcode" type="text" value="" /></td>
<td><input onclick="SearchBegin();return false;" type="submit" value="lookup" />

<select id="dropdown" style="display: none;" onchange="SearchIdBegin()"><option>Select an address:</option></select></td>
</tr>
<tr>
<td>Company</td>
<td><input id="company" type="text" value="" /></td>
</tr>
<tr>
<td>Address 1</td>
<td><input id="address1" type="text" value="" /></td>
</tr>
<tr>
<td>Address 2</td>
<td><input id="address2" type="text" value="" /></td>
</tr>
<tr>
<td>Town</td>
<td><input id="town" type="text" value="" /></td>
</tr>
<tr>
<td>County</td>
<td><input id="county" type="text" value="" /></td>
</tr>
</tbody>
</table>
</form></p>';
		$content .= $extra_content;
	}
	return $content;
}
add_filter('the_content', 'pc4u_add_content');


