(function () {
	'use strict';

	var WIDGET_SELECTOR = '.ddm-woo-product-image';
	var THUMB_SELECTOR = '.ddm-woo-product-image__thumb';
	var MAIN_IMAGE_SELECTOR = '.ddm-woo-product-image__main-image';

	function toArray(nodeList) {
		return Array.prototype.slice.call(nodeList || []);
	}

	function setMainImage(mainImage, thumbButton) {
		if (!mainImage || !thumbButton) {
			return;
		}

		var fullSrc = thumbButton.getAttribute('data-full-src') || '';
		var fullSrcset = thumbButton.getAttribute('data-full-srcset') || '';
		var fullSizes = thumbButton.getAttribute('data-full-sizes') || '';
		var fullAlt = thumbButton.getAttribute('data-full-alt') || '';

		if (fullSrc) {
			mainImage.setAttribute('src', fullSrc);
		}

		if (fullSrcset) {
			mainImage.setAttribute('srcset', fullSrcset);
		} else {
			mainImage.removeAttribute('srcset');
		}

		if (fullSizes) {
			mainImage.setAttribute('sizes', fullSizes);
		} else {
			mainImage.removeAttribute('sizes');
		}

		if (fullAlt) {
			mainImage.setAttribute('alt', fullAlt);
		}
	}

	function setActiveThumb(thumbs, activeButton) {
		thumbs.forEach(function (thumb) {
			var isActive = thumb === activeButton;
			thumb.classList.toggle('is-active', isActive);
			thumb.setAttribute('aria-current', isActive ? 'true' : 'false');
		});
	}

	function initWidget(root) {
		if (!root || root.dataset.ddmWooImageInit === 'yes') {
			return;
		}

		var mainImage = root.querySelector(MAIN_IMAGE_SELECTOR);
		var thumbs = toArray(root.querySelectorAll(THUMB_SELECTOR));
		if (!mainImage || !thumbs.length) {
			return;
		}

		root.dataset.ddmWooImageInit = 'yes';

		thumbs.forEach(function (thumb) {
			thumb.addEventListener('click', function () {
				setMainImage(mainImage, thumb);
				setActiveThumb(thumbs, thumb);
			});
		});
	}

	function initScope(scope) {
		var nodes = (scope || document).querySelectorAll(WIDGET_SELECTOR);
		toArray(nodes).forEach(initWidget);
	}

	function bootstrap() {
		initScope(document);

		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/devsroom_woo_product_image.default', function ($scope) {
				var context = $scope && $scope[0] ? $scope[0] : $scope;
				initScope(context || document);
			});
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', bootstrap);
	} else {
		bootstrap();
	}
})();

