<?php
/**
 * Mobile purchase bar for single product pages.
 *
 * @package CDPLAY
 *
 * @var array $args Mobile purchase bar data.
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_mobile_purchase_bar = wp_parse_args(
	isset($args) && is_array($args) ? $args : array(),
	array(
		'product'          => null,
		'purchase_area_id' => '',
	)
);

$cdplay_mobile_product = $cdplay_mobile_purchase_bar['product'];

if (!$cdplay_mobile_product || !class_exists('WC_Product') || !$cdplay_mobile_product instanceof WC_Product) {
	return;
}

$cdplay_purchase_area_id = sanitize_html_class($cdplay_mobile_purchase_bar['purchase_area_id']);
$cdplay_purchase_href    = $cdplay_purchase_area_id ? '#' . $cdplay_purchase_area_id : '#';
$cdplay_button_text      = __('Выбрать', 'cdplay');
$cdplay_button_classes   = array('cdplay-mobile-purchase-bar__button');
$cdplay_button_attrs     = array();
$cdplay_product_type     = $cdplay_mobile_product->get_type();
$cdplay_is_simple_buy    = $cdplay_mobile_product->is_type('simple') && $cdplay_mobile_product->is_purchasable() && $cdplay_mobile_product->is_in_stock();

if ($cdplay_is_simple_buy) {
	$cdplay_purchase_href  = $cdplay_mobile_product->add_to_cart_url();
	$cdplay_button_text    = __('В корзину', 'cdplay');
	$cdplay_button_classes = array_merge(
		$cdplay_button_classes,
		array(
			'add_to_cart_button',
			'ajax_add_to_cart',
			'product_type_simple',
		)
	);
	$cdplay_button_attrs['data-product_id']  = $cdplay_mobile_product->get_id();
	$cdplay_button_attrs['data-product_sku'] = $cdplay_mobile_product->get_sku();
	$cdplay_button_attrs['aria-label']       = sprintf(
		/* translators: %s: product name. */
		__('Добавить в корзину: %s', 'cdplay'),
		$cdplay_mobile_product->get_name()
	);
} elseif ($cdplay_mobile_product->is_type('variable') || $cdplay_mobile_product->is_type('grouped')) {
	$cdplay_button_text = __('Выбрать вариант', 'cdplay');
	$cdplay_button_attrs['aria-label'] = sprintf(
		/* translators: %s: product name. */
		__('Перейти к выбору варианта товара: %s', 'cdplay'),
		$cdplay_mobile_product->get_name()
	);
} elseif (!$cdplay_mobile_product->is_in_stock()) {
	$cdplay_button_text = __('Подробнее', 'cdplay');
	$cdplay_button_attrs['aria-label'] = sprintf(
		/* translators: %s: product name. */
		__('Посмотреть детали товара: %s', 'cdplay'),
		$cdplay_mobile_product->get_name()
	);
} else {
	$cdplay_button_attrs['aria-label'] = sprintf(
		/* translators: %s: product name. */
		__('Перейти к покупке товара: %s', 'cdplay'),
		$cdplay_mobile_product->get_name()
	);
}
?>

<aside class="cdplay-mobile-purchase-bar" aria-label="<?php esc_attr_e('Покупка товара', 'cdplay'); ?>">
	<div class="cdplay-mobile-purchase-bar__inner">
		<div class="cdplay-mobile-purchase-bar__content">
			<p class="cdplay-mobile-purchase-bar__title">
				<?php echo esc_html($cdplay_mobile_product->get_name()); ?>
			</p>

			<div class="cdplay-mobile-purchase-bar__meta">
				<?php if ($cdplay_mobile_product->get_price_html()) : ?>
					<p class="cdplay-mobile-purchase-bar__price">
						<?php echo wp_kses_post($cdplay_mobile_product->get_price_html()); ?>
					</p>
				<?php endif; ?>

				<p class="cdplay-mobile-purchase-bar__stock cdplay-mobile-purchase-bar__stock--<?php echo esc_attr($cdplay_mobile_product->is_in_stock() ? 'in-stock' : 'out-of-stock'); ?>">
					<?php echo esc_html($cdplay_mobile_product->is_in_stock() ? __('В наличии', 'cdplay') : __('Нет в наличии', 'cdplay')); ?>
				</p>
			</div>
		</div>

		<a
			class="<?php echo esc_attr(implode(' ', array_filter($cdplay_button_classes))); ?>"
			href="<?php echo esc_url($cdplay_purchase_href); ?>"
			data-product_type="<?php echo esc_attr($cdplay_product_type); ?>"
			<?php foreach ($cdplay_button_attrs as $cdplay_attr_name => $cdplay_attr_value) : ?>
				<?php if ('' !== (string) $cdplay_attr_value) : ?>
					<?php echo esc_attr($cdplay_attr_name); ?>="<?php echo esc_attr($cdplay_attr_value); ?>"
				<?php endif; ?>
			<?php endforeach; ?>
		>
			<?php echo esc_html($cdplay_button_text); ?>
		</a>
	</div>
</aside>
