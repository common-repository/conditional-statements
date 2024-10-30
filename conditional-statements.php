<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Plugin Name: Conditional Statements
 * Description: Add Conditional Statements to your post content e.g. IF the user is logged in display "Welcome back!"
 * Version: 1.0
 * Author: YeKen
 * Author URI: http://www.YeKen.uk
 * License: GPL2
 * Text Domain: conditional-statements
 */
/*  Copyright 2019 YeKen.uk

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'YK_CS_ABSPATH', plugin_dir_path( __FILE__ ) );

define( 'YK_CS_PLUGIN_VERSION', '1.0' );
define( 'YK_CS_SLUG', 'conditional-statements' );
define( 'YK_CS_NAME', 'Conditional Statements' );
define( 'YK_CS_SHORTCODE', 'cs-if' );

// -----------------------------------------------------------------------------------------
// AC: Include all relevant PHP files
// -----------------------------------------------------------------------------------------

include_once YK_CS_ABSPATH . 'includes/class-condition.php';
include_once YK_CS_ABSPATH . 'includes/functions.php';
include_once YK_CS_ABSPATH . 'includes/conditions.php';
include_once YK_CS_ABSPATH . 'includes/hooks.php';
include_once YK_CS_ABSPATH . 'includes/shortcode-if.php';
include_once YK_CS_ABSPATH . 'includes/pages/pages.list.php';
