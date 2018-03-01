<?php
/*
 * UTM CODES as shortcodes
 * =======================
 * 07/11/2017 Claudio Gobetti
 *
 * In this file there I store the following GET parameters
 * - utm_source
 * - utm_medium
 * - utm_campaign
 * - utm_term
 * - utm_content
 * in cookies and set them in global varaibles.
 * I also definition of the following shortcodes
 * - [utm_source]
 * - [utm_medium]
 * - [utm_campaign]
 * - [utm_term]
 * - [utm_content]
 * to be used inside your site.
 *
 *
 * How does it work?
 * =================
 *
 * Incoming traffic:
 * -----------------
 * http://www.mysite.co.uk/.../?utm_source=SUBID
 * or http://www.mysite.co.uk/.../?utm_source=SUBID&utm_medium=EXTRAID
 *
 */

$expire_ms  = 7776000;  // 7776000 = 90 days   2592000 = 30 days   604800 = 7 days
$cookie_domain = "cignpostlife.co.uk";  // available for all the subdomains    // ""; // default

global $my_mcid;

global $my_utm_source;
global $my_utm_medium;
global $my_utm_campaign;
global $my_utm_term;
global $my_utm_content;

$_GET = array_change_key_case($_GET, CASE_LOWER);

// MCID for LUNAR
// set value already stored
if ( isset($_COOKIE['my_mcid']) && !empty($_COOKIE['my_mcid']) ) {
  $my_mcid = $_COOKIE['my_mcid'];
} else {
  $my_mcid = '';
}
// overwrite / set the query string src to the cookie
if ( isset($_GET['my_mcid']) ) {
  if (!empty($_GET['my_mcid']) ) {
    setcookie('my_mcid', urlencode($_GET['my_mcid']), time()+$expire_ms, '/', $cookie_domain);
    $my_mcid = urlencode($_GET['my_mcid']);
  } else {
     unset($_COOKIE['my_mcid']);
     setcookie('my_mcid', null, -1, '/' , $cookie_domain);
     $my_mcid = '';
  }
}
// create the shortcode
function my_mcid_tracking( $default_value='' ) {
  global $my_mcid;
  $default_value ? $default_value = $default_value : $default_value = '';
  return $my_mcid ? $my_mcid : $default_value;
}
add_shortcode('mcid', 'my_mcid_tracking');


// UTM_SOURCE
// set value already stored
if ( isset($_COOKIE['my_utm_source']) && !empty($_COOKIE['my_utm_source']) ) {
  $my_utm_source = $_COOKIE['my_utm_source'];
} else {
  $my_utm_source = '';
}
// overwrite / set the query string src to the cookie
if ( isset($_GET['utm_source']) ) {
  if (!empty($_GET['utm_source']) ) {
    setcookie('my_utm_source', urlencode($_GET['utm_source']), time()+$expire_ms, '/', $cookie_domain);
    $my_utm_source = urlencode($_GET['utm_source']);
  } else {
     unset($_COOKIE['my_utm_source']);
     setcookie('my_utm_source', null, -1, '/', $cookie_domain);
     $my_utm_source = '';
  }
}
// create the shortcode
function my_utm_source_tracking( $default_value='' ) {
  global $my_utm_source;
  $default_value ? $default_value = $default_value : $default_value = 'web';
  return $my_utm_source ? $my_utm_source : $default_value;
}
add_shortcode('utm_source', 'my_utm_source_tracking');


