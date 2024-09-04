<?php

class Elementor_Custom_Button_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'custom_button';
    }

    public function get_title() {
        return __( 'Custom Button', 'dynamic-url-button-with-get-parameters' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function _register_controls() {
        // Content Controls
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'dynamic-url-button-with-get-parameters' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Click Here', 'dynamic-url-button-with-get-parameters' ),
            ]
        );

        $this->add_control(
            'button_id',
            [
                'label' => __( 'Button ID', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'custom-button-id', 'dynamic-url-button-with-get-parameters' ),
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => __( 'Button Icon', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'icon_spacing',
            [
                'label' => __( 'Icon Spacing', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-button i, {{WRAPPER}} .custom-button svg' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => __( 'Base URL', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => __( 'https://yourwebsite.com', 'dynamic-url-button-with-get-parameters' ),
            ]
        );

        // Dynamic URL and Multiple Parameters
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'get_parameter',
            [
                'label' => __( 'GET Parameter Name', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'pid',
            ]
        );

        $repeater->add_control(
            'dynamic_value',
            [
                'label' => __( 'Dynamic Value', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'post_id' => __( 'Post ID', 'dynamic-url-button-with-get-parameters' ),
                    'post_title' => __( 'Post Title', 'dynamic-url-button-with-get-parameters' ),
                    'post_slug' => __( 'Post Slug', 'dynamic-url-button-with-get-parameters' ),
                    'post_date' => __( 'Post Date', 'dynamic-url-button-with-get-parameters' ),
                    'author_id' => __( 'Author ID', 'dynamic-url-button-with-get-parameters' ),
                    'author_name' => __( 'Author Name', 'dynamic-url-button-with-get-parameters' ),
                    'category_name' => __( 'Category Name', 'dynamic-url-button-with-get-parameters' ),
                    'tag_name' => __( 'Tag Name', 'dynamic-url-button-with-get-parameters' ),
                ],
                'default' => 'post_id',
            ]
        );

        $this->add_control(
            'parameters',
            [
                'label' => __( 'Parameters', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ get_parameter }}}',
            ]
        );

        $this->end_controls_section();

        // Style Controls
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Button Style', 'dynamic-url-button-with-get-parameters' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button Text Color', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __( 'Background Color', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Hover State Controls
        $this->add_control(
            'button_hover_color',
            [
                'label' => __( 'Hover Text Color', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => __( 'Hover Background Color', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __( 'Typography', 'dynamic-url-button-with-get-parameters' ),
                'selector' => '{{WRAPPER}} .custom-button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => __( 'Border', 'dynamic-url-button-with-get-parameters' ),
                'selector' => '{{WRAPPER}} .custom-button',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .custom-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __( 'Box Shadow', 'dynamic-url-button-with-get-parameters' ),
                'selector' => '{{WRAPPER}} .custom-button',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => __( 'Button Alignment', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'dynamic-url-button-with-get-parameters' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'dynamic-url-button-with-get-parameters' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'dynamic-url-button-with-get-parameters' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .custom-button-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Hover Animation
        $this->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'dynamic-url-button-with-get-parameters' ),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_section();
		
		// Add Donate Us button at the end of all controls
        $this->start_controls_section(
            'donate_section',
            [
                'label' => __( 'Support Us', 'dynamic-url-button-with-get-parameters' ),
            ]
        );

        $this->add_control(
            'donate_button',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<a href="https://buymeacoffee.com/indranil_devstudio" target="_blank" class="elementor-button elementor-button-success">' . __( 'Donate Us', 'dynamic-url-button-with-get-parameters' ) . '</a>',
                'content_classes' => 'donate-button',
            ]
        );

        $this->end_controls_section();

		
    }
	
	

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Get the base URL
        $url = esc_url( $settings['url'] );

        // Build the URL with multiple dynamic parameters
        $params = [];
        if ( ! empty( $settings['parameters'] ) ) {
            foreach ( $settings['parameters'] as $param ) {
                $value = '';
                if ( 'post_id' === $param['dynamic_value'] ) {
                    $value = get_the_ID();
                } elseif ( 'post_title' === $param['dynamic_value'] ) {
                    $value = get_the_title();
                } elseif ( 'post_slug' === $param['dynamic_value'] ) {
                    $value = get_post_field( 'post_name', get_the_ID() );
                } elseif ( 'post_date' === $param['dynamic_value'] ) {
                    $value = get_the_date();
                } elseif ( 'author_id' === $param['dynamic_value'] ) {
                    $value = get_the_author_meta( 'ID' );
                } elseif ( 'author_name' === $param['dynamic_value'] ) {
                    $value = get_the_author();
                } elseif ( 'category_name' === $param['dynamic_value'] ) {
                    $category = get_the_category();
                    $value = ! empty( $category ) ? $category[0]->name : '';
                } elseif ( 'tag_name' === $param['dynamic_value'] ) {
                    $tag = get_the_tags();
                    $value = ! empty( $tag ) ? $tag[0]->name : '';
                }
                $params[ $param['get_parameter'] ] = $value;
            }
        }

        // Construct the final URL with multiple GET parameters
        $final_url = add_query_arg( $params, $url );

        // Render the button with icon and ID
        echo '<div class="custom-button-wrapper">';
        echo '<a href="' . esc_url( $final_url ) . '" id="' . esc_attr( $settings['button_id'] ) . '" class="custom-button elementor-button elementor-animation-' . esc_attr( $settings['hover_animation'] ) . '">';
        
        if ( ! empty( $settings['button_icon']['value'] ) ) {
            \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
        }

        echo esc_html( $settings['button_text'] );
        echo '</a>';
        echo '</div>';
    }
}
