<?php

	defined('ABSPATH') or die("Jog on");

	/**
	 * Validate and apply defaults to shortcode arguments
	 * @param $arg
	 *
	 * @return mixed|void
	 */
	function yk_cs_validate_arguments( $arg ) {

		// User ID: Integer
		$arg[ 'user-id' ] = ( false === empty( $arg[ 'user-id' ] ) ) ? (int) $arg[ 'user-id' ] : 0;

		// Condition
		if ( true === empty( $arg[ 'conditions' ] ) ) {
			$arg[ 'conditions' ] = 'is-logged-in';
		}

		// User ID: Integer
		$arg[ 'strip-p-br' ] = ( false === empty( $arg[ 'strip-p-br' ] ) ) ? filter_var( $arg[ 'strip-p-br' ] , FILTER_VALIDATE_BOOLEAN ) : false;

		return apply_filters( 'yk_cs_validated_arguments', $arg );

	}

	/**
	 * Validate condition
	 *
	 * @param $condition
	 *
	 * @return bool
	 */
	function yk_cs_validate_condition_key( $condition ) {

		if ( true === empty( $condition ) ) {
			return false;
		}

		if ( false === in_array( $condition, yk_cs_conditions_keys() ) ) {
			return false;
		}

		return true;
	}

	/*
	 * Return an array of valid operators
	 */
	function yk_cs_operators() {
		return array( 'exists', 'not-exists' );
	}

	/*
	 * Return an array of valid fields
	 */
	function yk_cs_conditions_keys() {
		return array_keys( yk_cs_conditions() );
	}

	/**
	 * Remove <br> and <p> tags from text
	 * @param $text
	 * @return mixed
	 */
	function yk_cs_remove_p_br($text) {

		if(false === empty($text)) {

			$find = ['<br>', '<br />', '<p>', '</p>'];

			foreach ($find as $value) {
				$text = str_ireplace($value, '', $text);
			}
		}

		return $text;
	}

	/**
	 * Display a table of premade shortcodes
	 *
	 * @param string $display
	 */
	function yk_cs_display_conditions() {

		$premium_user = false; // sh_cd_license_is_premium();
		$upgrade_link = sprintf( '<a class="button" href="%s"><i class="fas fa-check"></i> Upgrade now</a>', '#' );

		$conditions = yk_cs_conditions();
		$show_premium_col = false;

		$html = '<table class="widefat sh-cd-table" width="100%">
	                <tr class="row-title">
	                    <th class="row-title" width="30%">Condition</th>';

		if ( true === $show_premium_col) {
			$html .= '<th>Premium</th>';
		}

		$html .= '<th>Supported Operators</th>';

		$html .= '<th width="*">Description</th>
	                </tr>';

		$class = '';

		foreach ( $conditions as $key => $data ) {

			$class = ($class == 'alternate') ? '' : 'alternate';

			$shortcode = '[' . YK_CS_SHORTCODE. ' conditions="' . $key . '"]';

			$premium_shortcode = ( true === $data['premium'] );

			$html .= sprintf( '<tr class="%s"><td>%s</td>', $class, esc_html( $shortcode ) );


			if ( true === $show_premium_col) {

				$html .= sprintf( '<td align="center">%s%s</td>',
					( true === $premium_shortcode && true === $premium_user ) ? '<i class="fas fa-check"></i>' : '',
					( true == $premium_shortcode && false === $premium_user ) ? $upgrade_link : ''
				);
			}

			$html .= sprintf( '<td>%s</td>', implode( ', ', yk_cs_get_class_operators( $key ) ) );

			$html .= sprintf( '<td>%s</td></tr>', wp_kses_post( $data['description'] ) );

		}

		$html .= '</table>';

		return $html;
	}

	/**
	 * Fetch allowed operators for condition
	 *
	 * @param $condition_key
	 *
	 * @return array
	 */
	function yk_cs_get_class_operators( $condition_key ) {

		$condition_key = trim( $condition_key );

		$condition_classes = yk_cs_conditions();

		// Does the condition exist?
		if ( false === array_key_exists( $condition_key, $condition_classes ) ) {
			return [];
		}

		$class_name = $condition_classes[ $condition_key ][ 'class' ];

		if ( true === class_exists( $class_name ) ) {

			$condition_obj = new $class_name([]);

			return $condition_obj->get_allowed_operators();

		}

		return [];

	}