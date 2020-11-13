<?php

namespace DCoders\LookInsidePdf\Frontend;

/**
 * Class Product
 * @package DCoders\LookInsidePdf\Frontend
 *
 * @since 1.0.0
 *
 * @author Kapil Paul
 */
class Product {
    /**
     * Product constructor.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct() {
        add_action( 'woocommerce_product_thumbnails', [ $this, 'render_view_pdf_button' ] );
    }

    /**
     * Render view pdf button
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function render_view_pdf_button() {
        global $post;

        $product = wc_get_product( $post->ID );

        if ( ! $product ) {
            return false;
        }

        $_li_pdf_file = get_post_meta( $product->get_id(), '_li_pdf_file', true );

        if ( ! $_li_pdf_file ) {
            return false;
        }

        $read_button_text       = get_option( '_lipdf_read_button_text' );
        $show_button            = get_option( '_lipdf_show_read_button' );
        $button_class           = 'no' === $show_button ? 'donot_show_lipdf_btn' : 'button alt';
        $button_container_class = 'yes' === $show_button ? 'show_lipdf_button_container' : '';

        lipdf_get_template( 'product/single.php', [
            'pdf_url'                => $_li_pdf_file,
            'read_button_text'       => $read_button_text,
            'button_class'           => $button_class,
            'button_container_class' => $button_container_class,
        ] );
    }
}
