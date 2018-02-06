<?php
/**
 * Template for image module
 *
 * $this is an instance of the Image object.
 * Available properties:
 * $this->image (array|null) Image.
 *
 * @package Hogan
 */

declare( strict_types=1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Image ) ) {
	return; // Exit if accessed directly.
}

if ( empty( $this->image ) ) {
	return;
}

printf( '<figure class="%s">',
	esc_attr( hogan_classnames(
		apply_filters( 'hogan/module/image/figure_classes', [ 'wp-caption', 'size-' . $this->image['size'] ], $this )
	) )
);

if ( ! empty( $this->heading ) ) {
	hogan_component( 'heading', [
		'title' => $this->heading,
	] );
}

echo wp_get_attachment_image(
	$this->image['id'],
	$this->image['size'],
	$this->image['icon'],
	$this->image['attr']
);

$caption = apply_filters( 'hogan/module/image/template/caption', $this->caption, $this );
if ( ! empty( $caption ) ) {
	hogan_component( 'caption', [
		'classname' => apply_filters( 'hogan/module/image/figure_caption_classes', [ 'wp-caption-text' ], $this ),
		'content'   => $caption,
	] );
}

echo '</figure>';
