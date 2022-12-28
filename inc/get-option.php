<?php

namespace SarthemIncludes;

function get_option_season_support() {
    $options = get_option('sakura_backend_option');
    
    return $options["season_support"];
}

function get_option_theme_season() {
    $options = get_option('sakura_backend_option');
    
    return $options["theme_season"];
}

function get_option_sound() {
    $options = get_option('sakura_backend_option');
    
    return $options["sound"];
}

function get_option_profile_feature() {
    $options = get_option('sakura_backend_option');

    return $options["profile_feature"];
}

function get_option_profile_database() {
    $options = get_option('sakura_backend_option');

    return $options["profile_database"];
}

function get_option_profile_table() {
    $options = get_option('sakura_backend_option');

    return $options["profile_table"];
}