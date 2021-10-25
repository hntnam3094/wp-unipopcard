<?php

function theme_setup() {
    register_nav_menu('left-menu',__( 'Menu trái' ));
    register_nav_menu('right-menu',__( 'Menu phải' ));
}
add_action('init', 'theme_setup');

add_filter ( 'nav_menu_css_class', 'so_37823371_menu_item_class', 10, 4 );

function so_37823371_menu_item_class ( $classes, $item, $args, $depth ){
    $classes[] = 'nav-item';
    return $classes;
}
