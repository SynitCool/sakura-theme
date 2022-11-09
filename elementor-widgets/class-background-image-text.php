<?php

namespace Elementor;

class Background_Image_Text extends Widget_Base {
    public function get_name() {
		return 'Background Image Text';
	}
	
	public function get_title() {
		return 'Background Image & Text';
	}
	
	public function get_icon() {
		return 'eicon-featured-image';
	}
	
	public function get_categories() {
		return [ 'sakura-theme-widgets' ];
	}

    protected function _register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'elementor' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Content', 'elementor' ),
			]
		);
		
		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your title', 'elementor' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => __( 'Sub-title', 'elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter your sub-title', 'elementor' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'elementor' ),
				'default' => [
					'url' => '',
				]
			]
		);

		$this->end_controls_section();
	}

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['image']['url'] ) ) {
			return;
		}

        $image_url = esc_url($settings['image']['url']);
        $url = $settings['link']['url'];

		$explode_title = explode(" ", $settings['title']);
        $first_word_title = $explode_title[0];
        $rest_word_title = implode(" ",array_slice($explode_title, 1));

        $html_with_link = "
        <div id='image_text' class='image_text'>
            <div class='container'>
            <div class='row'>
                <div class='col-md-5'>
                    <div class='titlepage'>
                        <h2><span class='theme-color'>$first_word_title</span> $rest_word_title</h2>
                        <p>$settings[subtitle]</p>
                        <a class='read_more' href='$url'> Read More</a>
                    </div>
                </div>
                <div class='col-md-7'>
                    <div class='image_text_img'>
                        <figure><img src=$image_url' alt='#'></figure>
                    </div>
                </div>
            </div>
            </div>
        </div>
        ";

		$html_no_link = "
        <div id='image_text' class='image_text'>
            <div class='container'>
            <div class='row'>
                <div class='col-md-5'>
                    <div class='titlepage'>
						<h2><span class='theme-color'>$first_word_title</span> $rest_word_title</h2>
                        <p>$settings[subtitle]</p>
                    </div>
                </div>
                <div class='col-md-7'>
                    <div class='image_text_img'>
                        <figure><img src=$image_url' alt='#'></figure>
                    </div>
                </div>
            </div>
            </div>
        </div>
        ";

		if ($url) {
			echo $html_with_link;
		} else {
			echo $html_no_link;
		}
    }

    protected function _content_template() {

    }
}