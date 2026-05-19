<?php
/**
 * Custom WooCommerce single product template.
 *
 * @package CDPLAY
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<main id="primary" class="cdplay-site-main cdplay-single-product">
	<div class="cdplay-single-product__inner cdplay-container">
		<?php if (class_exists('WooCommerce')) : ?>
			<?php
			while (have_posts()) :
				the_post();

				global $product;

				$cdplay_single_product = $product instanceof WC_Product ? $product : (function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null);

				if (!$cdplay_single_product) {
					continue;
				}

				remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
				?>

				<?php do_action('woocommerce_before_single_product'); ?>

				<?php if (function_exists('woocommerce_breadcrumb')) : ?>
					<nav class="cdplay-single-product__breadcrumbs" aria-label="<?php esc_attr_e('Breadcrumbs', 'cdplay'); ?>">
						<?php woocommerce_breadcrumb(); ?>
					</nav>
				<?php endif; ?>

				<article id="product-<?php the_ID(); ?>" <?php wc_product_class('cdplay-single-product__product', $cdplay_single_product); ?>>
					<div class="cdplay-single-product__shell">
						<div class="cdplay-single-product__media">
							<?php do_action('woocommerce_before_single_product_summary'); ?>
						</div>

						<div class="cdplay-single-product__summary">
							<?php
							do_action('woocommerce_single_product_summary');
							?>
						</div>
					</div>

					<div class="cdplay-single-product__meta">
						<?php do_action('woocommerce_product_meta_start'); ?>
						<?php woocommerce_template_single_meta(); ?>
						<?php do_action('woocommerce_product_meta_end'); ?>
					</div>

					<div class="cdplay-single-product__tabs">
						<?php do_action('woocommerce_after_single_product_summary'); ?>
					</div>
				</article>

				<?php do_action('woocommerce_after_single_product'); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<section class="cdplay-single-product__empty" role="status">
				<h1><?php esc_html_e('Товар временно недоступен', 'cdplay'); ?></h1>
				<p><?php esc_html_e('WooCommerce сейчас не активен, поэтому страница товара не может быть отображена.', 'cdplay'); ?></p>
			</section>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer('shop');
