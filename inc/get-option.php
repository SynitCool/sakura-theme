<?php

namespace SarthemIncludes;

function get_option_profile_feature() {
    $options = get_option('sakura_backend_option');

    return $options["profile_feature"];
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