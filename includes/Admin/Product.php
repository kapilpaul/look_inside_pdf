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
        add_action( 'woocommerce_product_options_downloads', [ $this, 'render_look_inside_pdf_product_option' ] );
        add_action( 'woocommerce_process_product_meta', [ $this, 'store_look_inside_pdf_product_option' ] );
    }

    /**
     * Render pdf file input html
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function render_look_inside_pdf_product_option() {
        $the_post_id    = get_the_ID();
        $product_object = $the_post_id ? wc_get_product( $the_post_id ) : '';

        $_li_pdf_file = '';
        if ( $product_object ) {
            $_li_pdf_file = get_post_meta( $the_post_id, '_li_pdf_file', true );
        }

        woocommerce_wp_text_input(
            [
                'id'          => '_li_pdf_file',
                'value'       => $_li_pdf_file,
                'label'       => __( 'Look Inside PDF File', 'look-inside-pdf' ),
                'placeholder' => __( 'https://', 'look-inside-pdf' ),
                'description' => __( 'Enter the file link for demo book', 'look-inside-pdf' ),
                'type'        => 'text',
            ]
        );
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
        $post_data = wp_unslash( $_POST );

        if (
            ! isset( $post_data['woocommerce_meta_nonce'] ) ||
            ! wp_verify_nonce( $post_data['woocommerce_meta_nonce'], 'woocommerce_save_data' )
        ) {
            return false;
        }

        $_li_pdf_file = sanitize_text_field( $post_data['_li_pdf_file'] );

        update_post_meta( $post_id, '_li_pdf_file', $_li_pdf_file );
    }
}
