<?php

if ( ! function_exists( 'sakura_theme_header_menu' ) ) :
	/**
	 * Header menu (should you choose to use one)
	 */
	function sakura_theme_header_menu() {
		// display the WordPress Custom Menu if available
        if (has_nav_menu('primary')) {
            wp_nav_menu( array(
                             'menu'            => 'primary',
                             'theme_location'  => 'primary',
                             'depth'           => 3,
                             'container'       => '',
                             'menu_class'      => 'navbar-nav mx-auto',
                             'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                             'walker'          => new wp_bootstrap_navwalker(),
                         ) );
        }

        // wp_nav_menu(
        //     array(
        //        'menu' => 'primary',
        //        'container' => '',
        //        'theme_locations' => 'primary',
        //        'menu_class'    => 'navbar-nav mx-auto',
        //        'list_item_class'  => 'nav-item',
        //        'link_class'   => 'nav-link'
        //     )
        //  );
	} /* end header menu */
endif;