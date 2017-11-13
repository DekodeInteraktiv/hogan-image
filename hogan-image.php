<?php
/**
 * Plugin Name: Hogan Module: Image
 * Plugin URI: https://github.com/dekodeinteraktiv/hogan-image
 * Description: Image Module for Hogan.
 * Version: 1.0.0-dev
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Text Domain: hogan-image
 * Domain Path: /languages/
 *
 * @package Hogan
 * @author Dekode
 */

namespace Dekode\Hogan\Image;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once 'class-image.php';

add_action( 'plugins_loaded', __NAMESPACE__ . '\\hogan_load_textdomain' );
add_action( 'hogan/include_modules', __NAMESPACE__ . '\\hogan_register_module' );

/**
 * Register module text domain
 */
function hogan_load_textdomain() {
	\load_plugin_textdomain( 'hogan-image', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register module in Hogan
 */
function hogan_register_module() {
	\hogan_register_module( new \Dekode\Hogan\Image() );
}
