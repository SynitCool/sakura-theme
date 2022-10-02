<?php

// elementor widgets
require_once("widgets/widgets.php");


function worled_theme_support() {
    add_theme_support("title-tag");
    add_theme_support("custom-logo");
}

add_action("after_setup_theme", "worled_theme_support");

function wordpresstest_menus() {
    $locations = array(
        "primary" => "Navbar Menu Items",
        "footer" => "Footer Menu Items"
    );

    register_nav_menus($locations );
}

add_action("init", "wordpresstest_menus");


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

function worled_register_styles() {
    $version = wp_get_theme()->get("Version");

    // wp_enqueue_style("worled-style-1", get_template_directory_uri() . "/assets/css/style-1.css", array("worled-style-2"), $version, "all");
    wp_enqueue_style("worled-style", get_template_directory_uri() . "/style.css", array(), $version, "all");
    wp_enqueue_style("worled-style-limelight", get_template_directory_uri() . "/assets/css/style-limelight.css", array("worled-bootstrap-min-style"), $version, "all");
    wp_enqueue_style("worled-bootstrap-min-style", get_template_directory_uri() . "/assets/css/bootstrap.min.css", array(), "4.1.0", "all");
    wp_enqueue_style("worled-responsive-style", get_template_directory_uri() . "/assets/css/responsive.css", array("worled-bootstrap-min-style"), $version, "all");
    wp_enqueue_style("worled-jquery-mCustomScrollbar-min-style", get_template_directory_uri() . "/assets/css/jquery.mCustomScrollbar.min.css", array(), $version, "all");
    wp_enqueue_style("worled-font-awesome-style", "https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css", array(), "4.0.3", "all");
    wp_enqueue_style("worled-jquery-fancybox-min-style", "https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css", array(), "2.1.5", "screen");
}

add_action("wp_enqueue_scripts", "worled_register_styles");

function worled_register_scripts() {
    $version = wp_get_theme()->get("Version");

    wp_enqueue_script("worled-jquery-min",get_template_directory_uri() . "/assets/js/jquery.min.js",array() , "3.3.1", true);
    wp_enqueue_script("worled-bootstrap-bundle-min",get_template_directory_uri() . "/assets/js/bootstrap.bundle.min.js",array() , "4.1.0", true);
    wp_enqueue_script("worled-jquery-3.0.0-min",get_template_directory_uri() . "/assets/js/jquery-3.0.0.min.js",array() , "3.0.0", true);
    wp_enqueue_script("worled-jquery-mCustomScrollbar-concat-min",get_template_directory_uri() . "/assets/js/jquery.mCustomScrollbar.concat.min.js",array() , "3.1.13", true);
    wp_enqueue_script("worled-custom",get_template_directory_uri() . "/assets/js/custom.js",array() , $version, true);
}

add_action("wp_enqueue_scripts", "worled_register_scripts");
?>