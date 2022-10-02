<?php

namespace Elementor;

class Background_Image_List_Carousel extends Widget_Base {
	
	public function get_name() {
		return 'Background Image List Carousel';
	}
	
	public function get_title() {
		return 'Background Image & List Carousel';
	}
	
	public function get_icon() {
		return 'eicon-image-before-after';
	}
	
	public function get_categories() {
		return [ 'basic' ];
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
			'section_content',
			[
				'label' => esc_html__( 'Content List', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_list',
			[
				'label' => esc_html__( 'Title List', 'elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'title',
						'label' => esc_html__( 'Title', 'elementor' ),
						'type' => Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Enter your title', 'elementor' ),
						'default' => esc_html__( 'Default Title', 'elementor' ),
					],
					[
						'name' => 'sub-title',
						'label' => esc_html__( 'Sub Title', 'elementor' ),
						'type' => Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Enter your sub title', 'elementor' ),
						'default' => esc_html__( 'Default tub title', 'elementor' ),
					],
					[
						'name' => 'link',
						'label' => esc_html__( 'Link', 'elementor' ),
						'type' => Controls_Manager::URL,
						'placeholder' => esc_html__( 'https://your-link.com', 'elementor' ),
					],
				],
				'default' => [
					[
						'title' => esc_html__( 'Default Title #1', 'elementor' ),
						'sub-title' => esc_html__('Default sub title #1', 'elementor'),
						'link' => '#',
					],
					[
						'title' => esc_html__( 'Default Title #2', 'elementor' ),
						'sub-title' => esc_html__('Default sub title #2', 'elementor'),
						'link' => '#',
					],
				],
				'title_field' => '{{{ title }}}',
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

		?>
		<!-- banner -->
		<section class='banner_main' 
		style='
		position: relative;
		background: url(<?php echo $image_url ?>);
		background-size: 100% 100%;'
			>
		<div id='myCarousel' class='carousel slide banner' data-ride='carousel'>
		<ol class='carousel-indicators'>
		<?php foreach ( $settings['title_list'] as $index => $item ) : ?>
			<?php
				if ($index === 0) {
					?><li data-target='#myCarousel' data-slide-to='<?php echo $index ?>' class='active'></li><?php
				} else {
					?><li data-target='#myCarousel' data-slide-to='<?php echo $index ?>' class=''></li><?php
				}
			?>
		<?php endforeach; ?>
		</ol>
				<div class='carousel-inner'>
				<?php foreach ( $settings['title_list'] as $index => $item ) : ?>
					<?php
						if ($index === 0) {
							if (!$item['link']['url'])
							{
								?>
									<div class='carousel-item active'>
										<div class='container'>
											<div class='carousel-caption relative'>
											<div class='row'>
												<div class='col-md-7 offset-md-5'>
													<div class='text-bg'>
														<h1><?php echo $item['title']?></h1>
														<span><?php echo $item['sub-title']?></span>
													</div>
												</div>
											</div>
											</div>
										</div>
									</div>
								<?php
							} else {
								?>
									<div class='carousel-item active'>
										<div class='container'>
											<div class='carousel-caption relative'>
											<div class='row'>
												<div class='col-md-7 offset-md-5'>
													<div class='text-bg'>
														<h1><?php echo $item['title']?></h1>
														<span><?php echo $item['sub-title']?></span>
														<a class='read_more' href='<?php echo esc_url($item['link']['url']) ?>'>Read More</a>
													</div>
												</div>
											</div>
											</div>
										</div>
									</div>
								<?php
							}
						} else {
							if (!$item['link']['url']) 
							{
								?>
									<div class='carousel-item'>
										<div class='container'>
											<div class='carousel-caption relative'>
											<div class='row'>
												<div class='col-md-7 offset-md-5'>
													<div class='text-bg'>
														<h1><?php echo $item['title']?></h1>
														<span><?php echo $item['sub-title']?></span>
													</div>
												</div>
											</div>
											</div>
										</div>
									</div>
								<?php
							} else {
								?>
									<div class='carousel-item'>
										<div class='container'>
											<div class='carousel-caption relative'>
											<div class='row'>
												<div class='col-md-7 offset-md-5'>
													<div class='text-bg'>
														<h1><?php echo $item['title']?></h1>
														<span><?php echo $item['sub-title']?></span>
														<a class='read_more' href='<?php echo esc_url($item['link']['url']) ?>'>Read More</a>
													</div>
												</div>
											</div>
											</div>
										</div>
									</div>
								<?php
							}
							}
						?>
					<?php endforeach; ?>
				</div>
				<br />
				<?php
					if (count($settings['title_list']) != 1) 
					{
						?>
							<a class='carousel-control-prev' href='#myCarousel' role='button' data-slide='prev'>
							<i class='fa fa-angle-left' aria-hidden='true'></i>
							<span class='sr-only'>Previous</span>
							</a>
							<a class='carousel-control-next' href='#myCarousel' role='button' data-slide='next'>
							<i class='fa fa-angle-right' aria-hidden='true'></i>
							<span class='sr-only'>Next</span>
							</a>
						<?php
					}
				?>
				</div>
			</section>
		<!-- end banner -->
		<?php
	}
	
	protected function _content_template() {

    }
	
	
}