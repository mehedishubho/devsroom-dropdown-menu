# Release Notes - Version 1.4.3

**Release Date:** February 19, 2026
**Version:** 1.4.3
**Type:** Critical Bug Fix

---

## 📋 Overview

Version 1.4.3 is a critical bug fix release that addresses important issues with the WooCommerce Product Tabs widget. This release fixes tab item styling controls that were not working correctly and enhances third-party tab plugin compatibility.

---

## 🐛 Critical Bug Fixes

### WooCommerce Product Tabs Widget - Tab Item Styling

**Problem:** Tab item text color and background color controls in the Elementor editor were not applying to the frontend tabs. Users were unable to customize tab button colors for normal, hover, and active states.

**Solution:**

- Updated all tab item style selectors to match the HTML structure exactly
- Changed from CSS variable approach to direct selectors (`{{WRAPPER}} .ddm-woo-product-tabs__tab`)
- Fixed selectors for all three states:
  - Normal: `{{WRAPPER}} .ddm-woo-product-tabs__tab`
  - Hover: `{{WRAPPER}} .ddm-woo-product-tabs__tab:hover`
  - Active: `{{WRAPPER}} .ddm-woo-product-tabs__tab.is-active`

**Impact:** Users can now fully customize tab button colors for all states.

### WooCommerce Product Tabs Widget - Border Color Controls

**Problem:** Border color controls for hover and active states were not applying correctly.

**Solution:** Added direct selectors for border color controls in hover and active tabs.

**Impact:** Tab border colors now work correctly for all states.

### WooCommerce Product Tabs Widget - Icon Styling

**Problem:** Icon color controls were not applying correctly, especially for active tabs.

**Solution:** Added direct selectors for icon color controls with separate normal and active states.

**Impact:** Icon colors now work correctly for all tab states.

### WooCommerce Product Tabs Widget - Active Border Weight

**Problem:** The active tab border weight control was not changing the bottom border thickness.

**Solution:** Updated selector to target `.ddm-woo-product-tabs__tab.is-active` with `border-bottom-width` property.

**Impact:** Users can now customize the thickness of the active tab's bottom border.

---

## ✨ New Features

### Third-Party Tab Plugin Support

**Feature:** The Product Tabs widget now automatically fetches ALL registered WooCommerce tabs, including those added by third-party plugins.

**Implementation:**

- Uses `apply_filters('woocommerce_product_tabs', array())` to retrieve all registered tabs
- Third-party tabs are automatically included when using "WooCommerce Default" source mode
- Maintains priority and sorting from the WooCommerce tabs filter
- Full compatibility with popular tab plugins (YITH, Tab Manager, etc.)

**Benefits:**

- No need for custom coding to support third-party tabs
- Automatic inclusion of all registered tabs
- Maintains tab order and priority from source plugins
- Works seamlessly with custom styling controls

---

## 🔧 Technical Improvements

### CSS Specificity Enhancements

**Improvement:** Enhanced CSS specificity to ensure widget styles override default theme and WooCommerce styles.

**Changes:**

- Removed CSS variable approach in favor of direct selectors
- Added proper appearance reset for tab buttons
- Enhanced focus state styling for keyboard navigation
- Improved hover and active state transitions

**Benefits:**

- Styles apply correctly regardless of theme
- Better compatibility with various WooCommerce themes
- Consistent appearance across different environments

### Sticky Navigation Performance

**Improvement:** Optimized sticky navigation state management for better performance.

**Changes:**

- Implemented `requestAnimationFrame` for smooth 60fps updates
- Added proper cleanup for event listeners
- Enhanced state change detection to minimize DOM updates
- Improved scroll event handling with passive listeners

**Benefits:**

- Smoother sticky navigation on scroll
- Reduced CPU usage during scroll
- Better performance on mobile devices

### Accessibility Improvements

**Improvement:** Enhanced keyboard navigation and focus management.

**Changes:**

- Improved focus state styling for better visibility
- Enhanced tab switching with keyboard navigation
- Better ARIA attribute management
- Improved screen reader compatibility

**Benefits:**

