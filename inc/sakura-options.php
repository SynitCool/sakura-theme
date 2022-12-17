<?php

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