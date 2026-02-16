<?php
/**
 * Elementor widget: Advanced Product Actions.
 *
 * @package DevsroomDropdownMenu
 */

namespace Devsroom\DropdownMenu\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce product actions widget with quantity and custom action support.
 */
class DDM_Advanced_Product_Actions_Widget extends Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'devsroom_advanced_product_actions';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Devsroom Advanced Product Actions', 'devsroom-dropdown-menu' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-product-add-to-cart';
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
	 * Registers widget controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->register_quantity_controls();
		$this->register_add_to_cart_controls();
		$this->register_custom_action_controls();
		$this->register_layout_controls();
		$this->register_quantity_style_controls();
		$this->register_add_to_cart_style_controls();
		$this->register_custom_button_style_controls();
	}

	/**
	 * Registers quantity content controls.
	 *
	 * @return void
	 */
	private function register_quantity_controls() {
		$this->start_controls_section(
			'section_quantity',
			array(
				'label' => __( 'Quantity Selector', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'show_quantity',
			array(
				'label'        => __( 'Show Quantity', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_quantity_label',
			array(
				'label'        => __( 'Show Label', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'show_quantity' => 'yes',
				),
			)
		);

		$this->add_control(
			'quantity_label',
			array(
				'label'     => __( 'Quantity Label', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Qty:', 'devsroom-dropdown-menu' ),
				'condition' => array(
					'show_quantity'       => 'yes',
					'show_quantity_label' => 'yes',
				),
			)
		);

		$this->add_control(
			'min_quantity',
			array(
				'label'     => __( 'Min Quantity', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'step'      => 1,
				'default'   => 1,
				'condition' => array(
					'show_quantity' => 'yes',
				),
			)
		);

		$this->add_control(
			'max_quantity',
			array(
				'label'     => __( 'Max Quantity', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'step'      => 1,
				'default'   => 10,
				'condition' => array(
					'show_quantity' => 'yes',
				),
			)
		);

		$this->add_control(
			'enable_max_limit',
			array(
				'label'        => __( 'Enable Max Limit', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_quantity' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers add-to-cart content controls.
	 *
	 * @return void
	 */
	private function register_add_to_cart_controls() {
		$this->start_controls_section(
			'section_add_to_cart',
			array(
				'label' => __( 'Add to Cart Button', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'add_to_cart_text',
			array(
				'label'   => __( 'Button Text', 'devsroom-dropdown-menu' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Add to Cart', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_responsive_control(
			'add_to_cart_width',
			array(
				'label'      => __( 'Button Width', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
					'px' => array(
						'min' => 80,
						'max' => 700,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-add-to-cart'                    => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ddm-apa-cart-area .single_add_to_cart_button' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers custom action button content controls.
	 *
	 * @return void
	 */
	private function register_custom_action_controls() {
		$this->start_controls_section(
			'section_custom_action',
			array(
				'label' => __( 'Custom Action Button', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'show_custom_button',
			array(
				'label'        => __( 'Show Custom Button', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'action_type',
			array(
				'label'     => __( 'Action Type', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'whatsapp'  => __( 'WhatsApp', 'devsroom-dropdown-menu' ),
					'messenger' => __( 'Facebook Messenger', 'devsroom-dropdown-menu' ),
				),
				'default'   => 'whatsapp',
				'condition' => array(
					'show_custom_button' => 'yes',
				),
			)
		);

		$this->add_control(
			'whatsapp_phone',
			array(
				'label'       => __( 'Phone Number', 'devsroom-dropdown-menu' ),
				'description' => __( 'Include country code. Example: 15551234567', 'devsroom-dropdown-menu' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => array(
					'show_custom_button' => 'yes',
					'action_type'        => 'whatsapp',
				),
			)
		);

		$this->add_control(
			'messenger_page_id',
			array(
				'label'       => __( 'Page ID or Username', 'devsroom-dropdown-menu' ),
				'description' => __( 'Used in m.me/{value}.', 'devsroom-dropdown-menu' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => array(
					'show_custom_button' => 'yes',
					'action_type'        => 'messenger',
				),
			)
		);

		$this->add_control(
			'custom_button_text',
			array(
				'label'     => __( 'Button Text', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Buy via WhatsApp', 'devsroom-dropdown-menu' ),
				'condition' => array(
					'show_custom_button' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'custom_button_width',
			array(
				'label'      => __( 'Button Width', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
					'px' => array(
						'min' => 80,
						'max' => 700,
					),
				),
				'condition'  => array(
					'show_custom_button' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'message_template',
			array(
				'label'       => __( 'Message Template', 'devsroom-dropdown-menu' ),
				'description' => __( 'Supported placeholders: {product_name}, {product_price}, {product_url}', 'devsroom-dropdown-menu' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => $this->get_default_message_template(),
				'condition'   => array(
					'show_custom_button' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers layout controls.
	 *
	 * @return void
	 */
	private function register_layout_controls() {
		$this->start_controls_section(
			'section_layout',
			array(
				'label' => __( 'Layout & Arrangement', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'layout_direction',
			array(
				'label'     => __( 'Layout Direction', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'row'    => __( 'Row', 'devsroom-dropdown-menu' ),
					'column' => __( 'Column', 'devsroom-dropdown-menu' ),
				),
				'default'   => 'row',
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-layout' => 'display: flex; flex-direction: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'layout_alignment',
			array(
				'label'     => __( 'Alignment', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start'    => array(
						'title' => __( 'Start', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'        => array(
						'title' => __( 'Center', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end'      => array(
						'title' => __( 'End', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-h-align-right',
					),
					'space-between' => array(
						'title' => __( 'Space Between', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-justify-space-between-h',
					),
				),
				'default'   => 'flex-start',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-layout' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'layout_wrap',
			array(
				'label'              => __( 'Wrap', 'devsroom-dropdown-menu' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'          => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value'       => 'yes',
				'default'            => '',
				'selectors'          => array(
					'{{WRAPPER}} .ddm-apa-layout' => 'flex-wrap: {{VALUE}};',
				),
				'selectors_dictionary' => array(
					'yes' => 'wrap',
					''    => 'nowrap',
				),
			)
		);

		$this->add_responsive_control(
			'layout_gap',
			array(
				'label'      => __( 'Gap', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 0,
						'max' => 80,
					),
					'rem' => array(
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-layout' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers quantity style controls.
	 *
	 * @return void
	 */
	private function register_quantity_style_controls() {
		$this->start_controls_section(
			'section_style_quantity',
			array(
				'label' => __( 'Quantity', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'quantity_label_typography',
				'label'    => __( 'Label Typography', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-apa-qty-label',
			)
		);

		$this->add_control(
			'quantity_label_color',
			array(
				'label'     => __( 'Label Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'quantity_input_typography',
				'label'    => __( 'Input Typography', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-apa-qty-input, {{WRAPPER}} .ddm-apa-cart-area .qty',
			)
		);

		$this->add_control(
			'quantity_input_text_color',
			array(
				'label'     => __( 'Input Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-input, {{WRAPPER}} .ddm-apa-cart-area .qty' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quantity_input_background_color',
			array(
				'label'     => __( 'Input Background', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-input, {{WRAPPER}} .ddm-apa-cart-area .qty' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quantity_input_border_color',
			array(
				'label'     => __( 'Input Border Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-input, {{WRAPPER}} .ddm-apa-cart-area .qty' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers add-to-cart style controls.
	 *
	 * @return void
	 */
	private function register_add_to_cart_style_controls() {
		$this->start_controls_section(
			'section_style_add_to_cart',
			array(
				'label' => __( 'Add to Cart Button', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'add_to_cart_typography',
				'selector' => '{{WRAPPER}} .ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa-cart-area .single_add_to_cart_button',
			)
		);

		$this->add_control(
			'add_to_cart_text_color',
			array(
				'label'     => __( 'Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa-cart-area .single_add_to_cart_button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'add_to_cart_background_color',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa-cart-area .single_add_to_cart_button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers custom action button style controls.
	 *
	 * @return void
	 */
	private function register_custom_button_style_controls() {
		$this->start_controls_section(
			'section_style_custom_button',
			array(
				'label' => __( 'Custom Button', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'custom_button_typography',
				'selector' => '{{WRAPPER}} .ddm-apa-custom-action-btn',
			)
		);

		$this->add_control(
			'custom_button_text_color',
			array(
				'label'     => __( 'Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'custom_button_background_color',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn' => 'background-color: {{VALUE}};',
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
		$product  = $this->resolve_product();

		if ( ! $product ) {
			if ( $this->is_edit_mode() ) {
				echo '<div class="ddm-apa__notice">';
				echo esc_html__( 'No WooCommerce product found. Use this widget on a product page.', 'devsroom-dropdown-menu' );
				echo '</div>';
			}
			return;
		}

		$instance_id          = 'ddm-apa-' . $this->get_id();
		$show_quantity        = $this->is_switcher_enabled( $settings['show_quantity'] ?? 'yes' );
		$show_quantity_label  = $show_quantity && $this->is_switcher_enabled( $settings['show_quantity_label'] ?? 'yes' );
		$quantity_label       = sanitize_text_field( $settings['quantity_label'] ?? __( 'Qty:', 'devsroom-dropdown-menu' ) );
		$min_quantity         = max( 1, (int) ( $settings['min_quantity'] ?? 1 ) );
		$max_quantity_raw     = (int) ( $settings['max_quantity'] ?? 10 );
		$max_quantity         = max( $min_quantity, $max_quantity_raw );
		$enable_max_limit     = $show_quantity && $this->is_switcher_enabled( $settings['enable_max_limit'] ?? '' );
		$add_to_cart_text     = sanitize_text_field( $settings['add_to_cart_text'] ?? __( 'Add to Cart', 'devsroom-dropdown-menu' ) );
		$show_custom_button   = $this->is_switcher_enabled( $settings['show_custom_button'] ?? 'yes' );
		$action_type          = $this->sanitize_action_type( $settings['action_type'] ?? 'whatsapp' );
		$whatsapp_phone       = sanitize_text_field( $settings['whatsapp_phone'] ?? '' );
		$messenger_page_id    = sanitize_text_field( $settings['messenger_page_id'] ?? '' );
		$custom_button_text   = sanitize_text_field( $settings['custom_button_text'] ?? __( 'Buy via WhatsApp', 'devsroom-dropdown-menu' ) );
		$message_template     = sanitize_textarea_field( $settings['message_template'] ?? $this->get_default_message_template() );
		$fallback_name        = sanitize_text_field( $product->get_name() );
		$fallback_price       = sanitize_text_field( $this->get_product_price_text( $product ) );
		$fallback_url         = esc_url_raw( get_permalink( $product->get_id() ) );
		$button_disabled_attr = ( ! $product->is_purchasable() || ! $product->is_in_stock() ) ? ' disabled="disabled"' : '';

		if ( '' === $add_to_cart_text ) {
			$add_to_cart_text = __( 'Add to Cart', 'devsroom-dropdown-menu' );
		}

		if ( '' === $custom_button_text ) {
			$custom_button_text = __( 'Contact for Purchase', 'devsroom-dropdown-menu' );
		}

		if ( '' === $message_template ) {
			$message_template = $this->get_default_message_template();
		}

		$this->add_render_attribute(
			'wrapper',
			array(
				'id'                         => $instance_id,
				'class'                      => 'ddm-apa',
				'data-action-type'           => $action_type,
				'data-whatsapp-phone'        => $whatsapp_phone,
				'data-messenger-page-id'     => $messenger_page_id,
				'data-message-template'      => $message_template,
				'data-enable-max-limit'      => $enable_max_limit ? 'yes' : 'no',
				'data-min-qty'               => (string) $min_quantity,
				'data-max-qty'               => (string) $max_quantity,
				'data-add-to-cart-text'      => $add_to_cart_text,
				'data-fallback-name'         => $fallback_name,
				'data-fallback-price'        => $fallback_price,
				'data-fallback-url'          => $fallback_url,
				'data-alert-max'             => sprintf(
					/* translators: %d: Maximum quantity limit. */
					__( 'Maximum quantity allowed is %d.', 'devsroom-dropdown-menu' ),
					$max_quantity
				),
				'data-alert-min'             => sprintf(
					/* translators: %d: Minimum quantity limit. */
					__( 'Minimum quantity is %d.', 'devsroom-dropdown-menu' ),
					$min_quantity
				),
				'data-alert-action-missing'  => __( 'Please configure a phone number or Messenger page ID.', 'devsroom-dropdown-menu' ),
			)
		);

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
		echo '<div class="ddm-apa-layout">';
		echo '<div class="ddm-apa-cart-area">';

		if ( $product->is_type( 'simple' ) ) {
			$form_action = apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() );

			echo '<form class="cart ddm-apa-simple-cart" action="' . esc_url( $form_action ) . '" method="post" enctype="multipart/form-data">';

			if ( $show_quantity ) {
				echo '<div class="ddm-apa-qty-wrap">';

				if ( $show_quantity_label && '' !== $quantity_label ) {
					echo '<label class="ddm-apa-qty-label" for="' . esc_attr( $instance_id . '-quantity' ) . '">' . esc_html( $quantity_label ) . '</label>';
				}

				if ( function_exists( 'woocommerce_quantity_input' ) ) {
					$quantity_html = woocommerce_quantity_input(
						array(
							'input_id'    => $instance_id . '-quantity',
							'input_name'  => 'quantity',
							'input_value' => $min_quantity,
							'min_value'   => $min_quantity,
							'max_value'   => $max_quantity,
							'classes'     => array( 'input-text', 'qty', 'text', 'ddm-apa-qty-input' ),
						),
						$product,
						false
					);

					echo $quantity_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} else {
					echo '<input id="' . esc_attr( $instance_id . '-quantity' ) . '" class="ddm-apa-qty-input qty" type="number" name="quantity" value="' . esc_attr( (string) $min_quantity ) . '" min="' . esc_attr( (string) $min_quantity ) . '" max="' . esc_attr( (string) $max_quantity ) . '" step="1">';
				}

				echo '</div>';
			} else {
				echo '<input type="hidden" name="quantity" value="1">';
			}

			echo '<input type="hidden" name="product_id" value="' . esc_attr( (string) $product->get_id() ) . '">';
			echo '<button type="submit" name="add-to-cart" value="' . esc_attr( (string) $product->get_id() ) . '" class="single_add_to_cart_button button alt ddm-apa-add-to-cart"' . $button_disabled_attr . '>';
			echo esc_html( $add_to_cart_text );
			echo '</button>';
			echo '</form>';
		} else {
			$this->render_native_add_to_cart( $product );
		}

		echo '</div>';

		if ( $show_custom_button ) {
			echo '<button type="button" class="ddm-apa-custom-action-btn button">' . esc_html( $custom_button_text ) . '</button>';
		}

		echo '</div>';
		echo '</div>';

		$this->render_inline_script( $instance_id );
	}

	/**
	 * Renders WooCommerce native add-to-cart template for non-simple product types.
	 *
	 * @param \WC_Product $product Product instance.
	 * @return void
	 */
	private function render_native_add_to_cart( \WC_Product $product ) {
		if ( ! function_exists( 'woocommerce_template_single_add_to_cart' ) ) {
			return;
		}

		$previous_product = isset( $GLOBALS['product'] ) ? $GLOBALS['product'] : null;
		$GLOBALS['product'] = $product;

		woocommerce_template_single_add_to_cart(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( null !== $previous_product ) {
			$GLOBALS['product'] = $previous_product;
		} else {
			unset( $GLOBALS['product'] );
		}
	}

	/**
	 * Outputs per-instance frontend script for custom action and quantity validation.
	 *
	 * @param string $instance_id Widget instance ID.
	 * @return void
	 */
	private function render_inline_script( $instance_id ) {
		echo '<script>';
		echo '(function(){';
		echo 'var root=document.getElementById(' . wp_json_encode( $instance_id ) . ');';
		echo 'if(!root||root.dataset.ddmApaInit==="yes"){return;}';
		echo 'root.dataset.ddmApaInit="yes";';
		echo 'var customButton=root.querySelector(".ddm-apa-custom-action-btn");';
		echo 'var addToCartButtons=root.querySelectorAll(".ddm-apa-cart-area .single_add_to_cart_button");';
		echo 'var actionType=(root.dataset.actionType||"whatsapp").trim();';
		echo 'var whatsappPhone=(root.dataset.whatsappPhone||"").trim();';
		echo 'var messengerPageId=(root.dataset.messengerPageId||"").trim();';
		echo 'var messageTemplate=root.dataset.messageTemplate||"";';
		echo 'var fallbackName=root.dataset.fallbackName||"";';
		echo 'var fallbackPrice=root.dataset.fallbackPrice||"";';
		echo 'var fallbackUrl=root.dataset.fallbackUrl||window.location.href;';
		echo 'var addToCartText=(root.dataset.addToCartText||"").trim();';
		echo 'var maxLimitEnabled=root.dataset.enableMaxLimit==="yes";';
		echo 'var minQty=parseInt(root.dataset.minQty||"1",10);';
		echo 'var maxQty=parseInt(root.dataset.maxQty||"10",10);';
		echo 'var maxAlert=root.dataset.alertMax||("Maximum quantity allowed is "+maxQty+".");';
		echo 'var minAlert=root.dataset.alertMin||("Minimum quantity is "+minQty+".");';
		echo 'var missingActionAlert=root.dataset.alertActionMissing||"Please configure a phone number or Messenger page ID.";';
		echo 'if(!Number.isFinite(minQty)||minQty<1){minQty=1;}';
		echo 'if(!Number.isFinite(maxQty)||maxQty<minQty){maxQty=minQty;}';
		echo 'Array.prototype.forEach.call(addToCartButtons,function(button){';
		echo 'if(!addToCartText){return;}';
		echo 'if(button.tagName==="INPUT"){button.value=addToCartText;}else{button.textContent=addToCartText;}';
		echo '});';
		echo 'function readFirstText(selectors,fallback){';
		echo 'for(var i=0;i<selectors.length;i++){';
		echo 'var node=document.querySelector(selectors[i]);';
		echo 'if(!node){continue;}';
		echo 'var text=(node.textContent||node.innerText||"").replace(/\\s+/g," ").trim();';
		echo 'if(text){return text;}';
		echo '}';
		echo 'return fallback||"";';
		echo '}';
		echo 'function replacePlaceholders(template,data){';
		echo 'var output=template||"";';
		echo 'output=output.split("{product_name}").join(data.product_name||"");';
		echo 'output=output.split("{product_price}").join(data.product_price||"");';
		echo 'output=output.split("{product_url}").join(data.product_url||"");';
		echo 'return output;';
		echo '}';
		echo 'function buildDynamicMessage(){';
		echo '/*';
		echo ' Build message from live DOM values so the outgoing link reflects current product context.';
		echo ' Placeholders are replaced with title, price, and URL values at click time.';
		echo '*/';
		echo 'var productName=readFirstText([".product_title","h1.product_title","[itemprop=\\"name\\"]"],fallbackName);';
		echo 'var productPrice=readFirstText([".summary .price",".product .price",".price"],fallbackPrice);';
		echo 'var productUrl=window.location.href||fallbackUrl;';
		echo 'return replacePlaceholders(messageTemplate,{product_name:productName,product_price:productPrice,product_url:productUrl});';
		echo '}';
		echo 'function openCustomAction(){';
		echo 'var message=buildDynamicMessage();';
		echo 'var destination="";';
		echo 'if("messenger"===actionType){';
		echo 'var pageTarget=messengerPageId.replace(/^\\/+|\\/+$/g,"");';
		echo 'if(!pageTarget){window.alert(missingActionAlert);return;}';
		echo 'destination="https://m.me/"+encodeURIComponent(pageTarget);';
		echo 'if(message){destination+="?ref="+encodeURIComponent(message);}';
		echo '}else{';
		echo 'var phoneTarget=whatsappPhone.replace(/[^\\d]/g,"");';
		echo 'if(!phoneTarget){window.alert(missingActionAlert);return;}';
		echo 'destination="https://wa.me/"+phoneTarget;';
		echo 'if(message){destination+="?text="+encodeURIComponent(message);}';
		echo '}';
		echo 'window.open(destination,"_blank","noopener,noreferrer");';
		echo '}';
		echo 'if(customButton){customButton.addEventListener("click",function(event){event.preventDefault();openCustomAction();});}';
		echo 'function validateQuantityScope(scope){';
		echo 'if(!maxLimitEnabled){return true;}';
		echo 'var inputs=scope.querySelectorAll("input.qty,input[name=\\"quantity\\"]");';
		echo 'for(var i=0;i<inputs.length;i++){';
		echo 'var input=inputs[i];';
		echo 'var raw=(input.value||"").trim();';
		echo 'if(!raw){continue;}';
		echo 'var value=parseFloat(raw);';
		echo 'if(!Number.isFinite(value)){continue;}';
		echo 'if(value>maxQty){input.value=maxQty;window.alert(maxAlert);return false;}';
		echo 'if(value<minQty){input.value=minQty;window.alert(minAlert);return false;}';
		echo '}';
		echo 'return true;';
		echo '}';
		echo 'if(maxLimitEnabled){';
		echo 'var forms=root.querySelectorAll("form");';
		echo 'Array.prototype.forEach.call(forms,function(form){';
		echo 'form.addEventListener("submit",function(event){';
		echo 'if(!validateQuantityScope(form)){event.preventDefault();event.stopPropagation();}';
		echo '});';
		echo '});';
		echo '}';
		echo '})();';
		echo '</script>';
	}

	/**
	 * Resolves the current WooCommerce product.
	 *
	 * @return \WC_Product|null
	 */
	private function resolve_product() {
		if ( ! function_exists( 'wc_get_product' ) ) {
			return null;
		}

		global $product;
		if ( $product instanceof \WC_Product ) {
			return $product;
		}

		$post_id = get_the_ID();
		if ( $post_id && 'product' === get_post_type( $post_id ) ) {
			$current_product = wc_get_product( $post_id );
			if ( $current_product instanceof \WC_Product ) {
				return $current_product;
			}
		}

		if ( $this->is_edit_mode() && function_exists( 'wc_get_products' ) ) {
			$products = wc_get_products(
				array(
					'status' => 'publish',
					'limit'  => 1,
					'return' => 'objects',
				)
			);

			if ( ! empty( $products ) && $products[0] instanceof \WC_Product ) {
				return $products[0];
			}
		}

		return null;
	}

	/**
	 * Returns a simple human-readable price text.
	 *
	 * @param \WC_Product $product Product instance.
	 * @return string
	 */
	private function get_product_price_text( \WC_Product $product ) {
		$price_html = (string) $product->get_price_html();
		if ( '' !== $price_html ) {
			return html_entity_decode( wp_strip_all_tags( $price_html ), ENT_QUOTES, get_bloginfo( 'charset' ) );
		}

		$raw_price = $product->get_price();
		if ( '' !== $raw_price && function_exists( 'wc_price' ) ) {
			return html_entity_decode( wp_strip_all_tags( wc_price( (float) $raw_price ) ), ENT_QUOTES, get_bloginfo( 'charset' ) );
		}

		return '';
	}

	/**
	 * Returns default dynamic message template.
	 *
	 * @return string
	 */
	private function get_default_message_template() {
		return "Hi, I'm interested in this product: {product_name}\nPrice: {product_price}\nProduct URL: {product_url}";
	}

	/**
	 * Sanitizes action type value.
	 *
	 * @param string $action_type Action type setting.
	 * @return string
	 */
	private function sanitize_action_type( $action_type ) {
		return in_array( $action_type, array( 'whatsapp', 'messenger' ), true ) ? $action_type : 'whatsapp';
	}

	/**
	 * Checks whether Elementor editor mode is active.
	 *
	 * @return bool
	 */
	private function is_edit_mode() {
		return class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode();
	}

	/**
	 * Determines whether switcher value is enabled.
	 *
	 * @param mixed $value Switcher value.
	 * @return bool
	 */
	private function is_switcher_enabled( $value ) {
		return 'yes' === $value;
	}
}
