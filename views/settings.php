<?php

if( !defined( 'ABSPATH' ) )
    exit;

?>
<div class="wrap">
    <h1><?= esc_html__( 'Page Views Settings', 'pvc' ); ?></h1>

    <form method="post" action="" novalidate="novalidate">
        <?php wp_nonce_field( 'pvc-settings-update' ); ?>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="post_types"><?= esc_html__( 'Post Types', 'pvc' ); ?></label></th>
                <td>
                    <select name="pvc[post_types][]" id="post_types" multiple="multiple">
                        <?php foreach( get_post_types( array( "public" => true ), 'objects' ) as $name => $type ) : ?>
                            <option value="<?= esc_attr( $name ); ?>" <?php if( in_array( $name, $settings['post_types'] ) )
                                echo "selected='selected'"; ?>><?= esc_attr( $type->labels->name ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= esc_html__( 'Additional for authorized', 'pvc' ); ?></th>
                <td>
                    <fieldset>
                        <label for="authorized">
                            <?php if( $settings['authorized'] == 'on' ): ?>
                                <input name="pvc[authorized]" type="checkbox" id="authorized" value="on" checked="checked">
                            <?php else : ?>
                                <input name="pvc[authorized]" type="checkbox" id="authorized" value="on">
                            <?php endif; ?>
                            <?= esc_html__( 'Additional statistic for authorized users', 'pvc' ); ?>
                        </label>
                    </fieldset>
                </td>
            </tr>
        </table>

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?= esc_html__( 'Save', 'pvc' ); ?>">
        </p>
    </form>
</div>