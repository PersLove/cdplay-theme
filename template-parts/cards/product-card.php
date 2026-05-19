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
	)
);

$cdplay_wc_product = $cdplay_product_card['product'];

if ($cdplay_wc_product && class_exists('WC_Product') && $cdplay_wc_product instanceof WC_Product) {
	$cdplay_product_description = $cdplay_wc_product->get_short_description();

	if (!$cdplay_product_description) {
		$cdplay_product_description = $cdplay_wc_product->get_description();
	}

	$cdplay_product_card['slug']        = $cdplay_wc_product->get_slug();
	$cdplay_product_card['title']       = $cdplay_wc_product->get_name();
	$cdplay_product_card['description'] = wp_strip_all_tags(wp_trim_words($cdplay_product_description, 22));
	$cdplay_product_card['price']       = $cdplay_wc_product->get_price_html();
	$cdplay_product_card['url']         = $cdplay_wc_product->get_permalink();
	$cdplay_product_card['tags']        = array(
		$cdplay_wc_product->is_in_stock() ? __('В наличии', 'cdplay') : __('Нет в наличии', 'cdplay'),
	);

	if ($cdplay_wc_product->is_featured()) {
		$cdplay_product_card['tags'][] = __('Выбор CDPLAY', 'cdplay');
	}

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
?>

<article class="cdplay-product-card cdplay-product-card--<?php echo esc_attr($cdplay_product_slug); ?>" aria-labelledby="<?php echo esc_attr($cdplay_product_id); ?>">
	<div class="cdplay-product-card__media" aria-hidden="true">
		<div class="cdplay-product-card__image-slot">
			<?php if ($cdplay_product_card['image']) : ?>
				<?php echo wp_kses_post($cdplay_product_card['image']); ?>
			<?php endif; ?>
		</div>
		<div class="cdplay-product-card__wishlist-slot"></div>
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

		<div class="cdplay-product-card__footer">
			<?php if ($cdplay_product_card['price']) : ?>
				<p class="cdplay-product-card__price">
					<?php echo wp_kses_post($cdplay_product_card['price']); ?>
				</p>
			<?php endif; ?>

			<a class="cdplay-product-card__cta" href="<?php echo esc_url($cdplay_product_card['url']); ?>">
				<?php echo esc_html($cdplay_product_card['cta']); ?>
			</a>
		</div>
	</div>
</article>
