<?php

namespace DCoders\LookInsidePdf;

/**
 * Class Installer
 * @package DCoders\LookInsidePdf
 */
class Installer {
    /**
     * Run the installer
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function run() {
        $this->add_version();
    }

    /**
     * Add time and version on DB
     *
     * @since 1.0.0
     */
    public function add_version() {
        $installed = get_option( 'look_inside_pdf_installed' );

        if ( ! $installed ) {
            update_option( 'look_inside_pdf_installed', time() );
        }

        update_option( 'look_inside_pdf_version', LOOK_INSIDE_PDF_VERSION );
    }
}
