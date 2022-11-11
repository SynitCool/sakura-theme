<?php

/**
 * Sakura Back End Plugin
 *
 * @package           sakura-back-end-plugin
 * @author            SynitIsCool
 * @copyright         2022 SynitIsCool
 * @license           MIT License
 *
 * @wordpress-plugin
 * Plugin Name:       Sakura Back End Plugin
 * Plugin URI:        https://github.com/SynitCool/sakura-theme
 * Description:       Plugin for sakura theme to interact with back end of wordpress.
 * Version:           1.0.0
 * Author:            SynitIsCool
 * Author URI:        https://www.instagram.com/synitiscool
 * License:           MIT License
 * License URI:       https://github.com/SynitCool/sakura-theme/blob/master/LICENSE
 */


function load_styles() {
    $version = wp_get_theme()->get("Version");



    // wp_enqueue_style("sakura_back_end_plugin-style", get_template_directory_uri() . "/sakura-back-end-plugin/assets/css/style.css", array(), $version, "all");
    // wp_enqueue_style("sakura_back_anchor_button-style", get_template_directory_uri() . "/sakura-back-end-plugin/assets/css/anchor-button.css", array(), $version, "all");
    // wp_enqueue_style("sakura_back_button-style", get_template_directory_uri() . "/sakura-back-end-plugin/assets/css/button.css", array(), $version, "all");
    // wp_enqueue_style("sakura_back_box-style", get_template_directory_uri() . "/sakura-back-end-plugin/assets/css/box.css", array(), $version, "all");
    // wp_enqueue_style("sakura_back_grid-style", get_template_directory_uri() . "/sakura-back-end-plugin/assets/css/grid.css", array(), $version, "all");
    // wp_enqueue_style("sakura_back_table-style", get_template_directory_uri() . "/sakura-back-end-plugin/assets/css/table.css", array(), $version, "all");
    wp_enqueue_style("sakura_back_div-style", get_template_directory_uri() . "/sakura-back-end-plugin/assets/css/div.css", array(), $version, "all");
    wp_enqueue_style("sakura_back_end_font_awesome", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", array(), "4.7.0", "all");
}

function load_scripts() {
    $version = wp_get_theme()->get("Version");

    // wp_enqueue_script("sakura_back_end_cookie_state", get_template_directory_uri() . "/sakura-back-end-plugin/assets/js/cookie-state.js", array() , $version, true);
    // wp_enqueue_script("sakura_back_end_menu_bar", get_template_directory_uri() . "/sakura-back-end-plugin/assets/js/menu-bar.js", array() , $version, true);
    // wp_enqueue_script("sakura_back_end_states", get_template_directory_uri() . "/sakura-back-end-plugin/assets/js/states.js", array() , $version, true);
    wp_enqueue_script("sakura_back_end_main", get_template_directory_uri() . "/sakura-back-end-plugin/assets/js/main.js", array() , $version, true);
}

// add styles for admin
add_action("admin_enqueue_scripts", "load_styles");

// add scripts for admin
add_action("admin_enqueue_scripts", "load_scripts");

// menus
require_once("bar.php");
require_once("menus.php");