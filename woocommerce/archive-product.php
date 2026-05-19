<?php
/**
 * Custom WooCommerce product archive.
 *
 * @package CDPLAY
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<main id="primary" class="cdplay-site-main cdplay-catalog">
	<section class="cdplay-catalog__inner cdplay-container" aria-labelledby="cdplay-catalog-title">
		<header class="cdplay-catalog__header">
			<p class="cdplay-catalog__eyebrow">
				<?php esc_html_e('Каталог', 'cdplay'); ?>
			</p>

			<h1 id="cdplay-catalog-title" class="cdplay-catalog__title">
				<?php esc_html_e('Игровые приставки, игры и аксессуары', 'cdplay'); ?>
			</h1>

			<p class="cdplay-catalog__text">
				<?php esc_html_e('Выбирай платформу, настроение и формат игры — а не просто строку в каталоге.', 'cdplay'); ?>
			</p>
		</header>

		<?php if (class_exists('WooCommerce')) : ?>
			<?php if (function_exists('woocommerce_output_all_notices')) : ?>
				<?php woocommerce_output_all_notices(); ?>
			<?php endif; ?>

			<?php if (woocommerce_product_loop()) : ?>
				<?php
				remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
				remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
				remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

				do_action('woocommerce_before_shop_loop');
				?>

				<div class="cdplay-catalog__toolbar">
					<div class="cdplay-catalog__result-count">
						<?php
						if (function_exists('woocommerce_result_count')) {
							woocommerce_result_count();
						}
						?>
					</div>

					<div class="cdplay-catalog__ordering">
						<?php
						if (function_exists('woocommerce_catalog_ordering')) {
							woocommerce_catalog_ordering();
						}
						?>
					</div>
				</div>
				<div class="cdplay-catalog__grid">
					<?php
					while (have_posts()) :
						the_post();

						$cdplay_loop_product = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;

						if (!$cdplay_loop_product) {
							continue;
						}

						get_template_part(
							'template-parts/cards/product-card',
							null,
							array(
								'product' => $cdplay_loop_product,
							)
						);
					endwhile;
					?>
				</div>

				<?php do_action('woocommerce_after_shop_loop'); ?>
			<?php else : ?>
				<div class="cdplay-catalog__empty" role="status">
					<h2><?php esc_html_e('Пока ничего не нашли', 'cdplay'); ?></h2>
					<p><?php esc_html_e('Скоро здесь появятся консоли, игры и аксессуары CDPLAY. А пока можно выбрать настроение и платформу на главной.', 'cdplay'); ?></p>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<div class="cdplay-catalog__empty" role="status">
				<h2><?php esc_html_e('Каталог временно недоступен', 'cdplay'); ?></h2>
				<p><?php esc_html_e('WooCommerce сейчас не активен, поэтому товары не отображаются.', 'cdplay'); ?></p>
			</div>
		<?php endif; ?>
	</section>
</main>

<?php
get_footer('shop');
