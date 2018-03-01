<?php

// Contact Form 7
//
// Disable JS and CSS for CF7 + server side REDIRECT

add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
// Contact Form 7 - Custom redirection
function my_cf7_submit_redirection() {
	if ( wp_redirect($_SERVER['HTTP_REFERER'].'thank-you/?result=success') ) {
		exit;
	}
}
//add_action("wpcf7_before_send_mail", "my_cf7_submit_redirection");
add_action("wpcf7_mail_sent", "my_cf7_submit_redirection");
