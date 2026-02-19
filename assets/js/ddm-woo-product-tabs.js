/**
 * Devsroom WooCommerce Product Tabs Widget JavaScript
 * Production-ready with tab switching, sticky navigation, slider, and accessibility
 */

(function () {
	'use strict';

	// Widget Selectors
	var WIDGET_SELECTOR = '.ddm-woo-product-tabs';
	var PANEL_WRAP_SELECTOR = '.ddm-woo-product-tabs__panel-wrap';
	var NAV_SELECTOR = '.ddm-woo-product-tabs__nav';
	var TAB_SELECTOR = '.ddm-woo-product-tabs__tab[role="tab"]';
	var PANEL_SELECTOR = '.ddm-woo-product-tabs__panel[role="tabpanel"]';

	/**
	 * Convert NodeList to Array
	 */
	function toArray(nodeList) {
		return Array.prototype.slice.call(nodeList || []);
	}

	/**
	 * Parse integer with fallback
	 */
	function toInt(value, fallback) {
		var parsed = parseInt(value, 10);
		return Number.isFinite(parsed) ? parsed : fallback;
	}

	/**
	 * Get current URL hash without # symbol
	 */
	function getHashId() {
		if (!window.location.hash) {
			return '';
		}

		return window.location.hash.replace(/^#/, '').trim();
	}

	/**
	 * Set URL hash without page reload
	 */
	function setHashId(hashId) {
		if (!hashId || !window.history || typeof window.history.replaceState !== 'function') {
			return;
		}

		try {
			var urlWithoutHash = window.location.href.split('#')[0];
			window.history.replaceState(null, '', urlWithoutHash + '#' + hashId);
		} catch (error) {
			// Ignore URL write failures
		}
	}

	/**
	 * Find tab by target panel ID
	 */
	function findTabByTarget(tabs, targetId) {
		for (var i = 0; i < tabs.length; i++) {
			if ((tabs[i].getAttribute('data-tab-target') || '') === targetId) {
				return tabs[i];
			}
		}

		return null;
	}

	/**
	 * Activate a tab and its corresponding panel
	 */
	function activateTab(root, tabs, panels, targetTab, shouldUpdateHash) {
		if (!targetTab) {
			return;
		}

		var targetId = targetTab.getAttribute('data-tab-target') || '';
		if (!targetId) {
			return;
		}

		// Update tab states
		tabs.forEach(function (tab) {
			var isActive = tab === targetTab;
			tab.classList.toggle('is-active', isActive);
			tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
			tab.setAttribute('tabindex', isActive ? '0' : '-1');
		});

		// Update panel states
		panels.forEach(function (panel) {
			var isActive = panel.id === targetId;
			panel.classList.toggle('is-active', isActive);
			panel.hidden = !isActive;
		});

		// Update root data attribute
		root.setAttribute('data-active-tab', targetId);

		// Update URL hash if needed
		if (shouldUpdateHash) {
			setHashId(targetId);
		}
	}

	/**
	 * Get next tab index for keyboard navigation
	 */
	function getNextIndex(currentIndex, total) {
		return (currentIndex + 1) % total;
	}

	/**
	 * Get previous tab index for keyboard navigation
	 */
	function getPrevIndex(currentIndex, total) {
		return (currentIndex - 1 + total) % total;
	}

	/**
	 * Initialize slider navigation for mobile slide mode
	 */
	function initSliderNavigation(root, nav) {
		if (!nav || nav.dataset.sliderInit === 'yes') {
			return null;
		}

		var panelWrap = root.querySelector(PANEL_WRAP_SELECTOR);
		if (!panelWrap) {
			return null;
		}

		var mobileDisplayMode = panelWrap.dataset.mobileDisplayMode || 'wrap';
		var mobileSlideArrows = panelWrap.dataset.mobileSlideArrows === 'yes';
		var arrowsPosition = panelWrap.dataset.mobileArrowsPosition || 'outside';

		// Only initialize for slide mode with arrows enabled
		if (mobileDisplayMode !== 'slide' || !mobileSlideArrows) {
			return null;
		}

		nav.dataset.sliderInit = 'yes';

		// Find arrow buttons
		var prevArrow = root.querySelector('.ddm-slider-arrow-prev');
		var nextArrow = root.querySelector('.ddm-slider-arrow-next');

		if (!prevArrow || !nextArrow) {
			return null;
		}

		var rafId = 0;
		var scrollAmount = 200; // Pixels to scroll per click

		/**
		 * Update arrow button states based on scroll position
		 */
		function updateArrowStates() {
			rafId = 0;

			if (!nav.isConnected) {
				return;
			}

			var scrollLeft = nav.scrollLeft;
			var scrollWidth = nav.scrollWidth;
			var clientWidth = nav.clientWidth;
			var maxScroll = scrollWidth - clientWidth;

			// Disable prev arrow if at start
			prevArrow.disabled = scrollLeft <= 1;

			// Disable next arrow if at end
			nextArrow.disabled = scrollLeft >= maxScroll - 1;
		}

		/**
		 * Schedule arrow state update
		 */
		function scheduleArrowStateUpdate() {
			if (rafId) {
				return;
			}

			rafId = window.requestAnimationFrame(updateArrowStates);
		}

		/**
		 * Scroll navigation
		 */
		function scrollNav(direction) {
			var targetScroll = nav.scrollLeft + (direction * scrollAmount);
			nav.scrollTo({
				left: targetScroll,
				behavior: 'smooth'
			});
		}

		// Add event listeners to arrows
		prevArrow.addEventListener('click', function (event) {
			event.preventDefault();
			scrollNav(-1);
		});

		nextArrow.addEventListener('click', function (event) {
			event.preventDefault();
			scrollNav(1);
		});

		// Add keyboard support for arrows
		prevArrow.addEventListener('keydown', function (event) {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				scrollNav(-1);
			}
		});

		nextArrow.addEventListener('keydown', function (event) {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				scrollNav(1);
			}
		});

		// Update arrow states on scroll
		nav.addEventListener('scroll', scheduleArrowStateUpdate, { passive: true });

		// Update arrow states on resize
		window.addEventListener('resize', scheduleArrowStateUpdate);

		// Initial arrow state update
		scheduleArrowStateUpdate();

		// Cleanup function
		return function cleanup() {
			nav.removeEventListener('scroll', scheduleArrowStateUpdate);
			window.removeEventListener('resize', scheduleArrowStateUpdate);
			if (rafId) {
				window.cancelAnimationFrame(rafId);
			}
		};
	}

	/**
	 * Initialize sticky navigation state
	 * Uses requestAnimationFrame for performance
	 */
	function initStickyState(root, panelWrap) {
		if (!panelWrap || panelWrap.dataset.stickyEnabled !== 'yes') {
			return;
		}

		var stickyPosition = panelWrap.dataset.stickyPosition === 'bottom' ? 'bottom' : 'top';
		var stickyOffset = Math.max(0, toInt(panelWrap.dataset.stickyOffset, 0));
		var rafId = 0;
		var isSticky = false;

		/**
		 * Evaluate and update sticky state
		 */
		function evaluateStickyState() {
			rafId = 0;

			if (!root.isConnected || !panelWrap.isConnected) {
				panelWrap.classList.remove('is-sticky');
				return;
			}

			var wrapRect = panelWrap.getBoundingClientRect();
			var rootRect = root.getBoundingClientRect();
			var wrapHeight = panelWrap.offsetHeight || wrapRect.height || 0;
			var threshold = 1;
			var wasSticky = isSticky;

			if (stickyPosition === 'top') {
				// Top sticky: check if panel has reached top offset
				var reachedTop = wrapRect.top <= stickyOffset + threshold;
				var withinBoundsTop = rootRect.bottom > stickyOffset + wrapHeight;
				isSticky = reachedTop && withinBoundsTop;
			} else {
				// Bottom sticky: check if panel has reached bottom offset
				var viewportBottomLine = window.innerHeight - stickyOffset;
				var reachedBottom = wrapRect.bottom >= viewportBottomLine - threshold;
				var withinTopLimit = rootRect.top < viewportBottomLine - wrapHeight;
				var withinBottomLimit = rootRect.bottom > stickyOffset + wrapHeight;
				isSticky = reachedBottom && withinTopLimit && withinBottomLimit;
			}

			// Only update DOM if state changed
			if (wasSticky !== isSticky) {
				panelWrap.classList.toggle('is-sticky', isSticky);
			}
		}

		/**
		 * Schedule sticky state check using requestAnimationFrame
		 */
		function scheduleStickyStateCheck() {
			if (rafId) {
				return;
			}

			rafId = window.requestAnimationFrame(evaluateStickyState);
		}

		// Add event listeners for sticky state
		window.addEventListener('scroll', scheduleStickyStateCheck, { passive: true });
		window.addEventListener('resize', scheduleStickyStateCheck);
		window.addEventListener('orientationchange', scheduleStickyStateCheck);

		// Initial check
		scheduleStickyStateCheck();

		// Cleanup function
		return function cleanup() {
			window.removeEventListener('scroll', scheduleStickyStateCheck);
			window.removeEventListener('resize', scheduleStickyStateCheck);
			window.removeEventListener('orientationchange', scheduleStickyStateCheck);
			if (rafId) {
				window.cancelAnimationFrame(rafId);
			}
		};
	}

	/**
	 * Initialize widget functionality
	 */
	function initWidget(root) {
		if (!root || root.dataset.ddmWooTabsInit === 'yes') {
			return;
		}

		var tabs = toArray(root.querySelectorAll(TAB_SELECTOR));
		var panels = toArray(root.querySelectorAll(PANEL_SELECTOR));
		var nav = root.querySelector(NAV_SELECTOR);
		var panelWrap = root.querySelector(PANEL_WRAP_SELECTOR);

		if (!tabs.length || !panels.length) {
			return;
		}

		root.dataset.ddmWooTabsInit = 'yes';

		// Determine initial active tab
		var initialHashId = getHashId();
		var initialTab = initialHashId ? findTabByTarget(tabs, initialHashId) : null;
		var defaultActiveTab = tabs[0];

		// Check if any tab has is-active class from server
		for (var i = 0; i < tabs.length; i++) {
			if (tabs[i].classList.contains('is-active')) {
				defaultActiveTab = tabs[i];
				break;
			}
		}

		// Activate initial tab
		activateTab(root, tabs, panels, initialTab || defaultActiveTab, false);

		// Add click event listeners to tabs
		tabs.forEach(function (tab) {
			tab.addEventListener('click', function (event) {
				event.preventDefault();
				activateTab(root, tabs, panels, tab, true);
			});

			// Add keyboard navigation support
			tab.addEventListener('keydown', function (event) {
				var currentIndex = tabs.indexOf(tab);
				if (currentIndex < 0) {
					return;
				}

				var nextIndex = currentIndex;

				// Arrow keys for navigation
				if (event.key === 'ArrowRight') {
					nextIndex = getNextIndex(currentIndex, tabs.length);
				} else if (event.key === 'ArrowLeft') {
					nextIndex = getPrevIndex(currentIndex, tabs.length);
				} else if (event.key === 'Home') {
					nextIndex = 0;
				} else if (event.key === 'End') {
					nextIndex = tabs.length - 1;
				} else if (event.key === 'Enter' || event.key === ' ') {
					event.preventDefault();
					activateTab(root, tabs, panels, tab, true);
					return;
				} else {
					return;
				}

				event.preventDefault();

				var nextTab = tabs[nextIndex];
				if (!nextTab) {
					return;
				}

				nextTab.focus();
				activateTab(root, tabs, panels, nextTab, true);
			});
		});

		// Handle hash changes
		window.addEventListener('hashchange', function () {
			var hashId = getHashId();
			if (!hashId) {
				return;
			}

			var matchingTab = findTabByTarget(tabs, hashId);
			if (!matchingTab) {
				return;
			}

			activateTab(root, tabs, panels, matchingTab, false);
		});

		// Initialize slider navigation
		var sliderCleanup = initSliderNavigation(root, nav);

		// Initialize sticky state
		var stickyCleanup = initStickyState(root, panelWrap);

		// Store cleanup functions on root element
		if (sliderCleanup) {
			root._ddmSliderCleanup = sliderCleanup;
		}
		if (stickyCleanup) {
			root._ddmStickyCleanup = stickyCleanup;
		}
	}

	/**
	 * Initialize all widgets within a scope
	 */
	function initScope(scope) {
		var nodes = (scope || document).querySelectorAll(WIDGET_SELECTOR);
		toArray(nodes).forEach(initWidget);
	}

	/**
	 * Bootstrap widget
	 */
	function bootstrap() {
		// Initialize on page load
		initScope(document);

		// Elementor integration
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/devsroom_woo_product_tabs.default', function ($scope) {
				var context = $scope && $scope[0] ? $scope[0] : $scope;
				initScope(context || document);
			});
		}

		// Cleanup on page unload
		window.addEventListener('beforeunload', function () {
			var nodes = document.querySelectorAll(WIDGET_SELECTOR);
			toArray(nodes).forEach(function (node) {
				if (node._ddmSliderCleanup) {
					node._ddmSliderCleanup();
				}
				if (node._ddmStickyCleanup) {
					node._ddmStickyCleanup();
				}
			});
		});
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', bootstrap);
	} else {
		bootstrap();
	}
})();
