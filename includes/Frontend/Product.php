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

        if ( 'yes' === get_option( '_lipdf_show_read_more_button_after_add_to_cart_button', 'yes' ) ) {
            add_action( 'woocommerce_after_add_to_cart_button', [ $this, 'render_view_pdf_button_after_add_to_cart' ] );
        }
    }

    /**
     * Render view pdf button
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function render_view_pdf_button() {
        if ( ! $_li_pdf_images = $this->validate() ) {
            return false;
        }

        $show_on_product_thumb                           = get_option( '_lipdf_type_of_data_show_on_product_thumb', 'image' );
        $lipdf_read_more_image_link                      = 'image' === $show_on_product_thumb ? get_option( '_lipdf_read_more_image_link' ) : '';
        $lipdf_read_more_button_text                     = get_option( '_lipdf_read_more_button_text', 'Read More' );
        $lipdf_show_read_more_button_after_product_thumb = get_option( '_lipdf_show_read_more_button_after_product_thumb', 'yes' );

        lipdf_get_template( 'product/single.php', [
            'li_pdf_images'                                   => $_li_pdf_images,
            'show_on_product_thumb'                           => $show_on_product_thumb,
            'lipdf_read_more_image_link'                      => $lipdf_read_more_image_link,
            'lipdf_read_more_button_text'                     => $lipdf_read_more_button_text,
            'lipdf_show_read_more_button_after_product_thumb' => $lipdf_show_read_more_button_after_product_thumb,
        ] );
    }

    /**
     * Render view pdf button after add to cart button
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function render_view_pdf_button_after_add_to_cart() {
        if ( ! $this->validate() ) {
            return false;
        }

        $lipdf_read_more_button_text                          = get_option( '_lipdf_read_more_button_text', 'Read More' );
        $lipdf_show_read_more_button_after_add_to_cart_button = get_option( '_lipdf_show_read_more_button_after_add_to_cart_button', 'yes' );

        lipdf_get_template( 'product/after-add-to-cart.php', [
            'lipdf_read_more_button_text'                          => $lipdf_read_more_button_text,
            'lipdf_show_read_more_button_after_add_to_cart_button' => $lipdf_show_read_more_button_after_add_to_cart_button,
        ] );
    }

    /**
     * Validate wc product page and li pdf images
     *
     * @since 1.0.0
     *
     * @return array|bool|mixed
     */
    public function validate() {
        global $post;

        $product = wc_get_product( $post->ID );

        if ( ! $product ) {
            return false;
        }

        $_li_pdf_images = get_post_meta( $product->get_id(), '_li_pdf_images', true );

        if ( ! $_li_pdf_images ) {
            return false;
        }

        $_li_pdf_images = explode( ',', $_li_pdf_images );

        return $_li_pdf_images;
    }
}
