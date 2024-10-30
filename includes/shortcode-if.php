<?php

defined('ABSPATH') or die("Jog on");

/**
 * Render IF shortcode
 *
 * @param $user_defined_arguments
 * @param null $content - content between WP tags
 * @param $level - used to determine level of IF nesting
 * @return string
 */
function yk_cs_shortcode_if( $user_defined_arguments, $content = null, $level = 0 ) {

	// Check if we have content between opening and closing [wlt-if] tags, if we don't then nothing to render so why bother proceeding?
	if( true === empty( $content ) ) {
		return sprintf( '<p>To use this shortcode, you must specify content between opening and closing tags<br /><br />e.g. [cs-if%1$s]something to show if IF is true[/cs-if%1$s]</p>',
			( false === empty( $level ) ) ? '-' . (int) $level : ''
			)	;
	}

	$arguments = shortcode_atts(    array(
										'user-id'       => get_current_user_id(),
										'operator'      => '',				        // equals, exists, not-exists
										'compare-value' => '',
										'conditions'    => '',
										'strip-p-br'    => false
									),
									$user_defined_arguments
	);

	$arguments = yk_cs_validate_arguments( $arguments );

	$level = (int) $level;

	// Strip out BR / P tags?
	if ( true === $arguments['strip-p-br'] ) {
		$content = yk_cs_remove_p_br( $content );
	}

	$else_content = '';

	$else_tag = ($level > 0) ? '[else-' . $level . ']' : '[else]';

	// Is there an [else] within the content? If so, split the content into true condition and else.
	$else_location = stripos( $content, $else_tag );

	if ( false !== $else_location ) {

		$else_content = substr( $content, $else_location + strlen( $else_tag ) );

		// Strip out [else] content from true condition
		$content = substr( $content, 0, $else_location );
	}

	$conditions_met = yk_cs_shortcode_if_value_exist( $arguments['conditions'], $arguments );

	// If we should display true content, then do so. IF not, and it was specified, display [else]
	if ( $conditions_met ) {
		return do_shortcode( $content );
	} else if (false === $conditions_met && false === empty( $else_content ) ) {
		return do_shortcode( $else_content );
	}

	return '';
}
add_shortcode( 'cs-if', 'yk_cs_shortcode_if' );

/**
 *
 * Given a shortcode IF field, check it is populated
 *
 * @param $user_id
 * @param $fields
 * @return bool
 */
function yk_cs_shortcode_if_value_exist( $conditions, $arguments ) {

	// If we have a field, try exploding in case it is more than one value!
	if( false === empty( $conditions ) ) {

		if( false === is_array( $conditions ) ) {
			$conditions = explode(',', $conditions );
		}

		// Loop through each field. If any are invalid then return false
		foreach ( $conditions as $condition_key ) {

			$condition_key = trim( $condition_key );

			$condition_classes = yk_cs_conditions();

			// Does the condition exist?
			if ( false === array_key_exists( $condition_key, $condition_classes ) ) {
				return false;
			}

			$class_name = $condition_classes[ $condition_key ][ 'class' ];

			if ( true === class_exists( $class_name ) ) {

				// Any class arguments?
				if ( false === empty( $condition_classes[ $condition_key ][ 'args' ] ) ) {
					$arguments = array_merge( $arguments, $condition_classes[ $condition_key ][ 'args' ] );
				}

				$condition_obj = new $class_name( $arguments );

				$result = $condition_obj->evaluate();

				if ( false === $result ) {
					return false;
				}
			}
		}

	}
	return true;
}

/**
 * Shortcode to allow nesting of [cs-if]. This is for [cs-if-1]
 *
 * @param $user_defined_arguments
 * @param null $content
 * @return string
 */
function yk_cs_shortcode_if_level_one( $user_defined_arguments, $content = null ) {
    return yk_cs_shortcode_if( $user_defined_arguments, $content, 1 );
}
add_shortcode( 'cs-if-1', 'yk_cs_shortcode_if_level_one' );

/**
 * Shortcode to allow nesting of [cs-if]. This is for [cs-if-2]
 *
 * @param $user_defined_arguments
 * @param null $content
 * @return string
 */
function yk_cs_shortcode_if_level_two( $user_defined_arguments, $content = null ) {
	return yk_cs_shortcode_if( $user_defined_arguments, $content, 2 );
}
add_shortcode( 'cs-if-2', 'yk_cs_shortcode_if_level_two' );

/**
 * Shortcode to allow nesting of [cs-if]. This is for [cs-if-3]
 *
 * @param $user_defined_arguments
 * @param null $content
 * @return string
 */
function yk_cs_shortcode_if_level_three( $user_defined_arguments, $content = null ) {
	return yk_cs_shortcode_if( $user_defined_arguments, $content, 3 );
}
add_shortcode( 'cs-if-3', 'yk_cs_shortcode_if_level_three' );

/**
 * Shortcode to allow nesting of [cs-if]. This is for [cs-if-4]
 *
 * @param $user_defined_arguments
 * @param null $content
 * @return string
 */
function yk_cs_shortcode_if_level_four( $user_defined_arguments, $content = null ) {
	return yk_cs_shortcode_if( $user_defined_arguments, $content, 1 );
}
add_shortcode( 'cs-if-4', 'yk_cs_shortcode_if_level_four' );

/**
 * Shortcode to allow nesting of [cs-if]. This is for [cs-if-5]
 *
 * @param $user_defined_arguments
 * @param null $content
 * @return string
 */
function yk_cs_shortcode_if_level_five( $user_defined_arguments, $content = null ) {
	return yk_cs_shortcode_if( $user_defined_arguments, $content, 5 );
}
add_shortcode( 'cs-if-5', 'yk_cs_shortcode_if_level_five' );