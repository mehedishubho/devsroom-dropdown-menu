<?php
/**
 * Elementor widget: Devsroom Dropdown Menu.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dropdown menu widget class.
 */
class DDM_Dropdown_Menu_Widget extends Widget_Base {

	/**
	 * Widget slug.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'devsroom_dropdown_menu';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Devsroom Dropdown Menu', 'devsroom-dropdown-menu' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-menu-bar';
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
		return array( 'ddm-widget' );
	}

	/**
	 * Widget script dependencies.
	 *
	 * @return string[]
	 */
	public function get_script_depends() {
		return array( 'ddm-widget' );
	}

	/**
	 * Registers widget controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->register_trigger_controls();
		$this->register_menu_items_controls();
		$this->register_menu_settings_controls();
		$this->register_trigger_style_controls();
		$this->register_panel_style_controls();
		$this->register_item_style_controls();
	}

	/**
	 * Registers trigger controls.
	 *
	 * @return void
	 */
	private function register_trigger_controls() {
		$this->start_controls_section(
			'section_trigger',
			array(
				'label' => __( 'Hamburger Trigger', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'trigger_icon',
			array(
				'label'   => __( 'Icon', 'devsroom-dropdown-menu' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'trigger_show_text',
			array(
				'label'        => __( 'Show Text Label', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'trigger_text',
			array(
				'label'     => __( 'Text Label', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Menu', 'devsroom-dropdown-menu' ),
				'condition' => array(
					'trigger_show_text' => 'yes',
				),
			)
		);

		$this->add_control(
			'trigger_icon_position',
			array(
				'label'     => __( 'Icon Position', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'before' => __( 'Before Text', 'devsroom-dropdown-menu' ),
					'after'  => __( 'After Text', 'devsroom-dropdown-menu' ),
				),
				'default'   => 'before',
				'condition' => array(
					'trigger_show_text' => 'yes',
				),
			)
		);

		$this->add_control(
			'aria_label',
			array(
				'label'       => __( 'ARIA Label', 'devsroom-dropdown-menu' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Toggle navigation menu', 'devsroom-dropdown-menu' ),
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'trigger_alignment',
			array(
				'label'     => __( 'Trigger Alignment', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .ddm-widget' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers repeater menu items controls.
	 *
	 * @return void
	 */
	private function register_menu_items_controls() {
		$repeater = new Repeater();

		$repeater->add_control(
			'item_title',
			array(
				'label'       => __( 'Title', 'devsroom-dropdown-menu' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Menu Item', 'devsroom-dropdown-menu' ),
			)
		);

		$repeater->add_control(
			'item_link',
			array(
				'label'         => __( 'Link', 'devsroom-dropdown-menu' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'devsroom-dropdown-menu' ),
				'show_external' => true,
				'default'       => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
			)
		);

		$repeater->add_control(
			'item_icon',
			array(
				'label' => __( 'Icon', 'devsroom-dropdown-menu' ),
				'type'  => Controls_Manager::ICONS,
			)
		);

		$repeater->add_control(
			'item_icon_position',
			array(
				'label'   => __( 'Icon Position', 'devsroom-dropdown-menu' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'before' => __( 'Before Title', 'devsroom-dropdown-menu' ),
					'after'  => __( 'After Title', 'devsroom-dropdown-menu' ),
				),
				'default' => 'before',
			)
		);

		$repeater->add_control(
			'item_new_tab',
			array(
				'label'        => __( 'Open In New Tab', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->start_controls_section(
			'section_menu_items',
			array(
				'label' => __( 'Dropdown Menu Items', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'menu_items',
			array(
				'label'       => __( 'Items', 'devsroom-dropdown-menu' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_title' => __( 'Home', 'devsroom-dropdown-menu' ),
					),
					array(
						'item_title' => __( 'About', 'devsroom-dropdown-menu' ),
					),
				),
				'title_field' => '{{{ item_title }}}',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers menu settings and advanced controls.
	 *
	 * @return void
	 */
	private function register_menu_settings_controls() {
		$this->start_controls_section(
			'section_menu_settings',
			array(
				'label' => __( 'Menu Configuration', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'menu_animation',
			array(
				'label'   => __( 'Dropdown Animation', 'devsroom-dropdown-menu' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'       => __( 'None', 'devsroom-dropdown-menu' ),
					'fade'       => __( 'Fade', 'devsroom-dropdown-menu' ),
					'slide-down' => __( 'Slide Down', 'devsroom-dropdown-menu' ),
				),
				'default' => 'fade',
			)
		);

		$this->add_control(
			'menu_alignment',
			array(
				'label'   => __( 'Dropdown Position', 'devsroom-dropdown-menu' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => __( 'Left', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'devsroom-dropdown-menu' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'left',
				'toggle'  => false,
			)
		);

		$this->add_responsive_control(
			'menu_width',
			array(
				'label'      => __( 'Dropdown Width', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 120,
						'max' => 600,
					),
					'%'  => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 240,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_offset',
			array(
				'label'      => __( 'Dropdown Vertical Offset', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
					'em' => array(
						'min' => 0,
						'max' => 4,
					),
				),
				'default'    => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'menu_bg_color',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-panel' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'menu_border',
				'label'    => __( 'Border', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-panel',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'menu_shadow',
				'label'    => __( 'Shadow', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-panel',
			)
		);

		$this->add_control(
			'close_on_outside_click',
			array(
				'label'        => __( 'Close On Click Outside', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'close_on_link_click',
			array(
				'label'        => __( 'Close On Link Click', 'devsroom-dropdown-menu' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'devsroom-dropdown-menu' ),
				'label_off'    => __( 'No', 'devsroom-dropdown-menu' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'custom_css',
			array(
				'label'       => __( 'Custom CSS', 'devsroom-dropdown-menu' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => __( 'Use CSS declarations, or full rules using "selector" as the widget wrapper token.', 'devsroom-dropdown-menu' ),
				'rows'        => 6,
			)
		);

		$this->add_control(
			'custom_js',
			array(
				'label'       => __( 'Custom JavaScript', 'devsroom-dropdown-menu' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => __( 'Executed only for users with unfiltered_html capability. Use carefully.', 'devsroom-dropdown-menu' ),
				'rows'        => 6,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers trigger style controls.
	 *
	 * @return void
	 */
	private function register_trigger_style_controls() {
		$this->start_controls_section(
			'section_style_trigger',
			array(
				'label' => __( 'Trigger Style', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'trigger_typography',
				'label'    => __( 'Typography', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-trigger',
			)
		);

		$this->start_controls_tabs( 'trigger_colors_tabs' );

		$this->start_controls_tab(
			'trigger_colors_tab_normal',
			array(
				'label' => __( 'Normal', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'trigger_text_color',
			array(
				'label'     => __( 'Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-trigger' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'trigger_icon_color',
			array(
				'label'     => __( 'Icon Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-trigger .ddm-icon, {{WRAPPER}} .ddm-trigger .ddm-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-trigger .ddm-icon svg, {{WRAPPER}} .ddm-trigger .ddm-icon svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'trigger_bg_color',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-trigger' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'trigger_colors_tab_hover',
			array(
				'label' => __( 'Hover', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'trigger_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-trigger:hover, {{WRAPPER}} .ddm-trigger:focus-visible' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'trigger_icon_color_hover',
			array(
				'label'     => __( 'Icon Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-trigger:hover .ddm-icon, {{WRAPPER}} .ddm-trigger:hover .ddm-icon i, {{WRAPPER}} .ddm-trigger:focus-visible .ddm-icon, {{WRAPPER}} .ddm-trigger:focus-visible .ddm-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-trigger:hover .ddm-icon svg, {{WRAPPER}} .ddm-trigger:hover .ddm-icon svg *, {{WRAPPER}} .ddm-trigger:focus-visible .ddm-icon svg, {{WRAPPER}} .ddm-trigger:focus-visible .ddm-icon svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'trigger_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-trigger:hover, {{WRAPPER}} .ddm-trigger:focus-visible' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'trigger_padding',
			array(
				'label'      => __( 'Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'trigger_margin',
			array(
				'label'      => __( 'Margin', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-trigger' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'trigger_border',
				'label'    => __( 'Border', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-trigger',
			)
		);

		$this->add_responsive_control(
			'trigger_border_radius',
			array(
				'label'      => __( 'Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'trigger_icon_gap',
			array(
				'label'      => __( 'Icon Gap', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
					'em' => array(
						'min' => 0,
						'max' => 3,
					),
				),
				'default'    => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-trigger' => '--ddm-trigger-icon-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'trigger_icon_size',
			array(
				'label'      => __( 'Icon Size', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 8,
						'max' => 96,
					),
					'em'  => array(
						'min' => 0.5,
						'max' => 6,
					),
					'rem' => array(
						'min' => 0.5,
						'max' => 6,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-trigger .ddm-icon, {{WRAPPER}} .ddm-trigger .ddm-icon i, {{WRAPPER}} .ddm-trigger .ddm-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ddm-trigger .ddm-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'transition_duration',
			array(
				'label'      => __( 'Transition Duration (ms)', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1200,
					),
				),
				'default'    => array(
					'size' => 220,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-widget' => '--ddm-transition-duration: {{SIZE}}ms;',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers panel style controls.
	 *
	 * @return void
	 */
	private function register_panel_style_controls() {
		$this->start_controls_section(
			'section_style_panel',
			array(
				'label' => __( 'Dropdown Panel Style', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'panel_padding',
			array(
				'label'      => __( 'Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_horizontal_offset',
			array(
				'label'      => __( 'Horizontal Offset', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => -500,
						'max' => 500,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_vertical_offset',
			array(
				'label'      => __( 'Vertical Offset', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -200,
						'max' => 300,
					),
					'em' => array(
						'min' => -10,
						'max' => 20,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_min_width',
			array(
				'label'      => __( 'Min Width', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 80,
						'max' => 800,
					),
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_max_width',
			array(
				'label'      => __( 'Max Width', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 120,
						'max' => 1200,
					),
					'%'  => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_max_height',
			array(
				'label'      => __( 'Max Height', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array(
						'min' => 80,
						'max' => 1200,
					),
					'vh' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'max-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'panel_overflow_y',
			array(
				'label'     => __( 'Overflow Y', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'visible' => __( 'Visible', 'devsroom-dropdown-menu' ),
					'auto'    => __( 'Auto', 'devsroom-dropdown-menu' ),
					'scroll'  => __( 'Scroll', 'devsroom-dropdown-menu' ),
					'hidden'  => __( 'Hidden', 'devsroom-dropdown-menu' ),
				),
				'default'   => 'visible',
				'selectors' => array(
					'{{WRAPPER}} .ddm-panel' => 'overflow-y: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_margin',
			array(
				'label'      => __( 'Margin', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'panel_z_index',
			array(
				'label'     => __( 'Z-Index', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 2147483647,
				'step'      => 1,
				'default'   => 9999,
				'selectors' => array(
					'{{WRAPPER}} .ddm-panel' => 'z-index: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_border_radius',
			array(
				'label'      => __( 'Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers item style controls.
	 *
	 * @return void
	 */
	private function register_item_style_controls() {
		$this->start_controls_section(
			'section_style_items',
			array(
				'label' => __( 'Menu Item Style', 'devsroom-dropdown-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_typography',
				'label'    => __( 'Typography', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-item',
			)
		);

		$this->start_controls_tabs( 'item_colors_tabs' );

		$this->start_controls_tab(
			'item_colors_tab_normal',
			array(
				'label' => __( 'Normal', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'item_text_color',
			array(
				'label'     => __( 'Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-item' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'item_icon_color',
			array(
				'label'     => __( 'Icon Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-item .ddm-item-icon, {{WRAPPER}} .ddm-item .ddm-item-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-item .ddm-item-icon svg, {{WRAPPER}} .ddm-item .ddm-item-icon svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'item_bg_color',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-item' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'item_colors_tab_hover',
			array(
				'label' => __( 'Hover', 'devsroom-dropdown-menu' ),
			)
		);

		$this->add_control(
			'item_hover_text_color',
			array(
				'label'     => __( 'Text Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-item:hover, {{WRAPPER}} .ddm-item:focus-visible' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'item_hover_icon_color',
			array(
				'label'     => __( 'Icon Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-item:hover .ddm-item-icon, {{WRAPPER}} .ddm-item:hover .ddm-item-icon i, {{WRAPPER}} .ddm-item:focus-visible .ddm-item-icon, {{WRAPPER}} .ddm-item:focus-visible .ddm-item-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ddm-item:hover .ddm-item-icon svg, {{WRAPPER}} .ddm-item:hover .ddm-item-icon svg *, {{WRAPPER}} .ddm-item:focus-visible .ddm-item-icon svg, {{WRAPPER}} .ddm-item:focus-visible .ddm-item-icon svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'item_hover_bg_color',
			array(
				'label'     => __( 'Background Color', 'devsroom-dropdown-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ddm-item:hover, {{WRAPPER}} .ddm-item:focus-visible' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => __( 'Padding', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'item_border',
				'label'    => __( 'Border', 'devsroom-dropdown-menu' ),
				'selector' => '{{WRAPPER}} .ddm-item',
			)
		);

		$this->add_control(
			'item_gap',
			array(
				'label'      => __( 'Icon Gap', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
					'em' => array(
						'min' => 0,
						'max' => 3,
					),
				),
				'default'    => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-item' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_icon_size',
			array(
				'label'      => __( 'Icon Size', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 8,
						'max' => 96,
					),
					'em'  => array(
						'min' => 0.5,
						'max' => 6,
					),
					'rem' => array(
						'min' => 0.5,
						'max' => 6,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-item .ddm-item-icon, {{WRAPPER}} .ddm-item .ddm-item-icon i, {{WRAPPER}} .ddm-item .ddm-item-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ddm-item .ddm-item-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_border_radius',
			array(
				'label'      => __( 'Border Radius', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'      => __( 'Item Spacing', 'devsroom-dropdown-menu' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 40,
					),
					'em' => array(
						'min' => 0,
						'max' => 3,
					),
				),
				'default'    => array(
					'size' => 4,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ddm-menu-list' => 'gap: {{SIZE}}{{UNIT}};',
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
		$settings        = $this->get_settings_for_display();
		$instance_id     = 'ddm-widget-' . sanitize_html_class( $this->get_id() );
		$panel_id        = $instance_id . '-panel';
		$trigger_text    = isset( $settings['trigger_text'] ) ? sanitize_text_field( $settings['trigger_text'] ) : __( 'Menu', 'devsroom-dropdown-menu' );
		$show_text       = $this->is_switcher_enabled( $settings['trigger_show_text'] ?? '' );
		$trigger_icon    = $settings['trigger_icon'] ?? array();
		$trigger_legacy  = $settings['trigger_icon_classic'] ?? '';
		$trigger_icon_at = in_array( $settings['trigger_icon_position'] ?? 'before', array( 'before', 'after' ), true ) ? $settings['trigger_icon_position'] : 'before';
		$menu_alignment  = in_array( $settings['menu_alignment'] ?? 'left', array( 'left', 'center', 'right' ), true ) ? $settings['menu_alignment'] : 'left';
		$menu_animation  = in_array( $settings['menu_animation'] ?? 'fade', array( 'none', 'fade', 'slide-down' ), true ) ? $settings['menu_animation'] : 'fade';
		$close_outside   = $this->is_switcher_enabled( $settings['close_on_outside_click'] ?? 'yes' ) ? 'yes' : 'no';
		$close_link      = $this->is_switcher_enabled( $settings['close_on_link_click'] ?? 'yes' ) ? 'yes' : 'no';
		$aria_label      = isset( $settings['aria_label'] ) ? sanitize_text_field( $settings['aria_label'] ) : '';
		$aria_label      = '' !== $aria_label ? $aria_label : __( 'Toggle navigation menu', 'devsroom-dropdown-menu' );

		$this->add_render_attribute(
			'wrapper',
			array(
				'id'                 => $instance_id,
				'class'              => 'ddm-widget',
				'data-instance-id'   => $instance_id,
				'data-animation'     => $menu_animation,
				'data-alignment'     => $menu_alignment,
				'data-close-outside' => $close_outside,
				'data-close-link'    => $close_link,
			)
		);

		$this->add_render_attribute(
			'trigger',
			array(
				'class'         => 'ddm-trigger',
				'type'          => 'button',
				'aria-haspopup' => 'true',
				'aria-expanded' => 'false',
				'aria-controls' => $panel_id,
				'aria-label'    => $aria_label,
			)
		);

		$this->add_render_attribute(
			'panel',
			array(
				'id'          => $panel_id,
				'class'       => 'ddm-panel',
				'role'        => 'menu',
				'aria-hidden' => 'true',
			)
		);

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
		echo '<button ' . $this->get_render_attribute_string( 'trigger' ) . '>';

		if ( ! $show_text ) {
			echo $this->render_elementor_icon( $trigger_icon, 'ddm-trigger-icon', $trigger_legacy ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			if ( 'before' === $trigger_icon_at ) {
				echo $this->render_elementor_icon( $trigger_icon, 'ddm-trigger-icon', $trigger_legacy ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			echo '<span class="ddm-trigger-text">' . esc_html( $trigger_text ) . '</span>';

			if ( 'after' === $trigger_icon_at ) {
				echo $this->render_elementor_icon( $trigger_icon, 'ddm-trigger-icon', $trigger_legacy ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		echo '</button>';
		echo '<div ' . $this->get_render_attribute_string( 'panel' ) . '>';
		echo '<ul class="ddm-menu-list">';

		$menu_items = isset( $settings['menu_items'] ) && is_array( $settings['menu_items'] ) ? $settings['menu_items'] : array();
		foreach ( $menu_items as $item ) {
			$title = isset( $item['item_title'] ) ? sanitize_text_field( $item['item_title'] ) : '';
			if ( '' === $title ) {
				continue;
			}

			$item_icon_legacy = $item['item_icon_classic'] ?? '';
			$item_icon_markup = $this->render_elementor_icon( $item['item_icon'] ?? array(), 'ddm-item-icon', $item_icon_legacy );
			$icon_position    = in_array( $item['item_icon_position'] ?? 'before', array( 'before', 'after' ), true ) ? $item['item_icon_position'] : 'before';
			$link_data        = $item['item_link'] ?? array();
			$link_url         = ! empty( $link_data['url'] ) ? esc_url( $link_data['url'] ) : '';
			$item_new_tab     = $this->is_switcher_enabled( $item['item_new_tab'] ?? '' );
			$link_external    = ! empty( $link_data['is_external'] ) || $item_new_tab;
			$link_nofollow    = ! empty( $link_data['nofollow'] );

			echo '<li class="ddm-menu-item" role="none">';

			if ( '' !== $link_url ) {
				$rel = array();
				if ( $link_external ) {
					$rel[] = 'noopener';
					$rel[] = 'noreferrer';
				}

				if ( $link_nofollow ) {
					$rel[] = 'nofollow';
				}

				echo '<a class="ddm-item" role="menuitem" href="' . esc_url( $link_url ) . '"';
				if ( $link_external ) {
					echo ' target="_blank"';
				}

				if ( ! empty( $rel ) ) {
					echo ' rel="' . esc_attr( implode( ' ', array_unique( $rel ) ) ) . '"';
				}

				echo '>';
			} else {
				echo '<span class="ddm-item ddm-item--nolink" role="menuitem" tabindex="0">';
			}

			if ( 'before' === $icon_position ) {
				echo $item_icon_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			echo '<span class="ddm-item-text">' . esc_html( $title ) . '</span>';

			if ( 'after' === $icon_position ) {
				echo $item_icon_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			if ( '' !== $link_url ) {
				echo '</a>';
			} else {
				echo '</span>';
			}

			echo '</li>';
		}

		echo '</ul>';
		echo '</div>';
		echo '</div>';

		$this->render_custom_css( $settings['custom_css'] ?? '', $instance_id );
		$this->render_custom_js( $settings['custom_js'] ?? '', $instance_id );
	}

	/**
	 * Returns icon HTML for an Elementor icon control.
	 *
	 * @param mixed  $icon            Icon setting value.
	 * @param string $class           Additional class name.
	 * @param string $legacy_fallback Legacy icon class fallback.
	 * @return string
	 */
	private function render_elementor_icon( $icon, $class = '', $legacy_fallback = '' ) {
		$classes   = trim( 'ddm-icon ' . $class );
		$icon_html = '';

		if ( is_array( $icon ) ) {
			$icon_value = $icon['value'] ?? null;
			$has_value  = ( is_array( $icon_value ) && ! empty( $icon_value ) ) || ( is_string( $icon_value ) && '' !== trim( $icon_value ) );

			if ( $has_value ) {
				ob_start();
				Icons_Manager::render_icon(
					$icon,
					array(
						'aria-hidden' => 'true',
					)
				);
				$icon_html = trim( (string) ob_get_clean() );
			}

			if ( '' === $icon_html && ! empty( $icon['icon'] ) && is_string( $icon['icon'] ) ) {
				$legacy_fallback = $icon['icon'];
			}

			if ( '' === $icon_html && is_string( $icon_value ) && '' !== trim( $icon_value ) ) {
				$legacy_fallback = $icon_value;
			}
		} elseif ( is_string( $icon ) && '' !== trim( $icon ) ) {
			$legacy_fallback = $icon;
		}

		if ( '' === $icon_html && '' !== trim( (string) $legacy_fallback ) ) {
			$sanitized_legacy = $this->sanitize_icon_class( $legacy_fallback );
			if ( '' !== $sanitized_legacy ) {
				$icon_html = '<i class="' . esc_attr( $sanitized_legacy ) . '" aria-hidden="true"></i>';
			}
		}

		if ( '' === $icon_html ) {
			return '';
		}

		return '<span class="' . esc_attr( $classes ) . '" aria-hidden="true">' . $icon_html . '</span>';
	}

	/**
	 * Sanitizes an icon class list for legacy icon rendering.
	 *
	 * @param string $icon_class Raw icon class string.
	 * @return string
	 */
	private function sanitize_icon_class( $icon_class ) {
		$icon_class = trim( (string) $icon_class );
		if ( '' === $icon_class ) {
			return '';
		}

		$parts      = preg_split( '/\s+/', $icon_class );
		$safe_parts = array();

		foreach ( $parts as $part ) {
			$part = trim( (string) $part );
			if ( '' === $part ) {
				continue;
			}

			if ( preg_match( '/^[A-Za-z0-9_-]+$/', $part ) ) {
				$safe_parts[] = $part;
			}
		}

		return implode( ' ', $safe_parts );
	}

	/**
	 * Outputs per-instance custom CSS declarations.
	 *
	 * @param string $custom_css  User CSS declarations.
	 * @param string $instance_id Widget instance ID.
	 * @return void
	 */
	private function render_custom_css( $custom_css, $instance_id ) {
		$custom_css = trim( (string) $custom_css );
		if ( '' === $custom_css ) {
			return;
		}

		$custom_css = wp_strip_all_tags( $custom_css, false );
		$custom_css = str_replace( array( '</style>', '</STYLE>' ), '', $custom_css );
		if ( '' === trim( $custom_css ) ) {
			return;
		}

		if ( false !== strpos( $custom_css, '{' ) && false !== strpos( $custom_css, '}' ) ) {
			$scoped_css = str_replace( 'selector', '#' . $instance_id, $custom_css );
		} else {
			$scoped_css = '#' . $instance_id . ' {' . $custom_css . '}';
		}

		echo '<style id="' . esc_attr( $instance_id . '-custom-css' ) . '">';
		echo $scoped_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</style>';
	}

	/**
	 * Outputs per-instance custom JavaScript for trusted users.
	 *
	 * @param string $custom_js   User JavaScript.
	 * @param string $instance_id Widget instance ID.
	 * @return void
	 */
	private function render_custom_js( $custom_js, $instance_id ) {
		if ( ! current_user_can( 'unfiltered_html' ) ) {
			return;
		}

		$custom_js = trim( (string) $custom_js );
		if ( '' === $custom_js ) {
			return;
		}

		$custom_js = str_ireplace( array( '<script', '</script>' ), '', $custom_js );
		if ( '' === trim( $custom_js ) ) {
			return;
		}

		echo '<script>';
		echo '(function(){';
		echo 'const ddmRoot=document.getElementById(' . wp_json_encode( $instance_id ) . ');';
		echo 'if(!ddmRoot){return;}';
		echo $custom_js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '})();';
		echo '</script>';
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

