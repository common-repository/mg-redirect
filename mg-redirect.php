<?php
/**
* Plugin Name: Moodgiver Redirect
* Plugin URI: http://www.moodgiver.com/wpplugins-moodgiver-redirect/
* Description: This plugin adds a redirect to a user defined url/page/post with a login flag. You can add a simple shortcode with the following parameters: home (domain url - not required, default home_url()), page ( page or path - required ) , login ( not required, values 0 (default) = always redirect; 1 = redirect only not logged users).
* Version: 1.0.0
* Author: Antonio Nardone
* Author URI: http://www.moodgiver.com/wpplugins-moodgiver-redirect/
* License: GPL2
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/** main function **/
function mg_redirect( $atts )
{
		extract ( shortcode_atts (array (
			'login'=> '0',
			'home' => home_url(),
			'page' => '' ) , $atts));
		$location = $home . $page;
		if ( $login == '0' ){
			wp_redirect ( $location );
		} else {
	  		if ( !is_user_logged_in() ) {
				wp_redirect ( $location );
			}
		}
}

/** add shortcode */
add_shortcode ( 'mg_redirect' , 'mg_redirect' );

/** Add option page to admin menu */
add_action( 'admin_menu', 'mg_redirect_menu' );

/** Add option page */
function mg_redirect_menu() {
	add_options_page( 'mg Redirect', 'mg Redirect', 'manage_options', 'my-unique-identifier', 'mg_redirect_options' );
}

/** Option page */
function mg_redirect_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	$pagina = '<h1>moodgiver Redirect</h1>moodgiver Redirect is a very simple plugin that you can use in your post/page with a simple shortcode, in order to redirect it to a new url (internal or external).
<h2>Syntax</h2>
<pre>[mg_redirect home="your_domain" page="/your page" login="1"]</pre>
<h2>Usage</h2>
The simplest way to add a redirect to an <strong>internal url</strong> (same domain) is inserting into your post/page the following shortcode:
<pre>[mg_redirect page="/yourpage"]</pre>
If you need to redirect to an <strong>external url</strong> add the following shortcode
<pre>[mg_redirect home="http://your_domain" page="/yourpage"]</pre>
If you need to <strong>redirect to a url only to users that are not logged in</strong> add the parameter login=1
<pre>[mg_redirect page="/yourpage" login="1"]</pre>
<h3>License</h3>
MoodGiver Redirect is a free to use plugin. Please do not remove author info.
<h4>Support</h4>
Since this is a very simple and minimal plugin no support is provided. If you have any question please write us.
<h4>Author: Antonio Nardone</h4>
&copy; 2015 by <a href="http://www.moodgiver.com">moodgiver</a>
<small>Version 1.0.0</small>';
	echo $pagina;
	echo '</div>';
}

?>