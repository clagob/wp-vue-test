<?php
//===========================================================
//
//  Author: Claudio Gobetti [claudio@gobetti.org]
//  created: 28/08/2012 - 15/01/2018
//  updated:
//  version: 2.0.0
//
//===========================================================

class HTML {

	// build HTML OPTIONS for SELECT
	function get_select_options	( $array, $selected_key, $no_value=false, $prefix = '', $suffix = '' ) {
		if( !isset($selected_key) )
			$selected_key = '--';
		if( !$no_value )
			$no_value = false;
		$i = 0;
		$html = '';
		foreach( $array as $key=>$value ) {
			if( $no_value ) {
				if( "$value" == $selected_key )
					$html .= "<option value=\"$value\" selected=\"selected\">$value</option>";
				else
					$html .= "<option value=\"$value\">$prefix$value$suffix</option>";
			} else {
				if( "$key" == $selected_key )
					$html .= "<option value=\"$key\" selected=\"selected\">$value</option>";
				else
					$html .= "<option value=\"$key\">$prefix$value$suffix</option>";
			}
			$i++;
		}
		if( $i < 1 )
			$html.='<option value="0">Empty/No item found!</option>';
		return $html;
	}
	function select_options( $array, $selected_key, $no_value, $prefix = '', $suffix = '' ) {
		echo $this->get_select_options	( $array, $selected_key, $no_value, $prefix, $suffix );
	}


	// build HTML SELECT element from array with key
	function get_select_key_array( $array_with_key, $elem_name, $all_label = NULL, $prefix = '', $suffix = '', $elem_class = 'form-control' ) {
	  $selected_key = '';

	  // check for preset value
	  if ( isset($_GET[$elem_name]) && array_key_exists($_GET[$elem_name], $array_with_key) ) {
	    $selected_key = $_GET[$elem_name];
	  }

	  // build element
	  $html = '<select name="'.$elem_name.'" class="'.$elem_class.'">';
	  if( isset($all_label) && !empty($all_label) ) {
	    $html .= '<option>'.$all_label.'</option>';
	  }
		if( count($array_with_key) > 0 ) {
	  	$html .= $this->get_select_options($array_with_key, $selected_key, false, $prefix, $suffix);
		}
	  $html .= '</select>';

	  return $html;
	}
	function select_key_array( $array_with_key, $elem_name, $all_label = NULL, $prefix = '', $suffix = '', $elem_class = 'form-control' ) {
		echo $this->get_select_key_array( $array_with_key, $elem_name, $all_label, $prefix, $suffix, $elem_class );
	}


	// build HTML SELECT element from a simple indexed array without key
	function get_select_array( $indexed_array, $elem_name, $all_label = NULL, $prefix = '', $suffix = '', $elem_class = 'form-control' ) {
	  $selected_key = '';

	  // check for preset value
	  if ( isset($_GET[$elem_name]) && in_array($_GET[$elem_name], $indexed_array) ) {
	    $selected_key = $_GET[$elem_name];
	  }

	  // build element
	  $html = '<select name="'.$elem_name.'" class="'.$elem_class.'">';
	  if( isset($all_label) && !empty($all_label) ) {
	    $html .= '<option>'.$all_label.'</option>';
	  }
		if( count($indexed_array) > 0 ) {
		  $html .= $this->get_select_options($indexed_array, $selected_key, true, $prefix, $suffix);
		}
	  $html .= '</select>';

	  return $html;
	}
	function select_array( $indexed_array, $elem_name, $all_label = NULL, $prefix = '', $suffix = '', $elem_class = 'form-control' ) {
		return $this->get_select_array( $indexed_array, $elem_name, $all_label, $prefix, $suffix, $elem_class );
	}



	// build HTML INPUT CHECKBOX elements from array with key
	function get_checkboxs_key_array( $array_with_key, $elem_name, $prefix = '', $suffix = '', $parent_class = 'form-check' ) {
	  $selected_key = '';

	  // check for preset value
	  if ( isset($_GET[$elem_name]) && $this->array_keys_exists($_GET[$elem_name], $array_with_key) ) {
	    $selected_key = $_GET[$elem_name];
	  }
		$html = '';
		foreach( $array_with_key as $key=>$value ) {
			$id = $elem_name.'-'.$this->slugify($key);

		  // build element
		  $html .= '<div class="'.$parent_class.'">';
			$html .= '<input name="'.$elem_name.'[]" id="'.$id.'" type="checkbox" class="form-check-input" ';
			if(
				(gettype($selected_key)=='array' && in_array($key, $selected_key))
				||
				(gettype($selected_key)=='string' &&  $key==$selected_key)
				||
				!isset($_GET[$elem_name]) // select all
			) {
				$html .= 'checked="checked" ';
			}
			$html .= 'value="'. $key .'">';
			$html .= '<label class="form-check-label" for="'.$id.'">'.$prefix.$value.$suffix.'</label>';
			$html .= '</div>';
		}

	  return $html;
	}
	function checkboxs_key_array( $array_with_key, $elem_name, $prefix = '', $suffix = '', $parent_class = 'form-check' ) {
		echo $this->get_checkboxs_key_array( $array_with_key, $elem_name, $prefix, $suffix, $parent_class );
	}







	// build HTML INPUT RADIO elements from array with key
	function get_radios_key_array( $array_with_key, $elem_name, $prefix = '', $suffix = '', $parent_class = 'form-check' ) {
		$selected_key = '';

		// check for preset value
		if ( isset($_GET[$elem_name]) && array_key_exists($_GET[$elem_name], $array_with_key) ) {
			$selected_key = $_GET[$elem_name];
		}
		$html = '';
		foreach( $array_with_key as $key=>$value ) {
			$id = $elem_name.'-'.$this->slugify($key);

			// build element
			$html .= '<div class="'.$parent_class.'">';
			$html .= '<input name="'.$elem_name.'" id="'.$id.'" type="radio" class="form-check-input" ';
			if ( $key==$selected_key ) {
				$html .= 'checked="checked" ';
			}
			$html .= 'value="'. $key .'">';
			$html .= '<label class="form-check-label" for="'.$id.'">'.$prefix.$value.$suffix.'</label>';
			$html .= '</div>';
		}

		return $html;
	}
	function radios_key_array( $array_with_key, $elem_name, $prefix = '', $suffix = '', $parent_class = 'form-check' ) {
		echo $this->get_radios_key_array( $array_with_key, $elem_name, $prefix, $suffix, $parent_class );
	}



	static public function slugify($text) {
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);

	  if (empty($text)) {
	    return 'n-a';
	  }

	  return $text;
	}



	// Extend PHP functions
	static public function array_keys_exists( $array, $array_with_key ) {
		if( gettype($array)=='array') {
			foreach( $array as $value ) {
	      if( array_key_exists($value, $array_with_key) ) {
	      	return true;
	      }
	    }
		} else {
			return array_key_exists($array, $array_with_key);
		}
    return false;
	}


}





?>
