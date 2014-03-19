<?php

/********************************
* script control
********************************/

function pc4u_load_scripts () 
{

if (is_page('postcodes4u'))
{
wp_enqueue_style('pc4u-styles', plugin_dir_url( __FILE__ ) . 'css/styles.css');
wp_register_script('pc4u-script', plugin_dir_url( __FILE__ ) . 'js/pc4u.js');
wp_enqueue_script('pc4u-script');

 }               
}

add_action('wp_enqueue_scripts', 'pc4u_load_scripts');


