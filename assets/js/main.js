(function () {
	'use strict';

	var menu = document.querySelector('[data-cdplay-mobile-menu]');
	var toggles = document.querySelectorAll('[data-cdplay-mobile-nav-toggle]');
	var closeButton = document.querySelector('[data-cdplay-mobile-nav-close]');
	var activeElement = null;

	if (!menu || !toggles.length) {
		return;
	}

	function setToggleState(isOpen) {
		toggles.forEach(function (toggle) {
			var openLabel = toggle.getAttribute('data-cdplay-open-label') || 'Open menu';
			var closeLabel = toggle.getAttribute('data-cdplay-close-label') || 'Close menu';

			toggle.setAttribute('aria-expanded', String(isOpen));
			toggle.setAttribute(
				'aria-label',
				isOpen ? closeLabel : openLabel
			);
		});
	}

	function openMenu() {
		activeElement = document.activeElement;
		menu.hidden = false;
		document.body.classList.add('cdplay-mobile-menu-is-open');
		setToggleState(true);

		if (closeButton) {
			closeButton.focus();
		}
	}

	function closeMenu() {
		menu.hidden = true;
		document.body.classList.remove('cdplay-mobile-menu-is-open');
		setToggleState(false);

		if (activeElement && typeof activeElement.focus === 'function') {
			activeElement.focus();
		}
	}

	toggles.forEach(function (toggle) {
		toggle.addEventListener('click', function () {
			if (menu.hidden) {
				openMenu();
			} else {
				closeMenu();
			}
		});
	});

	if (closeButton) {
		closeButton.addEventListener('click', closeMenu);
	}

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape' && !menu.hidden) {
			closeMenu();
		}
	});
}());

(function () {
	'use strict';

	document.addEventListener('click', function (event) {
		var thumbButton = event.target.closest('[data-cdplay-product-gallery-thumb]');

		if (!thumbButton) {
			return;
		}

		var gallery = thumbButton.closest('[data-cdplay-product-gallery]');
		var mainImage = gallery ? gallery.querySelector('[data-cdplay-product-gallery-image]') : null;

		if (!gallery || !mainImage) {
			return;
		}

		var imageSrc = thumbButton.getAttribute('data-image-src');
		var imageSrcset = thumbButton.getAttribute('data-image-srcset');
		var imageSizes = thumbButton.getAttribute('data-image-sizes');
		var imageAlt = thumbButton.getAttribute('data-image-alt') || '';

		if (!imageSrc) {
			return;
		}

		mainImage.setAttribute('src', imageSrc);
		mainImage.setAttribute('alt', imageAlt);

		if (imageSrcset) {
			mainImage.setAttribute('srcset', imageSrcset);
		} else {
			mainImage.removeAttribute('srcset');
		}

		if (imageSizes) {
			mainImage.setAttribute('sizes', imageSizes);
		} else {
			mainImage.removeAttribute('sizes');
		}

		gallery.querySelectorAll('.cdplay-product-gallery__thumb').forEach(function (thumb) {
			thumb.classList.remove('cdplay-product-gallery__thumb--active');
		});

		gallery.querySelectorAll('[data-cdplay-product-gallery-thumb]').forEach(function (button) {
			button.setAttribute('aria-selected', 'false');
		});

		thumbButton.setAttribute('aria-selected', 'true');
		thumbButton.closest('.cdplay-product-gallery__thumb').classList.add('cdplay-product-gallery__thumb--active');
	});
}());
