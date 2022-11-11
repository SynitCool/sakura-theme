<?php
require_once("database/sakura-database.php");
require_once("admin/sakura-admin.php");

add_action( 'admin_menu', 'menu_init');

function menu_init() {
    add_menu_page( 
        "Sakura Admin", 
        "Sakura Admin", 
        "manage_options", 
        "sakura_admin",
        "sakura_admin_page",
        $icon_url = "dashicons-admin-generic",
        $position = 2
    );

    add_submenu_page( 
        "sakura_admin", 
        "Sakura Database",
        "Sakura Database",
        "manage_options", 
        "sakura_database",
        "new_menu_page",
        $position = 1
    );
}