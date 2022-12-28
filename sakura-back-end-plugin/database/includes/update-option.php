<?php

namespace DatabaseIncludes;

function update_option_profile_database($new_option) {
    $options_name = "sakura_backend_option";
    $option_profile_database_name = "profile_database";

    $current_options = get_option($options_name);
    $current_options[$option_profile_database_name] = $new_option;

    update_option( $options_name, $current_options );
}

function update_option_profile_table($new_option) {
    $options_name = "sakura_backend_option";
    $option_profile_table_name = "profile_table";

    $current_options = get_option($options_name);
    $current_options[$option_profile_table_name] = $new_option;

    update_option( $options_name, $current_options );
}
