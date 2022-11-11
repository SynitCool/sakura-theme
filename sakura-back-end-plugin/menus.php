<?php
require_once("database/sakura-database.php");
require_once("admin/sakura-admin.php");

add_action( 'admin_menu', 'menu_init');

function admin_menu_add_external_links_as_submenu() {
    global $submenu;

    $menu_slug = "externallink"; // used as "key" in menus
    $menu_pos = 2; // whatever position you want your menu to appear

    // create the top level menu
    add_menu_page( 'external_link', 'How-to...', 'read', $menu_slug, '', '', $menu_pos);
    
    // add the external links to the slug you used when adding the top level menu
    $submenu[$menu_slug][] = array('<div id="newtab1">...create CPT</div>', 'manage_options', 'sakura-admin-database.php?page=database');
    $submenu[$menu_slug][] = array('<div id="newtab2">...use Blocks</div>', 'manage_options', 'https://wpsimplehacks.com/how-to-use-blocksy-content-blocks-hooks-full-tutorial/'); 
  	$submenu[$menu_slug][] = array('<div id="newtab3">...get discounts</div>', 'manage_options', 'https://wpsimplehacks.com/start-here/'); 

function admin_menu_add_external_links_as_submenu_jquery() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready( function($) {   
            $('#newtab1').parent().attr('target','_blank');
            $('#newtab2').parent().attr('target','_blank');  
	    $('#newtab3').parent().attr('target','_blank');
        });
    </script>
    <?php
}
}

function menu_init() {
    add_menu_page( 
        "Sakura Admin", 
        "Sakura Admin", 
        "manage_options", 
        "sakura_admin",
        "submenu_page",
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