<?php

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 *
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: DOKAN_MIGRATOR_PATH)
 *
 * @return void
 */
function lipdf_get_template( $template_name, $args = [], $template_path = '', $default_path = LOOK_INSIDE_PDF_PATH ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $located = $default_path . '/templates/' . $template_name;

    if ( ! file_exists( $located ) ) {
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', esc_html( $located ) ), '0.1' );

        return;
    }

    include( $located );
}
