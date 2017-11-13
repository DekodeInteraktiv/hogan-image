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

<figure class="<?php echo $this->figure_wrapper_classes; ?>">
	<?php echo $this->image_content; ?>
	<?php if ( ! empty( $this->caption ) ) : ?>
		<figcaption><?php echo $this->caption; ?></figcaption>
	<?php endif; ?>
</figure>
