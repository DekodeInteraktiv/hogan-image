<?php
/**
 * Image module class
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\Image' ) && class_exists( '\\Dekode\\Hogan\\Module' ) ) {

	/**
	 * Image module class.
	 *
	 * @extends Modules base class.
	 */
	class Image extends Module {

		/**
		 * Image
		 *
		 * @var array|null $image
		 */
		public $image = null;

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
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$choices = apply_filters( 'hogan/module/image/image_size/choices', [
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

			// Merge $args from filter with $defaults.
			$constraints_args = wp_parse_args( apply_filters( 'hogan/module/image/image_size/constraints', [] ), $constraints_defaults );

			$fields = [];

			array_push( $fields,
				[
					'type'          => 'button_group',
					'key'           => $this->field_key . '_image_size',
					'name'          => 'image_size',
					'label'         => __( 'Image size', 'hogan-image' ),
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
					'required'      => 1,
					'return_format' => 'id',
					'preview_size'  => apply_filters( 'hogan/module/image/image_size/preview_size', 'medium' ),
					'library'       => apply_filters( 'hogan/module/image/image_size/library', 'all' ),
					'min_width'     => $constraints_args['min_width'],
					'min_height'    => $constraints_args['min_height'],
					'max_width'     => $constraints_args['max_width'],
					'max_height'    => $constraints_args['max_height'],
					'min_size'      => $constraints_args['min_size'],
					'max_size'      => $constraints_args['max_size'],
					'mime_types'    => $constraints_args['mime_types'],
				]
			);

			hogan_append_caption_field( $fields, $this );

			return $fields;
		}

		/**
		 * Map raw fields from acf to object variable.
		 *
		 * @param array $raw_content Content values.
		 * @param int   $counter Module location in page layout.
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			if ( ! empty( $raw_content['image_id'] ) ) {
				$image = wp_parse_args( apply_filters( 'hogan/module/image/image/args', [] ), [
					'size' => $raw_content['image_size'],
					'icon' => false,
					'attr' => apply_filters_deprecated( 'hogan/module/image/attachment/attr', [ [] ], '1.1.0', 'hogan/module/image/image/args' ),
				] );

				$image['id'] = $raw_content['image_id'];
				$this->image = $image;

				// Add image size classname to wrapper.
				$this->outer_wrapper_classnames = [ 'hogan-image-size-' . $image['size'] ];
			}

			parent::load_args_from_layout_content( $raw_content, $counter );
		}

		/**
		 * Validate module content before template is loaded.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function validate_args() : bool {
			return ! empty( $this->image );
		}
	}
}
