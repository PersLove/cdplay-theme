<?php
/**
 * Site header layout.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#';
$cdplay_account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
?>

<header class="cdplay-site-header" data-cdplay-header>
	<div class="cdplay-site-header__inner cdplay-container">
		<div class="cdplay-site-header__brand">
			<?php if (has_custom_logo()) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="cdplay-site-logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
					<?php echo esc_html(get_bloginfo('name')); ?>
				</a>
			<?php endif; ?>
		</div>

		<nav class="cdplay-primary-nav" aria-label="<?php esc_attr_e('Primary navigation', 'cdplay'); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'cdplay-primary-nav__list',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<div class="cdplay-header-actions" role="group" aria-label="<?php esc_attr_e('Header actions', 'cdplay'); ?>">
			<a class="cdplay-header-action" href="<?php echo esc_url(home_url('/?s=')); ?>" aria-label="<?php esc_attr_e('Search', 'cdplay'); ?>">
				<span aria-hidden="true">Search</span>
			</a>
			<a class="cdplay-header-action" href="#" aria-label="<?php esc_attr_e('Favorites', 'cdplay'); ?>">
				<span aria-hidden="true">Favorites</span>
			</a>
			<a class="cdplay-header-action" href="<?php echo esc_url($cdplay_cart_url); ?>" aria-label="<?php esc_attr_e('Cart', 'cdplay'); ?>">
				<span aria-hidden="true">Cart</span>
			</a>
			<a class="cdplay-header-action" href="<?php echo esc_url($cdplay_account_url); ?>" aria-label="<?php esc_attr_e('Profile', 'cdplay'); ?>">
				<span aria-hidden="true">Profile</span>
			</a>
			<button
				class="cdplay-mobile-menu-toggle"
				type="button"
					aria-label="<?php esc_attr_e('Open menu', 'cdplay'); ?>"
					aria-controls="cdplay-mobile-menu"
					aria-expanded="false"
					data-cdplay-open-label="<?php esc_attr_e('Open menu', 'cdplay'); ?>"
					data-cdplay-close-label="<?php esc_attr_e('Close menu', 'cdplay'); ?>"
					data-cdplay-mobile-nav-toggle
				>
				<span class="cdplay-mobile-menu-toggle__bar" aria-hidden="true"></span>
				<span class="cdplay-mobile-menu-toggle__bar" aria-hidden="true"></span>
			</button>
		</div>
	</div>
</header>

<?php get_template_part('template-parts/layout/mobile-nav'); ?>
