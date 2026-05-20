<?php
/**
 * Services lifestyle scenarios section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_services_eyebrow = cdplay_get_homepage_option(
	'services_eyebrow',
	__('Играть проще', 'cdplay')
);

$cdplay_services_title = cdplay_get_homepage_option(
	'services_title',
	__('Не обязательно покупать всё сразу', 'cdplay')
);

$cdplay_services_description = cdplay_get_homepage_option(
	'services_description',
	__('Можно обменять старую приставку, взять консоль в аренду или собрать игровой вечер без лишних сложностей.', 'cdplay')
);

$cdplay_services = array(
	array(
		'slug'   => 'trade-in',
		'label'  => cdplay_get_homepage_card_field('services', 'trade-in', 'label', __('Trade-In', 'cdplay')),
		'title'  => cdplay_get_homepage_card_field('services', 'trade-in', 'title', __('Старая приставка может стать новой', 'cdplay')),
		'text'   => cdplay_get_homepage_card_field('services', 'trade-in', 'text', __('Принеси свою консоль, а мы поможем обновиться на актуальную платформу без лишней суеты.', 'cdplay')),
		'points' => array(
			cdplay_get_homepage_card_field('services', 'trade-in', 'point_1', __('Оценим устройство', 'cdplay')),
			cdplay_get_homepage_card_field('services', 'trade-in', 'point_2', __('Подскажем варианты', 'cdplay')),
			cdplay_get_homepage_card_field('services', 'trade-in', 'point_3', __('Поможем перейти на новую консоль', 'cdplay')),
		),
		'cta'    => cdplay_get_homepage_card_field('services', 'trade-in', 'cta', __('Узнать про Trade-In', 'cdplay')),
		'url'    => cdplay_get_homepage_card_field('services', 'trade-in', 'url', home_url('/trade-in/')),
	),
	array(
		'slug'   => 'rental',
		'label'  => cdplay_get_homepage_card_field('services', 'rental', 'label', __('Аренда', 'cdplay')),
		'title'  => cdplay_get_homepage_card_field('services', 'rental', 'title', __('Игровой вечер без покупки консоли', 'cdplay')),
		'text'   => cdplay_get_homepage_card_field('services', 'rental', 'text', __('Взял приставку на вечер, выходные или праздник — и просто играешь с друзьями или семьей.', 'cdplay')),
		'points' => array(
			cdplay_get_homepage_card_field('services', 'rental', 'point_1', __('Для вечеринок', 'cdplay')),
			cdplay_get_homepage_card_field('services', 'rental', 'point_2', __('Для семейных вечеров', 'cdplay')),
			cdplay_get_homepage_card_field('services', 'rental', 'point_3', __('Для знакомства с платформой', 'cdplay')),
		),
		'cta'    => cdplay_get_homepage_card_field('services', 'rental', 'cta', __('Посмотреть аренду', 'cdplay')),
		'url'    => cdplay_get_homepage_card_field('services', 'rental', 'url', home_url('/rental/')),
	),
);

$cdplay_services = array_filter(
	$cdplay_services,
	static function ($cdplay_service): bool {
		return cdplay_is_homepage_card_enabled('services', $cdplay_service['slug']);
	}
);

if (empty($cdplay_services)) {
	return;
}
?>

<section class="cdplay-services" aria-labelledby="cdplay-services-title">
	<div class="cdplay-services__inner cdplay-container">
		<header class="cdplay-services__header">
			<p class="cdplay-services__eyebrow">
				<?php echo esc_html($cdplay_services_eyebrow); ?>
			</p>

			<h2 id="cdplay-services-title" class="cdplay-services__title">
				<?php echo esc_html($cdplay_services_title); ?>
			</h2>

			<p class="cdplay-services__text">
				<?php echo esc_html($cdplay_services_description); ?>
			</p>
		</header>

		<div class="cdplay-services__grid">
			<?php foreach ($cdplay_services as $cdplay_service) : ?>
				<?php
				$cdplay_service_style = cdplay_get_homepage_card_media_styles(
					'services',
					$cdplay_service['slug'],
					array(
						'photo_image_id' => '--cdplay-service-card-photo',
						'icon_id'        => '--cdplay-service-card-icon',
					)
				);
				?>
				<article class="cdplay-service-card cdplay-service-card--<?php echo esc_attr(sanitize_html_class($cdplay_service['slug'])); ?>"<?php echo $cdplay_service_style ? ' style="' . esc_attr($cdplay_service_style) . '"' : ''; ?>>
					<div class="cdplay-service-card__media" aria-hidden="true">
						<div class="cdplay-service-card__photo-slot"></div>
						<div class="cdplay-service-card__icon-slot"></div>
					</div>

					<div class="cdplay-service-card__content">
						<p class="cdplay-service-card__label">
							<?php echo esc_html($cdplay_service['label']); ?>
						</p>

						<h3 class="cdplay-service-card__title">
							<?php echo esc_html($cdplay_service['title']); ?>
						</h3>

						<p class="cdplay-service-card__text">
							<?php echo esc_html($cdplay_service['text']); ?>
						</p>

						<ul class="cdplay-service-card__points">
							<?php foreach ($cdplay_service['points'] as $cdplay_service_point) : ?>
								<li><?php echo esc_html($cdplay_service_point); ?></li>
							<?php endforeach; ?>
						</ul>

						<a class="cdplay-service-card__cta" href="<?php echo esc_url($cdplay_service['url']); ?>">
							<?php echo esc_html($cdplay_service['cta']); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
