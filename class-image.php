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
		 * Image heading - optional
		 *
		 * @var string $heading
		 */
		public $heading;

		/**
		 * Image id for optional use in template.
		 *
		 * @var $image_id
		 */
		public $image_id;

		/**
		 * Image size for use in template.
		 *
		 * @var $image_size
		 */
		public $image_size;

		/**
		 * Rendered image content for use in template.
		 *
		 * @var $image_content
		 */
		public $image_content;

		/**
		 * WYSIWYG caption - optional
		 *
		 * @var string $caption
		 */
		public $caption;

		/**
		 * Figure tag classes for use in template - default is the size-{image_size}.
		 *
		 * @var $figure_wrapper_classes
		 */
		public $figure_wrapper_classes;

		/**
		 * Figcaption classes for use in template - default is the wp-caption-text.
		 *
		 * @var $figure_caption_classes
		 */
		public $figure_caption_classes;

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

			$choices = apply_filters( 'hogan/module/image/field/choices', [
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

			$fields = [];

			if ( true === apply_filters( 'hogan/module/image/field/heading/enabled', true ) ) {
				$fields[] =
					[
						'type'         => 'text',
						'key'          => $this->field_key . '_heading',
						'name'         => 'heading',
						'label'        => __( 'Heading', 'hogan-image' ),
						'instructions' => __( 'Optional heading will show only if filled in.', 'hogan-image' ),
					];
			}

			array_push( $fields,
				[
					'type'          => 'radio',
					'key'           => $this->field_key . '_image_size',
					'name'          => 'image_size',
					'label'         => __( 'Image size', 'nettsteder-mal' ),
					'value'         => is_array( $choices ) && ! empty( $choices ) ? reset( $choices ) : null,
					// Use the first key in the choices array (default thumbnail)
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
				]
			);

			if ( true === apply_filters( 'hogan/module/image/field/caption/enabled', true ) ) {
				$fields[] = [
					'type'         => 'wysiwyg',
					'key'          => $this->field_key . '_caption',
					'name'         => 'caption',
					'label'        => __( 'Caption below the image object.', 'hogan-image' ),
					'delay'        => true,
					'tabs'         => apply_filters( 'hogan/module/image/field/caption/tabs', 'all' ),
					'media_upload' => 0,
					'toolbar'      => apply_filters( 'hogan/module/image/field/caption/toolbar', 'hogan' ),
				];
			}

			return $fields;
		}

		/**
		 * Map fields to object variable.
		 *
		 * @param array $content The content value.
		 */
		public function load_args_from_layout_content( $content ) {
			$this->heading       = isset( $content['heading'] ) ? esc_html( $content['heading'] ) : null;
			$this->image_id      = $content['image_id'];
			$this->image_size    = $content['image_size'];
			$this->image_content = wp_get_attachment_image( $this->image_id, $this->image_size, false, apply_filters( 'hogan/module/image/render/attr', [] ) );
			$embed_allowed_html  = apply_filters( 'hogan/module/image/render/caption/allowed_html', [
				'a' => [
					'href'  => true,
					'title' => true,
					'class' => [],
				],
			] );
			$this->caption       = apply_filters( 'hogan/module/image/render/show_caption', true ) ? wp_kses( ( $content['caption'] ?: get_post_field( 'post_excerpt', $this->image_id ) ), $embed_allowed_html ) : null;

			$figure_wrapper_classes_array   = apply_filters( 'hogan/module/image/render/figure_wrapper_classes', [ 'wp-caption', 'size-' . $this->image_size ], $this );
			$figure_wrapper_classes_escaped = array_map( 'esc_attr', $figure_wrapper_classes_array );
			$this->figure_wrapper_classes   = trim( implode( ' ', array_filter( $figure_wrapper_classes_escaped ) ) );

			$figure_caption_classes_array   = apply_filters( 'hogan/module/image/render/figure_caption_classes', [ 'wp-caption-text' ], $this );
			$figure_caption_classes_escaped = array_map( 'esc_attr', $figure_caption_classes_array );
			$this->figure_caption_classes   = trim( implode( ' ', array_filter( $figure_caption_classes_escaped ) ) );

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
