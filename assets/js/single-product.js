(function () {
	'use strict';

	var body = document.body;
	var mobileBar = document.querySelector('[data-cdplay-mobile-purchase-bar]');
	var purchaseTarget = document.querySelector('[data-cdplay-purchase-target]');
	var visibleClass = 'cdplay-mobile-purchase-visible';
	var mobileQuery = window.matchMedia('(max-width: 47.99rem)');
	var focusableSelector = 'a, button, input, select, textarea, [tabindex]';
	var frame = null;

	if (!body || !mobileBar || !purchaseTarget) {
		return;
	}

	var focusableItems = mobileBar.querySelectorAll(focusableSelector);

	function setMobileBarVisible(isVisible) {
		body.classList.toggle(visibleClass, isVisible);
		mobileBar.setAttribute('aria-hidden', isVisible ? 'false' : 'true');

		focusableItems.forEach(function (item) {
			if (isVisible) {
				if (item.hasAttribute('data-cdplay-original-tabindex')) {
					item.setAttribute('tabindex', item.getAttribute('data-cdplay-original-tabindex'));
					item.removeAttribute('data-cdplay-original-tabindex');
				} else {
					item.removeAttribute('tabindex');
				}

				return;
			}

			if (item.hasAttribute('tabindex')) {
				item.setAttribute('data-cdplay-original-tabindex', item.getAttribute('tabindex'));
			}

			item.setAttribute('tabindex', '-1');
		});
	}

	function shouldShowMobileBar() {
		if (!mobileQuery.matches) {
			return false;
		}

		var targetRect = purchaseTarget.getBoundingClientRect();

		return targetRect.bottom <= 0;
	}

	function updateMobileBar() {
		frame = null;
		setMobileBarVisible(shouldShowMobileBar());
	}

	function requestUpdate() {
		if (frame) {
			return;
		}

		frame = window.requestAnimationFrame(updateMobileBar);
	}

	setMobileBarVisible(false);

	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(
			function () {
				requestUpdate();
			},
			{
				root: null,
				threshold: [0, 0.01, 1],
			}
		);

		observer.observe(purchaseTarget);
	} else {
		window.addEventListener('scroll', requestUpdate, { passive: true });
	}

	window.addEventListener('resize', requestUpdate, { passive: true });

	if (typeof mobileQuery.addEventListener === 'function') {
		mobileQuery.addEventListener('change', requestUpdate);
	} else if (typeof mobileQuery.addListener === 'function') {
		mobileQuery.addListener(requestUpdate);
	}

	requestUpdate();
}());
