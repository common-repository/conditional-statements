<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Defines the abstract class that represents a condition
 *
 * Class CS_CONDITION
 */
abstract class CS_CONDITION {

	private     $args = [];
	private     $allowed_operators              = [ 'equals' ];     // Supported operators for this condition
	protected   $value;                                             // The value set by the class itself (used for comparisons)
	protected   $compare_value                  = true;             // The compare value should be what's passed in my the shortcode attribute "compare-to"
	protected   $operator                       = NULL;

	public function __construct( $arguments = NULL, $default_operator = 'equals' ) {

		// Set operator
		if ( false === empty( $arguments['operator'] ) ) {
			$this->set_operator( $arguments['operator'] );
		} else {
			$this->set_operator( $default_operator );
		}

		// Apply shortcode / class arguments
		if ( true === is_array( $arguments ) ) {
			$this->set_arguments( $arguments );
		}

		// Do we have a compare value specified by the user
		if ( false === empty( $arguments['compare-value'] ) ) {
			$this->set_compare_value( $arguments['compare-value'] );
		}

	}

	public function set_arguments( $args ) {

		if ( false === empty( $args ) && true === is_array( $args ) ) {

			$this->args = $args;

			return;
		}

		$this->args = [];
	}

	public function get_arguments() {
		return $this->args;
	}

	public function get_argument( $key, $default = NULL ) {
		return ( true === isset( $this->args[ $key ] ) ) ? $this->args[ $key ] : $default;
	}

	public function get_compare_value() {
		return $this->compare_value;
	}

	protected function set_compare_value( $compare_value ) {
		$this->compare_value = $compare_value;
	}

	private function set_values_to_bool() {
		$this->compare_value = filter_var( $this->compare_value , FILTER_VALIDATE_BOOLEAN );
		$this->value = filter_var( $this->value , FILTER_VALIDATE_BOOLEAN );
	}

	private function set_values_to_int() {
		$this->compare_value = (int) $this->compare_value;
		$this->value = (int) $this->value;
	}

	protected function set_value( $value ) {
		$this->value = $value;
	}

	protected function set_operator( $operator ) {
		if ( true === in_array( $operator, $this->allowed_operators ) ) {
			$this->operator = $operator;
		}
	}

	protected function set_allowed_operators( $operators ) {
		$this->allowed_operators = $operators;
	}

	public function get_allowed_operators() {
		return $this->allowed_operators;
	}

	// Return true or false depending on outcome
	abstract public function evaluate();

	/**
	 * Depending on the operator, determine if condition is true
	 *
	 * @param null $compare_to
	 *
	 * @return bool|null
	 */
	protected function auto_evaluate() {

		switch ( $this->operator ) {

			case 'equals':
				return $this->equals();
				break;
			case 'exists':
				return $this->exists();
				break;
			case 'not-exists':
				return $this->not_exists();
				break;
		}

		return NULL;
	}

	/**
	 * Does the shortcode value compare to that which is passed in
	 *
	 * @param $compare_to
	 *
	 * @return bool
	 */
	protected function equals() {
		return ( $this->compare_value === $this->value );
	}

	/**
	 * Compare values as booleans
	 *
	 * @return bool
	 */
	protected function equals_as_bools() {

		$this->set_values_to_bool();

		return ( $this->compare_value === $this->value );
	}

	/**
	 * Compare values as ints
	 *
	 * @return bool
	 */
	protected function equals_as_ints() {

		$this->set_values_to_int();

		return ( $this->compare_value === $this->value );
	}

	/**
	 * @return bool
	 */
	protected function exists() {
		return ! empty( $this->value );
	}

	/**
	 * Does the value exist?
	 *
	 * @return bool
	 */
	protected function not_exists() {
		return empty( $this->value );
	}

}