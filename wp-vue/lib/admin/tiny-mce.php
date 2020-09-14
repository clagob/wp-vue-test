<?php

// Tiny MCE
//
// Personalisation of the editor

if( current_user_can('edit_posts') ) {

  // Callback function to insert 'styleselect' into the $buttons array
  function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
  }
  add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );

	// Callback function to filter the MCE settings
  function my_mce_before_init_insert_formats( $init_array ) {
    // Define the style_formats array
    $style_formats = array(

			array(
				'title' => 'lead',
				'selector' => 'p',
				'classes' => 'lead',
				'wrapper' => true,
			),
      array(
        'title' => 'text center',
        'selector' => 'p,h1,h2,h3,h4',
        'classes' => 'text-center',
        'wrapper' => true,
      ),
      array(
        'title' => 'text right',
        'selector' => 'p,h1,h2,h3,h4',
        'classes' => 'text-right',
        'wrapper' => true,
      ),
      array(
        'title' => 'text white',
        'inline' => 'span',
        'classes' => 'text-white',
        'wrapper' => false,
      ),
      array(
        'title' => 'text primary',
        'inline' => 'span',
        'classes' => 'text-primary',
        'wrapper' => false,
      ),
			array(
        'title' => 'text secondary',
        'inline' => 'span',
        'classes' => 'text-secondary',
        'wrapper' => false,
      ),
      array(
        'title' => 'text warning',
        'inline' => 'span',
        'classes' => 'text-warning',
        'wrapper' => false,
      ),
			array(
        'title' => 'text danger',
        'inline' => 'span',
        'classes' => 'text-danger',
        'wrapper' => false,
      ),
			array(
        'title' => 'Unstyled list',
        'selector' => 'ul',
        'classes' => 'unstyled',
        'wrapper' => true,
      ),
			/*
			array(
        'title' => 'Avoid list - red',
        'selector' => 'ul',
        'classes' => 'avoid',
        'wrapper' => true,
      ),

			array(
        'title' => 'Ticked list blue',
        'selector' => 'ul',
        'classes' => 'tick-blue',
        'wrapper' => true,
      ),
      array(
        'title' => 'Ticked list green',
        'selector' => 'ul',
        'classes' => 'tick-green',
        'wrapper' => true,
      ),
      array(
        'title' => 'Ticked list orange',
        'selector' => 'ul',
        'classes' => 'tick-orange',
        'wrapper' => true,
      ),
      array(
        'title' => 'Ticked list red',
        'selector' => 'ul',
        'classes' => 'tick-red',
        'wrapper' => true,
      ),
      array(
        'title' => 'Speech Bubble',
        'selector' => 'blockquote',
        'classes' => 'speech_bubble',
        'wrapper' => true,
      ),
      array(
        'title' => 'Speech Bubble - Dark',
        'selector' => 'blockquote',
        'classes' => 'speech_bubble_dark',
        'wrapper' => true,
      ),
      array(
        'title' => 'Speech Bubble - Right',
        'selector' => 'blockquote',
        'classes' => 'speech_bubble_right',
        'wrapper' => true,
      ),
			*/
      // array(
      //   'title' => 'h2 underlined',
      //   'selector' => 'h2',
      //   'classes' => 'underlined',
      //   'wrapper' => false,
      // ),
      array(
        'title' => 'Inline button container (2+ buttons)',
        'selector' => 'p',
        'classes' => 'btn-container',
        'wrapper' => true,
      ),
      array(
        'title' => 'Button - Primary',
        'selector' => 'a',
        'classes' => 'btn btn-primary ',
        'wrapper' => false,
      ),
      array(
        'title' => 'Button - Secondary',
        'selector' => 'a',
        'classes' => 'btn btn-secondary',
        'wrapper' => false,
      ),
      // array(
      //   'title' => 'Button - Warning',
      //   'selector' => 'a',
      //   'classes' => 'btn btn-warning',
      //   'wrapper' => false,
      // ),
			array(
        'title' => 'Button - Outline Primary',
        'selector' => 'a',
        'classes' => 'btn btn-outline-primary',
        'wrapper' => false,
      ),
			array(
        'title' => 'Button - Outline Secondary',
        'selector' => 'a',
        'classes' => 'btn btn-outline-secondary',
        'wrapper' => false,
      ),
      array(
        'title' => 'Button - Outline White',
        'selector' => 'a',
        'classes' => 'btn btn-outline-white',
        'wrapper' => false,
      ),
      array(
        'title' => 'Button - large',
        'selector' => 'a.btn',
        'classes' => 'btn-lg',
        'wrapper' => false,
      ),
      array(
        'title' => 'Button - small',
        'selector' => 'a.btn',
        'classes' =>  'btn-sm',
        'wrapper' => false,
      ),
      array(
        'title' => 'code',
        'inline' => 'code',
        'wrapper' => false,
      ),
			array(
        'title' => 'Mark',
        'inline' => 'mark',
        'wrapper' => false,
      ),
			array(
        'title' => 'Header - Display 1',
        'selector' => 'h1,h2,h3,h4',
        'classes' => 'display-1',
        'wrapper' => false,
      ),
			array(
        'title' => 'Header - Display 2',
        'selector' => 'h1,h2,h3,h4',
        'classes' => 'display-2',
        'wrapper' => false,
      ),
			array(
        'title' => 'Header - Display 3',
        'selector' => 'h1,h2,h3,h4',
        'classes' => 'display-3',
        'wrapper' => false,
      ),
			array(
        'title' => 'Header - Display 4',
        'selector' => 'h1,h2,h3,h4',
        'classes' => 'display-4',
        'wrapper' => false,
      ),
      array(
        'title' => 'accent-top',
        'selector' => 'p,h1,h2,h3,h4,div',
        'classes' => 'accent-top',
        'wrapper' => false,
      ),
      array(
        'title' => 'mt-5',
        'selector' => 'p,h1,h2,h3,h4,div',
        'classes' => 'mt-5',
        'wrapper' => false,
      ),
    );
    $init_array['style_formats'] = json_encode( $style_formats );
    return $init_array;
  }
  add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

	add_editor_style('style-editor.css');
}
