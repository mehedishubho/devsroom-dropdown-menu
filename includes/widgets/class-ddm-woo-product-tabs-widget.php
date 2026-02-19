<?php

/**
 * Elementor widget: Woo Product Tabs.
 *
 * @package DevsroomDropdownMenu
 */

namespace Devsroom\DropdownMenu\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

/**
 * WooCommerce product tabs widget with custom and fallback tabs.
 */
class DDM_Woo_Product_Tabs_Widget extends Widget_Base
{

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name()
	{
		return 'devsroom_woo_product_tabs';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title()
	{
		return __('Devsroom Product Tabs', 'devsroom-dropdown-menu');
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon()
	{
		return 'eicon-tabs';
	}

	/**
	 * Widget categories.
	 *
	 * @return string[]
	 */
	public function get_categories()
	{
		return array('general');
	}

	/**
	 * Widget style dependencies.
	 *
	 * @return string[]
	 */
	public function get_style_depends()
	{
		return array('ddm-woo-product-tabs');
	}

	/**
	 * Widget script dependencies.
	 *
	 * @return string[]
	 */
	public function get_script_depends()
	{
		return array('ddm-woo-product-tabs');
	}

	/**
	 * Registers widget controls.
	 *
	 * @return void
	 */
	protected function register_controls()
	{
		$this->register_tabs_items_controls();
		$this->register_tabs_panel_layout_controls();
		$this->register_tabs_content_layout_controls();
		$this->register_panel_style_controls();
		$this->register_tab_item_style_controls();
		$this->register_content_style_controls();
	}

	/**
	 * Registers tab items controls.
	 *
	 * @return void
	 */
	private function register_tabs_items_controls()
	{
		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			array(
				'label'       => __('Tab Title', 'devsroom-dropdown-menu'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __('Tab Title', 'devsroom-dropdown-menu'),
			)
		);

		$repeater->add_control(
			'tab_icon',
			array(
				'label' => __('Icon', 'devsroom-dropdown-menu'),
				'type'  => Controls_Manager::ICONS,
			)
		);

		$repeater->add_control(
			'tab_content',
			array(
				'label'   => __('Tab Content', 'devsroom-dropdown-menu'),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => __('Add your tab content here.', 'devsroom-dropdown-menu'),
			)
		);

		$this->start_controls_section(
			'section_tabs_items',
			array(
				'label' => __('Tabs Items', 'devsroom-dropdown-menu'),
			)
		);

		$this->add_control(
			'tab_source',
			array(
				'label'   => __('Tab Source', 'devsroom-dropdown-menu'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'woocommerce_default' => __('WooCommerce Default', 'devsroom-dropdown-menu'),
					'custom'              => __('Custom', 'devsroom-dropdown-menu'),
				),
				'default' => 'custom',
			)
		);

		$this->add_control(
			'wc_tab_description_enable',
			array(
				'label'        => __('Description Tab', 'devsroom-dropdown-menu'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'devsroom-dropdown-menu'),
				'label_off'    => __('Hide', 'devsroom-dropdown-menu'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'tab_source' => 'woocommerce_default',
				),
			)
		);

		$this->add_control(
			'wc_tab_additional_info_enable',
			array(
				'label'        => __('Additional Info Tab', 'devsroom-dropdown-menu'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'devsroom-dropdown-menu'),
				'label_off'    => __('Hide', 'devsroom-dropdown-menu'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'tab_source' => 'woocommerce_default',
				),
			)
		);

		$this->add_control(
			'wc_tab_reviews_enable',
			array(
				'label'        => __('Reviews Tab', 'devsroom-dropdown-menu'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'devsroom-dropdown-menu'),
				'label_off'    => __('Hide', 'devsroom-dropdown-menu'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'tab_source' => 'woocommerce_default',
				),
			)
		);

		$this->add_control(
			'tabs_items',
			array(
				'label'       => __('Tabs', 'devsroom-dropdown-menu'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'tab_title'   => __('Tab Title', 'devsroom-dropdown-menu'),
						'tab_content' => __('Add your tab content here.', 'devsroom-dropdown-menu'),
					),
				),
				'title_field' => '{{{ tab_title }}}',
				'condition'   => array(
					'tab_source' => 'custom',
				),
			)
		);

		$this->add_control(
			'enable_woo_fallback',
			array(
				'label'        => __('Fallback To WooCommerce Tabs If Custom Is Empty', 'devsroom-dropdown-menu'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'devsroom-dropdown-menu'),
				'label_off'    => __('No', 'devsroom-dropdown-menu'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'tab_source' => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers panel layout controls.
	 *
	 * @return void
	 */
	private function register_tabs_panel_layout_controls()
	{
		$this->start_controls_section(
			'section_tabs_panel_layout',
			array(
				'label' => __('Tabs Panel Layout', 'devsroom-dropdown-menu'),
			)
		);

		$this->add_control(
			'tabs_panel_width_mode',
			array(
				'label'   => __('Width Mode', 'devsroom-dropdown-menu'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'full_width' => __('Full Width', 'devsroom-dropdown-menu'),
					'container'  => __('Container', 'devsroom-dropdown-menu'),
					'custom'     => __('Custom', 'devsroom-dropdown-menu'),
				),
				'default' => 'full_width',
			)
		);

		$this->add_control(
			'tabs_panel_custom_width',
			array(
				'label'      => __('Custom Width', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', '%'),
				'range'      => array(
					'px' => array(
						'min' => 300,
						'max' => 1920,
					),
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'condition'  => array(
					'tabs_panel_width_mode' => 'custom',
				),
			)
		);

		$this->add_control(
			'tabs_panel_sticky_enable',
			array(
				'label'        => __('Enable Sticky', 'devsroom-dropdown-menu'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'devsroom-dropdown-menu'),
				'label_off'    => __('No', 'devsroom-dropdown-menu'),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'tabs_panel_sticky_position',
			array(
				'label'     => __('Sticky Position', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'top'    => __('Top', 'devsroom-dropdown-menu'),
					'bottom' => __('Bottom', 'devsroom-dropdown-menu'),
				),
				'default'   => 'top',
				'condition' => array(
					'tabs_panel_sticky_enable' => 'yes',
				),
			)
		);

		$this->add_control(
			'tabs_panel_sticky_offset',
			array(
				'label'      => __('Sticky Offset', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'condition'  => array(
					'tabs_panel_sticky_enable' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers content layout controls.
	 *
	 * @return void
	 */
	private function register_tabs_content_layout_controls()
	{
		$this->start_controls_section(
			'section_tabs_content_layout',
			array(
				'label' => __('Tabs Content Layout', 'devsroom-dropdown-menu'),
			)
		);

		$this->add_control(
			'tabs_content_width_mode',
			array(
				'label'   => __('Width Mode', 'devsroom-dropdown-menu'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'full_width' => __('Full Width', 'devsroom-dropdown-menu'),
					'container'  => __('Container', 'devsroom-dropdown-menu'),
					'custom'     => __('Custom', 'devsroom-dropdown-menu'),
				),
				'default' => 'full_width',
			)
		);

		$this->add_control(
			'tabs_content_custom_width',
			array(
				'label'      => __('Custom Width', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', '%'),
				'range'      => array(
					'px' => array(
						'min' => 300,
						'max' => 1920,
					),
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'condition'  => array(
					'tabs_content_width_mode' => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers panel container style controls.
	 *
	 * @return void
	 */
	private function register_panel_style_controls()
	{
		$this->start_controls_section(
			'section_style_panel_container',
			array(
				'label' => __('Tabs Navigation Container', 'devsroom-dropdown-menu'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'panel_bg_color',
			array(
				'label'     => __('Background Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__panel-inner' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'panel_sticky_bg_color',
			array(
				'label'     => __('Sticky Background Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__panel-wrap.panel-sticky.is-sticky .ddm-woo-product-tabs__panel-inner' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'panel_border',
				'selector' => '{{WRAPPER}} .ddm-woo-product-tabs__panel-inner',
			)
		);

		$this->add_responsive_control(
			'panel_border_radius',
			array(
				'label'      => __('Border Radius', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__panel-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'panel_shadow',
				'selector' => '{{WRAPPER}} .ddm-woo-product-tabs__panel-inner',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'panel_sticky_shadow',
				'label'    => __('Sticky Box Shadow', 'devsroom-dropdown-menu'),
				'selector' => '{{WRAPPER}} .ddm-woo-product-tabs__panel-wrap.panel-sticky.is-sticky .ddm-woo-product-tabs__panel-inner',
			)
		);

		$this->add_responsive_control(
			'panel_padding',
			array(
				'label'      => __('Padding', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__panel-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_margin',
			array(
				'label'      => __('Margin', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__panel-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers tab item style controls.
	 * CRITICAL: Selectors must match the HTML structure exactly.
	 * Tab buttons are: <button class="ddm-woo-product-tabs__tab">
	 *
	 * @return void
	 */
	private function register_tab_item_style_controls()
	{
		$this->start_controls_section(
			'section_style_tab_items',
			array(
				'label' => __('Tab Item', 'devsroom-dropdown-menu'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_item_typography',
				'selector' => '{{WRAPPER}} .ddm-woo-product-tabs__tab',
			)
		);

		// Normal State - Direct selectors for maximum specificity
		$this->add_control(
			'tab_item_text_color',
			array(
				'label'     => __('Text Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_item_bg_color',
			array(
				'label'     => __('Background Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'tab_item_border',
				'selector' => '{{WRAPPER}} .ddm-woo-product-tabs__tab',
			)
		);

		$this->add_responsive_control(
			'tab_item_padding',
			array(
				'label'      => __('Padding', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_item_gap',
			array(
				'label'      => __('Gap Between Items', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em', 'rem'),
				'range'      => array(
					'px'  => array(
						'min' => 0,
						'max' => 60,
					),
					'em'  => array(
						'min' => 0,
						'max' => 4,
					),
					'rem' => array(
						'min' => 0,
						'max' => 4,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__nav' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs('tab_item_state_tabs');

		// Hover State
		$this->start_controls_tab(
			'tab_item_state_hover',
			array(
				'label' => __('Hover', 'devsroom-dropdown-menu'),
			)
		);

		$this->add_control(
			'tab_item_hover_text_color',
			array(
				'label'     => __('Text Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-woo-product-tabs__tab:focus-visible' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_item_hover_bg_color',
			array(
				'label'     => __('Background Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .ddm-woo-product-tabs__tab:focus-visible' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_item_hover_border_color',
			array(
				'label'     => __('Border Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ddm-woo-product-tabs__tab:focus-visible' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		// Active State
		$this->start_controls_tab(
			'tab_item_state_active',
			array(
				'label' => __('Active', 'devsroom-dropdown-menu'),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_item_active_typography',
				'selector' => '{{WRAPPER}} .ddm-woo-product-tabs__tab.is-active',
			)
		);

		$this->add_control(
			'tab_item_active_text_color',
			array(
				'label'     => __('Text Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab.is-active' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_item_active_bg_color',
			array(
				'label'     => __('Background Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab.is-active' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_item_active_border_color',
			array(
				'label'     => __('Border Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab.is-active' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_item_active_border_weight',
			array(
				'label'      => __('Active Border Weight', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 12,
					),
				),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab.is-active' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Icon Styling
		$this->add_responsive_control(
			'tab_icon_size',
			array(
				'label'      => __('Icon Size', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em', 'rem'),
				'range'      => array(
					'px'  => array(
						'min' => 8,
						'max' => 80,
					),
					'em'  => array(
						'min' => 0.5,
						'max' => 4,
					),
					'rem' => array(
						'min' => 0.5,
						'max' => 4,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__icon, {{WRAPPER}} .ddm-woo-product-tabs__tab-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ddm-woo-product-tabs__icon svg, {{WRAPPER}} .ddm-woo-product-tabs__tab-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'tab_icon_color',
			array(
				'label'     => __('Icon Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab .ddm-woo-product-tabs__icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-woo-product-tabs__tab .ddm-woo-product-tabs__tab-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_icon_active_color',
			array(
				'label'     => __('Active Icon Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__tab.is-active .ddm-woo-product-tabs__icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-woo-product-tabs__tab.is-active .ddm-woo-product-tabs__tab-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_icon_gap',
			array(
				'label'      => __('Icon Spacing', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em', 'rem'),
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
					'{{WRAPPER}} .ddm-woo-product-tabs__tab' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers content panel style controls.
	 *
	 * @return void
	 */
	private function register_content_style_controls()
	{
		$this->start_controls_section(
			'section_style_content_area',
			array(
				'label' => __('Tab Content Area', 'devsroom-dropdown-menu'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'content_bg_color',
			array(
				'label'     => __('Background Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__panel' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'content_border',
				'selector' => '{{WRAPPER}} .ddm-woo-product-tabs__panel',
			)
		);

		$this->add_responsive_control(
			'content_border_radius',
			array(
				'label'      => __('Border Radius', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => __('Padding', 'devsroom-dropdown-menu'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .ddm-woo-product-tabs__panel',
			)
		);

		$this->add_control(
			'content_text_color',
			array(
				'label'     => __('Text Color', 'devsroom-dropdown-menu'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-woo-product-tabs__panel' => 'color: {{VALUE}};',
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
	protected function render()
	{
		$settings      = $this->get_settings_for_display();
		$instance_id   = 'ddm-woo-product-tabs-' . sanitize_html_class($this->get_id());
		$tab_source    = $this->sanitize_tab_source($settings['tab_source'] ?? 'custom');
		$use_fallback  = $this->is_switcher_enabled($settings['enable_woo_fallback'] ?? 'yes');
		$product       = null;
		$fallback_used = false;
		$tabs          = array();

		if ('woocommerce_default' === $tab_source) {
			$product = $this->resolve_product();
			if ($product instanceof \WC_Product) {
				$tabs = $this->build_woocommerce_tabs($product, $instance_id, $settings);
			}
		} else {
			$tabs = $this->build_custom_tabs($settings, $instance_id);
			if (empty($tabs) && $use_fallback) {
				$product = $this->resolve_product();
				if ($product instanceof \WC_Product) {
					$tabs = $this->build_woocommerce_tabs($product, $instance_id, $settings);
				}
				$fallback_used = ! empty($tabs);
			}
		}

		if (empty($tabs)) {
			if ($this->is_edit_mode()) {
				echo '<div class="ddm-woo-product-tabs__notice">';
				if ('woocommerce_default' === $tab_source) {
					echo esc_html__('No WooCommerce default tabs are available for the current product/context.', 'devsroom-dropdown-menu');
				} elseif ($use_fallback) {
					echo esc_html__('No product tabs available. Add custom tabs, or use this widget on a WooCommerce single product template.', 'devsroom-dropdown-menu');
				} else {
					echo esc_html__('No custom tabs added. Add items in "Tabs Items" or enable WooCommerce fallback.', 'devsroom-dropdown-menu');
				}
				echo '</div>';
			}
			return;
		}

		$panel_mode         = $this->sanitize_width_mode($settings['tabs_panel_width_mode'] ?? 'full_width');
		$content_mode       = $this->sanitize_width_mode($settings['tabs_content_width_mode'] ?? 'full_width');
		$panel_custom_width = 'custom' === $panel_mode ? $this->get_custom_width_css_value($settings['tabs_panel_custom_width'] ?? array()) : '';
		$content_custom     = 'custom' === $content_mode ? $this->get_custom_width_css_value($settings['tabs_content_custom_width'] ?? array()) : '';
		$panel_sticky       = $this->is_switcher_enabled($settings['tabs_panel_sticky_enable'] ?? '');
		$sticky_position    = $this->sanitize_sticky_position($settings['tabs_panel_sticky_position'] ?? 'top');
		$sticky_offset      = $this->get_sticky_offset_value($settings['tabs_panel_sticky_offset'] ?? array());

		$panel_inner_classes = array('ddm-woo-product-tabs__panel-inner');
		if ('container' === $panel_mode) {
			$panel_inner_classes[] = 'ddm-tabs-container';
		}

		$content_inner_classes = array('ddm-woo-product-tabs__content-inner');
		if ('container' === $content_mode) {
			$content_inner_classes[] = 'ddm-tabs-container';
		}

		$this->add_render_attribute(
			'root',
			array(
				'id'              => $instance_id,
				'class'           => 'ddm-woo-product-tabs',
				'data-source'     => ('woocommerce_default' === $tab_source || $fallback_used) ? 'woocommerce' : 'custom',
				'data-tab-source' => $tab_source,
			)
		);

		$panel_class_suffix   = $this->get_layout_class_suffix($panel_mode);
		$content_class_suffix = $this->get_layout_class_suffix($content_mode);

		$this->add_render_attribute(
			'panel_wrap',
			array(
				'class' => array(
					'ddm-woo-product-tabs__panel-wrap',
					'panel-' . $panel_class_suffix,
				),
				'data-sticky-enabled'  => $panel_sticky ? 'yes' : 'no',
				'data-sticky-position' => $sticky_position,
				'data-sticky-offset'   => (string) $sticky_offset,
			)
		);

		if ($panel_sticky) {
			$this->add_render_attribute('panel_wrap', 'class', 'panel-sticky');
			$this->add_render_attribute('panel_wrap', 'class', 'panel-sticky-' . $sticky_position);
		}

		$this->add_render_attribute(
			'panel_inner',
			array(
				'class' => $panel_inner_classes,
			)
		);

		if ('' !== $panel_custom_width) {
			$this->add_render_attribute(
				'panel_inner',
				'style',
				'width:' . $panel_custom_width . ';'
			);
		}

		$this->add_render_attribute(
			'content_wrap',
			array(
				'class' => array(
					'ddm-woo-product-tabs__content-wrap',
					'content-' . $content_class_suffix,
				),
			)
		);

		$this->add_render_attribute(
			'content_inner',
			array(
				'class' => $content_inner_classes,
			)
		);

		if ('' !== $content_custom) {
			$this->add_render_attribute(
				'content_inner',
				'style',
				'width:' . $content_custom . ';'
			);
		}

		echo '<div ' . $this->get_render_attribute_string('root') . '>';
		echo '<div ' . $this->get_render_attribute_string('panel_wrap') . '>';
		echo '<div ' . $this->get_render_attribute_string('panel_inner') . '>';
		echo '<div class="ddm-woo-product-tabs__nav" role="tablist" aria-label="' . esc_attr__('Product tabs', 'devsroom-dropdown-menu') . '">';

		foreach ($tabs as $index => $tab) {
			$is_active = 0 === $index;
			$tab_class = $is_active ? 'ddm-woo-product-tabs__tab is-active' : 'ddm-woo-product-tabs__tab';

			echo '<button type="button" class="' . esc_attr($tab_class) . '" id="' . esc_attr($tab['button_id']) . '" role="tab" aria-controls="' . esc_attr($tab['panel_id']) . '" data-tab-target="' . esc_attr($tab['panel_id']) . '" aria-selected="' . esc_attr($is_active ? 'true' : 'false') . '" tabindex="' . esc_attr($is_active ? '0' : '-1') . '">';
			echo $this->render_tab_icon($tab['icon'], $tab['icon_legacy'] ?? '', 'ddm-woo-product-tabs__tab-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<span class="ddm-woo-product-tabs__tab-label">' . esc_html($tab['title']) . '</span>';
			echo '</button>';
		}

		echo '</div>';
		echo '</div>';
		echo '</div>';

		echo '<div ' . $this->get_render_attribute_string('content_wrap') . '>';
		echo '<div ' . $this->get_render_attribute_string('content_inner') . '>';
		echo '<div class="ddm-woo-product-tabs__panels">';

		foreach ($tabs as $index => $tab) {
			$is_active  = 0 === $index;
			$panel_class = $is_active ? 'ddm-woo-product-tabs__panel is-active' : 'ddm-woo-product-tabs__panel';

			echo '<div class="' . esc_attr($panel_class) . '" id="' . esc_attr($tab['panel_id']) . '" role="tabpanel" aria-labelledby="' . esc_attr($tab['button_id']) . '" tabindex="0"';
			if (! $is_active) {
				echo ' hidden';
			}
			echo '>';

			if (! empty($tab['is_woocommerce'])) {
				echo $tab['content_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				echo wp_kses_post($tab['content_html']);
			}

			echo '</div>';
		}

		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Builds custom tabs from repeater settings.
	 *
	 * @param array  $settings    Widget settings.
	 * @param string $instance_id Widget instance ID.
	 * @return array<int,array<string,mixed>>
	 */
	private function build_custom_tabs($settings, $instance_id)
	{
		$items = isset($settings['tabs_items']) && is_array($settings['tabs_items']) ? $settings['tabs_items'] : array();
		$tabs  = array();

		foreach ($items as $index => $item) {
			$title        = sanitize_text_field($item['tab_title'] ?? '');
			$parsed_html  = $this->parse_text_editor((string) ($item['tab_content'] ?? ''));
			$content_html = wp_kses_post($parsed_html);
			$plain_text   = trim(wp_strip_all_tags($content_html));

			if ('' === $title && '' === $plain_text) {
				continue;
			}

			if ('' === $title) {
				/* translators: %d: Tab number. */
				$title = sprintf(__('Tab %d', 'devsroom-dropdown-menu'), $index + 1);
			}

			$suffix = $this->build_tab_suffix($title, $index);
			$tabs[] = array(
				'title'          => $title,
				'button_id'      => sanitize_html_class($instance_id . '-tab-' . $suffix),
				'panel_id'       => sanitize_html_class($instance_id . '-panel-' . $suffix),
				'content_html'   => $content_html,
				'icon'           => $item['tab_icon'] ?? array(),
				'icon_legacy'    => $item['tab_icon_classic'] ?? '',
				'is_woocommerce' => false,
			);
		}

		return $tabs;
	}

	/**
	 * Builds WooCommerce tabs from native callbacks with settings filtering.
	 * CRITICAL: Now fetches ALL registered tabs using apply_filters('woocommerce_product_tabs', array())
	 * This ensures compatibility with third-party tab plugins.
	 *
	 * @param \WC_Product $product     Product object.
	 * @param string      $instance_id Widget instance ID.
	 * @param array       $settings    Widget settings.
	 * @return array<int,array<string,mixed>>
	 */
	private function build_woocommerce_tabs(\WC_Product $product, $instance_id, $settings)
	{
		$enabled_keys = $this->get_enabled_wc_tab_keys_from_settings($settings);
		$tabs_data    = $this->get_woocommerce_tabs_data($product);
		$tabs_data    = $this->apply_wc_tab_filters($tabs_data, $enabled_keys);
		$tabs         = array();
		$index        = 0;

		foreach ($tabs_data as $tab_key => $tab) {
			if (empty($tab) || ! is_array($tab)) {
				continue;
			}

			if (empty($tab['callback']) || ! is_callable($tab['callback'])) {
				continue;
			}

			$title = isset($tab['title']) ? sanitize_text_field(wp_strip_all_tags((string) $tab['title'])) : '';
			if ('' === $title) {
				$title = ucwords(str_replace('_', ' ', $tab_key));
			}

			$content_html = $this->get_woocommerce_tab_content($product, $tab_key, $tab);
			if ('' === trim($content_html)) {
				continue;
			}

			$suffix = $this->build_tab_suffix($tab_key, $index);
			$tabs[] = array(
				'title'          => $title,
				'button_id'      => sanitize_html_class($instance_id . '-tab-' . $suffix),
				'panel_id'       => sanitize_html_class($instance_id . '-panel-' . $suffix),
				'content_html'   => $content_html,
				'icon'           => array(),
				'icon_legacy'    => '',
				'is_woocommerce' => true,
			);

			$index++;
		}

		return $tabs;
	}

	/**
	 * Returns enabled default WooCommerce tab keys from control settings.
	 *
	 * @param array $settings Widget settings.
	 * @return string[]
	 */
	private function get_enabled_wc_tab_keys_from_settings($settings)
	{
		$enabled = array();

		$description_enabled = isset($settings['wc_tab_description_enable']) ? $this->is_switcher_enabled($settings['wc_tab_description_enable']) : true;
		$additional_enabled  = isset($settings['wc_tab_additional_info_enable']) ? $this->is_switcher_enabled($settings['wc_tab_additional_info_enable']) : true;
		$reviews_enabled     = isset($settings['wc_tab_reviews_enable']) ? $this->is_switcher_enabled($settings['wc_tab_reviews_enable']) : true;

		if ($description_enabled) {
			$enabled[] = 'description';
		}

		if ($additional_enabled) {
			$enabled[] = 'additional_information';
		}

		if ($reviews_enabled) {
			$enabled[] = 'reviews';
		}

		return $enabled;
	}

	/**
	 * Filters WooCommerce tab definitions by enabled keys.
	 * If enabled_keys is empty (all tabs enabled), return all tabs.
	 *
	 * @param array $tabs_data     WooCommerce tab definitions.
	 * @param array $enabled_keys  Enabled tab keys.
	 * @return array<string,array<string,mixed>>
	 */
	private function apply_wc_tab_filters($tabs_data, $enabled_keys)
	{
		if (! is_array($tabs_data)) {
			return array();
		}

		// If enabled_keys is empty, include all tabs (for third-party plugin tabs)
		if (empty($enabled_keys)) {
			return $tabs_data;
		}

		$filtered = array();

		// Include enabled default tabs AND any third-party tabs
		foreach ($tabs_data as $tab_key => $tab_data) {
			if (in_array($tab_key, $enabled_keys, true)) {
				// This is a default tab that's enabled
				$filtered[$tab_key] = $tab_data;
			} elseif (! in_array($tab_key, array('description', 'additional_information', 'reviews'), true)) {
				// This is a third-party tab, include it automatically
				$filtered[$tab_key] = $tab_data;
			}
		}

		return $filtered;
	}

	/**
	 * Resolves fallback tab definitions from WooCommerce filters.
	 * Uses apply_filters('woocommerce_product_tabs', array()) to fetch ALL registered tabs.
	 *
	 * @param \WC_Product $product Product object.
	 * @return array<string,array<string,mixed>>
	 */
	private function get_woocommerce_tabs_data(\WC_Product $product)
	{
		if (! function_exists('apply_filters')) {
			return array();
		}

		$previous_product   = $GLOBALS['product'] ?? null;
		$GLOBALS['product'] = $product;

		// CRITICAL: Use apply_filters to fetch ALL registered tabs including third-party tabs
		$tabs = apply_filters('woocommerce_product_tabs', array());

		if (empty($tabs) && function_exists('woocommerce_default_product_tabs')) {
			$tabs = woocommerce_default_product_tabs(array());
		}

		if (null !== $previous_product) {
			$GLOBALS['product'] = $previous_product;
		} else {
			unset($GLOBALS['product']);
		}

		if (! is_array($tabs)) {
			return array();
		}

		if (function_exists('wc_sort_product_tabs')) {
			uasort($tabs, 'wc_sort_product_tabs');
		} else {
			uasort(
				$tabs,
				static function ($tab_a, $tab_b) {
					$priority_a = isset($tab_a['priority']) ? (int) $tab_a['priority'] : 10;
					$priority_b = isset($tab_b['priority']) ? (int) $tab_b['priority'] : 10;
					return $priority_a <=> $priority_b;
				}
			);
		}

		return $tabs;
	}

	/**
	 * Captures WooCommerce tab callback output.
	 *
	 * @param \WC_Product $product Product object.
	 * @param string      $tab_key Tab key.
	 * @param array       $tab     Tab data.
	 * @return string
	 */
	private function get_woocommerce_tab_content(\WC_Product $product, $tab_key, $tab)
	{
		$previous_product   = $GLOBALS['product'] ?? null;
		$GLOBALS['product'] = $product;

		ob_start();
		call_user_func($tab['callback'], $tab_key, $tab);
		$content = (string) ob_get_clean();

		if (null !== $previous_product) {
			$GLOBALS['product'] = $previous_product;
		} else {
			unset($GLOBALS['product']);
		}

		return $content;
	}

	/**
	 * Sanitizes layout width mode values.
	 *
	 * @param string $mode Raw mode.
	 * @return string
	 */
	private function sanitize_width_mode($mode)
	{
		$mode = is_string($mode) ? trim($mode) : 'full_width';
		return in_array($mode, array('full_width', 'container', 'custom'), true) ? $mode : 'full_width';
	}

	/**
	 * Sanitizes tab source mode.
	 *
	 * @param string $source Raw source value.
	 * @return string
	 */
	private function sanitize_tab_source($source)
	{
		$source = is_string($source) ? trim($source) : 'custom';
		return in_array($source, array('woocommerce_default', 'custom'), true) ? $source : 'custom';
	}

	/**
	 * Maps layout mode to the required wrapper class suffix.
	 *
	 * @param string $mode Sanitized mode.
	 * @return string
	 */
	private function get_layout_class_suffix($mode)
	{
		if ('full_width' === $mode) {
			return 'full';
		}

		return $mode;
	}

	/**
	 * Sanitizes sticky position setting.
	 *
	 * @param string $position Sticky position.
	 * @return string
	 */
	private function sanitize_sticky_position($position)
	{
		$position = is_string($position) ? trim($position) : 'top';
		return in_array($position, array('top', 'bottom'), true) ? $position : 'top';
	}

	/**
	 * Returns sticky offset value in pixels.
	 *
	 * @param mixed $offset_setting Sticky offset setting.
	 * @return int
	 */
	private function get_sticky_offset_value($offset_setting)
	{
		if (! is_array($offset_setting)) {
			return 0;
		}

		$size = $offset_setting['size'] ?? 0;
		if (! is_numeric($size)) {
			return 0;
		}

		$size = (int) round((float) $size);
		if ($size < 0) {
			return 0;
		}

		if ($size > 300) {
			return 300;
		}

		return $size;
	}

	/**
	 * Builds a CSS width value from a slider control value.
	 *
	 * @param mixed $slider Slider value.
	 * @return string
	 */
	private function get_custom_width_css_value($slider)
	{
		if (! is_array($slider)) {
			return '';
		}

		$size = $slider['size'] ?? '';
		$unit = $slider['unit'] ?? 'px';
		$unit = in_array($unit, array('px', '%'), true) ? $unit : 'px';

		if (! is_numeric($size)) {
			return '';
		}

		$size = (float) $size;
		if ($size <= 0) {
			return '';
		}

		return $size . $unit;
	}

	/**
	 * Builds unique tab suffix.
	 *
	 * @param string $title Tab title.
	 * @param int    $index Tab index.
	 * @return string
	 */
	private function build_tab_suffix($title, $index)
	{
		$slug = sanitize_title($title);
		if ('' === $slug) {
			$slug = 'tab';
		}

		return $slug . '-' . ((int) $index + 1);
	}

	/**
	 * Resolves the current WooCommerce product.
	 *
	 * @return \WC_Product|null
	 */
	private function resolve_product()
	{
		if (! function_exists('wc_get_product')) {
			return null;
		}

		global $product;
		if ($product instanceof \WC_Product) {
			return $product;
		}

		$post_id = get_the_ID();
		if ($post_id && 'product' === get_post_type($post_id)) {
			$current_product = wc_get_product($post_id);
			if ($current_product instanceof \WC_Product) {
				return $current_product;
			}
		}

		if ($this->is_edit_mode() && function_exists('wc_get_products')) {
			$products = wc_get_products(
				array(
					'status' => 'publish',
					'limit'  => 1,
					'return' => 'objects',
				)
			);

			if (! empty($products) && $products[0] instanceof \WC_Product) {
				return $products[0];
			}
		}

		return null;
	}

	/**
	 * Returns icon HTML for a tab icon setting.
	 *
	 * @param mixed  $icon            Icon setting value.
	 * @param string $legacy_fallback Legacy icon class fallback.
	 * @param string $class           Wrapper class.
	 * @return string
	 */
	private function render_tab_icon($icon, $legacy_fallback = '', $class = '')
	{
		$classes   = trim('ddm-woo-product-tabs__icon ' . $class);
		$icon_html = '';

		if (is_array($icon)) {
			$icon_value = $icon['value'] ?? null;
			$has_value  = (is_array($icon_value) && ! empty($icon_value)) || (is_string($icon_value) && '' !== trim($icon_value));

			if ($has_value) {
				ob_start();
				Icons_Manager::render_icon(
					$icon,
					array(
						'aria-hidden' => 'true',
					)
				);
				$icon_html = trim((string) ob_get_clean());
			}

			if ('' === $icon_html && ! empty($icon['icon']) && is_string($icon['icon'])) {
				$legacy_fallback = $icon['icon'];
			}

			if ('' === $icon_html && is_string($icon_value) && '' !== trim($icon_value)) {
				$legacy_fallback = $icon_value;
			}
		} elseif (is_string($icon) && '' !== trim($icon)) {
			$legacy_fallback = $icon;
		}

		if ('' === $icon_html && '' !== trim((string) $legacy_fallback)) {
			$sanitized_legacy = $this->sanitize_icon_class($legacy_fallback);
			if ('' !== $sanitized_legacy) {
				$icon_html = '<i class="' . esc_attr($sanitized_legacy) . '" aria-hidden="true"></i>';
			}
		}

		if ('' === $icon_html) {
			return '';
		}

		return '<span class="' . esc_attr($classes) . '" aria-hidden="true">' . $icon_html . '</span>';
	}

	/**
	 * Sanitizes legacy icon class value.
	 *
	 * @param string $icon_class Icon classes.
	 * @return string
	 */
	private function sanitize_icon_class($icon_class)
	{
		$icon_class = trim((string) $icon_class);
		if ('' === $icon_class) {
			return '';
		}

		$parts      = preg_split('/\s+/', $icon_class);
		$safe_parts = array();

		foreach ($parts as $part) {
			$part = trim((string) $part);
			if ('' === $part) {
				continue;
			}

			if (preg_match('/^[A-Za-z0-9_-]+$/', $part)) {
				$safe_parts[] = $part;
			}
		}

		return implode(' ', $safe_parts);
	}

	/**
	 * Checks whether Elementor editor mode is active.
	 *
	 * @return bool
	 */
	private function is_edit_mode()
	{
		return class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode();
	}

	/**
	 * Determines whether switcher value is enabled.
	 *
	 * @param mixed $value Switcher value.
	 * @return bool
	 */
	private function is_switcher_enabled($value)
	{
		return 'yes' === $value;
	}
}
