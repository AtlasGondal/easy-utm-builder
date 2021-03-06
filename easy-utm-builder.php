<?php

/*
Plugin Name:        Easy UTM Builder
Plugin URI:         http://www.AtlasGondal.com/
Description:        This plugin will help you in building URLs with UTM parameters for all of your site or custom post types!
Version:            1.1
Author:             Atlas Gondal
Author URI:         http://www.AtlasGondal.com/
License:            GPL v2 or higher
License URI:        License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if( ! defined( 'WPINC') )
    die;

function easy_utm_builder_nav(){

    add_options_page(
        'Easy UTM Builder',
        'Easy UTM Builder',
        'manage_options',
        'easy-utm-builder-settings',
        'include_easy_utm_builder_settings_page'
    );

}


add_action( 'admin_menu', 'easy_utm_builder_nav' );

function include_easy_utm_builder_settings_page(){

    require_once plugin_dir_path( __FILE__ ) . 'easy-utm-builder-settings.php';

}


function easy_utm_builder_on_activate() {
    set_transient( 'eub_easy_utm_builder_activation_redirect', true, 30 );
}

register_activation_hook( __FILE__, 'easy_utm_builder_on_activate' );

function easy_utm_builder_activation() {

    if ( ! get_transient( 'eub_easy_utm_builder_activation_redirect' ) ) {
        return;
    }

    delete_transient( 'eub_easy_utm_builder_activation_redirect' );

    wp_safe_redirect( add_query_arg( array( 'page' => 'easy-utm-builder-settings' ), admin_url( 'options-general.php' ) ) );


}
add_action( 'admin_init', 'easy_utm_builder_activation' );

add_filter( 'admin_footer_text', 'eub_admin_footer_text' );
function eub_admin_footer_text( $footer_text ) {

    $current_screen = get_current_screen();

    $is_easy_utm_builder_screen = ( $current_screen && false !== strpos( $current_screen->id, 'easy-utm-builder-settings' ) );

    if ( $is_easy_utm_builder_screen ) {
        $footer_text = 'Enjoyed <strong>Easy UTM Builder</strong>? Please leave us a <a href="https://wordpress.org/support/plugin/easy-utm-builder/reviews/?filter=5#new-post" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. We really appreciate your support! ';
    }

    return $footer_text;
}