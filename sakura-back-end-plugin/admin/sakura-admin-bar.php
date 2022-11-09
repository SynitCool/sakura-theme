<?php

// First level menu
add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
	$admin_bar->add_menu( array(
		'id'    => 'my-item',
		'title' => 'All tutorials', // Your menu title
		'href'  => 'https://know.local/', // URL
		'meta'  => array(
		 'target' => '_blank',
		),
	));

  // Submenus
	$admin_bar->add_menu( array(
		'parent' => 'my-item',
		'title' => 'Remove admin menus', // Your submenu title
		'href'  => 'https://wpsimplehacks.com/how-to-remove-wordpress-admin-menu-items/', // URL
		'meta'  => array(
		'target' => '_blank',
		),
	));
		$admin_bar->add_menu( array(
		'parent' => 'my-item',
		'title' => 'Custom Admin Dashboard',
		'href'  => 'https://wpsimplehacks.com/how-to-create-custom-wordpress-admin-dashboard/',
		'meta'  => array(
		'target' => '_blank',
		),
	));  
	$admin_bar->add_menu( array(
		'parent' => 'my-item',
		'title' => 'Block Patterns',
		'href'  => 'https://wpsimplehacks.com/how-to-create-wordpress-block-patterns-and-reusable-blocks/',
		'meta'  => array(
		'target' => '_blank',
		),
	));
}