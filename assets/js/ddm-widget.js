(function () {
	'use strict';

	var WIDGET_SELECTOR = '.ddm-widget';
	var TRIGGER_SELECTOR = '.ddm-trigger';
	var PANEL_SELECTOR = '.ddm-panel';
	var ITEM_SELECTOR = '.ddm-item';

	function toArray(nodeList) {
		return Array.prototype.slice.call(nodeList || []);
	}

	function getFocusableItems(panel) {
		return toArray(panel.querySelectorAll(ITEM_SELECTOR)).filter(function (item) {
			return !item.hasAttribute('disabled') && item.offsetParent !== null;
		});
	}

	function moveFocus(items, current, direction) {
		if (!items.length) {
			return;
		}

		var index = items.indexOf(current);
		if (index === -1) {
			items[0].focus();
			return;
		}

		var next = index + direction;
		if (next < 0) {
			next = items.length - 1;
		}
		if (next >= items.length) {
			next = 0;
		}

		items[next].focus();
	}

	function initWidget(root) {
		if (!root || root.dataset.ddmInitialized === 'yes') {
			return;
		}

		var trigger = root.querySelector(TRIGGER_SELECTOR);
		var panel = root.querySelector(PANEL_SELECTOR);
		if (!trigger || !panel) {
			return;
		}

		root.dataset.ddmInitialized = 'yes';

		var closeOnOutside = root.dataset.closeOutside === 'yes';
		var closeOnLink = root.dataset.closeLink === 'yes';
		var isOpen = false;

		function syncState() {
			root.classList.toggle('is-open', isOpen);
			trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			panel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
		}

		function openMenu(focusTarget) {
			if (isOpen) {
				return;
			}

			isOpen = true;
			syncState();

			var items = getFocusableItems(panel);
			if (focusTarget === 'first' && items[0]) {
				items[0].focus();
			}
			if (focusTarget === 'last' && items.length) {
				items[items.length - 1].focus();
			}
		}

		function closeMenu(returnFocus) {
			if (!isOpen) {
				return;
			}

			isOpen = false;
			syncState();
			if (returnFocus) {
				trigger.focus();
			}
		}

		function toggleMenu() {
			if (isOpen) {
				closeMenu(false);
				return;
			}
			openMenu();
		}

		trigger.addEventListener('click', function (event) {
			event.preventDefault();
			toggleMenu();
		});

		trigger.addEventListener('keydown', function (event) {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				toggleMenu();
				return;
			}

			if (event.key === 'ArrowDown') {
				event.preventDefault();
				openMenu('first');
				return;
			}

			if (event.key === 'ArrowUp') {
				event.preventDefault();
				openMenu('last');
			}
		});

		panel.addEventListener('keydown', function (event) {
			var items = getFocusableItems(panel);
			if (!items.length) {
				if (event.key === 'Escape') {
					event.preventDefault();
					closeMenu(true);
				}
				return;
			}

			if (event.key === 'Escape') {
				event.preventDefault();
				closeMenu(true);
				return;
			}

			if (event.key === 'ArrowDown') {
				event.preventDefault();
				moveFocus(items, document.activeElement, 1);
				return;
			}

			if (event.key === 'ArrowUp') {
				event.preventDefault();
				moveFocus(items, document.activeElement, -1);
				return;
			}

			if (event.key === 'Home') {
				event.preventDefault();
				items[0].focus();
				return;
			}

			if (event.key === 'End') {
				event.preventDefault();
				items[items.length - 1].focus();
			}
		});

		if (closeOnLink) {
			panel.addEventListener('click', function (event) {
				var clickedLink = event.target.closest('a.ddm-item');
				if (!clickedLink) {
					return;
				}
				closeMenu(false);
			});
		}

		if (closeOnOutside) {
			document.addEventListener('click', function (event) {
				if (!isOpen) {
					return;
				}

				if (!root.contains(event.target)) {
					closeMenu(false);
				}
			});
		}

		syncState();
	}

	function initScope(scope) {
		var nodes = (scope || document).querySelectorAll(WIDGET_SELECTOR);
		toArray(nodes).forEach(initWidget);
	}

	function bootstrap() {
		initScope(document);

		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/devsroom_dropdown_menu.default', function ($scope) {
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
