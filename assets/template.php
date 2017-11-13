<?php
/**
 * Template for image module
 *
 * $this is an instance of the Image object.
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Image ) ) {
	return; // Exit if accessed directly.
}
?>

<?php if ( ! empty( $this->heading ) ) : ?>
	<h2 class="heading"><?php echo $this->heading; ?></h2>
<?php endif; ?>

<?php echo $this->image_content; ?>
<?php if ( ! empty( $this->caption ) ) : ?>
	<?php echo sprintf( '<figcaption%1$s>%2$s</figcaption>',
		! empty( $this->figure_caption_classes ) ? ' class="' . $this->figure_caption_classes . '"' : '',
		$this->caption
	); ?>
<?php endif; ?>
