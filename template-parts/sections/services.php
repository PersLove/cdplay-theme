<?php
/**
 * Services lifestyle scenarios section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_services = array(
	array(
		'slug'   => 'trade-in',
		'label'  => __('Trade-In', 'cdplay'),
		'title'  => __('Старая приставка может стать новой', 'cdplay'),
		'text'   => __('Принеси свою консоль, а мы поможем обновиться на актуальную платформу без лишней суеты.', 'cdplay'),
		'points' => array(
			__('Оценим устройство', 'cdplay'),
			__('Подскажем варианты', 'cdplay'),
			__('Поможем перейти на новую консоль', 'cdplay'),
		),
		'cta'    => __('Узнать про Trade-In', 'cdplay'),
		'url'    => home_url('/trade-in/'),
	),
	array(
		'slug'   => 'rental',
		'label'  => __('Аренда', 'cdplay'),
		'title'  => __('Игровой вечер без покупки консоли', 'cdplay'),
		'text'   => __('Взял приставку на вечер, выходные или праздник — и просто играешь с друзьями или семьей.', 'cdplay'),
		'points' => array(
			__('Для вечеринок', 'cdplay'),
			__('Для семейных вечеров', 'cdplay'),
			__('Для знакомства с платформой', 'cdplay'),
		),
		'cta'    => __('Посмотреть аренду', 'cdplay'),
		'url'    => home_url('/rental/'),
	),
);
?>

<section class="cdplay-services" aria-labelledby="cdplay-services-title">
	<div class="cdplay-services__inner cdplay-container">
		<header class="cdplay-services__header">
			<p class="cdplay-services__eyebrow">
				<?php esc_html_e('Играть проще', 'cdplay'); ?>
			</p>

			<h2 id="cdplay-services-title" class="cdplay-services__title">
				<?php esc_html_e('Не обязательно покупать всё сразу', 'cdplay'); ?>
			</h2>

			<p class="cdplay-services__text">
				<?php esc_html_e('Можно обменять старую приставку, взять консоль в аренду или собрать игровой вечер без лишних сложностей.', 'cdplay'); ?>
			</p>
		</header>

		<div class="cdplay-services__grid">
			<?php foreach ($cdplay_services as $cdplay_service) : ?>
				<article class="cdplay-service-card cdplay-service-card--<?php echo esc_attr(sanitize_html_class($cdplay_service['slug'])); ?>">
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
