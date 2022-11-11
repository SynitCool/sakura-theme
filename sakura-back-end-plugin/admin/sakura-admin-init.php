<?php
require_once('sakura-admin.php');
require_once('includes/get-option.php');

add_action( 'admin_init', 'init' );

function init() {
    // Register a new setting for "sakura_admin" page.
    register_setting( 'sakura_admin', 'sakura_backend_option' );

    theme_support_section();
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