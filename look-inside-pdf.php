<?php
/*
Plugin Name: Look Inside PDF
Plugin URI: https://kapilpaul.me/projects/look-inside-pdf
Description: Look Inside a pdf book to read or book sample to read
Version: 1.0.0
Author: Kapil Paul
Author URI: https://kapilpaul.me
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: look-inside-pdf
Domain Path: /languages
*/

/**
 * Copyright (c) 2020 Kapil Paul (email: kapilpaul007@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * LookInsidePdf class
 *
 * @class LookInsidePdf The class that holds the entire LookInsidePdf plugin
 */
final class LookInsidePdf {
    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = [];

    /**
     * Constructor for the LookInsidePdf class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @since 1.0.0
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

        $this->init_appsero_tracker();

        add_action( 'woocommerce_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes the LookInsidePdf() class
     *
     * Checks for an existing LookInsidePdf() instance
     * and if it doesn't find one, creates it.
     *
     * @since 1.0.0
     *
     * @return LookInsidePdf|bool
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new LookInsidePdf();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Define the constants
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function define_constants() {
        define( 'LOOK_INSIDE_PDF_VERSION', self::version );
        define( 'LOOK_INSIDE_PDF_FILE', __FILE__ );
        define( 'LOOK_INSIDE_PDF_PATH', dirname( LOOK_INSIDE_PDF_FILE ) );
        define( 'LOOK_INSIDE_PDF_INCLUDES', LOOK_INSIDE_PDF_PATH . '/includes' );
        define( 'LOOK_INSIDE_PDF_URL', plugins_url( '', LOOK_INSIDE_PDF_FILE ) );
        define( 'LOOK_INSIDE_PDF_ASSETS', LOOK_INSIDE_PDF_URL . '/assets' );
    }

    /**
     * Load the plugin after all plugins are loaded
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function activate() {
        $installer = new DCoders\LookInsidePdf\Installer();
        $installer->run();
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     *
     * @since 1.0.0
     */
    public function deactivate() {

    }

    /**
     * Include the required files
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function includes() {
        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin'] = new DCoders\LookInsidePdf\Admin();
        }

        if ( $this->is_request( 'frontend' ) ) {
            $this->container['frontend'] = new DCoders\LookInsidePdf\Frontend();
        }

        if ( $this->is_request( 'ajax' ) ) {
            // require_once LOOK_INSIDE_PDF_INCLUDES . '/class-ajax.php';
        }
    }

    /**
     * Initialize the hooks
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_hooks() {
        add_action( 'init', [ $this, 'init_classes' ] );

        // Localize our plugin
        add_action( 'init', [ $this, 'localization_setup' ] );

        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ $this, 'plugin_action_links' ] );
    }

    /**
     * Instantiate the required classes
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_classes() {
        if ( $this->is_request( 'ajax' ) ) {
            // $this->container['ajax'] =  new DCoders\LookInsidePdf\Ajax();
        }

        $this->container['assets'] = new DCoders\LookInsidePdf\Assets();

        $this->container = apply_filters( 'lipdf_get_class_container', $this->container );
    }

    /**
     * Initialize plugin for localization
     *
     * @since 1.0.0
     *
     * @return void
     * @uses load_plugin_textdomain()
     *
     */
    public function localization_setup() {
        load_plugin_textdomain( 'look-inside-pdf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * What type of request is this?
     *
     * @param string $type admin, ajax, cron or frontend.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();

            case 'ajax' :
                return defined( 'DOING_AJAX' );

            case 'rest' :
                return defined( 'REST_REQUEST' );

            case 'cron' :
                return defined( 'DOING_CRON' );

            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

    /**
     * Plugin action links
     *
     * @param array $links
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function plugin_action_links( $links ) {
        $links[] = '<a href="' . admin_url( 'edit.php?post_type=product&page=lipdf-settings' ) . '">' . __( 'Settings', 'look-inside-pdf' ) . '</a>';

        return $links;
    }

    /**
     * Init appsero tracker
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_appsero_tracker() {
        if ( ! class_exists( 'Appsero\Client' ) ) {
            require_once __DIR__ . '/appsero/src/Client.php';
        }

        $client = new Appsero\Client( '30f28eed-c18a-411e-892b-1f3d2b978ab4', 'Look Inside PDF', __FILE__ );

        // Active insights
        $client->insights()->init();
    }

} // LookInsidePdf

/**
 * Initialize the main plugin
 *
 * @since 1.0.0
 *
 * @return \LookInsidePdf|bool
 */
function lookinsidepdf() {
    return LookInsidePdf::init();
}

/**
 *  kick-off the plugin
 */
lookinsidepdf();
