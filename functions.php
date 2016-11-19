<?php

if( !defined( 'ABSPATH' ) )
    exit;

function pvc_views( $postID = 0 ) {
    echo pvc_get_views( $postID );
}

function pvc_get_views( $postID = 0 ) {
    $post = get_post( $postID );
    return pvc_get_post_views( $post->ID );
}

function pvc_get_post_views( $postID ) {
    $views = get_post_meta( $postID, '_views', true );
    if( !$views )
        return 0;
    if( !is_array( $views ) )
        return intval( $views );
    return intval( $views[0] );
}

function pvc_views_authorized( $postID = 0 ) {
    echo pvc_get_views_authorized( $postID );
}

function pvc_get_views_authorized( $postID = 0 ) {
    $post = get_post( $postID );
    return pvc_get_post_views_authorized( $post->ID );
}

function pvc_get_post_views_authorized( $postID ) {
    $views = get_post_meta( $postID, '_views', true );
    if( !$views || !is_array( $views ) )
        return 0;
    return intval( $views[1] );
}