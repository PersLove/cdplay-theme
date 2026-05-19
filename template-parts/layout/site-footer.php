<?php
/**
 * Site footer layout.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}
?>

<footer class="cdplay-site-footer">
	<div class="cdplay-site-footer__inner cdplay-container">
		<div class="cdplay-site-footer__brand">
			<a class="cdplay-site-logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
				<?php echo esc_html(get_bloginfo('name')); ?>
			</a>
		</div>

		<nav class="cdplay-footer-nav" aria-label="<?php esc_attr_e('Footer navigation', 'cdplay'); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'cdplay-footer-nav__list',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<p class="cdplay-site-footer__copyright">
			&copy;
			<?php
			printf(
				esc_html__('%1$s %2$s. All rights reserved.', 'cdplay'),
				esc_html(gmdate('Y')),
				esc_html(get_bloginfo('name'))
			);
			?>
		</p>
	</div>
</footer>
