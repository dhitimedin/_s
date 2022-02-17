<?php
/**
 * The template for displaying search forms
 *
 * @package _s
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<form method="get" class="form-floating d-flex ms-lg-5" id="demo-2" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
        <input class="form-control customsearch" id="s" name="s" type="text" id="floatingInput"
			placeholder="<?php esc_attr_e( 'Search &hellip;', '_s' ); ?>">
        <label for="floatingInput position-relative"><i class="bi bi-search fs-3 text-primary position-absolute translate-middle-y"></i></label>
</form>