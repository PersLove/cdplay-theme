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
				$cdplay_normalize_attribute_slug = static function($slug) {
					$slug = str_replace('_', '-', sanitize_title((string) $slug));

					if (0 === strpos($slug, 'pa-')) {
						$slug = substr($slug, 3);
					}

					return $slug;
				};
				$cdplay_attribute_map = array(
					array(
						'label' => __('Платформа', 'cdplay'),
						'slugs' => array('platform', 'pa_platform', 'platforma', 'pa_platforma'),
					),
					array(
						'label' => __('Состояние', 'cdplay'),
						'slugs' => array('condition', 'pa_condition', 'sostoyanie', 'pa_sostoyanie'),
					),
					array(
						'label' => __('Совместимость', 'cdplay'),
						'slugs' => array('compatibility', 'pa_compatibility', 'sovmestimost', 'pa_sovmestimost'),
					),
					array(
						'label' => __('Локализация', 'cdplay'),
						'slugs' => array('localization', 'pa_localization', 'lokalizaciya', 'pa_lokalizaciya'),
					),
					array(
						'label' => __('Жанр', 'cdplay'),
						'slugs' => array('genre', 'pa_genre', 'zhanr', 'pa_zhanr'),
					),
					array(
						'label' => __('Год выхода', 'cdplay'),
						'slugs' => array('release_year', 'pa_release_year', 'god_vyhoda', 'pa_god-vyhoda'),
					),
					array(
						'label' => __('Количество игроков', 'cdplay'),
						'slugs' => array('players', 'pa_players', 'kolichestvo-igrokov', 'pa_kolichestvo-igrokov'),
					),
					array(
						'label' => __('Возрастной рейтинг', 'cdplay'),
						'slugs' => array('age_rating', 'pa_age_rating', 'vozrastnoy-reyting', 'pa_vozrastnoy-reyting'),
					),
				);
				$cdplay_attribute_lookup = array();
				$cdplay_generic_attributes = array();

				foreach ($cdplay_single_product->get_attributes() as $cdplay_attribute_key => $cdplay_attribute) {
					if (!is_object($cdplay_attribute) || !method_exists($cdplay_attribute, 'get_name')) {
						continue;
					}

					if (method_exists($cdplay_attribute, 'get_visible') && !$cdplay_attribute->get_visible()) {
						continue;
					}

					$cdplay_attribute_name  = $cdplay_attribute->get_name();
					$cdplay_attribute_value = $cdplay_single_product->get_attribute($cdplay_attribute_name);

					if (!$cdplay_attribute_value && $cdplay_attribute_key !== $cdplay_attribute_name) {
						$cdplay_attribute_value = $cdplay_single_product->get_attribute($cdplay_attribute_key);
					}

					$cdplay_attribute_value = trim(wp_strip_all_tags($cdplay_attribute_value));

					if ('' === $cdplay_attribute_value) {
						continue;
					}

					$cdplay_attribute_label = wc_attribute_label($cdplay_attribute_name, $cdplay_single_product);

					$cdplay_attribute_lookup[$cdplay_normalize_attribute_slug($cdplay_attribute_name)] = $cdplay_attribute_value;
					$cdplay_attribute_lookup[$cdplay_normalize_attribute_slug($cdplay_attribute_key)]  = $cdplay_attribute_value;

					if ('' !== trim(wp_strip_all_tags($cdplay_attribute_label))) {
						$cdplay_generic_attributes[] = array(
							'label' => $cdplay_attribute_label,
							'value' => $cdplay_attribute_value,
						);
					}
				}

				$cdplay_product_info_blocks = array();

				foreach ($cdplay_attribute_map as $cdplay_attribute_group) {
					foreach ($cdplay_attribute_group['slugs'] as $cdplay_attribute_slug) {
						$cdplay_normalized_slug = $cdplay_normalize_attribute_slug($cdplay_attribute_slug);

						if (empty($cdplay_attribute_lookup[$cdplay_normalized_slug])) {
							continue;
						}

						$cdplay_product_info_blocks[] = array(
							'label' => $cdplay_attribute_group['label'],
							'value' => $cdplay_attribute_lookup[$cdplay_normalized_slug],
						);

						break;
					}

					if (8 <= count($cdplay_product_info_blocks)) {
						break;
					}
				}

				if (empty($cdplay_product_info_blocks) && !empty($cdplay_generic_attributes)) {
					$cdplay_product_info_blocks = array_slice($cdplay_generic_attributes, 0, 8);
				}

				$cdplay_find_attribute_value = static function($slugs) use ($cdplay_attribute_lookup, $cdplay_normalize_attribute_slug) {
					foreach ($slugs as $slug) {
						$normalized_slug = $cdplay_normalize_attribute_slug($slug);

						if (!empty($cdplay_attribute_lookup[$normalized_slug])) {
							return $cdplay_attribute_lookup[$normalized_slug];
						}
					}

					return '';
				};
				$cdplay_product_categories = wp_get_post_terms(get_the_ID(), 'product_cat', array('fields' => 'names'));

				if (is_wp_error($cdplay_product_categories)) {
					$cdplay_product_categories = array();
				}

				$cdplay_product_signal = $cdplay_single_product->get_name() . ' ' . implode(' ', $cdplay_product_categories);
				$cdplay_contains_signal = static function($haystack, $needles) {
					$haystack = function_exists('mb_strtolower') ? mb_strtolower((string) $haystack, 'UTF-8') : strtolower((string) $haystack);

					foreach ($needles as $needle) {
						$needle = function_exists('mb_strtolower') ? mb_strtolower((string) $needle, 'UTF-8') : strtolower((string) $needle);

						if ('' !== $needle && false !== strpos($haystack, $needle)) {
							return true;
						}
					}

					return false;
				};
				$cdplay_product_pills = array();
				$cdplay_product_pill_keys = array();
				$cdplay_add_product_pill = static function($label, $type) use (&$cdplay_product_pills, &$cdplay_product_pill_keys) {
					$label = trim(wp_strip_all_tags((string) $label));
					$type  = sanitize_html_class((string) $type);

					if ('' === $label || '' === $type || 5 <= count($cdplay_product_pills)) {
						return;
					}

					$key = sanitize_title($type . '-' . $label);

					if (isset($cdplay_product_pill_keys[$key])) {
						return;
					}

					$cdplay_product_pills[] = array(
						'label' => $label,
						'type'  => $type,
					);
					$cdplay_product_pill_keys[$key] = true;
				};

				$cdplay_platform_pill = $cdplay_find_attribute_value(array('platform', 'pa_platform', 'platforma', 'pa_platforma'));

				if ('' === $cdplay_platform_pill) {
					$cdplay_platform_fallbacks = array(
						'PS5'      => array('ps5', 'playstation 5', 'playstation5'),
						'PS4'      => array('ps4', 'playstation 4', 'playstation4'),
						'Xbox'     => array('xbox', 'series x', 'series s'),
						'Nintendo' => array('nintendo', 'switch'),
						'PC'       => array('pc', 'windows'),
					);

					foreach ($cdplay_platform_fallbacks as $cdplay_platform_label => $cdplay_platform_needles) {
						if ($cdplay_contains_signal($cdplay_product_signal, $cdplay_platform_needles)) {
							$cdplay_platform_pill = $cdplay_platform_label;
							break;
						}
					}
				}

				$cdplay_add_product_pill($cdplay_platform_pill, 'platform');
				$cdplay_add_product_pill($cdplay_find_attribute_value(array('condition', 'pa_condition', 'sostoyanie', 'pa_sostoyanie')), 'condition');

				$cdplay_type_pill = $cdplay_find_attribute_value(array('type', 'pa_type', 'tip', 'pa_tip', 'product-type', 'pa_product-type', 'tip-tovara', 'pa_tip-tovara'));

				if ('' === $cdplay_type_pill) {
					$cdplay_type_fallbacks = array(
						__('Игровой диск', 'cdplay') => array('disc', 'disk', 'диск', 'игра'),
						__('Консоль', 'cdplay')      => array('console', 'consoley', 'konsol', 'консоль', 'приставка'),
						__('Аксессуар', 'cdplay')    => array('accessory', 'accessories', 'aksessuar', 'аксессуар'),
					);

					foreach ($cdplay_type_fallbacks as $cdplay_type_label => $cdplay_type_needles) {
						if ($cdplay_contains_signal($cdplay_product_signal, $cdplay_type_needles)) {
							$cdplay_type_pill = $cdplay_type_label;
							break;
						}
					}
				}

				$cdplay_add_product_pill($cdplay_type_pill, 'type');
				$cdplay_add_product_pill($cdplay_find_attribute_value(array('localization', 'pa_localization', 'lokalizaciya', 'pa_lokalizaciya')), 'localization');
				$cdplay_add_product_pill($cdplay_single_product->is_in_stock() ? __('В наличии', 'cdplay') : __('Нет в наличии', 'cdplay'), 'stock');
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

							<?php if (!empty($cdplay_product_pills)) : ?>
								<div class="cdplay-product-pills" aria-label="<?php esc_attr_e('Ключевые характеристики товара', 'cdplay'); ?>">
									<?php foreach ($cdplay_product_pills as $cdplay_product_pill) : ?>
										<span class="cdplay-product-pill cdplay-product-pill--<?php echo esc_attr($cdplay_product_pill['type']); ?>">
											<?php echo esc_html($cdplay_product_pill['label']); ?>
										</span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

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

					<!-- CDPLAY product info items: <?php echo esc_html((string) count($cdplay_product_info_blocks)); ?> -->
					<?php if (!empty($cdplay_product_info_blocks)) : ?>
						<section class="cdplay-product-info" aria-labelledby="cdplay-product-info-title-<?php echo esc_attr(get_the_ID()); ?>">
							<div class="cdplay-product-info__header">
								<h2 id="cdplay-product-info-title-<?php echo esc_attr(get_the_ID()); ?>" class="cdplay-product-info__title"><?php esc_html_e('Коротко о товаре', 'cdplay'); ?></h2>
							</div>

							<div class="cdplay-product-info__grid">
								<?php foreach ($cdplay_product_info_blocks as $cdplay_product_info_block) : ?>
									<article class="cdplay-product-info__card">
										<p class="cdplay-product-info__label"><?php echo esc_html($cdplay_product_info_block['label']); ?></p>
										<p class="cdplay-product-info__value"><?php echo esc_html($cdplay_product_info_block['value']); ?></p>
									</article>
								<?php endforeach; ?>
							</div>
						</section>
					<?php endif; ?>

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
