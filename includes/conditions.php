<?php

defined('ABSPATH') or die("Jog on");

/**
 * Define an array of conditions and their classes
 *
 * @return array
 */
function yk_cs_conditions() {

	$conditions = [
						'is-logged-in' => [ 'class' => 'CS_CONDITION_LOGGED_IN', 'description' => 'User logged in', 'premium' => true ],
						'ip' => [ 'class' => 'CS_CONDITION_IP', 'description' => 'User\'s IP', 'premium' => true ],
						'first-name' => [ 'class' => 'CS_CONDITION_USER_PROFILE', 'description' => 'User\'s first name', 'args' => [ '_sh_cd_func' => 'user_firstname' ] ],
						'last-name' => [ 'class' => 'CS_CONDITION_USER_PROFILE', 'description' => 'User\'s last name.', 'args' => [ '_sh_cd_func' => 'user_lastname' ] ],
						'display-name' => [ 'class' => 'CS_CONDITION_USER_PROFILE', 'description' => 'User\'s display name.', 'args' => [ '_sh_cd_func' => 'display_name' ] ],
						'user-id' => [ 'class' => 'CS_CONDITION_USER_ID', 'description' => 'User\'s ID.' ],
						'post-id' => [ 'class' => 'CS_CONDITION_POST_ID', 'description' => 'Post ID of current post in loop.' ],
						'post-slug' => [ 'class' => 'CS_CONDITION_POST_SLUG', 'description' => 'Slug of current post in loop.' ],
						'post-type' => [ 'class' => 'CS_CONDITION_POST_TYPE', 'description' => 'Post type of current post in loop.' ],

	];

	return apply_filters( 'yk_cs_conditions', $conditions );
}


/**
 * Is the user currently logged in?
 */
class CS_CONDITION_IP extends CS_CONDITION {

	public function __construct( $arguments = NULL ) {

		parent::__construct( $arguments );

		parent::set_value( $this->get_ip() );
	}

	public function evaluate() {
		return $this->equals();
	}

	/**
	 * Fetch the existing user's IP
	 *
	 * @return mixed
	 */
	private function get_ip() {

		// Code based on WP Beginner article: http://www.wpbeginner.com/wp-tutorials/how-to-display-a-users-ip-address-in-wordpress/
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}

/**
 * Is the user currently logged in?
 */
class CS_CONDITION_LOGGED_IN extends CS_CONDITION {

	public function __construct( $arguments = NULL ) {

		parent::__construct( $arguments );

		parent::set_value( is_user_logged_in() );
	}

	public function evaluate() {
		return $this->equals_as_bools();
	}
}

/**
 * User ID
 */
class CS_CONDITION_USER_ID extends CS_CONDITION {

	public function __construct( $arguments = NULL ) {

		parent::__construct( $arguments );

		parent::set_value( get_current_user_id() );
	}

	public function evaluate() {
		return $this->equals_as_ints();
	}
}

/**
 * Post ID
 */
class CS_CONDITION_POST_ID extends CS_CONDITION {

	public function __construct( $arguments = NULL ) {

		parent::__construct( $arguments );

		parent::set_value( get_the_ID() );
	}

	public function evaluate() {
		return $this->equals_as_ints();
	}
}

/**
 * Post Slug
 */
class CS_CONDITION_POST_SLUG extends CS_CONDITION {

	public function __construct( $arguments = NULL ) {

		parent::__construct( $arguments );

		$post_slug = get_post_field( 'post_name', get_post() );

		parent::set_value( $post_slug );
	}

	public function evaluate() {
		return $this->equals();
	}
}

/**
 * Post Type
 */
class CS_CONDITION_POST_TYPE extends CS_CONDITION {

	public function __construct( $arguments = NULL ) {

		parent::__construct( $arguments );

		parent::set_value( get_post_type() );
	}

	public function evaluate() {
		return $this->equals();
	}
}

/**
 * Determine if user profile elements exist
 */
class CS_CONDITION_USER_PROFILE extends CS_CONDITION {

	private $key = NULL;

	public function __construct( $arguments = NULL ) {

		if ( false === empty( $arguments['_sh_cd_func'] ) ) {
			$this->key = $arguments['_sh_cd_func'];
		}

		parent::set_allowed_operators( [ 'equals', 'exists', 'not-exists' ] );

		parent::__construct( $arguments, 'exists' );

	}

	public function evaluate() {

		$current_user = wp_get_current_user();

		// Not logged in?
		if ( false === $current_user->exists() ) {
			return false;
		}

		$value = NULL;

		switch ( $this->key ) {

			case 'user_email':
				$value = $current_user->user_email;
				break;
			case 'display_name':
				$value = $current_user->display_name;
				break;
			case 'user_firstname':
				$value = $current_user->user_firstname;
				break;
			case 'user_lastname':
	            $value = $current_user->user_lastname;
				break;

		}

		$this->set_value( $value );

		return $this->auto_evaluate();
	}
}