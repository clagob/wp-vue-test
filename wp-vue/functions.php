<?php
// STYLESHEETPATH or TEMPLATEPATH or dirname( __FILE__ )
//require_once(dirname( __FILE__ ).'/lib/HTML.class.php');
require_once(dirname( __FILE__ ).'/lib/type/index.php');
//require_once(dirname( __FILE__ ).'/lib/widget/widgets.php');
//require_once(dirname( __FILE__ ).'/lib/shortcode/index.php');
//require_once(dirname( __FILE__ ).'/lib/plugin/index.php');



////////////////////////////////////////////
// SECURITY and DISABLE
////////////////////////////////////////////
remove_action('wp_head','wp_generator');
// //add_filter('login_errors',create_function('$a', "return null;"));
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// // Remove support for Comments
// function remove_comment_support() {
// 	if ( function_exists('remove_post_type_support') ) {
// 		remove_post_type_support('post', 'comments');
// 		remove_post_type_support('page', 'comments');
// 	}
// }
// //add_action('admin_menu', 'remove_comment_support');
// // Remove Comments from Admin Menu:
// function sb_remove_admin_menus (){
// 	if ( function_exists('remove_menu_page') )
// 		remove_menu_page('edit-comments.php');
// }
// //add_action('admin_menu', 'sb_remove_admin_menus');

// function remove_dashboard_widgets(){
//     //remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
//     remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
//     remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
//     remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
//     remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
//     remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
//     remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
//     remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
// }
//add_action('wp_dashboard_setup', 'remove_dashboard_widgets');


// Disable the emoji's
add_action( 'init', 'disable_emojis' );
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
// Filter function used to remove the tinymce emoji plugin.
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}



////////////////////////////////////////////
// SPEED - move script position
////////////////////////////////////////////
function remove_head_scripts() {
  if( !is_admin() ) {
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);

		// Disable Contact Form 7 CSS
		//wp_deregister_style('contact-form-7');
  }
}
add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );



// Load styles and scripts
function my_scripts() {


  if ( !is_admin() ) {

    // CSS
		//wp_enqueue_style( 'stylesheet', get_bloginfo('stylesheet_url'), NULL );
    wp_enqueue_style( 'stylesheet', get_template_directory_uri().'/dist/build.css', NULL );


    // Disable scripts not in use
    //wp_dequeue_script( 'jquery' );


    // JavaScript at the bottom page
    //wp_enqueue_script('custom-js', get_template_directory_uri().'/custom.js', array('jquery'), NULL, true);
    wp_enqueue_script('theme-script', get_template_directory_uri().'/dist/main.js', array(), NULL, true);

    // Prepare localized translations to JavaScript for client-side
    // https://codex.wordpress.org/Function_Reference/wp_localize_script
    $base_url  = esc_url_raw( home_url() );
    $base_path = rtrim( parse_url( $base_url, PHP_URL_PATH ), '/' );
    wp_localize_script( 'theme-script', 'wp', array(
      'root'      => esc_url_raw( rest_url() ),
      'base_url'  => $base_url,
      'base_path' => $base_path ? $base_path . '/' : '/',
      'nonce'     => wp_create_nonce( 'wp_rest' ),
      'site_name' => get_bloginfo( 'name' ),
      'routes'    => rest_theme_routes(),
    ));

    //wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/releases/v5.0.4/js/all.js', array(), '5.0.4', true);

  }
}
// Get all the singular SLUGs (URIs) for SPA
// To revisit because it could be big.
function rest_theme_routes() {
	$routes = array();
	$query = new WP_Query( array(
		'post_type'      => 'any',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	) );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$routes[] = array(
				'id'   => get_the_ID(),
				'type' => get_post_type(),
				'slug' => basename( get_permalink() ),
			);
		}
	}
	wp_reset_postdata();
	return $routes;
}
add_action( 'wp_enqueue_scripts', 'my_scripts' );

// function my_deregister_scripts(){
//  wp_dequeue_script( 'wp-embed' );
// }
// add_action( 'wp_footer', 'my_deregister_scripts' );



// function disable_embeds_code_init() {
//  // Remove the REST API endpoint.
//  remove_action( 'rest_api_init', 'wp_oembed_register_route' );
//  // Turn off oEmbed auto discovery.
//  add_filter( 'embed_oembed_discover', '__return_false' );
//  // Don't filter oEmbed results.
//  remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
//  // Remove oEmbed discovery links.
//  remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
//  // Remove oEmbed-specific JavaScript from the front-end and back-end.
//  remove_action( 'wp_head', 'wp_oembed_add_host_js' );
//  add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
//  // Remove all embeds rewrite rules.
//  add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
//  // Remove filter of the oEmbed result before any HTTP requests are made.
//  remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
// }
// add_action( 'init', 'disable_embeds_code_init', 9999 );
// function disable_embeds_tiny_mce_plugin($plugins) {
//   return array_diff($plugins, array('wpembed'));
// }
// function disable_embeds_rewrites($rules) {
//   foreach($rules as $rule => $rewrite) {
//     if(false !== strpos($rewrite, 'embed=true')) {
//       unset($rules[$rule]);
//     }
//   }
//   return $rules;
// }




