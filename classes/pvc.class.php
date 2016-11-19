<?php

namespace PVC;

if( !defined( 'ABSPATH' ) )
    exit;

class PVC
{
    public static function plugin_activation() {
        update_option( 'views_counter_data', \PVC\Settings::get_settings() );
    }

    public static function plugin_deactivation() {

    }

    public static function wp() {
        global $post;
        if( !is_admin() && ( is_singular() ) ) {
            if( in_array( get_post_type( $post->ID ), \PVC\Settings::get_settings()["post_types"] ) ) {
                $views = get_post_meta( $post->ID, '_views', true );
                if( !$views )
                    $views = array( 0, 0 );
                if( !is_array( $views ) )
                    $views = array( intval( $views ), 0 );
                $views[0] = intval( $views[0] ) + 1;
                if( is_user_logged_in() )
                    $views[1] = intval( $views[1] ) + 1;
                update_post_meta( $post->ID, '_views', $views );
            }
        }
    }

    public static function init() {
        load_plugin_textdomain( 'pvc', '', 'views-counter/languages/' );
    }

    public static function init_widget() {
        register_widget( 'PVC\Widget_Viewed_Posts' );
    }

    public static function edit_view_count( $post ) {
        if( in_array( get_post_type( $post->ID ), \PVC\Settings::get_settings()["post_types"] ) ) {
            if( \PVC\Settings::get_settings()["authorized"] == 'on' ) {
                $str = "<div class='misc-pub-section' id='visibility'> %s <span style='font-weight:bold;'>%s</span> (<span style='font-weight:bold;'>%s</span> %s)</div>";
                echo sprintf( $str, esc_html__( "Views:", 'pvc' ), esc_html( pvc_get_views( $post->ID ) ), esc_html( pvc_get_views_authorized( $post->ID ) ), esc_html__( "authorized", 'pvc' ) );
            }
            else {
                $str = "<div class='misc-pub-section' id='visibility'> %s <span style='font-weight:bold;'>%s</span></div>";
                echo sprintf( $str, esc_html__( "Views:", 'pvc' ), esc_html( pvc_get_views( $post->ID ) ) );
            }
        }
    }
}