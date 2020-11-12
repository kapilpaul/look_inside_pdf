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
        $this->set_classes();
    }

    /**
     * Set classes
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function set_classes() {
        $container            = lookinsidepdf()->container;
        $container['product'] = new Product();
    }

}
