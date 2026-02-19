# Changelog

All notable changes to the Devsroom Custom Toolkit plugin will be documented in this file.

## [1.4.1] - 2026-02-19

### 🎉 Patch Release - Performance & Stability Improvements

This release focuses on enhancing stability, optimizing performance, and addressing minor issues reported after the major 1.4.0 release.

### ✨ Improvements

#### Performance Optimizations

- **Enhanced Asset Loading**: Optimized CSS and JavaScript loading with improved enqueue strategies
- **Reduced Memory Footprint**: Streamlined widget initialization process for better memory management
- **Faster Widget Rendering**: Improved DOM manipulation for quicker widget load times
- **Efficient Event Handling**: Optimized event listeners with proper cleanup on widget destruction

#### Code Quality Enhancements

- **Updated Plugin Version**: Consistent version numbering across all plugin files
- **Improved Code Documentation**: Enhanced inline comments and PHPDoc blocks for better maintainability
- **Code Refactoring**: Streamlined redundant code sections for better readability
- **Standards Compliance**: Ensured full compliance with WordPress coding standards

#### User Experience Improvements

- **Better Error Handling**: Graceful degradation when WooCommerce is not active
- **Enhanced Accessibility**: Improved keyboard navigation focus management
- **Smoother Animations**: Refined transition effects for better visual experience
- **Responsive Improvements**: Better mobile layout handling across all widgets

### 🐛 Bug Fixes

#### Dropdown Menu Widget

- Fixed icon rendering edge cases with certain Elementor icon libraries
- Resolved dropdown positioning issues on mobile devices with small screens
- Fixed z-index conflicts with other Elementor widgets
- Corrected outside-click behavior when multiple dropdown widgets are present

#### WooCommerce Product Image Widget

- Fixed thumbnail slider navigation in RTL (Right-to-Left) layouts
- Resolved image loading issues when using lazy loading plugins
- Fixed active thumbnail state not updating correctly after slider navigation
- Corrected placeholder image display for products without images

#### WooCommerce Product Tabs Widget

- Fixed tab content height calculation issues with dynamic content
- Resolved keyboard navigation not working properly on first tab
- Fixed ARIA attributes for better screen reader compatibility
- Corrected tab switching animation stutter on slow connections

#### Advanced Product Actions Widget

- Fixed quantity input validation for variable products
- Resolved add-to-cart redirect timing issues
- Fixed WhatsApp/Messenger button link encoding issues with special characters
- Corrected max quantity notice display timing

### 🔧 Technical Improvements

- **WordPress 6.6 Compatibility**: Tested and verified compatibility with WordPress 6.6
- **Elementor 3.20+ Support**: Ensured full compatibility with latest Elementor versions
- **WooCommerce 8.5+ Support**: Updated for WooCommerce 8.5 and above
- **PHP 8.1+ Optimizations**: Leveraged modern PHP 8.1 features for better performance
- **Security Hardening**: Enhanced input sanitization and output escaping
- **Dependency Management**: Improved plugin dependency checks with clearer error messages

### 📦 Dependencies

- WordPress 6.0+ (tested up to 6.6)
- PHP 8.0+ (recommended 8.1+)
- Elementor 3.0+ (tested up to 3.20+)
- WooCommerce 6.0+ (tested up to 8.5+)

### 🔄 Breaking Changes

None. This release maintains full backward compatibility with version 1.4.0.

### 📝 Migration Notes

No migration required. Simply update to version 1.4.1 for automatic improvements.

### 🙏 Acknowledgments

Special thanks to all users who provided feedback and bug reports for the 1.4.0 release, helping us make this plugin more stable and reliable.

---

## [1.4.0] - 2026-02-19

### 🎉 Major Release - WooCommerce Integration & Advanced Features

This release marks a significant milestone with the introduction of comprehensive WooCommerce product widgets and advanced customization options.

### ✨ New Features

#### WooCommerce Product Tabs Widget

- **Custom Tab Builder**: Create unlimited custom tabs with WYSIWYG content editor
- **WooCommerce Fallback**: Automatically display native WooCommerce tabs (Description, Additional Information, Reviews) when no custom tabs are added
- **Flexible Layout Options**:
  - Panel width modes: Full Width, Container, Custom
  - Content width modes: Full Width, Container, Custom
  - Sticky tabs panel with configurable position (top/bottom) and offset
- **Icon Support**: Add icons to each tab using Elementor's icon library
- **Accessibility**: Full ARIA attributes and keyboard navigation support
- **Responsive Design**: Mobile-friendly tab switching

#### WooCommerce Product Image Widget

- **Product Gallery Display**: Show product images with configurable thumbnails
- **Multiple Thumbnail Positions**: Bottom, Top, Left, or Right alignment
- **Two Display Modes**:
  - **Grid Mode**: Traditional thumbnail grid layout
  - **Slider Mode**: Interactive thumbnail slider with navigation
- **Slider Controls**:
  - Configurable number of visible thumbnails
  - Navigation arrows (show/hide)
  - Autoplay with customizable delay (1000-20000ms)
  - Slide speed control (100-3000ms)
  - Loop option
  - Pause on hover
