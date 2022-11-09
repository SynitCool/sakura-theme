<?php
class Widgets {

	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
		require_once('class-background-image-text.php');
		require_once('class-background-image-list-carousel.php');
		require_once('class-content-list-image-text.php');
		require_once('class-profile-database.php');
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	public function register_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\Background_Image_Text() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\Background_Image_List_Carousel() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\Content_List_Image_Text() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\Profile_Database() );
	}

}

class Categories {
    protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_categories' ] );
	}

	public function add_categories() {
		\Elementor\Plugin::instance()->elements_manager->add_category( 
			'sakura-theme-widgets', 
			[
				'title' => esc_html__('Sakura Theme Widgets', 'elementor'),
				'icon' => 'fa fa-plug',
				] 
			);
	}
}

add_action( 'init', 'my_elementor_init' );
function my_elementor_init() {
	Widgets::get_instance();
	Categories::get_instance();
}
