<?php
/**
 * Elementor widget: Woo Product Image.
 *
 * @package DevsroomDropdownMenu
 */

namespace Devsroom\DropdownMenu\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce product image widget with configurable thumbnail layout.
 */
class DDM_Woo_Product_Image_Widget extends Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'devsroom_woo_product_image';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Devsroom Product Image', 'devsroom-dropdown-menu' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-product-images';
	}

	/**
	 * Widget categories.
	 *
	 * @return string[]
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Widget style dependencies.
	 *
	 * @return string[]
	 */
	public function get_style_depends() {
		return array( 'ddm-woo-product-image' );
	}

	/**
	 * Widget script dependencies.
	 *
	 * @return string[]
	 */
	public function get_script_depends() {
		return array( 'ddm-woo-product-image' );
	}

	/**
	 * Registers widget controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->register_content_controls();
		$this->register_main_image_style_controls();
		$this->register_thumbnail_style_controls();
	}

	/**
	 * Registers content controls.
	 *
	 * @return void
	 */
	private function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Product Image', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'product_source',
			array(
				'label'   => __( 'Product Source', 'devsroom-dropdown-menu' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'current' => __( 'Current Product', 'devsroom-dropdown-menu' ),
					'custom'  => __( 'Custom Product', 'devsroom-dropdown-menu' ),
				),
				'default' => 'current',
			)
		);

		$this->add_control(
			'product_id',
			array(
				'label'       => __( 'Select Product', 'devsroom-dropdown-menu' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->get_product_options(),
				'label_block' => true,
				'condition'   => array(
					'product_source' => 'custom',
				),
			)
		);

		$this->add_control(
			'show_thumbnails',
			array(
				'label'        => __( 'Show Thumbnails', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'thumb_position',
			array(
				'label'   => __( 'Thumbnail Position', 'devsroom-dropdown-menu' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'bottom' => __( 'Bottom', 'devsroom-dropdown-menu' ),
					'top'    => __( 'Top', 'devsroom-dropdown-menu' ),
					'left'   => __( 'Left', 'devsroom-dropdown-menu' ),
					'right'  => __( 'Right', 'devsroom-dropdown-menu' ),
				),
				'default' => 'bottom',
			)
		);

		$this->add_responsive_control(
			'thumb_size',
			array(
				'label'      => __( 'Thumbnail Size', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 36,
						'max' => 220,
					),
				),
				'default'    => array(
					'size' => 72,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-image' => '--ddm-thumb-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'thumb_gap',
			array(
				'label'      => __( 'Thumbnail Gap', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 48,
					),
				),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-image' => '--ddm-thumb-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers main image style controls.
	 *
	 * @return void
	 */
	private function register_main_image_style_controls() {
		$this->start_controls_section(
			'section_style_main_image',
			array(
				'label' => __( 'Main Image', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'main_image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-image__main-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'main_image_border',
				'selector' => '{{WRAPPER}} .ddm-woo-product-image__main-image',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'main_image_shadow',
				'selector' => '{{WRAPPER}} .ddm-woo-product-image__main-image',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers thumbnail style controls.
	 *
	 * @return void
	 */
	private function register_thumbnail_style_controls() {
		$this->start_controls_section(
			'section_style_thumbnails',
			array(
				'label' => __( 'Thumbnails', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'thumb_border_radius',
			array(
				'label'      => __( 'Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-image__thumb, {{WRAPPER}} .ddm-woo-product-image__thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'thumb_border',
				'selector' => '{{WRAPPER}} .ddm-woo-product-image__thumb',
			)
		);

		$this->add_control(
			'thumb_active_border_color',
			array(
				'label'     => __( 'Active Border Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-image__thumb.is-active' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Renders widget output.
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$product  = $this->resolve_product( $settings );

		if ( ! $product ) {
			if ( $this->is_edit_mode() ) {
				echo '<div class="ddm-woo-product-image__notice">';
				echo esc_html__( 'No WooCommerce product found. Choose "Custom Product" or use this on a product page.', 'devsroom-dropdown-menu' );
				echo '</div>';
			}
			return;
		}

		$image_ids = $this->get_product_image_ids( $product );
		if ( empty( $image_ids ) ) {
			if ( $this->is_edit_mode() ) {
				echo '<div class="ddm-woo-product-image__notice">';
				echo esc_html__( 'This product has no images.', 'devsroom-dropdown-menu' );
				echo '</div>';
			}
			return;
		}

		$position        = $settings['thumb_position'] ?? 'bottom';
		$allowed         = array( 'bottom', 'top', 'left', 'right' );
		$thumb_position  = in_array( $position, $allowed, true ) ? $position : 'bottom';
		$show_thumbnails = 'yes' === ( $settings['show_thumbnails'] ?? 'yes' );

		$main_image_id = (int) $image_ids[0];
		$main_src      = wp_get_attachment_image_url( $main_image_id, 'woocommerce_single' );
		$main_srcset   = wp_get_attachment_image_srcset( $main_image_id, 'woocommerce_single' );
		$main_sizes    = wp_get_attachment_image_sizes( $main_image_id, 'woocommerce_single' );
		$main_alt      = get_post_meta( $main_image_id, '_wp_attachment_image_alt', true );

		if ( ! $main_src && function_exists( 'wc_placeholder_img_src' ) ) {
			$main_src = wc_placeholder_img_src( 'woocommerce_single' );
		}

		if ( ! $main_src ) {
			return;
		}

		if ( '' === $main_alt ) {
			$main_alt = $product->get_name();
		}

		$this->add_render_attribute(
			'wrapper',
			array(
				'class'               => 'ddm-woo-product-image',
				'data-thumb-position' => $thumb_position,
			)
		);

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
		echo '<div class="ddm-woo-product-image__main">';
		echo '<img class="ddm-woo-product-image__main-image" src="' . esc_url( $main_src ) . '" alt="' . esc_attr( $main_alt ) . '"';

		if ( ! empty( $main_srcset ) ) {
			echo ' srcset="' . esc_attr( $main_srcset ) . '"';
		}

		if ( ! empty( $main_sizes ) ) {
			echo ' sizes="' . esc_attr( $main_sizes ) . '"';
		}

		echo '>';
		echo '</div>';

		if ( $show_thumbnails && count( $image_ids ) > 1 ) {
			echo '<div class="ddm-woo-product-image__thumbs" role="tablist" aria-label="' . esc_attr__( 'Product gallery thumbnails', 'devsroom-dropdown-menu' ) . '">';

			foreach ( $image_ids as $index => $image_id ) {
				$image_id     = (int) $image_id;
				$thumb_src    = wp_get_attachment_image_url( $image_id, 'woocommerce_thumbnail' );
				$full_src     = wp_get_attachment_image_url( $image_id, 'woocommerce_single' );
				$full_srcset  = wp_get_attachment_image_srcset( $image_id, 'woocommerce_single' );
				$full_sizes   = wp_get_attachment_image_sizes( $image_id, 'woocommerce_single' );
				$image_alt    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				$is_active    = 0 === $index;
				$button_class = $is_active ? 'ddm-woo-product-image__thumb is-active' : 'ddm-woo-product-image__thumb';

				if ( '' === $image_alt ) {
					$image_alt = $product->get_name();
				}

				if ( ! $full_src ) {
					continue;
				}

				if ( ! $thumb_src ) {
					$thumb_src = $full_src;
				}

				echo '<button type="button" class="' . esc_attr( $button_class ) . '" data-full-src="' . esc_url( $full_src ) . '"';

				if ( ! empty( $full_srcset ) ) {
					echo ' data-full-srcset="' . esc_attr( $full_srcset ) . '"';
				}

				if ( ! empty( $full_sizes ) ) {
					echo ' data-full-sizes="' . esc_attr( $full_sizes ) . '"';
				}

				echo ' data-full-alt="' . esc_attr( $image_alt ) . '" aria-label="' . esc_attr__( 'Show image', 'devsroom-dropdown-menu' ) . '">';
				echo '<img src="' . esc_url( $thumb_src ) . '" alt="' . esc_attr( $image_alt ) . '">';
				echo '</button>';
			}

			echo '</div>';
		}

		echo '</div>';
	}

	/**
	 * Resolves the product from widget settings/context.
	 *
	 * @param array $settings Widget settings.
	 * @return \WC_Product|null
	 */
	private function resolve_product( $settings ) {
		if ( ! function_exists( 'wc_get_product' ) ) {
			return null;
		}

		$source = $settings['product_source'] ?? 'current';
		if ( 'custom' === $source && ! empty( $settings['product_id'] ) ) {
			$custom_product = wc_get_product( (int) $settings['product_id'] );
			if ( $custom_product ) {
				return $custom_product;
			}
		}

		global $product;
		if ( $product instanceof \WC_Product ) {
			return $product;
		}

		$post_id = get_the_ID();
		if ( $post_id && 'product' === get_post_type( $post_id ) ) {
			$current_product = wc_get_product( $post_id );
			if ( $current_product ) {
				return $current_product;
			}
		}

		if ( $this->is_edit_mode() ) {
			$products = function_exists( 'wc_get_products' ) ? wc_get_products(
				array(
					'status' => 'publish',
					'limit'  => 1,
					'return' => 'objects',
				)
			) : array();

			if ( ! empty( $products ) && $products[0] instanceof \WC_Product ) {
				return $products[0];
			}
		}

		return null;
	}

	/**
	 * Builds unique image IDs list for product gallery.
	 *
	 * @param \WC_Product $product Product instance.
	 * @return int[]
	 */
	private function get_product_image_ids( \WC_Product $product ) {
		$image_ids = array();
		$main_id   = (int) $product->get_image_id();

		if ( $main_id > 0 ) {
			$image_ids[] = $main_id;
		}

		$gallery_ids = $product->get_gallery_image_ids();
		if ( is_array( $gallery_ids ) ) {
			foreach ( $gallery_ids as $gallery_id ) {
				$gallery_id = (int) $gallery_id;
				if ( $gallery_id > 0 ) {
					$image_ids[] = $gallery_id;
				}
			}
		}

		return array_values( array_unique( $image_ids ) );
	}

	/**
	 * Returns product list options for control dropdown.
	 *
	 * @return array<string,string>
	 */
	private function get_product_options() {
		$options = array();

		if ( ! post_type_exists( 'product' ) ) {
			return $options;
		}

		$products = get_posts(
			array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => 100,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		foreach ( $products as $product_post ) {
			$options[ (string) $product_post->ID ] = $product_post->post_title;
		}

		return $options;
	}

	/**
	 * Checks whether Elementor editor mode is active.
	 *
	 * @return bool
	 */
	private function is_edit_mode() {
		return class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode();
	}
}
