<?php
require_once('sakura-admin.php');
require_once('includes/get-option.php');
require_once('includes/database.php');

add_action( 'admin_init', 'init' );

function init() {
    // Register a new setting for "sakura_admin" page.
    register_setting( 'sakura_admin', 'sakura_backend_option' );

    theme_support_section();
    profile_feature_section();
}

function profile_feature_section() {
    add_settings_section( 
        'profile_section', 
        __('Profile Feature', 'sakura_backend'), 
        'profile_section', 
        'sakura_admin' 
    );

    add_settings_field( 
        'profile_feature_field', 
        __('Profile Feature', 'sakura_backend'), 
        'profile_feature_field', 
        'sakura_admin', 
        'profile_section',
        array(
            'label_for' => 'profile_feature',
            'custom_data' => 'profile_feature'
        )
    );

    if (get_option_profile_feature() == "on") {
        add_settings_field( 
            'profile_database_field', 
            __('Profile Database', 'sakura_backend'), 
            'profile_database_field', 
            'sakura_admin', 
            'profile_section',
            array(
                'label_for' => 'profile_database',
                'custom_data' => 'profile_database'
            )
        );
    }

    
    # ERROR
    if (
        (get_option_profile_feature() == "on") &&
        (!in_array(get_option_profile_database(), array("no-selected", false)))) {
            
        $selected_database = get_option_profile_database();
        $tables = AdminIncludes\get_tables($selected_database);

        $valid_tables = AdminIncludes\check_table_feature($selected_database, $tables, "profile");

        if (!empty($valid_tables)) {
            add_settings_field( 
                'profile_table_field', 
                __('Profile Table', 'sakura_backend'), 
                'profile_table_field', 
                'sakura_admin', 
                'profile_section',
                array(
                    'label_for' => 'profile_table',
                    'custom_data' => 'profile_table',
                    'valid_tables' => $valid_tables
                )
            );
        }
    }
}

function theme_support_section() {
    add_settings_section( 
        'theme_section', 
        __('Theme Support', 'sakura_backend'), 
        'theme_section', 
        'sakura_admin' 
    );
    
    add_settings_field( 
        'season_support_field', 
        __('Season Support', 'sakura_backend'), 
        'season_support_field', 
        'sakura_admin', 
        'theme_section',
        array(
            'label_for' => 'season_support',
            'custom_data' => 'season_support'
        )
    );

    if (get_option_season_support() == "manual") {
        add_settings_field( 
            'theme_season_field', 
            __('Theme Season', 'sakura_backend'), 
            'theme_season_field', 
            'sakura_admin', 
            'theme_section',
            array(
                'label_for' => 'theme_season',
                'custom_data' => 'theme_season'
            )
        );
    }
        
    add_settings_field( 
        'sound_field', 
        __('Sound', 'sakura_backend'), 
        'sound_field', 
        'sakura_admin', 
        'theme_section',
        array(
            'label_for' => 'sound',
            'custom_data' => 'sound'
        )
    );
}