=== Devsroom Dropdown Menu ===
Contributors: devsroom
Requires at least: 6.4
Tested up to: 6.6
Requires PHP: 8.0
Stable tag: 1.4.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: elementor, dropdown, menu, hamburger, navigation, woocommerce, product tabs, product gallery, product actions

A customizable Elementor widgets pack including a dropdown menu, WooCommerce product tabs, product image gallery, and advanced product actions.

== Description ==

Devsroom Dropdown Menu adds Elementor widgets for navigation and WooCommerce product display.

Features include:

* Hamburger trigger with optional label text
* Icon position control for trigger and each menu item
* Repeater-based menu items with link, icon, and new-tab option
* Dropdown animations, alignment, width, and visual styling
* Advanced dropdown box controls (offsets, min/max size, overflow, z-index)
* Outside-click and link-click close behavior
* Custom CSS declarations scoped to each widget instance
* Admin-only custom JavaScript execution support
* Keyboard navigation and ARIA attributes
* Improved icon rendering compatibility for Elementor icon payloads
* **WooCommerce Product Tabs Widget**:
  - Display all WooCommerce default tabs (Description, Additional Information, Reviews)
  - Support for third-party tab plugins automatically
  - Custom tab builder with WYSIWYG content editor
  - Flexible layout options (Full Width, Container, Custom)
  - Sticky navigation with configurable position (top/bottom) and offset
  - Icon support for each tab
  - Comprehensive styling controls for all states (Normal, Hover, Active)
  - Tab item text color and background color styling (FIXED)
  - Full keyboard navigation and accessibility support
* **WooCommerce Product Image Widget**:
  - Product gallery display with configurable thumbnails
  - Multiple thumbnail positions (Bottom, Top, Left, Right)
  - Grid and Slider display modes
  - Slider controls (visible thumbnails, navigation arrows, autoplay, slide speed)
  - Customizable styling (thumbnail size, gap, border radius, shadows)
  - Active thumbnail border color
  - Responsive images with srcset and sizes
  - Placeholder support for products without images
* **Advanced Product Actions Widget**:
  - Quantity selector with customizable minus/plus icons
  - Min/max quantity limits with notice display
  - Optional quantity label with position control
  - Add to Cart button with custom text and redirect option
  - Custom action buttons (WhatsApp, Facebook Messenger)
  - Dynamic message templates with product placeholders
  - Full styling customization for all elements
  - Smart product detection and form validation

== Installation ==

1. Upload `devsroom-dropdown-menu` folder to `/wp-content/plugins/`.
2. Activate plugin through `Plugins` screen in WordPress.
3. Edit a page with Elementor and search for `Devsroom` widgets.

== Frequently Asked Questions ==

= Does this plugin require Elementor? =

Yes. Elementor must be installed and activated.

= Does this plugin require WooCommerce? =

WooCommerce is only required for the product-related widgets (Product Tabs, Product Image, Advanced Product Actions). The Dropdown Menu widget works independently.

= Does widget support nested submenu levels? =

Version 1 supports a single-level dropdown menu.

= Does the Product Tabs widget support third-party tab plugins? =

Yes! The Product Tabs widget automatically fetches all registered WooCommerce tabs using the `woocommerce_product_tabs` filter, ensuring full compatibility with third-party tab plugins.

= Can I customize tab item colors? =

Yes! Version 1.4.3 includes fixed tab item styling controls with direct selectors for text color, background color, and border styling for all states (Normal, Hover, Active).

== Changelog ==

= 1.4.3 =
* **CRITICAL FIX**: Fixed tab item text color and background color styling not applying correctly
* Updated tab item style selectors to match HTML structure exactly
* Enhanced WooCommerce tab fetching to support ALL registered tabs (including third-party plugins)
* Improved CSS specificity to override default theme and WooCommerce styles
* Added comprehensive styling controls for all tab states (Normal, Hover, Active)
* Enhanced sticky navigation with proper state management
* Performance optimizations with requestAnimationFrame for sticky calculations
* Improved keyboard navigation and accessibility support
* Added border color controls for hover and active states
* Enhanced icon styling with separate normal/active color controls
* WordPress 6.6, Elementor 3.20+, and WooCommerce 8.5+ compatibility

= 1.4.1 =
* Performance optimizations with enhanced asset loading and reduced memory footprint
* Improved code quality with better documentation and refactoring
* Bug fixes for dropdown menu icon rendering and mobile positioning
* Fixed WooCommerce product image widget thumbnail slider in RTL layouts
* Resolved product tabs widget keyboard navigation and ARIA attributes
* Fixed advanced product actions widget quantity validation and redirect timing
* Enhanced user experience with better error handling and smoother animations
* WordPress 6.6, Elementor 3.20+, and WooCommerce 8.5+ compatibility
* Security hardening with improved input sanitization

= 1.0.0 =
* Initial release.
* Added Elementor dropdown menu widget with trigger/menu customization controls.
* Added accessibility behavior and responsive styling.
