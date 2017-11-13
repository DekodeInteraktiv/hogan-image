<?php
/**
 * Image module class
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\Image' ) ) {

	/**
	 * Image module class.
	 *
	 * @extends Modules base class.
	 */
	class Image extends Module {

		/**
		 * Image heading
		 *
		 * @var string $heading
		 */
		public $heading;

		/**
		 * Rendered image for optional use in template.
		 *
		 * @var $image_id
		 */
		public $image_id;

		/**
		 * Rendered image content for use in template.
		 *
		 * @var $image_content
		 */
		public $image_content;

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label    = __( 'Image', 'hogan-image' );
			$this->template = __DIR__ . '/assets/template.php';

			parent::__construct();
		}

		/**
		 * Field definitions for module.
		 */
		public function get_fields() {

			$choices = apply_filters( 'hogan/module/image/choices', [
				'thumbnail' => _x( 'Small', 'Image Size', 'hogan-image' ),
				'medium'    => _x( 'Medium', 'Image Size', 'hogan-image' ),
				'large'     => _x( 'Large', 'Image Size', 'hogan-image' ),
			] );

			$constraints_defaults = [
				'min_width'  => '',
				'min_height' => '',
				'max_width'  => '',
				'max_height' => '',
				'min_size'   => '',
				'max_size'   => '',
				'mime_types' => '',
			];

			// Merge $args from filter with $defaults
			$constraints_args = wp_parse_args( apply_filters( 'hogan/module/image/field/constraints', [] ), $constraints_defaults );

			return [
				[
					'type'         => 'text',
					'key'          => $this->field_key . '_heading',
					'name'         => 'heading',
					'label'        => __( 'Heading', 'hogan-embed' ),
					'instructions' => __( 'Optional heading will show only if filled in.', 'hogan-image' ),
				],
				[
					'type'          => 'radio',
					'key'           => $this->field_key . '_image_size',
					'name'          => 'image_size',
					'label'         => __( 'Image size', 'nettsteder-mal' ),
					'value'         => is_array( $choices ) && ! empty( $choices ) ? reset( $choices ) : null,
					'instructions'  => __( 'Choose Image Size', 'hogan-image' ),
					'choices'       => $choices,
					'layout'        => 'horizontal',
					'return_format' => 'value',
				],
				[
					'type'          => 'image',
					'key'           => $this->field_key . '_image_id',
					'name'          => 'image_id',
					'label'         => __( 'Add Image', 'hogan-image' ),
					//'instructions'  => '',
					'required'      => 1,
					'return_format' => 'id',
					'preview_size'  => apply_filters( 'hogan/module/image/field/preview_size', 'medium' ),
					'library'       => apply_filters( 'hogan/module/image/field/library', 'all' ),
					'min_width'     => $constraints_args['min_width'],
					'min_height'    => $constraints_args['min_height'],
					'max_width'     => $constraints_args['max_width'],
					'max_height'    => $constraints_args['max_height'],
					'min_size'      => $constraints_args['min_size'],
					'max_size'      => $constraints_args['max_size'],
					'mime_types'    => $constraints_args['mime_types'],
				],
			];
		}

		/**
		 * Map fields to object variable.
		 *
		 * @param array $content The content value.
		 */
		public function load_args_from_layout_content( $content ) {
			$this->heading       = $content['heading'] ?? null;
			$this->image_id      = $content['image_id'];
			$this->image_content = wp_get_attachment_image( $content['image_id'], $content['image_size'], false, apply_filters( 'hogan/module/image/render/attr', [] ) );

			parent::load_args_from_layout_content( $content );
		}

		/**
		 * Validate module content before template is loaded.
		 */
		public function validate_args() {
			return ! empty( $this->image_content );
		}
	}
}
