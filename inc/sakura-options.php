<?php

namespace SarthemIncludes;

function get_theme_option() {
    $options = get_option( "sakura_backend_option" );
    $season_support = $options["season_support"];

    if ($season_support == "auto") {
        return "auto";
    }

    $theme_season = $options["theme_season"];

    return $theme_season;
}

function get_sound_option() {
    $options = get_option( "sakura_backend_option" );
    $sound = $options["sound"];

    return $sound;
}

function create_option_standard() {
    $options_name = "sakura_backend_option";
    $options = array();
    $options["season_support"] = "auto";
    $options["sound"] = "on";
    $options["profile_feature"] = "off";

    add_option($options_name, $options);
}

function check_option_standard() {
    $options_name = "sakura_backend_option";
    $standard_option_columns = array("season_support", "sound", "profile_feature");

    $options = get_option($options_name);
    if (!$options) return create_option_standard();

    foreach ($standard_option_columns as $column) {
        if (!array_key_exists($column, $options)) {
            update_option_standard();
            break;
        }
    }
}

function update_option_standard() {
    $options_name = "sakura_backend_option";
    $standard_option = array("season_support", "sound", "profile_feature");
    $standard_option["season_support"] = "auto";
    $standard_option["sound"] = "on";
    $standard_option["profile_feature"] = "off";

    $options = get_option($options_name);

    update_option($options_name, $standard_option);
}