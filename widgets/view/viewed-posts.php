<?php

if( !defined( 'ABSPATH' ) )
    exit;

?>
<?= $args['before_widget']; ?>
    <h2 class="widgettitle"><?= $instance['title']; ?></h2>

    <?php
    $the_query = new WP_Query( $query_args );

    if( $the_query->have_posts() ) :
        ?>
        <ul class="viewed-posts">
            <?php
            while( $the_query->have_posts() ) : $the_query->the_post(); ?>

                <li>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                        <?php if( !empty( $instance["view_count"] ) ) : ?>
                            <div class="pull-right views-count">
                                <span class="dashicons dashicons-visibility"></span>
                                <span class="counter"><?= pvc_get_views(); ?></span>
                            </div>
                        <?php endif; ?>
                    </a>
                </li>

            <?php endwhile;
            wp_reset_query(); ?>
        </ul>
    <?php endif; ?>
<?= $args['after_widget']; ?>