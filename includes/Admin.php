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
        register_setting( 'lipdf-settings', '_lipdf_read_button_text' );
        register_setting( 'lipdf-settings', '_lipdf_show_read_button' );
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
        lipdf_get_template( 'admin/settings.php' );
    }

}