// Set metadata
function wp_api_encode_yoast($data, $post, $context) {

  // unset( $data->data['author'] );
  // unset( $data->data['status'] );
  // unset( $data->data['template'] );

  $yoastMeta = array(
    // 'focuskw' => get_post_meta($post->ID, '_yoast_wpseo_focuskw', true),
    'title' => get_post_meta($post->ID, '_yoast_wpseo_title', true),
    'metadesc' => get_post_meta($post->ID, '_yoast_wpseo_metadesc', true),
    // 'linkdex' => get_post_meta($post->ID, '_yoast_wpseo_linkdex', true),
    // 'metakeywords' => get_post_meta($post->ID, '_yoast_wpseo_metakeywords', true),
    'meta-robots-noindex' => get_post_meta($post->ID, '_yoast_wpseo_meta-robots-noindex', true),
    'meta-robots-nofollow' => get_post_meta($post->ID, '_yoast_wpseo_meta-robots-nofollow', true),
    // 'meta-robots-adv' => get_post_meta($post->ID, '_yoast_wpseo_meta-robots-adv', true),
    // 'canonical' => get_post_meta($post->ID, '_yoast_wpseo_canonical', true),
    // 'redirect' => get_post_meta($post->ID, '_yoast_wpseo_redirect', true),
    // 'opengraph-title' => get_post_meta($post->ID, '_yoast_wpseo_opengraph-title', true),
    // 'opengraph-description' => get_post_meta($post->ID, '_yoast_wpseo_opengraph-description', true),
    // 'opengraph-image' => get_post_meta($post->ID, '_yoast_wpseo_opengraph-image', true),
    // 'twitter-title' => get_post_meta($post->ID, '_yoast_wpseo_twitter-title', true),
    // 'twitter-description' => get_post_meta($post->ID, '_yoast_wpseo_twitter-description', true),
    // 'twitter-image' => get_post_meta($post->ID, '_yoast_wpseo_twitter-image', true)
  );
  $data->data['yoast_meta'] = (array) $yoastMeta;
  return $data;
}
add_filter('rest_prepare_post', 'wp_api_encode_yoast', 10, 3);
add_filter('rest_prepare_page', 'wp_api_encode_yoast', 10, 3);
add_filter('rest_prepare_deal', 'wp_api_encode_yoast', 10, 3);



////////////////////////////////////////////
// PESONALISE
////////////////////////////////////////////



// // Set Menu theme locations
// if( function_exists('register_nav_menus') ) {
//   register_nav_menus(
//     array(
//       'nav_main' => 'Main Navigation'
//       //, 'nav_tab' => 'TAB Navigation (only one item)'
//       //, 'nav_aside' => 'Aside Navigation'
//       , 'nav_bottom' => 'Footer Navigation'
// 			//, 'nav_help' => 'How can we help?'
//     )
//   );
// }


//error_reporting(E_ALL & ~E_NOTICE);
// if( function_exists('add_theme_support') ) {
//   add_theme_support('post-thumbnails');
//   add_theme_support('nav-menus');
//   add_theme_support('automatic-feed-links');
//   add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
//   add_theme_support('title-tag');
//   //Additional Sizes
//   //set_post_thumbnail_size(500, 0);
//   //add_image_size('landscape', 600, 400, true);
//   //add_image_size('square', 360, 360, true);
//   //add_image_size('banner', 1170, 350, true);
//   //add_image_size('people', 360, 195, true);
// }



// // Change Excerpt Length - Default: 55
// function new_excerpt_length($length){return 30;}
// add_filter('excerpt_length', 'new_excerpt_length');



// // Change Excerpts more filter - Default: [...]
// function new_excerpt_more($more){return '...';}
// add_filter('excerpt_more', 'new_excerpt_more');





////////////////////////////////////////////
// ADMIN PANEL
////////////////////////////////////////////
require_once(dirname( __FILE__ ).'/lib/admin/tiny-mce.php');
// Set up Customisable OPTIONS from within Appearance => Customize
require_once(dirname( __FILE__ ).'/lib/wp-customize.php');

// Hide Admin bar to everybody
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
  if ( !is_admin() ) {
    show_admin_bar(false);
  }
}


////////////////////////////////////////////
// PERMISSIONS
////////////////////////////////////////////
// function add_my_caps(){
// 	// get the the role object
// 	$role_obj = get_role('editor');
// 	// add capability to this role
// 	$role_obj->add_cap('edit_theme_options');
// }
// add_action('admin_init', 'add_my_caps');

////////////////////////////////////////////
//  Hide Admin bar to subcribers + redirect
////////////////////////////////////////////
// if ( !current_user_can('edit_posts') && !is_admin() ) {
//   show_admin_bar(false);
// }
// //redirect after login
// function my_login_redirect( $redirect_to, $request, $user  ) {
//   return ( is_array( $user->roles ) && in_array( 'subscriber', $user->roles ) ) ?  site_url() : admin_url();
// }
// add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );


////////////////////////////////////////////
// CUSTOM LOGIN
////////////////////////////////////////////
// function custom_login_logo() {
//   echo '<style type="text/css">
//   h1 a {
//     background: url('.get_template_directory_uri().'/img/logo.svg) 50% 50% no-repeat !important;
//     background-size: contain !important;
//     width:250px !important;
//     height:60px !important;
//     margin:0 auto 1em !important;
//   }
//   </style>';
// }
// add_action('login_head', 'custom_login_logo');
// function change_wp_login_url(){
// 	return get_bloginfo('url');
// }
// add_filter('login_headerurl', 'change_wp_login_url');
// function change_wp_login_title(){
// 	return get_option('blogname');
// }
// add_filter('login_headertitle', 'change_wp_login_title');
