<?php

// sakura back end plugin
require_once("sakura-back-end-plugin/sakura-back-end-plugin.php");

// utils
require_once("inc/season.php");

// checking function
if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

function sakura_theme_backend_setup() {
    // create standard options
    SarthemIncludes\check_option_standard();
}

function sakura_theme_init() {
    // checking elementor installed
    if (is_plugin_active( "elementor/elementor.php" )) {
		require_once("elementor-widgets/widgets.php");
	}

    // setup
    sakura_theme_backend_setup();
}

sakura_theme_init();

function sakura_theme_theme_support() {
    /*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
     */
	add_theme_support( 'title-tag' );

    /**
	 * Add support for the custom logo functionality
	 */
    add_theme_support("custom-logo");

    /*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
        'primary'     => esc_html__( 'Primary' ),
        'social-menu' => esc_html__( 'Social Menu' ),
        'footer'      => esc_html__( 'Footer Menu Items' )
    ) );
}

add_action("after_setup_theme", "sakura_theme_theme_support");

// filters
function add_menu_list_item_class($classes, $item, $args) {
    if (property_exists($args, 'list_item_class')) {
        $classes[] = $args->list_item_class;
    }
    return $classes;
  }

add_filter('nav_menu_css_class', 'add_menu_list_item_class', 1, 3);

function add_menu_link_class( $atts, $item, $args ) {
    if (property_exists($args, 'link_class')) {
      $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );

function sakura_theme_register_styles() {
    $version = wp_get_theme()->get("Version");

    // Default styles
    wp_enqueue_style("sakura_theme-style", get_template_directory_uri() . "/style.css", array(), $version, "all");
    wp_enqueue_style("sakura_theme-style-limelight", get_template_directory_uri() . "/assets/css/style-limelight.css", array("sakura_theme-bootstrap-min-style"), $version, "all");
    wp_enqueue_style("sakura_theme-bootstrap-min-style", get_template_directory_uri() . "/assets/css/bootstrap.min.css", array(), "4.1.0", "all");
    wp_enqueue_style("sakura_theme-responsive-style", get_template_directory_uri() . "/assets/css/responsive.css", array("sakura_theme-bootstrap-min-style"), $version, "all");
    wp_enqueue_style("sakura_theme-jquery-mCustomScrollbar-min-style", get_template_directory_uri() . "/assets/css/jquery.mCustomScrollbar.min.css", array(), $version, "all");
    wp_enqueue_style("sakura_theme-font-awesome-style", "https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css", array(), "4.0.3", "all");
    wp_enqueue_style("sakura_theme-jquery-fancybox-min-style", "https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css", array(), "2.1.5", "screen");
    
    if (current_season() == "christmas") {
        // Christmas styles
        wp_enqueue_style("sakura_theme-christmas-style", get_template_directory_uri() . "/assets/css/christmas-style.css", array("sakura_theme-style-limelight"), $version, "all");
        wp_enqueue_style("sakura_theme-christmas-responsive-style", get_template_directory_uri() . "/assets/css/christmas-responsive.css", array("sakura_theme-responsive-style"), $version, "all");
    }
}

add_action("wp_enqueue_scripts", "sakura_theme_register_styles");

function sakura_theme_register_effects_styles() {
    $version = wp_get_theme()->get("Version");

    if (current_season() == "christmas") {
        wp_enqueue_style("sakura_theme-snow-style", get_template_directory_uri() . "/assets/css/snow-styles.css", array(), $version, "all");
    }
}

add_action("wp_enqueue_scripts", "sakura_theme_register_effects_styles");


function sakura_theme_register_scripts() {
    $version = wp_get_theme()->get("Version");

    wp_enqueue_script("sakura_theme-jquery-min",get_template_directory_uri() . "/assets/js/jquery.min.js",array() , "3.3.1", true);
    wp_enqueue_script("sakura_theme-bootstrap-bundle-min",get_template_directory_uri() . "/assets/js/bootstrap.bundle.min.js",array() , "4.1.0", true);
    wp_enqueue_script("sakura_theme-jquery-3.0.0-min",get_template_directory_uri() . "/assets/js/jquery-3.0.0.min.js",array() , "3.0.0", true);
    wp_enqueue_script("sakura_theme-jquery-mCustomScrollbar-concat-min",get_template_directory_uri() . "/assets/js/jquery.mCustomScrollbar.concat.min.js",array() , "3.1.13", true);
    wp_enqueue_script("sakura_theme-custom",get_template_directory_uri() . "/assets/js/custom.js",array() , $version, true);
}

add_action("wp_enqueue_scripts", "sakura_theme_register_scripts");

function sakura_theme_custom_title() {
    if (!is_404()) return;

    $profile_database = SarthemIncludes\get_option_profile_database();
    $profile_table = SarthemIncludes\get_option_profile_table();

    if (
        ($profile_database == "no-selected") || 
		($profile_table == "no-selected") || 
		($profile_database == false) || 
		($profile_table == false)) return;



    if (!SarthemIncludes\check_table_exist_database($profile_database, $profile_table)) return;

    $url      = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url_path = parse_url( $url, PHP_URL_PATH );

    $slug = pathinfo( $url_path, PATHINFO_BASENAME );
    $profile_rows = SarthemIncludes\get_row_by_column_row($profile_database, $profile_table, "slug", $slug);
    $profile_exist = True;

    if (empty($profile_rows)) {
        $profile_exist = False;
        return;
    } else {
        $profile = $profile_rows[0];
    
        $profile_name = $profile['name'];
        $profile_slug = $profile['slug'];
        return "$profile_name (@$profile_slug)";
    }
}

add_filter('pre_get_document_title', 'sakura_theme_custom_title');

/**
 * Load custom nav walker
 */
require get_template_directory() . '/inc/navwalker.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Social Navition
 */
require get_template_directory() . '/inc/socialnav.php';

/**
 * Load option for sarthem
 */
require get_template_directory() . '/inc/get-option.php';

/**
 * Load database
 */
require get_template_directory() . '/inc/database.php';
?>