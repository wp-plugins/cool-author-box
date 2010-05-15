<?php
/*
Plugin Name: Cool Author Box
Plugin URI: http://www.designisphilosophy.com/wordpress/cool-author-box-free-wordpress-plugin-20100514/
Version: 0.0.1
Author: Morten Rand-Hendriksen of <a href="http://www.pinkandyellow.com" title="Pink &amp; Yellow Media">Pink &amp; Yellow Media</a> and <a href="http://www.designisphilosophy.com" title="Design is Philosophy">Design is Philosophy</a>.
Description: Adds a author box to the top or bottom of posts and pages displaying the author name (linking to other posts by the same author), author website and author Gravatar in a cool and unusual layout.

Author URI: http://www.pinkandyellow.com

Copyright 2010 by Morten Rand-Hendriksen and Pink & Yellow Media

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/

function author_BOX_display($content)
{
	$options['page'] = get_option('bio_on_page');
	$options['post'] = get_option('bio_on_post');
	$authorID = get_the_author_meta('ID');
	

	if ( (is_single() && $options['post']) || (is_page() && $options['page']) )
	{
		$bio_box =
		'<div class="profile">
			<div class="profileText">
			'.get_the_author_meta('description').'
			</div>
			<div class="profileStats">
				'.get_avatar( get_the_author_meta('user_email'), '80' ).'
				<div class="profileName">
					'.get_the_author_meta("display_name").' 
				</div>
				<div class="profileJob">
					View all posts by <a href="'.get_author_posts_url( $authorID ).'" title="View all posts by '.get_the_author().'">'.get_the_author().'</a><br />
					<a href="'.get_the_author_meta('user_url').'" title="'.get_the_author_meta('first_name').'s website">'.get_the_author_meta('first_name').\'s website</a>
				</div>
			</div>
		</div>

		';

		return $content . $bio_box;
	} else {
		return $content;
	}
}

function author_BOX_style()
{

	echo
	'<style type=\'text/css\'>
		
	.profile {
			border: 1px solid #CCCCCC;
			position: relative;
			margin: 15px 0px 15px 0px;
		}
	 
		.profileText {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 0.8em;
			padding: 10px;
			line-height: 1.4em;
			text-align: justify;
		}
	 
		.profileStats {
			font-family: Georgia, "Times New Roman", Times, serif;
			font-style: italic;
			text-align: right;
		}
	 
		.profileStats img {
			position: absolute;
			right: 0px;
			bottom: 0px;
		}
	 
		.profileName {
			padding-bottom: 5px;
			padding-right: 92px;
			font-size: 1.2em;
			font-weight: bold;
			color: #2e4672;
		}
	 
		.profileName a {
			color: #2e4672;
		}
		 
		.profileName a:hover {
			color:#24375B;
			text-decoration: none;
		}
		 
		.profileJob {
			font-size: 0.8em;
			padding-right: 92px;
			padding-top: 5px;
			background-image: url(\''.get_bloginfo('url').'/wp-content/plugins/cool-author-box/testimonialBlue.gif\'); 
			background-repeat: repeat-x;
			height: 45px;
			color: #FFFFFF;
			line-height: 18px;
		}
	 
		.profileJob a {
			color: #FFFFFF;
			font-weight: bold;
			text-decoration: none;
		}

		
	</style>';
}

function author_BOX_settings()
{

	if ($_POST['action'] == 'update')
	{
		$_POST['show_pages'] == 'on' ? update_option('bio_on_page', 'checked') : update_option('bio_on_page', '');
		$_POST['show_posts'] == 'on' ? update_option('bio_on_post', 'checked') : update_option('bio_on_post', '');
		$message = '<div id="message" class="updated fade"><p><strong>Options Saved</strong></p></div>';
	}

	$options['page'] = get_option('bio_on_page');
	$options['post'] = get_option('bio_on_post');

	echo '
	<div class="wrap">
		'.$message.'
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Cool Author Box Settings</h2>

		<form method="post" action="">
		<input type="hidden" name="action" value="update" />

		<h3>Where to display Cool Author Box</h3>
		<input name="show_pages" type="checkbox" id="show_pages" '.$options['page'].' /> Display box on Pages<br />
		<input name="show_posts" type="checkbox" id="show_posts" '.$options['post'].' /> Display box on Posts<br />
		<br />
		<input type="submit" class="button-primary" value="Save Changes" />
		</form>

	</div>';
}

function author_BOX_admin_menu()
{
	// this is where we add our plugin to the admin menu
	add_options_page('Cool Author Box', 'Cool Author Box', 9, basename(__FILE__), 'author_BOX_settings');
}


add_action('the_content', 'author_BOX_display');
add_action('admin_menu', 'author_BOX_admin_menu');
add_action('wp_head', 'author_BOX_style');

?>
