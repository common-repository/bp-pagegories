<?php
/*
Plugin Name: BP Pagegories
Plugin URI: http://www.brianpiltin.com/development/bp-pagegories-wordpress-widget/
Description: 
	A sidebar widget that displays both the pages and categories as a single list.  This is useful if you don't care to have users distinguish between categories and pages when they are navigating your site.
Author: Brian Piltin
Version: 1.1.0
Author URI: http://brianpiltin.com/

   I am the owner of the copyright of this work and I reserve no rights to it. You  can modify it, copy it, distribute it, and even take credit for it at will... God bless you.

   This is a WordPress plugin and widget (http://wordpress.org) 
	
*/

function widget_bp_pagegories($args) {
	
	extract($args);

	$options = get_option("widget_bp_pagegories");
	$title = $options['title'] ? $options['title'] : '';
	$categories_first = $options['categories_first'];
	
	echo $before_widget; 
	echo $before_title . $title . $after_title; 
	
	echo '<ul>';
		
	if (!$categories_first) {
		wp_list_pages('sort_column=menu_order&title_li=');
		wp_list_categories('title_li=');  
	} else {
		wp_list_categories('title_li=');  
		wp_list_pages('sort_column=menu_order&title_li=');
	}
	
	echo $after_widget;
	echo '</ul>';
	
}

function bp_pagegories_control() 
{
	$options = $new_options = get_option("widget_bp_pagegories");
	
	if ( !is_array($options) ) 
		$options = array( 'title' => '', 'categories_first' => 0 );
		
	if ( $_POST['bp-pagegories-options-submitted'] )
	{
		$options['title'] = $_POST['bp-pagegories-title'];
		$options['categories_first'] = $_POST['bp-pagegories-categories-first'];
		
		update_option("widget_bp_pagegories", $options);
	}
		
	$bp_title = $options['title'];
	$bp_categories_first = $options['categories_first'] ? 'checked="checked"' : '';
	
	echo '<p>
		<label for="bp-pagegories-title">Title: </label>
		<input type="text" style="width: 200px;" id="bp-pagegories-title" name="bp-pagegories-title" value="' . $bp_title . '" />
		<label for="bp-pagegories-categories-first">List Categories First: </label>
		<input class="checkbox" type="checkbox" ' . $bp_categories_first . ' id="bp-pagegories-categories-first" name="bp-pagegories-categories-first" value="1" />
		<input type="hidden" id="bp-pagegories-options-submitted" name="bp-pagegories-options-submitted" value="1" />
	</p>';
}

function bp_pagegories_init() {

    if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
        return; 

	register_sidebar_widget(__('BP Pagegories'), 'widget_bp_pagegories');
    register_widget_control(   'BP Pagegories', 'bp_pagegories_control');
}

add_action('plugins_loaded', 'bp_pagegories_init');

?>
