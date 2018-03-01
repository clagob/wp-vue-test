<?php
// Set up Customisable OPTIONS from within Appearance => Customize
function my_customize_register( $wp_customize ) {



  // TELEPHONE
  //
  //

  $wp_customize->add_section( 'my_telephone' , array('title' => __( 'Telephone settings', 'Inchora' ), 'priority'   => 20 ) );
  $wp_customize->add_setting( 'my_telephone_number', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_telephone_number',
      array(
        'label'    => __( 'Telephone Number: [telephone]', 'Inchora' ),
        'section'  => 'my_telephone',
        'settings' => 'my_telephone_number',
        'type'     => 'text'
      )
    )
  );



  


  // SOCIAL LINKS SECTION
  //
  // All the social info for the creation of the icons

  $wp_customize->add_section( 'my_social' , array('title' => __( 'SOCIAL links', 'Inchora' ), 'priority'   => 30 ) );
  //Facebook
  $wp_customize->add_setting( 'my_social_facebook', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_social_facebook',
      array(
        'label'    => __( 'Facebook link', 'Inchora' ),
        'section'  => 'my_social',
        'settings' => 'my_social_facebook',
        'type'     => 'text'
      )
    )
  );
  //Twitter
  $wp_customize->add_setting( 'my_social_twitter', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_social_twitter',
      array(
        'label'    => __( 'Twitter link', 'Inchora' ),
        'section'  => 'my_social',
        'settings' => 'my_social_twitter',
        'type'     => 'text'
      )
    )
  );
  //LinkedIn
  $wp_customize->add_setting( 'my_social_linkedin', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_social_linkedin',
      array(
        'label'    => __( 'LinkedIn link', 'Inchora' ),
        'section'  => 'my_social',
        'settings' => 'my_social_linkedin',
        'type'     => 'text'
      )
    )
  );
  //Instagram
  $wp_customize->add_setting( 'my_social_instagram', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_social_instagram',
      array(
        'label'    => __( 'Instagram link', 'Inchora' ),
        'section'  => 'my_social',
        'settings' => 'my_social_instagram',
        'type'     => 'text'
      )
    )
  );
  //Pinterest
  $wp_customize->add_setting( 'my_social_pinterest', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_social_pinterest',
      array(
        'label'    => __( 'Pinterest link', 'Inchora' ),
        'section'  => 'my_social',
        'settings' => 'my_social_pinterest',
        'type'     => 'text'
      )
    )
  );
  //Google+
  $wp_customize->add_setting( 'my_social_google_plus', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_social_google_plus',
      array(
        'label'    => __( 'Google+ link', 'Inchora' ),
        'section'  => 'my_social',
        'settings' => 'my_social_google_plus',
        'type'     => 'text'
      )
    )
  );
  //Youtube
  $wp_customize->add_setting( 'my_social_youtube', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_social_youtube',
      array(
        'label'    => __( 'Youtube link', 'Inchora' ),
        'section'  => 'my_social',
        'settings' => 'my_social_youtube',
        'type'     => 'text'
      )
    )
  );
  //Vimeo
  $wp_customize->add_setting( 'my_social_vimeo', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_social_vimeo',
      array(
        'label'    => __( 'Vimeo link', 'Inchora' ),
        'section'  => 'my_social',
        'settings' => 'my_social_vimeo',
        'type'     => 'text'
      )
    )
  );
  //Skype
  $wp_customize->add_setting( 'my_social_skype', array('default' => '', 'transport' => 'postMessage') );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'my_social_skype',
      array(
        'label'    => __( 'Skype link', 'Inchora' ),
        'section'  => 'my_social',
        'settings' => 'my_social_skype',
        'type'     => 'text'
      )
    )
  );

}
add_action( 'customize_register', 'my_customize_register' );
