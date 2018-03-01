<?php
// Template Shortcode
// ===========================
// 06/12/2016 Claudio Gobetti
//
// [template name="form-test"]
//
// this will translate to
//
// get_template_part('form-test');
//
// form-test.php has to be in the theme root


class TemplateShortcode {

  function __construct() {
   add_action( 'init', array( $this, 'add_shortcode' ) );
   add_filter( 'the_content', array( $this, 'the_content_filter' ) );
   // Apply the same filter to ACF wysiwyg
   add_filter( 'acf_the_content', array( $this, 'the_content_filter' ) );
  }

  public $shortcodes = array('template');


  function add_shortcode() {
		add_shortcode( 'template', array( $this, 'my_template' ) );
	}


  // Clean all P and BR sorrounding the shortcode
  function the_content_filter($content) {
    $block = join("|",$this->shortcodes);
    $rep = preg_replace("/(<p>|<br \/>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    $rep = preg_replace("/(<p>|<br \/>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
    return $rep;
  }


  function my_template( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        "name"  => false,
    ), $atts );
    $output = '';
    if( $atts['name'] ) {
      ob_start();
      get_template_part($atts['name']);
      $output =  ob_get_clean();
    }
    return $output;
  }

}

new TemplateShortcode();
