(function () {
	'use strict';

	var WIDGET_SELECTOR = '.ddm-woo-product-tabs';
	var TAB_SELECTOR = '.ddm-woo-product-tabs__tab[role="tab"]';
	var PANEL_SELECTOR = '.ddm-woo-product-tabs__panel[role="tabpanel"]';

	function toArray(nodeList) {
		return Array.prototype.slice.call(nodeList || []);
	}

	function getHashId() {
		if (!window.location.hash) {
			return '';
		}

		return window.location.hash.replace(/^#/, '').trim();
	}

	function setHashId(hashId) {
		if (!hashId || !window.history || typeof window.history.replaceState !== 'function') {
			return;
		}

		try {
			var urlWithoutHash = window.location.href.split('#')[0];
			window.history.replaceState(null, '', urlWithoutHash + '#' + hashId);
		} catch (error) {
			// Silently ignore URL write failures.
		}
	}

	function findTabByTarget(tabs, targetId) {
		for (var i = 0; i < tabs.length; i++) {
			if ((tabs[i].getAttribute('data-tab-target') || '') === targetId) {
				return tabs[i];
			}
		}

		return null;
	}

	function activateTab(root, tabs, panels, targetTab, shouldUpdateHash) {
		if (!targetTab) {
			return;
		}

		var targetId = targetTab.getAttribute('data-tab-target') || '';
		if (!targetId) {
			return;
		}

		tabs.forEach(function (tab) {
			var isActive = tab === targetTab;
			tab.classList.toggle('is-active', isActive);
			tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
			tab.setAttribute('tabindex', isActive ? '0' : '-1');
		});

		panels.forEach(function (panel) {
			var isActive = panel.id === targetId;
			panel.classList.toggle('is-active', isActive);
			panel.hidden = !isActive;
		});

		root.setAttribute('data-active-tab', targetId);

		if (shouldUpdateHash) {
			setHashId(targetId);
		}
	}

	function getNextIndex(currentIndex, total) {
		return (currentIndex + 1) % total;
	}

	function getPrevIndex(currentIndex, total) {
		return (currentIndex - 1 + total) % total;
	}

	function initWidget(root) {
		if (!root || root.dataset.ddmWooTabsInit === 'yes') {
			return;
		}

		var tabs = toArray(root.querySelectorAll(TAB_SELECTOR));
		var panels = toArray(root.querySelectorAll(PANEL_SELECTOR));
		if (!tabs.length || !panels.length) {
			return;
		}

		root.dataset.ddmWooTabsInit = 'yes';

		var initialHashId = getHashId();
		var initialTab = initialHashId ? findTabByTarget(tabs, initialHashId) : null;
		var defaultActiveTab = tabs[0];
		for (var i = 0; i < tabs.length; i++) {
			if (tabs[i].classList.contains('is-active')) {
				defaultActiveTab = tabs[i];
				break;
			}
		}

		activateTab(root, tabs, panels, initialTab || defaultActiveTab, false);

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function (event) {
				event.preventDefault();
				activateTab(root, tabs, panels, tab, true);
			});

			tab.addEventListener('keydown', function (event) {
				var currentIndex = tabs.indexOf(tab);
				if (currentIndex < 0) {
					return;
				}

				var nextIndex = currentIndex;

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
	}

	function initScope(scope) {
		var nodes = (scope || document).querySelectorAll(WIDGET_SELECTOR);
		toArray(nodes).forEach(initWidget);
	}

	function bootstrap() {
		initScope(document);

		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/devsroom_woo_product_tabs.default', function ($scope) {
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
