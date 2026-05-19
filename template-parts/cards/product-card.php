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
	$args,
	array(
		'slug'        => '',
		'title'       => '',
		'tags'        => array(),
		'description' => '',
		'price'       => '',
		'url'         => '#',
		'cta'         => __('Посмотреть консоль', 'cdplay'),
	)
);

$cdplay_product_slug = sanitize_html_class($cdplay_product_card['slug']);
?>

<article class="cdplay-product-card cdplay-product-card--<?php echo esc_attr($cdplay_product_slug); ?>">
	<div class="cdplay-product-card__media" aria-hidden="true">
		<div class="cdplay-product-card__image-slot"></div>
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

		<h3 class="cdplay-product-card__title">
			<?php echo esc_html($cdplay_product_card['title']); ?>
		</h3>

		<p class="cdplay-product-card__description">
			<?php echo esc_html($cdplay_product_card['description']); ?>
		</p>

		<div class="cdplay-product-card__footer">
			<p class="cdplay-product-card__price">
				<?php echo esc_html($cdplay_product_card['price']); ?>
			</p>

			<a class="cdplay-product-card__cta" href="<?php echo esc_url($cdplay_product_card['url']); ?>">
				<?php echo esc_html($cdplay_product_card['cta']); ?>
			</a>
		</div>
	</div>
</article>
