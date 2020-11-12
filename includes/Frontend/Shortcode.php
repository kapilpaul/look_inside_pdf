<?php

namespace DCoders\LookInsidePdf\Frontend;

/**
 * Class Shortcode
 * @package DCoders\LookInsidePdf\Frontend
 *
 * @author Kapil Paul
 */
class Shortcode {

    /**
     * Shortcode constructor.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct() {
        add_shortcode( 'look_inside_pdf', [ $this, 'render_frontend' ] );
    }

    /**
     * Render frontend app
     *
     * @param array $atts
     * @param string $content
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function render_frontend( $atts, $content = '' ) {

    }
}
