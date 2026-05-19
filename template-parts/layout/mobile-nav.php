<?php
/**
 * Mobile navigation layout.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#';
$cdplay_account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
?>

<nav class="cdplay-mobile-bottom-nav" aria-label="<?php esc_attr_e('Mobile platform navigation', 'cdplay'); ?>">
	<a class="cdplay-mobile-bottom-nav__item" href="<?php echo esc_url(home_url('/playstation/')); ?>">
		<span><?php esc_html_e('PlayStation', 'cdplay'); ?></span>
	</a>
	<a class="cdplay-mobile-bottom-nav__item" href="<?php echo esc_url(home_url('/xbox/')); ?>">
		<span><?php esc_html_e('Xbox', 'cdplay'); ?></span>
	</a>
	<a class="cdplay-mobile-bottom-nav__item" href="<?php echo esc_url(home_url('/nintendo/')); ?>">
		<span><?php esc_html_e('Nintendo', 'cdplay'); ?></span>
	</a>
	<a class="cdplay-mobile-bottom-nav__item" href="<?php echo esc_url(home_url('/pc/')); ?>">
		<span><?php esc_html_e('PC', 'cdplay'); ?></span>
	</a>
	<button
		class="cdplay-mobile-bottom-nav__item"
		type="button"
		aria-label="<?php esc_attr_e('Open menu', 'cdplay'); ?>"
		aria-controls="cdplay-mobile-menu"
		aria-expanded="false"
		data-cdplay-open-label="<?php esc_attr_e('Open menu', 'cdplay'); ?>"
		data-cdplay-close-label="<?php esc_attr_e('Close menu', 'cdplay'); ?>"
		data-cdplay-mobile-nav-toggle
	>
		<span><?php esc_html_e('Menu', 'cdplay'); ?></span>
	</button>
</nav>

<div
	id="cdplay-mobile-menu"
	class="cdplay-mobile-menu"
	role="dialog"
	aria-modal="true"
	aria-labelledby="cdplay-mobile-menu-title"
	hidden
	data-cdplay-mobile-menu
>
	<div class="cdplay-mobile-menu__panel">
		<div class="cdplay-mobile-menu__header">
			<h2 id="cdplay-mobile-menu-title"><?php esc_html_e('Navigation', 'cdplay'); ?></h2>
			<button
				class="cdplay-mobile-menu__close"
				type="button"
				aria-label="<?php esc_attr_e('Close menu', 'cdplay'); ?>"
				data-cdplay-mobile-nav-close
			>
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<div class="cdplay-mobile-menu__platforms" role="group" aria-label="<?php esc_attr_e('Platforms', 'cdplay'); ?>">
			<a href="<?php echo esc_url(home_url('/playstation/')); ?>"><?php esc_html_e('PlayStation', 'cdplay'); ?></a>
			<a href="<?php echo esc_url(home_url('/xbox/')); ?>"><?php esc_html_e('Xbox', 'cdplay'); ?></a>
			<a href="<?php echo esc_url(home_url('/nintendo/')); ?>"><?php esc_html_e('Nintendo', 'cdplay'); ?></a>
			<a href="<?php echo esc_url(home_url('/pc/')); ?>"><?php esc_html_e('PC', 'cdplay'); ?></a>
		</div>

		<nav class="cdplay-mobile-menu__nav" aria-label="<?php esc_attr_e('Mobile menu', 'cdplay'); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'mobile',
					'container'      => false,
					'menu_class'     => 'cdplay-mobile-menu__list',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<div class="cdplay-mobile-menu__actions" role="group" aria-label="<?php esc_attr_e('Quick actions', 'cdplay'); ?>">
			<a href="<?php echo esc_url(home_url('/?s=')); ?>"><?php esc_html_e('Search', 'cdplay'); ?></a>
			<a href="#"><?php esc_html_e('Favorites', 'cdplay'); ?></a>
			<a href="<?php echo esc_url($cdplay_cart_url); ?>"><?php esc_html_e('Cart', 'cdplay'); ?></a>
			<a href="<?php echo esc_url($cdplay_account_url); ?>"><?php esc_html_e('Profile', 'cdplay'); ?></a>
		</div>
	</div>
</div>
