<div class="wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e( 'Look Inside PDF Settings', 'look-inside-pdf' ); ?></h1>

    <?php do_action( 'lipdf_settings_before_form' ); ?>

    <form method="post" action="options.php">
        <?php settings_fields( 'lipdf-settings' ); ?>
        <?php do_settings_sections( 'lipdf-settings' ); ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">Read Button Text</th>
                <td>
                    <input class="widefat" type="text" name="_lipdf_read_button_text" value="<?php echo get_option( '_lipdf_read_button_text' ); ?>"/>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Show Read Button</th>
                <td>
                    <select name="_lipdf_show_read_button" class="widefat">
                        <option value="yes" <?php echo 'yes' === get_option( '_lipdf_show_read_button' ) ? 'selected' : ''; ?> >Yes</option>
                        <option value="no" <?php echo 'no' === get_option( '_lipdf_show_read_button' ) ? 'selected' : ''; ?>>No</option>
                    </select>
                </td>
            </tr>

            <?php do_action( 'lipdf_settings_after_fields' ); ?>
        </table>

        <?php submit_button(); ?>
    </form>

    <?php do_action( 'lipdf_settings_after_form' ); ?>
</div>
