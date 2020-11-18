<?php

namespace DCoders\LookInsidePdf;

/**
 * Scripts and Styles Class
 */
class Assets {
    /**
     * Assets constructor.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct() {
        $this->register_all_scripts();

        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
        } else {
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_front_scripts' ] );
        }
    }

    /**
     * Enqueue admin scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_admin_scripts() {
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }

        wp_enqueue_style( 'admin_lookinsidepdf' );
        wp_enqueue_script( 'admin_lookinsidepdf' );
    }

    /**
     * Enqueue front scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_front_scripts() {
        wp_enqueue_style( 'front_lookinsidepdf' );
        wp_enqueue_script( 'front_lookinsidepdf' );
    }

    /**
     * Register our app scripts and styles
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_all_scripts() {
        $this->register_scripts( $this->get_scripts() );
        $this->register_styles( $this->get_styles() );
    }

    /**
     * Register scripts
     *
     * @param array $scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function register_scripts( $scripts ) {
        foreach ( $scripts as $handle => $script ) {
            $deps      = isset( $script['deps'] ) ? $script['deps'] : false;
            $in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
            $version   = isset( $script['version'] ) ? $script['version'] : LOOK_INSIDE_PDF_VERSION;

            wp_register_script( $handle, $script['src'], $deps, $version, $in_footer );
        }
    }

    /**
     * Register styles
     *
     * @param array $styles
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_styles( $styles ) {
        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, LOOK_INSIDE_PDF_VERSION );
        }
    }

    /**
     * Get all registered scripts
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_scripts() {
        $scripts = [
            'front_lookinsidepdf' => [
                'src'       => LOOK_INSIDE_PDF_ASSETS . '/front/js/script.js',
                'version'   => filemtime( LOOK_INSIDE_PDF_PATH . '/assets/front/js/script.js' ),
                'deps'      => [],
                'in_footer' => true,
            ],
            'admin_lookinsidepdf' => [
                'src'       => LOOK_INSIDE_PDF_ASSETS . '/admin/js/script.js',
                'version'   => filemtime( LOOK_INSIDE_PDF_PATH . '/assets/admin/js/script.js' ),
                'deps'      => [],
                'in_footer' => true,
            ],
        ];

        return $scripts;
    }

    /**
     * Get registered styles
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_styles() {
        $styles = [
            'front_lookinsidepdf' => [
                'src'     => LOOK_INSIDE_PDF_ASSETS . '/front/css/style.css',
                'deps'    => [],
                'version' => filemtime( LOOK_INSIDE_PDF_PATH . '/assets/front/css/style.css' ),
            ],
            'admin_lookinsidepdf' => [
                'src'     => LOOK_INSIDE_PDF_ASSETS . '/admin/css/style.css',
                'deps'    => [],
                'version' => filemtime( LOOK_INSIDE_PDF_PATH . '/assets/admin/css/style.css' ),
            ],
        ];

        return $styles;
    }
}
