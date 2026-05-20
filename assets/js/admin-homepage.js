(function () {
	'use strict';

	if (!window.wp || !window.wp.media) {
		return;
	}

	document.querySelectorAll('[data-cdplay-media-field]').forEach(function (field) {
		var input = field.querySelector('[data-cdplay-media-input]');
		var preview = field.querySelector('[data-cdplay-media-preview]');
		var selectButton = field.querySelector('[data-cdplay-media-select]');
		var removeButton = field.querySelector('[data-cdplay-media-remove]');
		var mediaFrame;

		if (!input || !preview || !selectButton || !removeButton) {
			return;
		}

		selectButton.addEventListener('click', function () {
			if (mediaFrame) {
				mediaFrame.open();
				return;
			}

			mediaFrame = window.wp.media({
				title: 'Select hero image',
				button: {
					text: 'Use this image'
				},
				multiple: false
			});

			mediaFrame.on('select', function () {
				var attachment = mediaFrame.state().get('selection').first().toJSON();
				var previewUrl = attachment.url;

				if (attachment.sizes && attachment.sizes.medium) {
					previewUrl = attachment.sizes.medium.url;
				}

				input.value = attachment.id;
				preview.src = previewUrl;
				preview.style.display = 'block';
			});

			mediaFrame.open();
		});

		removeButton.addEventListener('click', function () {
			input.value = '';
			preview.removeAttribute('src');
			preview.style.display = 'none';
		});
	});
}());
