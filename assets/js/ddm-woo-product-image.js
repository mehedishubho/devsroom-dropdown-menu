(function () {
	'use strict';

	var WIDGET_SELECTOR = '.ddm-woo-product-image';
	var THUMB_SELECTOR = '.ddm-woo-product-image__thumb';
	var MAIN_IMAGE_SELECTOR = '.ddm-woo-product-image__main-image';
	var THUMBS_SELECTOR = '.ddm-woo-product-image__thumbs';
	var VIEWPORT_SELECTOR = '.ddm-woo-product-image__thumbs-viewport';
	var TRACK_SELECTOR = '.ddm-woo-product-image__thumbs-track';
	var PREV_SELECTOR = '.ddm-woo-product-image__nav--prev';
	var NEXT_SELECTOR = '.ddm-woo-product-image__nav--next';

	function toArray(nodeList) {
		return Array.prototype.slice.call(nodeList || []);
	}

	function toInt(value, fallback) {
		var number = parseInt(value, 10);
		return Number.isFinite(number) ? number : fallback;
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

	function getGap(track) {
		if (!track) {
			return 0;
		}

		var styles = window.getComputedStyle(track);
		var gap = parseFloat(styles.gap || styles.columnGap || styles.rowGap || '0');
		return Number.isFinite(gap) ? gap : 0;
	}

	function moveTrack(track, axis, currentStart) {
		if (!track) {
			return;
		}

		var first = track.querySelector(THUMB_SELECTOR);
		if (!first) {
			return;
		}

		var step = axis === 'y' ? first.offsetHeight : first.offsetWidth;
		step += getGap(track);
		var distance = step * currentStart;
		var transform = axis === 'y'
			? 'translate3d(0, -' + distance + 'px, 0)'
			: 'translate3d(-' + distance + 'px, 0, 0)';

		track.style.transform = transform;
	}

	function initWidget(root) {
		if (!root || root.dataset.ddmWooImageInit === 'yes') {
			return;
		}

		var mainImage = root.querySelector(MAIN_IMAGE_SELECTOR);
		var thumbsWrapper = root.querySelector(THUMBS_SELECTOR);
		var thumbs = toArray(root.querySelectorAll(THUMB_SELECTOR));
		if (!mainImage || !thumbsWrapper || !thumbs.length) {
			return;
		}

		root.dataset.ddmWooImageInit = 'yes';

		var sliderEnabled = thumbsWrapper.dataset.slider === 'yes';
		var axis = thumbsWrapper.dataset.axis === 'y' ? 'y' : 'x';
		var slidesToShow = Math.max(1, toInt(thumbsWrapper.dataset.slides, 4));
		var autoplay = thumbsWrapper.dataset.autoplay === 'yes';
		var autoplayDelay = Math.max(1000, toInt(thumbsWrapper.dataset.autoplayDelay, 3000));
		var loop = thumbsWrapper.dataset.loop === 'yes';
		var pauseOnHover = thumbsWrapper.dataset.pauseHover === 'yes';
		var prevButton = thumbsWrapper.querySelector(PREV_SELECTOR);
		var nextButton = thumbsWrapper.querySelector(NEXT_SELECTOR);
		var track = thumbsWrapper.querySelector(TRACK_SELECTOR);
		var viewport = thumbsWrapper.querySelector(VIEWPORT_SELECTOR);
		var autoplayTimer = null;
		var currentStart = 0;
		var activeIndex = Math.max(0, thumbs.findIndex(function (thumb) {
			return thumb.classList.contains('is-active');
		}));

		function maxStart() {
			return Math.max(0, thumbs.length - slidesToShow);
		}

		function updateNavState() {
			if (!sliderEnabled || loop) {
				return;
			}

			if (prevButton) {
				prevButton.disabled = currentStart <= 0;
			}

			if (nextButton) {
				nextButton.disabled = currentStart >= maxStart();
			}
		}

		function applySliderPosition() {
			if (!sliderEnabled || !track || !viewport) {
				return;
			}

			currentStart = Math.max(0, Math.min(currentStart, maxStart()));
			moveTrack(track, axis, currentStart);
			updateNavState();
		}

		function ensureThumbVisible(index) {
			if (!sliderEnabled) {
				return;
			}

			if (index < currentStart) {
				currentStart = index;
			} else if (index >= currentStart + slidesToShow) {
				currentStart = index - slidesToShow + 1;
			}

			applySliderPosition();
		}

		function gotoNextStep() {
			if (!sliderEnabled) {
				return;
			}

			var max = maxStart();
			if (currentStart >= max) {
				currentStart = loop ? 0 : max;
			} else {
				currentStart += 1;
			}

			applySliderPosition();
		}

		function gotoPrevStep() {
			if (!sliderEnabled) {
				return;
			}

			if (currentStart <= 0) {
				currentStart = loop ? maxStart() : 0;
			} else {
				currentStart -= 1;
			}

			applySliderPosition();
		}

		function stopAutoplay() {
			if (!autoplayTimer) {
				return;
			}

			window.clearInterval(autoplayTimer);
			autoplayTimer = null;
		}

		function startAutoplay() {
			if (!autoplay || thumbs.length <= 1) {
				return;
			}

			stopAutoplay();
			autoplayTimer = window.setInterval(function () {
				if (!loop && activeIndex >= thumbs.length - 1) {
					stopAutoplay();
					return;
				}

				var nextIndex = activeIndex + 1;
				if (nextIndex >= thumbs.length) {
					nextIndex = 0;
				}

				activeIndex = nextIndex;
				var nextThumb = thumbs[activeIndex];
				if (!nextThumb) {
					return;
				}

				setMainImage(mainImage, nextThumb);
				setActiveThumb(thumbs, nextThumb);
				ensureThumbVisible(activeIndex);
			}, autoplayDelay);
		}

		thumbs.forEach(function (thumb) {
			thumb.addEventListener('click', function () {
				setMainImage(mainImage, thumb);
				setActiveThumb(thumbs, thumb);
				activeIndex = thumbs.indexOf(thumb);
				ensureThumbVisible(activeIndex);
			});
		});

		if (sliderEnabled) {
			if (prevButton) {
				prevButton.addEventListener('click', gotoPrevStep);
			}

			if (nextButton) {
				nextButton.addEventListener('click', gotoNextStep);
			}

			window.addEventListener('resize', applySliderPosition);
			ensureThumbVisible(activeIndex);
		}

		if (autoplay) {
			startAutoplay();

			if (pauseOnHover) {
				thumbsWrapper.addEventListener('mouseenter', stopAutoplay);
				thumbsWrapper.addEventListener('mouseleave', startAutoplay);
			}
		}
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
