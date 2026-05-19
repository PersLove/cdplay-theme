<?php
/**
 * Reusable product card foundation.
 *
 * @package CDPLAY
 *
 * @var array $args Product card data.
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_product_card = wp_parse_args(
	isset($args) && is_array($args) ? $args : array(),
	array(
		'product'     => null,
		'slug'        => '',
		'title'       => '',
		'tags'        => array(),
		'description' => '',
		'price'       => '',
		'image'       => '',
		'url'         => '#',
		'cta'         => __('Посмотреть консоль', 'cdplay'),
		'is_catalog'  => false,
		'meta'        => array(),
	)
);

$cdplay_wc_product = $cdplay_product_card['product'];

if ($cdplay_wc_product && class_exists('WC_Product') && $cdplay_wc_product instanceof WC_Product) {
	$cdplay_find_product_attribute = static function($product, $slugs) {
		foreach ($slugs as $slug) {
			$value = $product->get_attribute($slug);

			if ('' !== trim(wp_strip_all_tags((string) $value))) {
				return trim(wp_strip_all_tags((string) $value));
			}
		}

		return '';
	};
	$cdplay_split_product_values = static function($value) {
		$values = preg_split('/\s*[,|\/]\s*/', (string) $value);
		$values = array_filter(
			array_map(
				static function($item) {
					return trim(wp_strip_all_tags((string) $item));
				},
				(array) $values
			)
		);

		return array_values(array_unique($values));
	};
	$cdplay_product_description = $cdplay_wc_product->get_short_description();

	if (!$cdplay_product_description) {
		$cdplay_product_description = $cdplay_wc_product->get_description();
	}

	$cdplay_product_categories = wp_get_post_terms($cdplay_wc_product->get_id(), 'product_cat', array('fields' => 'names'));

	if (is_wp_error($cdplay_product_categories)) {
		$cdplay_product_categories = array();
	}

	$cdplay_product_platforms = array_merge(
		$cdplay_split_product_values($cdplay_find_product_attribute($cdplay_wc_product, array('platform', 'pa_platform', 'platforma', 'pa_platforma'))),
		$cdplay_split_product_values($cdplay_find_product_attribute($cdplay_wc_product, array('compatibility', 'pa_compatibility', 'sovmestimost', 'pa_sovmestimost')))
	);
	$cdplay_product_platforms = array_slice(array_values(array_unique($cdplay_product_platforms)), 0, 4);
	$cdplay_product_genre     = $cdplay_find_product_attribute($cdplay_wc_product, array('genre', 'pa_genre', 'zhanr', 'pa_zhanr', 'type', 'pa_type', 'tip', 'pa_tip'));
	$cdplay_product_year      = $cdplay_find_product_attribute($cdplay_wc_product, array('release_year', 'pa_release_year', 'god-vyhoda', 'pa_god-vyhoda', 'god_vyhoda', 'pa_god_vyhoda'));

	if ('' === $cdplay_product_genre && !empty($cdplay_product_categories)) {
		$cdplay_product_genre = reset($cdplay_product_categories);
	}

	$cdplay_product_card['slug']        = $cdplay_wc_product->get_slug();
	$cdplay_product_card['title']       = $cdplay_wc_product->get_name();
	$cdplay_product_card['description'] = trim(wp_strip_all_tags($cdplay_product_description));
	$cdplay_product_card['price']       = $cdplay_wc_product->get_price_html();
	$cdplay_product_card['url']         = $cdplay_wc_product->get_permalink();
	$cdplay_product_card['cta']         = __('К странице товара', 'cdplay');
	$cdplay_product_card['is_catalog']  = true;
	$cdplay_product_card['tags']        = !empty($cdplay_product_platforms) ? $cdplay_product_platforms : array(
		$cdplay_wc_product->is_in_stock() ? __('В наличии', 'cdplay') : __('Нет в наличии', 'cdplay'),
	);
	$cdplay_product_card['meta']        = array_filter(
		array(
			$cdplay_product_genre,
			$cdplay_product_year ? sprintf(
				/* translators: %s: release year. */
				__('%s г.', 'cdplay'),
				$cdplay_product_year
			) : '',
		)
	);

	if ($cdplay_wc_product->get_image_id()) {
		$cdplay_product_card['image'] = wp_get_attachment_image(
			$cdplay_wc_product->get_image_id(),
			'woocommerce_thumbnail',
			false,
			array(
				'class'   => 'cdplay-product-card__image',
				'loading' => 'lazy',
			)
		);
	}
}

$cdplay_product_slug = sanitize_html_class($cdplay_product_card['slug']);
$cdplay_product_id   = 'cdplay-product-card-title-' . ($cdplay_product_slug ? $cdplay_product_slug : wp_unique_id());
$cdplay_product_classes = array(
	'cdplay-product-card',
	'cdplay-product-card--' . $cdplay_product_slug,
);

if ($cdplay_product_card['is_catalog']) {
	$cdplay_product_classes[] = 'cdplay-product-card--catalog';
}
?>

<article class="<?php echo esc_attr(implode(' ', array_filter($cdplay_product_classes))); ?>" aria-labelledby="<?php echo esc_attr($cdplay_product_id); ?>">
	<div class="cdplay-product-card__media">
		<div class="cdplay-product-card__image-slot">
			<?php if ($cdplay_product_card['image']) : ?>
				<?php echo wp_kses_post($cdplay_product_card['image']); ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="cdplay-product-card__body">
		<?php if (!empty($cdplay_product_card['tags'])) : ?>
			<div class="cdplay-product-card__badges" aria-label="<?php esc_attr_e('Product tags', 'cdplay'); ?>">
				<?php foreach ($cdplay_product_card['tags'] as $cdplay_product_tag) : ?>
					<span class="cdplay-product-card__badge">
						<?php echo esc_html($cdplay_product_tag); ?>
					</span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<h3 id="<?php echo esc_attr($cdplay_product_id); ?>" class="cdplay-product-card__title">
			<?php echo esc_html($cdplay_product_card['title']); ?>
		</h3>

		<?php if ($cdplay_product_card['description']) : ?>
			<p class="cdplay-product-card__description">
				<?php echo esc_html($cdplay_product_card['description']); ?>
			</p>
		<?php endif; ?>

		<?php if ($cdplay_product_card['is_catalog'] && !empty($cdplay_product_card['meta'])) : ?>
			<div class="cdplay-product-card__meta">
				<?php foreach ($cdplay_product_card['meta'] as $cdplay_product_meta_item) : ?>
					<p><?php echo esc_html($cdplay_product_meta_item); ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="cdplay-product-card__footer">
			<?php if ($cdplay_product_card['price']) : ?>
				<p class="cdplay-product-card__price">
					<?php echo wp_kses_post($cdplay_product_card['price']); ?>
				</p>
			<?php endif; ?>

			<a class="cdplay-product-card__cta" href="<?php echo esc_url($cdplay_product_card['url']); ?>">
				<span><?php echo esc_html($cdplay_product_card['cta']); ?></span>
			</a>

			<?php if ($cdplay_product_card['is_catalog']) : ?>
				<a class="cdplay-product-card__cta cdplay-product-card__cta--secondary" href="<?php echo esc_url($cdplay_product_card['url']); ?>">
					<span><?php esc_html_e('Подробнее', 'cdplay'); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</article>
