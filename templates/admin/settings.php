<div class="wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e( 'Look Inside PDF Settings', 'look-inside-pdf' ); ?></h1>

    <?php do_action( 'lipdf_settings_before_form' ); ?>

    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php settings_fields( 'lipdf-settings' ); ?>
        <?php do_settings_sections( 'lipdf-settings' ); ?>

        <table class="form-table">
            <?php
            foreach ( $input_fields as $key => $input ) {
                switch ( $input['type'] ) {
                    case 'text' :
            ?>

            <tr valign="top" class="<?php echo $key; ?>">
                <th scope="row"><?php echo $input['label']; ?></th>
                <td>
                    <input id="<?php echo $input['id']; ?>" class="<?php echo $input['class']; ?>" type="text" name="<?php echo $key; ?>" value="<?php echo $input['value']; ?>" placeholder="<?php echo $input['placeholder']; ?>"/>
                </td>
            </tr>

            <?php
                        break;
                    case 'select' :
            ?>
            <tr valign="top" class="<?php echo $key; ?>">
                <th scope="row"><?php echo $input['label']; ?></th>
                <td>
                    <select id="<?php echo $input['id']; ?>" name="<?php echo $key; ?>" class="<?php echo $input['class']; ?>">
                        <?php
                        foreach ( $input['options'] as $option_key => $option ) {
                            $selected = $option_key === get_option( $key ) ? 'selected' : '';
                            echo "<option value=\"{$option_key}\" {$selected}>{$option}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?php
                        break;
            ?>
            <?php } } ?>

            <?php do_action( 'lipdf_settings_after_fields' ); ?>
        </table>

        <?php submit_button(); ?>
    </form>

    <?php do_action( 'lipdf_settings_after_form' ); ?>
</div>