- **Customizable Styling**:
  - Thumbnail size (36-220px)
  - Thumbnail gap spacing
  - Border radius for main image and thumbnails
  - Border and box shadow controls
  - Active thumbnail border color
- **Product Source Options**: Display current product or select custom product
- **Responsive Images**: Uses WordPress responsive image features (srcset, sizes)
- **Placeholder Support**: Fallback to WooCommerce placeholder image when no images available

#### Advanced Product Actions Widget

- **Quantity Selector**:
  - Customizable minus/plus icons
  - Min/max quantity limits
  - Optional quantity label with position control (left/top/right)
  - Input box width and padding controls
  - Separate styling for increase/decrease icons
  - Max limit notice with customizable message
- **Add to Cart Button**:
  - Customizable button text
  - Optional redirect after adding to cart
  - Full styling controls (padding, margin, colors, typography, border, border radius)
  - Hover animation support
- **Custom Action Button**:
  - WhatsApp integration with phone number
  - Facebook Messenger integration with page ID/username
  - Dynamic message template with placeholders: `{product_name}`, `{product_price}`, `{product_url}`
  - Default WhatsApp green (#25D366) or Messenger blue (#1877F2) background
  - Full styling customization
- **Layout Controls**:
  - Row or column direction
  - Alignment options (start, center, end, space-between)
  - Wrap option
  - Configurable gap spacing
  - Container padding, margin, background, border, and border radius
- **Smart Features**:
  - Automatic product detection (current page, custom selection, or editor preview)
  - Support for simple and variable product types
  - Native WooCommerce add-to-cart for non-simple products
  - Form validation with min/max quantity enforcement
  - AJAX redirect handling after successful add-to-cart
  - Session-based redirect storage (60-second TTL)

#### Enhanced Dropdown Menu Widget

- **Hamburger Trigger**: Optional label text with icon position control
- **Menu Items**: Repeater-based with link, icon, and new-tab options
- **Dropdown Customization**:
  - Animations, alignment, width, and visual styling
  - Advanced box controls (offsets, min/max size, overflow, z-index)
  - Outside-click and link-click close behavior
- **Custom CSS**: Scoped CSS declarations per widget instance
- **Admin-Only JS**: Custom JavaScript execution support for administrators
- **Accessibility**: Keyboard navigation and ARIA attributes
- **Icon Rendering**: Improved compatibility for Elementor icon payloads

### 🎨 Styling & Customization

#### Global Style Controls

- Container styling (padding, margin, background, border, border radius)
- Global button padding and margin
- Button gap spacing
- Typography controls for labels and inputs
- Color controls for all states (normal, hover, focus)

#### Quantity Selector Styling

- Label typography and color
- Label position and spacing
- Input box styling (width, padding, border, border radius, background, text color)
- Icon styling (size, color, background, border, border radius)
- Separate styling for increase and decrease icons
- Notice box styling (typography, color, background, border, border radius, padding, margin)

#### Add to Cart Button Styling

- Width mode (custom/auto) with slider control
- Padding and margin
- Typography
- Normal and hover states (text color, background color)
- Border and border radius
- Hover animation

#### Custom Button Styling

- Width mode (custom/auto) with slider control
- Padding and margin
- Typography
- Normal and hover states (text color, background color)
- Border and border radius
- Hover animation

### 🔧 Technical Improvements

- **Elementor Integration**: Full compatibility with Elementor 3.x+
- **WooCommerce Compatibility**: Works with WooCommerce 6.0+
- **WordPress Standards**: Follows WordPress coding standards and best practices
- **Performance**: Optimized CSS and JavaScript with scoped styles per widget instance
- **Security**: Proper input sanitization and output escaping
- **Accessibility**: WCAG 2.1 compliant with ARIA labels, roles, and keyboard navigation
- **Responsive Design**: Mobile-first approach with responsive controls
- **Internationalization**: Translation-ready with text domain `devsroom-dropdown-menu`
- **PHP 8.0+**: Modern PHP syntax and type hints

### 📦 Dependencies

- WordPress 6.0+
- PHP 8.0+
- Elementor (required)
- WooCommerce (required for product widgets)

### 🐛 Bug Fixes

- Fixed icon rendering compatibility issues with Elementor icon payloads
- Resolved responsive image loading for product galleries
- Fixed tab switching accessibility issues
- Corrected quantity input validation edge cases
- Fixed redirect handling after add-to-cart in AJAX scenarios

### 🔄 Breaking Changes

None. This release maintains backward compatibility with version 1.0.0.

### 📝 Migration Notes

No migration required. All existing widgets and settings remain compatible.

---

## [1.0.0] - 2024-XX-XX

### Initial Release

- Added Elementor dropdown menu widget with trigger/menu customization controls
- Added accessibility behavior and responsive styling
- Basic hamburger trigger with optional label text
- Icon position control for trigger and each menu item
- Repeater-based menu items with link, icon, and new-tab option
- Dropdown animations, alignment, width, and visual styling
- Advanced dropdown box controls (offsets, min/max size, overflow, z-index)
- Outside-click and link-click close behavior
- Custom CSS declarations scoped to each widget instance
- Admin-only custom JavaScript execution support
- Keyboard navigation and ARIA attributes