// UTM_MEDIUM
// set value already stored
if ( isset($_COOKIE['my_utm_medium']) && !empty($_COOKIE['my_utm_medium']) ) {
  $my_utm_medium = $_COOKIE['my_utm_medium'];
} else {
  $my_utm_medium = '';
}
// overwrite / set the query string src to the cookie
if ( isset($_GET['utm_medium']) ) {
  if (!empty($_GET['utm_medium']) ) {
    setcookie('my_utm_medium', urlencode($_GET['utm_medium']), time()+$expire_ms , '/', $cookie_domain);
    $my_utm_medium = urlencode($_GET['utm_medium']);
  } else {
     unset($_COOKIE['my_utm_medium']);
     setcookie('my_utm_medium', null, -1, '/', $cookie_domain);
     $my_utm_medium = '';
  }
}
// create the shortcode
function my_utm_medium_tracking( $default_value='' ) {
  global $my_utm_medium;
  $default_value ? $default_value = $default_value : $default_value = '';
  return $my_utm_medium ? $my_utm_medium : $default_value;
}
add_shortcode('utm_medium', 'my_utm_medium_tracking');


// UTM_CAMPAIGN
// set value already stored
if ( isset($_COOKIE['my_utm_campaign']) && !empty($_COOKIE['my_utm_campaign']) ) {
  $my_utm_campaign = $_COOKIE['my_utm_campaign'];
} else {
  $my_utm_campaign = '';
}
// overwrite / set the query string src to the cookie
if ( isset($_GET['utm_campaign']) ) {
  if (!empty($_GET['utm_campaign']) ) {
    setcookie('my_utm_campaign', urlencode($_GET['utm_campaign']), time()+$expire_ms, '/', $cookie_domain);
    $my_utm_campaign = urlencode($_GET['utm_campaign']);
  } else {
     unset($_COOKIE['my_utm_campaign']);
     setcookie('my_utm_campaign', null, -1, '/', $cookie_domain);
     $my_utm_campaign = '';
  }
}
// create the shortcode
function my_utm_campaign_tracking( $default_value='' ) {
  global $my_utm_campaign;
  $default_value ? $default_value = $default_value : $default_value = '';
  return $my_utm_campaign ? $my_utm_campaign : $default_value;
}
add_shortcode('utm_campaign', 'my_utm_campaign_tracking');


// UTM_TERM
// set value already stored
if ( isset($_COOKIE['my_utm_term']) && !empty($_COOKIE['my_utm_term']) ) {
  $my_utm_term = $_COOKIE['my_utm_term'];
} else {
  $my_utm_term = '';
}
// overwrite / set the query string src to the cookie
if ( isset($_GET['utm_term']) ) {
  if (!empty($_GET['utm_term']) ) {
    setcookie('my_utm_term', urlencode($_GET['utm_term']), time()+$expire_ms, '/', $cookie_domain);
    $my_utm_term = urlencode($_GET['utm_term']);
  } else {
     unset($_COOKIE['my_utm_term']);
     setcookie('my_utm_term', null, -1, '/', $cookie_domain);
     $my_utm_term = '';
  }
}
// create the shortcode
function my_utm_term_tracking( $default_value='' ) {
  global $my_utm_term;
  $default_value ? $default_value = $default_value : $default_value = '';
  return $my_utm_term ? $my_utm_term : $default_value;
}
add_shortcode('utm_term', 'my_utm_term_tracking');


// UTM_CONTENT
// set value already stored
if ( isset($_COOKIE['my_utm_content']) && !empty($_COOKIE['my_utm_content']) ) {
  $my_utm_content = $_COOKIE['my_utm_content'];
} else {
  $my_utm_content = '';
}
// overwrite / set the query string src to the cookie
if ( isset($_GET['utm_content']) ) {
  if (!empty($_GET['utm_content']) ) {
    setcookie('my_utm_content', urlencode($_GET['utm_content']), time()+$expire_ms, '/', $cookie_domain);
    $my_utm_content = urlencode($_GET['utm_content']);
  } else {
     unset($_COOKIE['my_utm_content']);
     setcookie('my_utm_content', null, -1, '/', $cookie_domain);
     $my_utm_content = '';
  }
}
// create the shortcode
function my_utm_content_tracking( $default_value='' ) {
  global $my_utm_content;
  $default_value ? $default_value = $default_value : $default_value = '';
  return $my_utm_content ? $my_utm_content : $default_value;
}
add_shortcode('utm_content', 'my_utm_content_tracking');
