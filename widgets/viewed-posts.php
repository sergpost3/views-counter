<?php

namespace PVC;

if( !defined( 'ABSPATH' ) )
    exit;

class Widget_Viewed_Posts extends \WP_Widget
{
    public function __construct() {
        parent::__construct( "widget_viewed_posts", __( 'Viewed posts', 'pvc' ),
            array( "description" => __( 'Display the most viewed posts', 'pvc' ) ) );
    }

    public function form( $instance ) {
        $title = "";
        $count = 5;
        $view_count = true;

        if( !empty( $instance ) ) {
            $title = $instance["title"];
            $count = intval( $instance["count"] );
            $view_count = empty( $instance["view_count"] ) ? false : true;
        }

        $tableId = $this->get_field_id( "title" );
        $tableName = $this->get_field_name( "title" );
        echo "<p><label for='{$tableId}'>" . __( "Block name", "pvc" ) . "</label><br />";
        echo "<input id='{$tableId}' type='text' name='{$tableName}' value='{$title}'></p>";

        $tableId = $this->get_field_id( "count" );
        $tableName = $this->get_field_name( "count" );
        echo "<p><label for='{$tableId}'>" . __( "Posts count: ", "pvc" ) . "</label>";
        echo "<input class='tiny-text' id='{$tableId}' name='{$tableName}' type='number' step='1' min='1' value='{$count}' size='3'></p>";

        $tableId = $this->get_field_id( "view_count" );
        $tableName = $this->get_field_name( "view_count" );
        if( $view_count )
            echo "<p><input class='checkbox' checked='checked' type='checkbox' id='{$tableId}' name='{$tableName}'>";
        else
            echo "<p><input class='checkbox' type='checkbox' id='{$tableId}' name='{$tableName}'>";
        echo "<label for='{$tableId}'>" . __( "Show views?", "pvc" ) . "</label></p>";
    }

    public function update( $newInstance, $oldInstance ) {
        $values = array();
        $values["title"] = htmlentities( $newInstance["title"] );
        $values["count"] = htmlentities( $newInstance["count"] );
        $values["view_count"] = htmlentities( $newInstance["view_count"] );
        return $values;
    }

    public function widget( $args, $instance ) {
        $query_args = array(
            "numberposts" => $instance['count'],
            "posts_per_page" => $instance['count'],
            'meta_key' => '_views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );

        include( PVC__PLUGIN_DIR . "/widgets/view/viewed-posts.php" );
    }
}