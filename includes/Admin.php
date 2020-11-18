<?php

namespace DCoders\LookInsidePdf;

use DCoders\LookInsidePdf\Admin\Product;

/**
 * Class Admin
 * @package DCoders\LookInsidePdf
 *
 * @author Kapil Paul
 */
class Admin {

    /**
     * Initialize the class
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        $this->set_classes();
    }

    /**
     * Set classes
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function set_classes() {
        $container            = lookinsidepdf()->container;
        $container['product'] = new Product();
    }

    /**
     * Register Settings
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_settings() {
        $options = [
            '_lipdf_type_of_data_show_on_product_thumb',
            '_lipdf_read_more_image_link',
            '_lipdf_read_more_button_text',
            '_lipdf_show_read_more_button_after_product_thumb',
            '_lipdf_show_read_more_button_after_add_to_cart_button',
        ];

        foreach ( $options as $option ) {
            register_setting( 'lipdf-settings', $option );
        }
    }

    /**
     * Set admin menu
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function admin_menu() {
        add_submenu_page(
            'edit.php?post_type=product',
            __( 'Look Inside PDF Settings', 'look-inside-pdf' ),
            __( 'LI PDF Settings', 'look-inside-pdf' ),
            'manage_woocommerce',
            'lipdf-settings',
            [ $this, 'render_settings_page' ]
        );
    }

    /**
     * Render settings page
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function render_settings_page() {
        $input_fields = [
            '_lipdf_type_of_data_show_on_product_thumb'             => [
                'type'    => 'select',
                'label'   => __( 'Show on Product Thumb', 'look-inside-pdf' ),
                'options' => [
                    'image' => __( 'Image', 'look-inside-pdf' ),
                    'text'  => __( 'Text', 'look-inside-pdf' ),
                    'no'    => __( 'None', 'look-inside-pdf' ),
                ],
                'value'   => get_option( '_lipdf_type_of_data_show_on_product_thumb', 'image' ),
                'class'   => 'widefat',
                'id'      => '_lipdf_type_of_data_show_on_product_thumb',
            ],
            '_lipdf_read_more_image_link'                           => [
                'type'        => 'text',
                'label'       => __( 'Read More Image Link', 'look-inside-pdf' ),
                'value'       => get_option( '_lipdf_read_more_image_link' ),
                'placeholder' => __( 'https://', 'look-inside-pdf' ),
                'class'       => 'widefat',
                'id'          => '_lipdf_read_more_image_link',
            ],
            '_lipdf_read_more_button_text'                          => [
                'type'  => 'text',
                'label' => __( 'Button Text', 'look-inside-pdf' ),
                'value' => get_option( '_lipdf_read_more_button_text', 'Read More' ),
                'class' => 'widefat',
                'id'    => '_lipdf_read_more_button_text',
            ],
            '_lipdf_show_read_more_button_after_product_thumb'      => [
                'type'    => 'select',
                'label'   => __( 'Show button after Product Thumb', 'look-inside-pdf' ),
                'options' => [
                    'yes' => __( 'Yes', 'look-inside-pdf' ),
                    'no'  => __( 'No', 'look-inside-pdf' ),
                ],
                'value'   => get_option( '_lipdf_show_read_more_button_after_product_thumb', 'yes' ),
                'class'   => 'widefat',
                'id'      => '_lipdf_show_read_more_button_after_product_thumb',
            ],
            '_lipdf_show_read_more_button_after_add_to_cart_button' => [
                'type'    => 'select',
                'label'   => __( 'Show button after Add to cart', 'look-inside-pdf' ),
                'options' => [
                    'yes' => __( 'Yes', 'look-inside-pdf' ),
                    'no'  => __( 'No', 'look-inside-pdf' ),
                ],
                'value'   => get_option( '_lipdf_show_read_more_button_after_add_to_cart_button', 'yes' ),
                'class'   => 'widefat',
                'id'      => '_lipdf_show_read_more_button_after_add_to_cart_button',
            ],
        ];

        $input_fields = apply_filters( 'lipdf_admin_option_input_fields', $input_fields );

        lipdf_get_template( 'admin/settings.php', [
            'input_fields' => $input_fields,
        ] );
    }

}
