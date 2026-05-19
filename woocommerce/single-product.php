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

				$cdplay_product_image_ids = array_filter(
					array_unique(
						array_merge(
							array($cdplay_single_product->get_image_id()),
							$cdplay_single_product->get_gallery_image_ids()
						)
					)
				);
				$cdplay_primary_image_id  = reset($cdplay_product_image_ids);
				$cdplay_get_image_aspect  = static function($image_id, $is_featured = false) {
					if ($is_featured) {
						return 'square';
					}

					$metadata = wp_get_attachment_metadata($image_id);
					$width    = isset($metadata['width']) ? (int) $metadata['width'] : 0;
					$height   = isset($metadata['height']) ? (int) $metadata['height'] : 0;

					if ($width > 0 && $height > 0 && $width > $height) {
						return 'wide';
					}

					return 'square';
				};
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
							<section class="cdplay-product-gallery" aria-label="<?php esc_attr_e('Галерея товара', 'cdplay'); ?>" data-cdplay-product-gallery>
								<div class="cdplay-product-gallery__main">
									<div class="cdplay-product-gallery__viewport is-square" data-cdplay-product-gallery-viewport>
										<?php if ($cdplay_primary_image_id) : ?>
											<?php
											echo wp_get_attachment_image(
												$cdplay_primary_image_id,
												'woocommerce_single',
												false,
												array(
													'class'   => 'cdplay-product-gallery__image cdplay-product-gallery__image--square',
													'loading' => 'eager',
													'data-cdplay-product-gallery-image' => '',
													'data-image-aspect' => 'square',
													'data-aspect' => 'square',
												)
											);
											?>
										<?php else : ?>
											<div class="cdplay-product-gallery__placeholder" aria-hidden="true"></div>
										<?php endif; ?>
									</div>
								</div>

								<?php if (count($cdplay_product_image_ids) > 1) : ?>
									<div class="cdplay-product-gallery__thumbs" role="list" aria-label="<?php esc_attr_e('Изображения товара', 'cdplay'); ?>">
										<?php foreach ($cdplay_product_image_ids as $cdplay_gallery_index => $cdplay_gallery_image_id) : ?>
											<?php
											$cdplay_gallery_full_src = wp_get_attachment_image_url($cdplay_gallery_image_id, 'woocommerce_single');
											$cdplay_gallery_srcset   = wp_get_attachment_image_srcset($cdplay_gallery_image_id, 'woocommerce_single');
											$cdplay_gallery_sizes    = wp_get_attachment_image_sizes($cdplay_gallery_image_id, 'woocommerce_single');
											$cdplay_gallery_alt      = get_post_meta($cdplay_gallery_image_id, '_wp_attachment_image_alt', true);
											$cdplay_gallery_aspect   = $cdplay_get_image_aspect($cdplay_gallery_image_id, 0 === $cdplay_gallery_index);
											?>
											<div class="cdplay-product-gallery__thumb <?php echo 0 === $cdplay_gallery_index ? 'cdplay-product-gallery__thumb--active' : ''; ?>" role="listitem">
												<button
													class="cdplay-product-gallery__thumb-button"
													type="button"
													aria-label="<?php echo esc_attr(sprintf(__('Показать изображение %d', 'cdplay'), $cdplay_gallery_index + 1)); ?>"
													aria-selected="<?php echo 0 === $cdplay_gallery_index ? 'true' : 'false'; ?>"
													data-cdplay-product-gallery-thumb
													data-image-src="<?php echo esc_url($cdplay_gallery_full_src); ?>"
													data-image-srcset="<?php echo esc_attr($cdplay_gallery_srcset); ?>"
													data-image-sizes="<?php echo esc_attr($cdplay_gallery_sizes); ?>"
													data-image-alt="<?php echo esc_attr($cdplay_gallery_alt); ?>"
													data-image-aspect="<?php echo esc_attr($cdplay_gallery_aspect); ?>"
													data-aspect="<?php echo esc_attr($cdplay_gallery_aspect); ?>"
												>
													<?php
													echo wp_get_attachment_image(
														$cdplay_gallery_image_id,
														'woocommerce_thumbnail',
														false,
														array(
															'class'   => 'cdplay-product-gallery__thumb-image',
															'loading' => 'lazy',
														)
													);
													?>
												</button>
											</div>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</section>
						</div>

						<div class="cdplay-single-product__summary">
							<h1 class="cdplay-single-product__title"><?php echo esc_html($cdplay_single_product->get_name()); ?></h1>

							<?php if ($cdplay_single_product->get_price_html()) : ?>
								<p class="cdplay-single-product__price"><?php echo wp_kses_post($cdplay_single_product->get_price_html()); ?></p>
							<?php endif; ?>

							<p class="cdplay-single-product__availability cdplay-single-product__availability--<?php echo esc_attr($cdplay_single_product->is_in_stock() ? 'in-stock' : 'out-of-stock'); ?>">
								<?php echo esc_html($cdplay_single_product->is_in_stock() ? __('В наличии', 'cdplay') : __('Нет в наличии', 'cdplay')); ?>
							</p>

							<?php if ($cdplay_single_product->get_short_description()) : ?>
								<div class="cdplay-single-product__short-description">
									<?php echo wp_kses_post(wpautop($cdplay_single_product->get_short_description())); ?>
								</div>
							<?php endif; ?>

							<div class="cdplay-single-product__cart">
								<?php
								$cdplay_add_to_cart_text = static function() {
									return __('Добавить в корзину', 'cdplay');
								};

								add_filter('woocommerce_product_single_add_to_cart_text', $cdplay_add_to_cart_text);
								woocommerce_template_single_add_to_cart();
								remove_filter('woocommerce_product_single_add_to_cart_text', $cdplay_add_to_cart_text);
								?>
							</div>

							<div class="cdplay-single-product__meta">
								<?php do_action('woocommerce_product_meta_start'); ?>
								<?php woocommerce_template_single_meta(); ?>
								<?php do_action('woocommerce_product_meta_end'); ?>
							</div>
						</div>
					</div>

					<div class="cdplay-single-product__tabs">
						<?php woocommerce_output_product_data_tabs(); ?>
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
