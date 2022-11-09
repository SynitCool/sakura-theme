<?php
require_once('sakura-admin.php');

add_action( 'admin_init', 'init' );

function init() {
    // Register a new setting for "sakura_admin" page.
    register_setting( 'sakura_admin', 'sakura_backend_option' );
    // Register a new section in the "sakura_admin" page.
    add_settings_section( 
        'sakura_admin_section', 
        __( 'Sakura Admin', 'sakura_backend' ), 
        'section_callback', 
        'sakura_admin');
    // Register a new field in the "sakura_admin_section" section, inside the "sakura_admin" page.
    add_settings_field( 
        'sakura_admin_field', 
        __('Options', 'sakura_backend'), 
        'field_callback' ,
        'sakura_admin', 
        'sakura_admin_section',
        array(
            'label_for'         => 'wporg_field_pill',
            'class'             => 'wporg_row',
            'wporg_custom_data' => 'custom',
        )
    );
}