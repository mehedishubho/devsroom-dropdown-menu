<?php
/**
 * Elementor widget: Advanced Product Actions.
 *
 * @package DevsroomDropdownMenu
 */

namespace Devsroom\DropdownMenu\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
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
		$this->register_container_style_controls();
		$this->register_buttons_common_style_controls();
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
				'label'     => __( 'Label', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Qty:', 'devsroom-dropdown-menu' ),
				'condition' => array(
					'show_quantity'       => 'yes',
					'show_quantity_label' => 'yes',
				),
			)
		);

		$this->add_control(
			'quantity_label_position',
			array(
				'label'     => __( 'Label Position', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'left'  => __( 'Left', 'devsroom-dropdown-menu' ),
					'top'   => __( 'Top', 'devsroom-dropdown-menu' ),
					'right' => __( 'Right', 'devsroom-dropdown-menu' ),
				),
				'default'   => 'left',
				'condition' => array(
					'show_quantity'       => 'yes',
					'show_quantity_label' => 'yes',
				),
			)
		);

		$this->add_control(
			'minus_icon',
			array(
				'label'     => __( 'Minus Icon', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => '',
					'library' => '',
				),
				'condition' => array(
					'show_quantity' => 'yes',
				),
			)
		);

		$this->add_control(
			'plus_icon',
			array(
				'label'       => __( 'Increase Icon (+)', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => '',
					'library' => '',
				),
				'description' => __( 'Icon shown on the right-side quantity increase button.', 'devsroom-dropdown-menu' ),
				'label_block' => true,
				'condition' => array(
					'show_quantity' => 'yes',
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

		$this->add_control(
			'max_limit_notice',
			array(
				'label'     => __( 'Max Limit Notice', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows'      => 3,
				'default'   => __( 'You cannot order more than {max} items.', 'devsroom-dropdown-menu' ),
				'condition' => array(
					'show_quantity'    => 'yes',
					'enable_max_limit' => 'yes',
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
			'show_add_to_cart',
			array(
				'label'        => __( 'Show Add to Cart', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'add_to_cart_text',
			array(
				'label'   => __( 'Button Text', 'devsroom-dropdown-menu' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Add to Cart', 'devsroom-dropdown-menu' ),
				'condition' => array(
					'show_add_to_cart' => 'yes',
				),
			)
		);

		$this->add_control(
			'add_to_cart_link',
			array(
				'label'         => __( 'Redirect Link After Add', 'devsroom-dropdown-menu' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-site.com/cart', 'devsroom-dropdown-menu' ),
				'show_external' => false,
				'default'       => array(
					'url' => '',
				),
				'condition'     => array(
					'show_add_to_cart' => 'yes',
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

		$this->add_responsive_control(
			'layout_margin',
			array(
				'label'      => __( 'Widget Margin', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers container style controls.
	 *
	 * @return void
	 */
	private function register_container_style_controls() {
		$this->start_controls_section(
			'section_style_container',
			array(
				'label' => __( 'Container', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => __( 'Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_margin',
			array(
				'label'      => __( 'Margin', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .ddm-apa',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .ddm-apa',
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => __( 'Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers common button style controls.
	 *
	 * @return void
	 */
	private function register_buttons_common_style_controls() {
		$this->start_controls_section(
			'section_style_buttons_common',
			array(
				'label' => __( 'Buttons Common', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'buttons_global_padding',
			array(
				'label'      => __( 'Global Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa button, {{WRAPPER}} .ddm-apa .button, {{WRAPPER}} .ddm-apa-cart-area .single_add_to_cart_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'buttons_global_margin',
			array(
				'label'      => __( 'Global Margin', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa button, {{WRAPPER}} .ddm-apa .button, {{WRAPPER}} .ddm-apa-cart-area .single_add_to_cart_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'buttons_global_gap',
			array(
				'label'      => __( 'Button Gap', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 0,
						'max' => 80,
					),
					'em'  => array(
						'min' => 0,
						'max' => 5,
					),
					'rem' => array(
						'min' => 0,
						'max' => 5,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa' => '--ddm-apa-button-gap: {{SIZE}}{{UNIT}};',
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

		$this->add_responsive_control(
			'quantity_label_margin_bottom',
			array(
				'label'      => __( 'Label Margin Bottom', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 0,
						'max' => 80,
					),
					'em'  => array(
						'min' => 0,
						'max' => 5,
					),
					'rem' => array(
						'min' => 0,
						'max' => 5,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-qty-wrap--label-top .ddm-apa-qty-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'quantity_label_gap',
			array(
				'label'      => __( 'Label Gap', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 0,
						'max' => 80,
					),
					'em'  => array(
						'min' => 0,
						'max' => 5,
					),
					'rem' => array(
						'min' => 0,
						'max' => 5,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa' => '--ddm-apa-qty-label-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'quantity_inner_gap',
			array(
				'label'      => __( 'Inner Gap', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 0,
						'max' => 40,
					),
					'em'  => array(
						'min' => 0,
						'max' => 3,
					),
					'rem' => array(
						'min' => 0,
						'max' => 3,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa' => '--ddm-apa-qty-inner-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'quantity_box_width',
			array(
				'label'      => __( 'Input Box Width', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 190,
				),
				'range'      => array(
					'px' => array(
						'min' => 100,
						'max' => 500,
					),
					'%'  => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-qty-field'           => '--ddm-apa-qty-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ddm-apa-cart-area .quantity' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'quantity_box_padding',
			array(
				'label'      => __( 'Input Box Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-qty-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .ddm-apa-qty-field, {{WRAPPER}} .ddm-apa-qty-input, {{WRAPPER}} .ddm-apa-cart-area .qty' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quantity_input_border_color',
			array(
				'label'     => __( 'Input Border Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-field, {{WRAPPER}} .ddm-apa-qty-input, {{WRAPPER}} .ddm-apa-cart-area .qty' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'quantity_box_border',
				'label'    => __( 'Quantity Box Border', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-apa-qty-field',
			)
		);

		$this->add_responsive_control(
			'quantity_box_border_radius',
			array(
				'label'      => __( 'Input Box Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-qty-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'quantity_icons_heading',
			array(
				'label'     => __( 'Icons (+/-)', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'quantity_icon_size',
			array(
				'label'      => __( 'Icon Size', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 8,
						'max' => 80,
					),
					'em'  => array(
						'min' => 0.5,
						'max' => 5,
					),
					'rem' => array(
						'min' => 0.5,
						'max' => 5,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa' => '--ddm-apa-icon-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'quantity_icon_color_tabs' );

		$this->start_controls_tab(
			'quantity_icon_color_tab_normal',
			array(
				'label' => __( 'Normal', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'quantity_icon_color',
			array(
				'label'     => __( 'Icon Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-btn, {{WRAPPER}} .ddm-apa-qty-btn .ddm-apa-qty-btn-icon, {{WRAPPER}} .ddm-apa-qty-btn .ddm-apa-qty-btn-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-apa-qty-btn .ddm-apa-qty-btn-icon svg, {{WRAPPER}} .ddm-apa-qty-btn .ddm-apa-qty-btn-icon svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quantity_icon_bg_color',
			array(
				'label'     => __( 'Icon Background', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'quantity_icon_color_tab_hover',
			array(
				'label' => __( 'Hover', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'quantity_icon_color_hover',
			array(
				'label'     => __( 'Icon Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-btn:hover, {{WRAPPER}} .ddm-apa-qty-btn:focus-visible, {{WRAPPER}} .ddm-apa-qty-btn:hover .ddm-apa-qty-btn-icon, {{WRAPPER}} .ddm-apa-qty-btn:hover .ddm-apa-qty-btn-icon i, {{WRAPPER}} .ddm-apa-qty-btn:focus-visible .ddm-apa-qty-btn-icon, {{WRAPPER}} .ddm-apa-qty-btn:focus-visible .ddm-apa-qty-btn-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-apa-qty-btn:hover .ddm-apa-qty-btn-icon svg, {{WRAPPER}} .ddm-apa-qty-btn:hover .ddm-apa-qty-btn-icon svg *, {{WRAPPER}} .ddm-apa-qty-btn:focus-visible .ddm-apa-qty-btn-icon svg, {{WRAPPER}} .ddm-apa-qty-btn:focus-visible .ddm-apa-qty-btn-icon svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quantity_icon_bg_color_hover',
			array(
				'label'     => __( 'Icon Background', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-btn:hover, {{WRAPPER}} .ddm-apa-qty-btn:focus-visible' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'quantity_increase_icon_heading',
			array(
				'label'     => __( 'Increase Icon Style', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'quantity_increase_icon_color',
			array(
				'label'     => __( 'Increase Icon Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-btn--plus, {{WRAPPER}} .ddm-apa-qty-btn--plus .ddm-apa-qty-btn-icon, {{WRAPPER}} .ddm-apa-qty-btn--plus .ddm-apa-qty-btn-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-apa-qty-btn--plus .ddm-apa-qty-btn-icon svg, {{WRAPPER}} .ddm-apa-qty-btn--plus .ddm-apa-qty-btn-icon svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quantity_increase_icon_bg_color',
			array(
				'label'     => __( 'Increase Icon Background', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-btn--plus' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quantity_increase_icon_color_hover',
			array(
				'label'     => __( 'Increase Icon Hover Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-btn--plus:hover, {{WRAPPER}} .ddm-apa-qty-btn--plus:focus-visible, {{WRAPPER}} .ddm-apa-qty-btn--plus:hover .ddm-apa-qty-btn-icon, {{WRAPPER}} .ddm-apa-qty-btn--plus:hover .ddm-apa-qty-btn-icon i, {{WRAPPER}} .ddm-apa-qty-btn--plus:focus-visible .ddm-apa-qty-btn-icon, {{WRAPPER}} .ddm-apa-qty-btn--plus:focus-visible .ddm-apa-qty-btn-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-apa-qty-btn--plus:hover .ddm-apa-qty-btn-icon svg, {{WRAPPER}} .ddm-apa-qty-btn--plus:hover .ddm-apa-qty-btn-icon svg *, {{WRAPPER}} .ddm-apa-qty-btn--plus:focus-visible .ddm-apa-qty-btn-icon svg, {{WRAPPER}} .ddm-apa-qty-btn--plus:focus-visible .ddm-apa-qty-btn-icon svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quantity_increase_icon_bg_color_hover',
			array(
				'label'     => __( 'Increase Icon Hover Background', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-btn--plus:hover, {{WRAPPER}} .ddm-apa-qty-btn--plus:focus-visible' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'quantity_increase_icon_border',
				'label'    => __( 'Increase Icon Border', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-apa-qty-btn--plus',
			)
		);

		$this->add_control(
			'quantity_increase_icon_border_color_hover',
			array(
				'label'     => __( 'Increase Icon Hover Border Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-qty-btn--plus:hover, {{WRAPPER}} .ddm-apa-qty-btn--plus:focus-visible' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'quantity_icon_padding',
			array(
				'label'      => __( 'Icon Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-qty-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'quantity_icon_border_radius',
			array(
				'label'      => __( 'Icon Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-qty-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'quantity_notice_heading',
			array(
				'label'     => __( 'Error Notice', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'quantity_notice_typography',
				'selector' => '{{WRAPPER}} .advanced-qty-notice',
			)
		);

		$this->add_control(
			'quantity_notice_color',
			array(
				'label'     => __( 'Notice Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .advanced-qty-notice' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'quantity_notice_bg_color',
			array(
				'label'     => __( 'Notice Background', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .advanced-qty-notice' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'quantity_notice_border',
				'selector' => '{{WRAPPER}} .advanced-qty-notice',
			)
		);

		$this->add_responsive_control(
			'quantity_notice_border_radius',
			array(
				'label'      => __( 'Notice Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .advanced-qty-notice' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'quantity_notice_padding',
			array(
				'label'      => __( 'Notice Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .advanced-qty-notice' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'quantity_notice_margin',
			array(
				'label'      => __( 'Notice Margin', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .advanced-qty-notice' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$this->add_control(
			'add_to_cart_width_mode',
			array(
				'label'                => __( 'Width', 'devsroom-dropdown-menu' ),
				'type'                 => Controls_Manager::SELECT,
				'options'              => array(
					'custom' => __( 'Custom', 'devsroom-dropdown-menu' ),
					'auto'   => __( 'Auto', 'devsroom-dropdown-menu' ),
				),
				'default'              => 'custom',
				'selectors'            => array(
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button' => 'width: {{VALUE}} !important;',
				),
				'selectors_dictionary' => array(
					'custom' => 'initial',
					'auto'   => 'auto',
				),
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
				'condition'  => array(
					'add_to_cart_width_mode' => 'custom',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart' => 'width: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button'                       => 'width: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'add_to_cart_padding',
			array(
				'label'      => __( 'Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'add_to_cart_margin',
			array(
				'label'      => __( 'Margin', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'add_to_cart_typography',
				'selector' => '{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button',
			)
		);

		$this->start_controls_tabs( 'add_to_cart_color_tabs' );

		$this->start_controls_tab(
			'add_to_cart_color_tab_normal',
			array(
				'label' => __( 'Normal', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'add_to_cart_text_color',
			array(
				'label'     => __( 'Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'add_to_cart_background_color',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button' => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'add_to_cart_color_tab_hover',
			array(
				'label' => __( 'Hover', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'add_to_cart_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart:hover, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart:focus-visible, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button:hover, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button:focus-visible' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'add_to_cart_background_color_hover',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart:hover, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart:focus-visible, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button:hover, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button:focus-visible' => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'add_to_cart_border',
				'selector' => '{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button',
			)
		);

		$this->add_responsive_control(
			'add_to_cart_border_radius',
			array(
				'label'      => __( 'Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button.ddm-apa-add-to-cart, {{WRAPPER}} .ddm-apa .ddm-apa-cart-area .single_add_to_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_control(
			'add_to_cart_hover_animation',
			array(
				'label' => __( 'Hover Animation', 'devsroom-dropdown-menu' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
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

		$this->add_control(
			'custom_button_width_mode',
			array(
				'label'                => __( 'Width', 'devsroom-dropdown-menu' ),
				'type'                 => Controls_Manager::SELECT,
				'options'              => array(
					'custom' => __( 'Custom', 'devsroom-dropdown-menu' ),
					'auto'   => __( 'Auto', 'devsroom-dropdown-menu' ),
				),
				'default'              => 'custom',
				'selectors'            => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn' => 'width: {{VALUE}};',
				),
				'selectors_dictionary' => array(
					'custom' => 'initial',
					'auto'   => 'auto',
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
					'custom_button_width_mode' => 'custom',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'custom_button_padding',
			array(
				'label'      => __( 'Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'custom_button_margin',
			array(
				'label'      => __( 'Margin', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'custom_button_typography',
				'selector' => '{{WRAPPER}} .ddm-apa-custom-action-btn',
			)
		);

		$this->start_controls_tabs( 'custom_button_color_tabs' );

		$this->start_controls_tab(
			'custom_button_color_tab_normal',
			array(
				'label' => __( 'Normal', 'devsroom-dropdown-menu' ),
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

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_button_color_tab_hover',
			array(
				'label' => __( 'Hover', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'custom_button_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn:hover, {{WRAPPER}} .ddm-apa-custom-action-btn:focus-visible' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'custom_button_background_color_hover',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn:hover, {{WRAPPER}} .ddm-apa-custom-action-btn:focus-visible' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'custom_button_border',
				'selector' => '{{WRAPPER}} .ddm-apa-custom-action-btn',
			)
		);

		$this->add_responsive_control(
			'custom_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-apa-custom-action-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'custom_button_hover_animation',
			array(
				'label' => __( 'Hover Animation', 'devsroom-dropdown-menu' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
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
		$quantity_label_pos   = $this->sanitize_quantity_label_position( $settings['quantity_label_position'] ?? 'left' );
		$minus_icon_markup    = $this->get_icon_markup( $settings['minus_icon'] ?? array(), '-' );
		$plus_icon_markup     = $this->get_icon_markup( $settings['plus_icon'] ?? array(), '+' );
		$min_quantity         = max( 1, (int) ( $settings['min_quantity'] ?? 1 ) );
		$max_quantity_raw     = (int) ( $settings['max_quantity'] ?? 10 );
		$max_quantity         = max( $min_quantity, $max_quantity_raw );
		$enable_max_limit     = $show_quantity && $this->is_switcher_enabled( $settings['enable_max_limit'] ?? '' );
		$max_notice_template  = sanitize_textarea_field( $settings['max_limit_notice'] ?? __( 'You cannot order more than {max} items.', 'devsroom-dropdown-menu' ) );
		$max_notice_text      = str_replace( '{max}', (string) $max_quantity, $max_notice_template );
		$input_max_attribute  = $enable_max_limit ? ' max="' . esc_attr( (string) $max_quantity ) . '"' : '';
		$show_add_to_cart     = $this->is_switcher_enabled( $settings['show_add_to_cart'] ?? 'yes' );
		$add_to_cart_text     = sanitize_text_field( $settings['add_to_cart_text'] ?? __( 'Add to Cart', 'devsroom-dropdown-menu' ) );
		$add_to_cart_link     = isset( $settings['add_to_cart_link'] ) && is_array( $settings['add_to_cart_link'] ) ? $settings['add_to_cart_link'] : array();
		$redirect_after_add   = ! empty( $add_to_cart_link['url'] ) ? esc_url_raw( $add_to_cart_link['url'] ) : '';
		$add_to_cart_anim     = $this->sanitize_hover_animation( $settings['add_to_cart_hover_animation'] ?? '' );
		$show_custom_button   = $this->is_switcher_enabled( $settings['show_custom_button'] ?? 'yes' );
		$action_type          = $this->sanitize_action_type( $settings['action_type'] ?? 'whatsapp' );
		$whatsapp_phone       = sanitize_text_field( $settings['whatsapp_phone'] ?? '' );
		$messenger_page_id    = sanitize_text_field( $settings['messenger_page_id'] ?? '' );
		$custom_button_text   = sanitize_text_field( $settings['custom_button_text'] ?? __( 'Buy via WhatsApp', 'devsroom-dropdown-menu' ) );
		$custom_button_anim   = $this->sanitize_hover_animation( $settings['custom_button_hover_animation'] ?? '' );
		$custom_button_bg     = $settings['custom_button_background_color'] ?? '';
		$message_template     = sanitize_textarea_field( $settings['message_template'] ?? $this->get_default_message_template() );
		$fallback_name        = sanitize_text_field( $product->get_name() );
		$fallback_price       = sanitize_text_field( $this->get_product_price_text( $product ) );
		$fallback_url         = esc_url_raw( get_permalink( $product->get_id() ) );
		$button_disabled_attr = ( ! $product->is_purchasable() || ! $product->is_in_stock() ) ? ' disabled="disabled"' : '';
		$custom_default_bg    = 'messenger' === $action_type ? '#1877F2' : '#25D366';
		$custom_default_color = '#ffffff';

		if ( '' === $add_to_cart_text ) {
			$add_to_cart_text = __( 'Add to Cart', 'devsroom-dropdown-menu' );
		}

		if ( '' === $custom_button_text ) {
			$custom_button_text = __( 'Contact for Purchase', 'devsroom-dropdown-menu' );
		}

		if ( '' === $message_template ) {
			$message_template = $this->get_default_message_template();
		}

		if ( '' === $max_notice_template ) {
			$max_notice_template = __( 'You cannot order more than {max} items.', 'devsroom-dropdown-menu' );
			$max_notice_text     = str_replace( '{max}', (string) $max_quantity, $max_notice_template );
		}

		$add_to_cart_button_class = 'single_add_to_cart_button button alt ddm-apa-add-to-cart';
		if ( '' !== $add_to_cart_anim ) {
			$add_to_cart_button_class .= ' elementor-animation-' . $add_to_cart_anim;
		}

		$custom_button_class = 'ddm-apa-custom-action-btn button';
		if ( '' !== $custom_button_anim ) {
			$custom_button_class .= ' elementor-animation-' . $custom_button_anim;
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
				'data-max-limit'             => (string) $max_quantity,
				'data-min-qty'               => (string) $min_quantity,
				'data-max-qty'               => (string) $max_quantity,
				'data-max-notice-template'   => $max_notice_template,
				'data-max-notice-text'       => $max_notice_text,
				'data-show-add-to-cart'      => $show_add_to_cart ? 'yes' : 'no',
				'data-add-to-cart-text'      => $add_to_cart_text,
				'data-add-cart-redirect'     => $redirect_after_add,
				'data-add-cart-animation'    => $add_to_cart_anim,
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

		if ( $show_add_to_cart ) {
			if ( $product->is_type( 'simple' ) ) {
				$form_action = apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() );

				echo '<form class="cart ddm-apa-simple-cart" action="' . esc_url( $form_action ) . '" method="post" enctype="multipart/form-data">';

				if ( $show_quantity ) {
					$qty_wrap_class = 'ddm-apa-qty-wrap ddm-apa-qty-wrap--label-' . $quantity_label_pos;
					if ( ! $show_quantity_label || '' === $quantity_label ) {
						$qty_wrap_class .= ' ddm-apa-qty-wrap--no-label';
					}

					echo '<div class="' . esc_attr( $qty_wrap_class ) . '">';

					$render_label_before = in_array( $quantity_label_pos, array( 'left', 'top' ), true );
					if ( $show_quantity_label && '' !== $quantity_label && $render_label_before ) {
						echo '<label class="ddm-apa-qty-label" for="' . esc_attr( $instance_id . '-quantity' ) . '">' . esc_html( $quantity_label ) . '</label>';
					}

					echo '<div class="ddm-apa-qty-field">';
					echo '<div class="ddm-apa-qty-field-inner">';
					echo '<button type="button" class="ddm-apa-qty-btn ddm-apa-qty-btn--minus" data-qty-step="-1" aria-label="' . esc_attr__( 'Decrease quantity', 'devsroom-dropdown-menu' ) . '">';
					echo '<span class="ddm-apa-qty-btn-icon" aria-hidden="true">' . $minus_icon_markup . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '</button>';
					echo '<input id="' . esc_attr( $instance_id . '-quantity' ) . '" class="ddm-apa-qty-input qty" type="number" name="quantity" value="' . esc_attr( (string) $min_quantity ) . '" min="' . esc_attr( (string) $min_quantity ) . '"' . $input_max_attribute . ' data-max-limit="' . esc_attr( (string) $max_quantity ) . '" step="1" inputmode="numeric" pattern="[0-9]*">';
					echo '<button type="button" class="ddm-apa-qty-btn ddm-apa-qty-btn--plus" data-qty-step="1" aria-label="' . esc_attr__( 'Increase quantity', 'devsroom-dropdown-menu' ) . '">';
					echo '<span class="ddm-apa-qty-btn-icon" aria-hidden="true">' . $plus_icon_markup . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '</button>';
					echo '</div>';
					echo '</div>';

					if ( $show_quantity_label && '' !== $quantity_label && 'right' === $quantity_label_pos ) {
						echo '<label class="ddm-apa-qty-label" for="' . esc_attr( $instance_id . '-quantity' ) . '">' . esc_html( $quantity_label ) . '</label>';
					}

					echo '<div class="ddm-apa-notice advanced-qty-notice" aria-live="polite" style="display:none;">' . esc_html( $max_notice_text ) . '</div>';
					echo '</div>';
				} else {
					echo '<input type="hidden" name="quantity" value="1">';
				}

				echo '<input type="hidden" name="product_id" value="' . esc_attr( (string) $product->get_id() ) . '">';
				echo '<button type="submit" name="add-to-cart" value="' . esc_attr( (string) $product->get_id() ) . '" class="' . esc_attr( $add_to_cart_button_class ) . '"' . $button_disabled_attr . '>';
				echo esc_html( $add_to_cart_text );
				echo '</button>';
				echo '</form>';
			} else {
				$this->render_native_add_to_cart( $product );
			}
		}

		echo '</div>';

		if ( $show_custom_button ) {
			echo '<button type="button" class="' . esc_attr( $custom_button_class ) . '">' . esc_html( $custom_button_text ) . '</button>';
		}

		echo '</div>';
		echo '</div>';

		$this->render_inline_styles(
			$instance_id,
			array(
				'custom_bg'       => $custom_default_bg,
				'custom_text'     => $custom_default_color,
				'has_custom_bg'   => ! empty( $custom_button_bg ),
			)
		);
		$this->render_inline_script( $instance_id );
	}

	/**
	 * Outputs per-instance default styling for quantity stepper UI.
	 *
	 * @param string $instance_id Widget instance ID.
	 * @param array  $style_args  Runtime style defaults.
	 * @return void
	 */
	private function render_inline_styles( $instance_id, array $style_args = array() ) {
		$scoped_id = ':where(#' . $instance_id . ')';
		$custom_bg = $style_args['custom_bg'] ?? '#25D366';
		$custom_tx = $style_args['custom_text'] ?? '#ffffff';
		$has_bg    = ! empty( $style_args['has_custom_bg'] );

		echo '<style id="' . esc_attr( $instance_id . '-style' ) . '">';
		echo $scoped_id . '{--ddm-apa-qty-width:190px;--ddm-apa-qty-label-gap:10px;--ddm-apa-qty-inner-gap:0px;--ddm-apa-icon-size:18px;--ddm-apa-button-gap:0px;}';
		echo $scoped_id . ' .ddm-apa-simple-cart{display:flex;align-items:center;flex-wrap:wrap;gap:var(--ddm-apa-button-gap);}';
		echo $scoped_id . ' .ddm-apa-qty-wrap{display:grid;align-items:center;column-gap:var(--ddm-apa-qty-label-gap);row-gap:var(--ddm-apa-qty-label-gap);width:100%;}';
		echo $scoped_id . ' .ddm-apa-qty-wrap--label-left{grid-template-columns:auto minmax(0,1fr);}';
		echo $scoped_id . ' .ddm-apa-qty-wrap--label-right{grid-template-columns:minmax(0,1fr) auto;}';
		echo $scoped_id . ' .ddm-apa-qty-wrap--label-top{grid-template-columns:minmax(0,1fr);}';
		echo $scoped_id . ' .ddm-apa-qty-wrap--no-label{grid-template-columns:minmax(0,1fr);}';
		echo $scoped_id . ' .ddm-apa-qty-wrap .advanced-qty-notice{grid-column:1/-1;}';
		echo $scoped_id . ' .ddm-apa-qty-field{display:block;width:var(--ddm-apa-qty-width);max-width:100%;min-height:42px;overflow:hidden;border:1px solid #ced4dc;border-radius:0;background-color:#ffffff;}';
		echo $scoped_id . ' .ddm-apa-qty-field-inner{display:flex;align-items:center;justify-content:space-between;gap:var(--ddm-apa-qty-inner-gap);min-height:42px;}';
		echo $scoped_id . ' .ddm-apa-qty-btn{width:48px;min-height:42px;border:1px solid transparent;line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#9ca3af;background:transparent;transition:color 180ms ease,background-color 180ms ease,border-color 180ms ease;}';
		echo $scoped_id . ' .ddm-apa-qty-btn:focus-visible{outline:none;}';
		echo $scoped_id . ' .ddm-apa-qty-btn .ddm-apa-qty-btn-icon,' . $scoped_id . ' .ddm-apa-qty-btn .ddm-apa-qty-btn-icon i,' . $scoped_id . ' .ddm-apa-qty-btn .ddm-apa-qty-btn-icon svg{font-size:var(--ddm-apa-icon-size);width:var(--ddm-apa-icon-size);height:var(--ddm-apa-icon-size);line-height:1;font-weight:400;}';
		echo $scoped_id . ' .ddm-apa-qty-input{flex:1 1 auto;min-width:0;height:42px;border:0;text-align:center;appearance:textfield;-moz-appearance:textfield;padding:0 6px;background:transparent;color:#5f748b;font-size:22px;line-height:1.2;font-weight:500;}';
		echo $scoped_id . ' .ddm-apa-qty-input::-webkit-outer-spin-button,' . $scoped_id . ' .ddm-apa-qty-input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0;}';
		echo $scoped_id . ' .advanced-qty-notice{margin-top:8px;padding:8px 12px;font-size:13px;line-height:1.4;color:#991b1b;background:#fef2f2;border:1px solid #fecaca;}';
		if ( ! $has_bg ) {
			echo $scoped_id . ' .ddm-apa-custom-action-btn{background-color:' . esc_attr( $custom_bg ) . ';color:' . esc_attr( $custom_tx ) . ';}';
		}
		echo $scoped_id . ' .ddm-apa__notice{padding:12px;border:1px dashed #d1d5db;color:#374151;font-size:13px;}';
		echo '</style>';
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
		echo 'function init(){';
		echo 'var root=document.getElementById(' . wp_json_encode( $instance_id ) . ');';
		echo 'if(!root||root.dataset.ddmApaInit==="yes"){return;}';
		echo 'root.dataset.ddmApaInit="yes";';
		echo 'var container=root.closest(".elementor-widget-devsroom_advanced_product_actions")||root;';
		echo 'var customButton=root.querySelector(".ddm-apa-custom-action-btn");';
		echo 'var qtyButtons=root.querySelectorAll(".ddm-apa-qty-btn");';
		echo 'var noticeBox=root.querySelector(".advanced-qty-notice");';
		echo 'var qtyInput=root.querySelector("input.qty[name=\\"quantity\\"],input[name=\\"quantity\\"]");';
		echo 'var addToCartButtons=root.querySelectorAll(".ddm-apa-cart-area .single_add_to_cart_button");';
		echo 'var actionType=(root.dataset.actionType||"whatsapp").trim();';
		echo 'var whatsappPhone=(root.dataset.whatsappPhone||"").trim();';
		echo 'var messengerPageId=(root.dataset.messengerPageId||"").trim();';
		echo 'var messageTemplate=root.dataset.messageTemplate||"";';
		echo 'var fallbackName=root.dataset.fallbackName||"";';
		echo 'var fallbackPrice=root.dataset.fallbackPrice||"";';
		echo 'var fallbackUrl=root.dataset.fallbackUrl||window.location.href;';
		echo 'var showAddToCart=root.dataset.showAddToCart==="yes";';
		echo 'var addToCartText=(root.dataset.addToCartText||"").trim();';
		echo 'var addCartRedirect=(root.dataset.addCartRedirect||"").trim();';
		echo 'var addCartAnimation=(root.dataset.addCartAnimation||"").trim();';
		echo 'var maxLimitEnabled=root.dataset.enableMaxLimit==="yes";';
		echo 'var minQty=parseInt(root.dataset.minQty||"1",10);';
		echo 'var maxQty=parseInt(root.dataset.maxLimit||root.dataset.maxQty||"0",10);';
		echo 'var inputMax=parseInt((qtyInput&&qtyInput.dataset.maxLimit)||"",10);';
		echo 'var maxLimit=Number.isFinite(inputMax)&&inputMax>0?inputMax:(Number.isFinite(maxQty)&&maxQty>0?maxQty:null);';
		echo 'var maxNoticeTemplate=root.dataset.maxNoticeTemplate||"";';
		echo 'var maxNoticeFallback=root.dataset.maxNoticeText||("Maximum quantity allowed is "+(maxLimit||"")+".");';
		echo 'var missingActionAlert=root.dataset.alertActionMissing||"Please configure a phone number or Messenger page ID.";';
		echo 'var redirectStorageKey="ddmApaRedirect:"+root.id;';
		echo 'var redirectTTL=60000;';
		echo 'if(!Number.isFinite(minQty)||minQty<1){minQty=1;}';
		echo 'Array.prototype.forEach.call(addToCartButtons,function(button){';
		echo 'if(!addToCartText){return;}';
		echo 'button.classList.add("ddm-apa-add-to-cart");';
		echo 'if(button.tagName==="INPUT"){button.value=addToCartText;}else{button.textContent=addToCartText;}';
		echo 'if(addCartAnimation){button.classList.add("elementor-animation-"+addCartAnimation);}';
		echo '});';
		echo 'function hasAddSuccessSignal(){';
		echo 'if(window.location&&window.location.search){';
		echo 'var params=new URLSearchParams(window.location.search);';
		echo 'if(params.has("add-to-cart")||params.has("added-to-cart")){return true;}';
		echo '}';
		echo 'var notices=document.querySelectorAll(".woocommerce-message,.woocommerce-notices-wrapper .woocommerce-message");';
		echo 'return notices.length>0;';
		echo '}';
		echo 'function setRedirectPending(){';
		echo 'if(!addCartRedirect){return;}';
		echo 'try{sessionStorage.setItem(redirectStorageKey,JSON.stringify({url:addCartRedirect,time:Date.now()}));}catch(e){}';
		echo '}';
		echo 'function clearRedirectPending(){';
		echo 'try{sessionStorage.removeItem(redirectStorageKey);}catch(e){}';
		echo '}';
		echo 'function maybeRedirectFromPending(){';
		echo 'if(!addCartRedirect){return;}';
		echo 'try{';
		echo 'var raw=sessionStorage.getItem(redirectStorageKey);';
		echo 'if(!raw){return;}';
		echo 'var data=JSON.parse(raw)||{};';
		echo 'if(!data.time||Date.now()-Number(data.time)>redirectTTL){clearRedirectPending();return;}';
		echo 'if(hasAddSuccessSignal()){clearRedirectPending();window.location.assign(addCartRedirect);}';
		echo '}catch(e){clearRedirectPending();}';
		echo '}';
		echo 'maybeRedirectFromPending();';
		echo 'function getMaxNoticeMessage(){';
		echo 'var maxValue=maxLimit===null?"":String(maxLimit);';
		echo 'var message=(maxNoticeTemplate||"").split("{max}").join(maxValue);';
		echo 'if(!message){message=maxNoticeFallback||"";}';
		echo 'return message;';
		echo '}';
		echo 'function setNotice(show,message){';
		echo 'if(!noticeBox){return;}';
		echo 'if(show){noticeBox.textContent=message||getMaxNoticeMessage();noticeBox.style.display="block";return;}';
		echo 'noticeBox.style.display="none";';
		echo '}';
		echo 'function getInputValue(input){';
		echo 'var value=parseFloat((input.value||"").trim());';
		echo 'return Number.isFinite(value)?value:minQty;';
		echo '}';
		echo 'function applyInputValue(input,value){';
		echo 'input.value=String(value);';
		echo 'input.dispatchEvent(new Event("change",{bubbles:true}));';
		echo '}';
		echo 'function validateManualInput(input){';
		echo 'var value=getInputValue(input);';
		echo 'if(value<minQty){applyInputValue(input,minQty);setNotice(false,"");return false;}';
		echo 'if(maxLimitEnabled&&maxLimit!==null&&value>maxLimit){applyInputValue(input,maxLimit);setNotice(true,getMaxNoticeMessage());return false;}';
		echo 'setNotice(false,"");';
		echo 'return true;';
		echo '}';
		echo 'function stepQuantity(button){';
		echo 'var field=button.closest(".ddm-apa-qty-field");';
		echo 'if(!field){return;}';
		echo 'var input=field.querySelector("input.qty,input[name=\\"quantity\\"]");';
		echo 'if(!input){return;}';
		echo 'var step=parseInt(button.dataset.qtyStep||"0",10);';
		echo 'if(!Number.isFinite(step)||0===step){return;}';
		echo 'var current=getInputValue(input);';
		echo 'if(step>0){';
		echo 'var increased=current+step;';
		echo 'if(maxLimitEnabled&&maxLimit!==null&&increased>maxLimit){';
		echo 'applyInputValue(input,maxLimit);';
		echo 'setNotice(true,getMaxNoticeMessage());';
		echo 'return;';
		echo '}';
		echo 'applyInputValue(input,increased);';
		echo 'setNotice(false,"");';
		echo 'return;';
		echo '}';
		echo 'var decreased=current+step;';
		echo 'if(decreased<minQty){decreased=minQty;}';
		echo 'applyInputValue(input,decreased);';
		echo 'if(!maxLimitEnabled||maxLimit===null||decreased<=maxLimit){setNotice(false,"");}';
		echo '}';
		echo 'function readFirstText(selectors,fallback){';
		echo 'for(var i=0;i<selectors.length;i++){';
		echo 'var localNode=container.querySelector(selectors[i]);';
		echo 'if(localNode){';
		echo 'var localText=(localNode.textContent||localNode.innerText||"").replace(/\\s+/g," ").trim();';
		echo 'if(localText){return localText;}';
		echo '}';
		echo 'var globalNode=document.querySelector(selectors[i]);';
		echo 'if(globalNode){';
		echo 'var globalText=(globalNode.textContent||globalNode.innerText||"").replace(/\\s+/g," ").trim();';
		echo 'if(globalText){return globalText;}';
		echo '}';
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
		echo 'Array.prototype.forEach.call(qtyButtons,function(button){';
		echo 'button.addEventListener("click",function(event){event.preventDefault();stepQuantity(button);});';
		echo '});';
		echo 'var forms=root.querySelectorAll("form");';
		echo 'Array.prototype.forEach.call(forms,function(form){';
		echo 'form.addEventListener("submit",function(event){';
		echo 'var formInput=form.querySelector("input.qty,input[name=\\"quantity\\"]");';
		echo 'if(formInput&&!validateManualInput(formInput)){event.preventDefault();event.stopPropagation();return;}';
		echo 'if(showAddToCart&&addCartRedirect){setRedirectPending();}';
		echo '});';
		echo '});';
		echo 'if(qtyInput){';
		echo 'qtyInput.addEventListener("input",function(){validateManualInput(qtyInput);});';
		echo 'qtyInput.addEventListener("change",function(){validateManualInput(qtyInput);});';
		echo '}';
		echo 'if(showAddToCart&&addCartRedirect&&window.jQuery&&window.jQuery(document.body).on){';
		echo 'window.jQuery(document.body).on("added_to_cart.ddmApa"+root.id,function(event,fragments,cartHash,$button){';
		echo 'if($button&&$button.length&&$button.closest("#"+root.id).length===0){return;}';
		echo 'clearRedirectPending();';
		echo 'window.location.assign(addCartRedirect);';
		echo '});';
		echo '}';
		echo '}';
		echo 'if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",init);}else{init();}';
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
	 * Returns icon markup from Elementor icon control.
	 *
	 * @param mixed  $icon_value    Icon control value.
	 * @param string $text_fallback Text fallback when icon is empty.
	 * @return string
	 */
	private function get_icon_markup( $icon_value, $text_fallback = '' ) {
		$icon_html = '';

		if ( is_array( $icon_value ) ) {
			$icon_setting = $icon_value;
			$raw_value    = $icon_setting['value'] ?? '';
			$has_value    = ( is_array( $raw_value ) && ! empty( $raw_value ) ) || ( is_string( $raw_value ) && '' !== trim( $raw_value ) );

			if ( $has_value ) {
				ob_start();
				Icons_Manager::render_icon(
					$icon_setting,
					array(
						'aria-hidden' => 'true',
					)
				);
				$icon_html = trim( (string) ob_get_clean() );
			}
		}

		if ( '' === $icon_html ) {
			$icon_html = esc_html( $text_fallback );
		}

		return $icon_html;
	}

	/**
	 * Sanitizes quantity label position value.
	 *
	 * @param string $position Label position setting.
	 * @return string
	 */
	private function sanitize_quantity_label_position( $position ) {
		return in_array( $position, array( 'left', 'top', 'right' ), true ) ? $position : 'left';
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
	 * Sanitizes Elementor hover animation setting.
	 *
	 * @param string $animation Raw animation value.
	 * @return string
	 */
	private function sanitize_hover_animation( $animation ) {
		$animation = strtolower( trim( (string) $animation ) );
		if ( '' === $animation || 'none' === $animation ) {
			return '';
		}

		$sanitized = preg_replace( '/[^a-z0-9_-]/', '', $animation );
		return is_string( $sanitized ) ? $sanitized : '';
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
