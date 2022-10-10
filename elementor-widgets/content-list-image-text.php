<?php

namespace Elementor;

class Content_List_Image_Text extends Widget_Base {
    public function get_name() {
		return 'Content List Image Text';
	}
	
	public function get_title() {
		return 'Content List Image Text';
	}
	
	public function get_icon() {
		return 'eicon-post-content';
	}
	
	public function get_categories() {
		return [ 'sakura-theme-widgets' ];
	}

    protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'elementor' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'elementor' ),
				'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title', 'elementor' ),
                'default' => esc_html__('Title', 'elementor')
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_1',
			[
				'label' => esc_html__( 'Content 1', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'sub_title_1',
            [
                'label' => esc_html__( 'Sub Title 1', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your sub title 1', 'elementor' ),
                'default' => esc_html__( 'Sub Title 1', 'elementor')
            ]
        );

        $this->add_control(
			'sub_image_1',
			[
				'label' => esc_html__( 'Choose Sub Image 1', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
            'sub_description_1',
            [
                'label' => esc_html__( 'Sub Description 1', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your sub description 1', 'elementor' ),
                'default' => esc_html__( 'Sub Description 1', 'elementor')
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_content_2',
			[
				'label' => esc_html__( 'Content 2', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'sub_title_2',
            [
                'label' => esc_html__( 'Sub Title 2', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your sub title 2', 'elementor' ),
                'default' => esc_html__( 'Sub Title 2', 'elementor')
            ]
        );

        $this->add_control(
			'sub_image_2',
			[
				'label' => esc_html__( 'Choose Sub Image 2', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
            'sub_description_2',
            [
                'label' => esc_html__( 'Sub Description 2', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your sub description 2', 'elementor' ),
                'default' => esc_html__( 'Sub Description 2', 'elementor')
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_content_3',
			[
				'label' => esc_html__( 'Content 3', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'sub_title_3',
            [
                'label' => esc_html__( 'Sub Title 3', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your sub title 3', 'elementor' ),
                'default' => esc_html__( 'Sub Title 3', 'elementor')
            ]
        );

        $this->add_control(
			'sub_image_3',
			[
				'label' => esc_html__( 'Choose Sub Image 3', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
            'sub_description_3',
            [
                'label' => esc_html__( 'Sub Description 3', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your sub description 3', 'elementor' ),
                'default' => esc_html__( 'Sub Description 3', 'elementor')
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_content_4',
			[
				'label' => esc_html__( 'Content 4', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'sub_title_4',
            [
                'label' => esc_html__( 'Sub Title 4', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your sub title 4', 'elementor' ),
                'default' => esc_html__( 'Sub Title 4', 'elementor')
            ]
        );

        $this->add_control(
			'sub_image_4',
			[
				'label' => esc_html__( 'Choose Sub Image 4', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
            'sub_description_4',
            [
                'label' => esc_html__( 'Sub Description 4', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your sub description 4', 'elementor' ),
                'default' => esc_html__( 'Sub Description 4', 'elementor')
            ]
        );

		$this->end_controls_section();
	}

    protected function render() {
        $settings = $this->get_settings_for_display();

        $image_url_1 = esc_url($settings['sub_image_1']['url']);
        $image_url_2 = esc_url($settings['sub_image_2']['url']);
        $image_url_3 = esc_url($settings['sub_image_3']['url']);
        $image_url_4 = esc_url($settings['sub_image_4']['url']);

        $explode_title = explode(" ", $settings['title']);
        $first_word_title = $explode_title[0];
        $rest_word_title = implode(" ",array_slice($explode_title, 1));

        // $html_with_link = "
        // <div id='service' class='service'>
        // <div class='container'>
        //    <div class='row'>
        //       <div class='col-md-12'>
        //          <div class='titlepage'>
        //             <h2>Our <span class='green'>Services</span></h2>
        //          </div>
        //       </div>
        //    </div>
        //    <div class='row'>
        //       <div class='col-md-10 offset-md-1'>
        //          <div class='row'>
   
        //             <div class='col-md-4 col-sm-6'>
        //                <div class='service_box'>
        //                   <i><img src='images/service1.png' alt='#'></i>
        //                   <h3>Retina Ready</h3>
        //                   <p>many variations of passages <br>of Lorem Ipsum available,</p>
        //                </div>
        //             </div>
        //             <div class='col-md-4 offset-md-1 col-sm-6'>
        //                <div class='service_box'>
        //                   <i><img src='images/service2.png' alt='#'></i>
        //                   <h3>Creative Elements</h3>
        //                   <p>many variations of passages <br>of Lorem Ipsum available,</p>
        //                </div>
        //             </div>
        //             <div class='col-md-4 offset-md-3 col-sm-6 mar_top'>
        //                <div class='service_box'>
        //                   <i><img src='images/service3.png' alt='#'></i>
        //                   <h3>Easy-to-Use</h3>
        //                   <p>many variations of passages <br>of Lorem Ipsum available,</p>
        //                </div>
        //             </div>
        //             <div class='col-md-4 offset-md-1 col-sm-6 mar_top'>
        //                <div class='service_box'>
        //                   <i><img src='images/service4.png' alt='#'></i>
        //                   <h3>Easy Import</h3>
        //                   <p>many variations of passages <br>of Lorem Ipsum available,</p>
        //                </div>
        //             </div>
        //             <div class='col-md-12'>
        //                <a class='read_more' href='Javascript:void(0)'> Read More</a>
        //             </div>
        //             </div>
        //         </div>
        //     </div>
        //     </div>
        // </div>
        // ";

		$html_no_link = "
        <div id='service' class='service'>
        <div class='container'>
           <div class='row'>
              <div class='col-md-12'>
                 <div class='titlepage'>
                    <h2><span class='theme-color'>$first_word_title</span> $rest_word_title</h2>
                 </div>
              </div>
           </div>
           <div class='row'>
              <div class='col-md-10 offset-md-1'>
                 <div class='row'>
                    <div class='col-md-4 col-sm-6'>
                       <div class='service_box'>
                          <i><img src=$image_url_1 alt='#'></i>
                          <h3>$settings[sub_title_1]</h3>
                          <p>$settings[sub_description_1]</p>
                       </div>
                    </div>
                    <div class='col-md-4 offset-md-1 col-sm-6'>
                       <div class='service_box'>
                          <i><img src=$image_url_2 alt='#'></i>
                          <h3>$settings[sub_title_2]</h3>
                          <p>$settings[sub_description_2]</p>
                       </div>
                    </div>
                    <div class='col-md-4 offset-md-3 col-sm-6 mar_top'>
                       <div class='service_box'>
                          <i><img src=$image_url_3 alt='#'></i>
                          <h3>$settings[sub_title_3]</h3>
                          <p>$settings[sub_description_3]</p>
                       </div>
                    </div>
                    <div class='col-md-4 offset-md-1 col-sm-6 mar_top'>
                       <div class='service_box'>
                          <i><img src=$image_url_4 alt='#'></i>
                          <h3>$settings[sub_title_4]</h3>
                          <p>$settings[sub_description_4]</p>
                       </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        ";

		echo $html_no_link;
    }

    protected function _content_template() {

    }
}