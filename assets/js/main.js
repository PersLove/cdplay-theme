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
