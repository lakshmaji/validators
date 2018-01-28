<?php

namespace Lakshmaji\Validators\Contracts;

/**
 * Interface Validable Interface.
 *
 * @package     Validators
 * @version     1.0.0
 * @since       1.0.0
 * @author      Lakshmaji 
 */
interface ValidableInterface
{

    /**
     * With
     *
     * @param array
     * @return self
     */
    public function with(array $input);

    /**
     * Passes
     *
     * @return boolean
     */
    public function passes();

    /**
     * Errors
     *
     * @return array
     */
    public function errors();
}
//end of interface ValidableInterface
//end of file ValidableInterface.php
