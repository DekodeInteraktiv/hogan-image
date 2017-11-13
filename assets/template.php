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
	<h2 class="heading"><?php echo esc_html( $this->heading ); ?></h2>
<?php endif; ?>

<?php echo $this->image_content;
