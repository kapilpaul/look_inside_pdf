<?php

namespace DCoders\LookInsidePdf;

use DCoders\LookInsidePdf\Frontend\Product;

/**
 * Frontend handler class
 */
class Frontend {
    /**
     * Frontend constructor.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct() {
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
}
