<?php
// STYLESHEETPATH or TEMPLATEPATH or dirname( __FILE__ )
//require_once(dirname( __FILE__ ).'/lib/HTML.class.php');
require_once(dirname( __FILE__ ).'/lib/type/index.php');
//require_once(dirname( __FILE__ ).'/lib/widget/widgets.php');
//require_once(dirname( __FILE__ ).'/lib/shortcode/index.php');
require_once(dirname( __FILE__ ).'/lib/plugin/index.php');



////////////////////////////////////////////
// SECURITY and DISABLE
////////////////////////////////////////////
remove_action('wp_head','wp_generator');
// //add_filter('login_errors',create_function('$a', "return null;"));
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');



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


////////////////////////////////////////////
// VUE as theme
////////////////////////////////////////////

// Load styles and scripts
function my_scripts() {


  if ( !is_admin() ) {

    // CSS
		//wp_enqueue_style( 'stylesheet', get_bloginfo('stylesheet_url'), NULL );
    wp_enqueue_style( 'stylesheet', get_template_directory_uri().'/dist/build.css', NULL );


    // Disable scripts not in use
    //wp_dequeue_script( 'jquery' );


    // JavaScript at the bottom page
		//wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/releases/v5.0.4/js/all.js', array(), '5.0.4', true);
    //wp_enqueue_script('custom-js', get_template_directory_uri().'/custom.js', array('jquery'), NULL, true);
    wp_enqueue_script('theme-script', get_template_directory_uri().'/dist/main.js', array(), NULL, true);

		// REST setting for VUE
    // Prepare localized translations to JavaScript for client-side
    // https://codex.wordpress.org/Function_Reference/wp_localize_script
    $base_url  = esc_url_raw( home_url() );
    $base_path = rtrim( parse_url( $base_url, PHP_URL_PATH ), '/' );
		$domain = esc_url_raw(($_SERVER['SERVER_PORT']==='443'?'https://':'http://').$_SERVER['HTTP_HOST']);
    wp_localize_script( 'theme-script', 'wp', array(
      'root'     => esc_url_raw( rest_url() ),
      'baseUrl'  => $base_url,
      'basePath' => $base_path ? $base_path . '/' : '/',
			'themeUri' => esc_url_raw( get_template_directory_uri() ),
      'nonce'    => wp_create_nonce( 'wp_rest' ),
      'siteName' => get_bloginfo( 'name' ),
			'domain' 	 => $domain,
      //'routes'    => rest_theme_routes(),
    ));

  }
}
// // Get all the singular SLUGs (URIs) for SPA
// // To revisit because it could be big.
// function rest_theme_routes() {
// 	$routes = array();
// 	$query = new WP_Query( array(
// 		'post_type'      => 'any',
// 		'post_status'    => 'publish',
// 		'posts_per_page' => -1,
// 	) );
// 	if ( $query->have_posts() ) {
// 		while ( $query->have_posts() ) {
// 			$query->the_post();
// 			$routes[] = array(
// 				'id'   => get_the_ID(),
// 				'type' => get_post_type(),
// 				'slug' => basename( get_permalink() ),
// 			);
// 		}
// 	}
// 	wp_reset_postdata();
// 	return $routes;
// }
add_action( 'wp_enqueue_scripts', 'my_scripts' );



// Change WP default permalink
//
// Allow to use VUE as theme at the best
function my_custom_rewrite_rule() {
	global $wp_rewrite;
	$wp_rewrite->front               = $wp_rewrite->root;
	$wp_rewrite->set_permalink_structure( 'blog/%postname%/' );
	$wp_rewrite->page_structure      = $wp_rewrite->root . 'page/%pagename%/'; //'page/%pagename%/';
	$wp_rewrite->author_base         = 'author';
	$wp_rewrite->author_structure    = '/' . $wp_rewrite->author_base . '/%author%';
	$wp_rewrite->set_category_base( 'category' );
	$wp_rewrite->set_tag_base( 'tag' );
	$wp_rewrite->add_rule( '^blog$', 'index.php', 'top' );
	//flush_rewrite_rules();
}
// Forcing permalink structure
// function force_my_permalink_struct( $old_permalink_structure, $new_permalink_structure ) {
// 	//update_option( 'permalink_structure', 'blog/%postname%' );
// 	my_custom_rewrite_rule();
// 	flush_rewrite_rules();
// }
// add_action( 'permalink_structure_changed', 'force_my_permalink_struct' );
add_action( 'init', 'my_custom_rewrite_rule' );


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
error_reporting(E_ALL & ~E_NOTICE);
if( function_exists('add_theme_support') ) {
  add_theme_support('post-thumbnails');
  add_theme_support('nav-menus');
  //add_theme_support('automatic-feed-links');
  add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
  add_theme_support('title-tag');
  //Additional Sizes
  //set_post_thumbnail_size(500, 0);
  //add_image_size('landscape', 600, 400, true);
  //add_image_size('square', 360, 360, true);
  //add_image_size('banner', 1170, 350, true);
  //add_image_size('people', 360, 195, true);
}


// Set Menu theme locations
if( function_exists('register_nav_menus') ) {
  register_nav_menus(
    array(
      'nav_main' => 'Main Navigation'
      , 'nav_bottom' => 'Footer Navigation'
    )
  );
}


// // Change Excerpt Length - Default: 55
// function new_excerpt_length($length){return 30;}
// add_filter('excerpt_length', 'new_excerpt_length');


// Change Excerpts more filter - Default: [...]
function new_excerpt_more($more) { return '...'; }
add_filter('excerpt_more', 'new_excerpt_more');





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