- Better experience for keyboard-only users
- Improved accessibility compliance (WCAG 2.1)
- More reliable tab switching with keyboard

---

## 📦 File Changes

### Modified Files

1. **`includes/widgets/class-ddm-woo-product-tabs-widget.php`**
   - Updated tab item style selectors (lines 509-688)
   - Enhanced WooCommerce tab fetching to support third-party tabs (lines 1182-1225)
   - Improved tab filtering logic (lines 1166-1180)

2. **`assets/css/ddm-woo-product-tabs.css`**
   - Removed CSS variable approach
   - Added direct selectors for tab buttons
   - Enhanced hover and active state styling
   - Improved sticky navigation styles
   - Added responsive and accessibility improvements

3. **`assets/js/ddm-woo-product-tabs.js`**
   - Optimized sticky navigation with requestAnimationFrame
   - Enhanced event listener cleanup
   - Improved keyboard navigation
   - Added performance optimizations

4. **`devsroom-dropdown-menu.php`**
   - Updated version constant to 1.4.3

5. **`readme.txt`**
   - Updated version to 1.4.3
   - Added new features and bug fixes
   - Updated feature list

6. **`CHANGELOG.md`**
   - Added 1.4.3 release notes
   - Documented all changes and improvements

---

## 🔄 Migration Guide

### For Existing Users

**No migration required.** This release is fully backward compatible with version 1.4.2.

**Recommended Actions:**

1. Update the plugin to version 1.4.3
2. Review your Product Tabs widgets in Elementor
3. Re-apply any tab item color styles that weren't working before
4. Test with third-party tab plugins if you use them

**What to Expect:**

- Tab item color controls now work as expected
- Third-party tabs appear automatically when using WooCommerce Default source
- Sticky navigation is smoother and more performant
- Better accessibility and keyboard navigation

### For New Users

Simply install and activate the plugin. The Product Tabs widget will work correctly with all styling controls.

---

## 📋 Testing Checklist

Before deploying to production, test the following:

### WooCommerce Product Tabs Widget

- [ ] Tab item text color applies correctly (Normal state)
- [ ] Tab item background color applies correctly (Normal state)
- [ ] Tab item colors change on hover
- [ ] Tab item colors change when active
- [ ] Tab border color works for all states
- [ ] Active tab border weight control works
- [ ] Icon colors work for normal and active states
- [ ] Sticky navigation works with top position
- [ ] Sticky navigation works with bottom position
- [ ] Sticky offset control works correctly
- [ ] Third-party tabs appear when using WooCommerce Default source
- [ ] Tab switching works with mouse click
- [ ] Tab switching works with keyboard navigation
- [ ] URL hash updates when switching tabs
- [ ] Tab content displays correctly
- [ ] Responsive design works on mobile devices

### General

- [ ] Plugin activates without errors
- [ ] Widget appears in Elementor editor
- [ ] No PHP warnings or notices
- [ ] Styles load correctly on frontend
- [ ] JavaScript loads without errors
- [ ] Compatible with current WordPress version (6.6)
- [ ] Compatible with current Elementor version (3.20+)
- [ ] Compatible with current WooCommerce version (8.5+)

---

## 🙏 Acknowledgments

Special thanks to the following:

- **Users who reported tab item styling issues** - Your detailed reports helped us identify the root cause
- **Users testing third-party tab plugins** - Your feedback ensured full compatibility
- **Community feedback** - Your input continues to help us improve the plugin

---

## 📞 Support

If you encounter any issues with this release:

1. **Check the documentation** - Review the readme.txt and widget controls
2. **Clear your cache** - Clear browser, server, and caching plugin caches
3. **Test in a staging environment** - Always test updates before deploying to production
4. **Report issues** - Provide detailed information including:
   - WordPress version
   - Elementor version
   - WooCommerce version
   - PHP version
   - Browser and device
   - Steps to reproduce the issue

---

## 🔮 Upcoming Features

Future releases may include:

- Additional WooCommerce product widgets
- Enhanced customization options
- More integration with popular plugins
- Performance optimizations
- Accessibility enhancements

Stay tuned for future updates!

---

**End of Release Notes**
