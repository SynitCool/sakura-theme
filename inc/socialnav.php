<?php

/**
 * Social Navigation Menu
 */

if ( ! function_exists( 'sakura_theme_social_icons' ) ) :
	/**
	 * Display social links in footer and widgets
	 * 
	 */
	function sakura_theme_social_icons() {
		if ( has_nav_menu('social-menu') ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'social-menu',
					'container'       => '',
					'menu_class'      => 'social_icon',
					'link_before'     => '<i class="fa"><span>',
					'link_after'      => '</span></i>'
				)
			);
		}
	}
endif;