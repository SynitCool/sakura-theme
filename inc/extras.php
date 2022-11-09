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


/*
 * Header Logo
 */
function sakura_theme_get_header_logo() {
	$logo_id = get_theme_mod( 'custom_logo', '' );
	$logo    = wp_get_attachment_image_src( $logo_id, 'full' ); 

    ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php
        if ( $logo != '' ) { ?>
            <img src="<?php echo esc_url( $logo[0] ); ?>"
                alt="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>"><?php
        } else { ?>
            <span class="site-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span><?php
        } ?>
	</a><?php
}

/*
 * Loading animation
 */
function sakura_theme_loading() {
    $path_gif = get_template_directory_uri() . "/assets/images/loading.gif";

    ?>
    <div class="loader">
        <img 
            src="<?php echo $path_gif ?>" 
            alt="#"
        />
    <?php
}


























