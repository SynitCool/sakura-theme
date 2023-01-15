<?php

function get_option_season_support() {
    $options = get_option('sakura_backend_option');
    
    return $options["season_support"];
}

function get_option_theme_season() {
    $options = get_option('sakura_backend_option');

    if (array_key_exists("theme_season", $options)) {
        return $options["theme_season"];
    }

    return false;
}

function get_option_sound() {
    $options = get_option('sakura_backend_option');
    
    return $options["sound"];
}

function get_option_profile_feature() {
    $options = get_option('sakura_backend_option');

    if (array_key_exists("profile_feature", $options)) {
        return $options["profile_feature"];
    }

    return false;
}

function get_option_profile_database() {
    $options = get_option('sakura_backend_option');

    if (array_key_exists("profile_database", $options)) {
        return $options["profile_database"];
    }

    return false;
}

function get_option_profile_table() {
    $options = get_option('sakura_backend_option');

    if (array_key_exists("profile_table", $options)) {
        return $options["profile_table"];
    }

    return false;
}