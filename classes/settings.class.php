<?php

namespace PVC;

if( !defined( 'ABSPATH' ) )
    exit;

class Settings
{
    public static function add_submenu_page() {
        add_submenu_page(
            'options-general.php',
            __( "Page Views", 'pvc' ),
            __( "Page Views", 'pvc' ),
            'manage_options',
            'page-views',
            array( "PVC\Settings", "page" )
        );
    }

    public static function page() {
        if( !empty( $_POST ) && wp_verify_nonce( $_POST['_wpnonce'], 'pvc-settings-update' ) )
            self::save_settings();
        $settings = self::get_settings();
        include( PVC__PLUGIN_DIR . "views/settings.php" );
    }

    public static function get_settings() {
        $settings = get_option( "views_counter_data" );
        if( !$settings )
            $settings = self::get_default_settings();
        else
            $settings = array_merge( self::get_default_settings(), $settings );
        return $settings;
    }

    private static function save_settings() {
        if( !empty( $_POST['pvc'] ) )
            $data = $_POST['pvc'];
        else
            $data = array();

        $data['authorized'] = self::get_checkbox_value( 'authorized' );

        $data = self::validate_data( $data );
        $data = self::sanitize_data( $data );

        update_option( 'views_counter_data', $data );
    }

    private static function validate_data( $data ) {
        if( empty( $data ) || !is_array( $data ) )
            return self::get_default_settings();

        if( empty( $data['authorized'] ) || !in_array( $data['authorized'], array( 'on', 'off' ) ) )
            $data['authorized'] = 'off';

        $post_types = get_post_types( array( "public" => true ) );
        if( !is_array( $data['post_types'] ) )
            $data['post_types'] = array();
        else {
            foreach( $data['post_types'] as $key => $type )
                if( !in_array( $type, $post_types ) )
                    unset( $data['post_types'][$key] );
        }

        return $data;
    }

    private static function sanitize_data( $data ) {
        foreach( $data as $key => $value )
            if( is_array( $data[$key] ) )
                $data[$key] = self::sanitize_data( $value );
            else
                $data[$key] = sanitize_text_field( $value );

        return $data;
    }

    private static function get_default_settings() {
        return array(
            'post_types' => array( 'post', 'page' ),
            'authorized' => 'on'
        );
    }

    private static function get_checkbox_value( $key ) {
        return ( !empty( $_POST['pvc'][$key] ) && $_POST['pvc'][$key] == 'on' ) ? 'on' : 'off';
    }
}