<?php

namespace DCoders\LookInsidePdf\Admin;

/**
 * Class Product
 * @package DCoders\LookInsidePdf\Admin
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
        add_action( 'woocommerce_product_options_general_product_data', [ $this, 'render_look_inside_pdf_gallery_product_option' ] );
        add_action( 'woocommerce_process_product_meta', [ $this, 'store_look_inside_pdf_product_option' ] );
    }

    /**
     * Render pdf gallery option
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function render_look_inside_pdf_gallery_product_option() {
        $the_post_id    = get_the_ID();
        $product_object = $the_post_id ? wc_get_product( $the_post_id ) : '';

        $_li_pdf_images = [];

        if ( $product_object ) {
            $_li_pdf_images = get_post_meta( $the_post_id, '_li_pdf_images', true );
            $_li_pdf_images = explode( ',', $_li_pdf_images );
        }

        lipdf_get_template( 'admin/product/options.php', [
            'li_pdf_images' => $_li_pdf_images,
        ] );
    }

    /**
     * Store pdf file url
     *
     * @param $post_id
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function store_look_inside_pdf_product_option( $post_id ) {
        $woocommerce_meta_nonce = sanitize_key( $_POST['woocommerce_meta_nonce'] );

        if (
            ! isset( $woocommerce_meta_nonce ) ||
            ! wp_verify_nonce( $woocommerce_meta_nonce, 'woocommerce_save_data' )
        ) {
            return false;
        }

        if ( ! isset( $_POST['_li_pdf_images'] ) ) {
            return false;
        }

        $_li_pdf_images = sanitize_text_field( $_POST['_li_pdf_images'] );

        update_post_meta( $post_id, '_li_pdf_images', $_li_pdf_images );
    }
}
