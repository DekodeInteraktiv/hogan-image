<?php
/**
 * Template for image module
 *
 * $this is an instance of the Image object.
 * Available properties:
 * $this->image_id (int) Image id for the image.
 * $this->image_size (string) Image size selected in admin.
 *
 * @package Hogan
 */

declare( strict_types=1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Image ) ) {
	return; // Exit if accessed directly.
}

$figure_classes_array   = apply_filters( 'hogan/module/image/figure_classes', [ 'wp-caption', 'size-' . $this->image_size ], $this );
$figure_classes_escaped = array_map( 'esc_attr', $figure_classes_array );
$figure_classes         = trim( implode( ' ', array_filter( $figure_classes_escaped ) ) );

$figure_caption_classes_array   = apply_filters( 'hogan/module/image/figure_caption_classes', [ 'wp-caption-text' ], $this );
$figure_caption_classes_escaped = array_map( 'esc_attr', $figure_caption_classes_array );
$figure_caption_classes         = trim( implode( ' ', array_filter( $figure_caption_classes_escaped ) ) );

$image_content = wp_get_attachment_image( $this->image_id, $this->image_size, false, apply_filters( 'hogan/module/image/attachment/attr', [] ) );

?>
<?php echo sprintf( '<figure%1$s>', ! empty( $figure_classes ) ? ' class="' . $figure_classes . '"' : '' );
?>

<?php
if ( ! empty( $this->heading ) ) {
	hogan_component( 'heading', [
		'title' => $this->heading,
	] );
}
?>

<?php echo $image_content; ?>

<?php
$caption = apply_filters( 'hogan/module/image/template/caption', $this->caption, $this );

if ( ! empty( $caption ) ) : ?>
	<?php echo sprintf( '<figcaption%1$s>%2$s</figcaption>',
		! empty( $figure_caption_classes ) ? ' class="' . $figure_caption_classes . '"' : '',
		wp_kses( $caption, hogan_caption_allowed_html() )
	); ?>
<?php endif; ?>
</figure>
