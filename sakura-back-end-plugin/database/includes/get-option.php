<?php

namespace DatabaseIncludes;

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