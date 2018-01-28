<?php

namespace Lakshmaji\Validators\Contracts;

/**
 * Abstract Validator class.
 *
 * @package     Validators
 * @version     1.0.0
 * @since       1.0.0
 * @author      Lakshmaji 
 */
abstract class AbstractValidator
{

    /**
     * Validator
     *
     * @var object
     * @access  protected
     */
    protected $validator;

    /**
     * Data to be validated
     *
     * @var array
     * @access protected
     */
    protected $data = [];

    /**
     * Validation Rules
     *
     * @var array
     * @access protected
     */
    protected $rules = [];

    /**
     * Validation errors
     *
     * @var    array
     * @access protected
     */
    protected $errors = [];

    //--------------------------------------------------------------------

    /**
     * Set data to validate.
     *
     * @access public
     * @param  array $data
     * @since  1.0.0
     */
    public function with(array $data)
    {
        $this->data = $data;
        return $this;
    }

    //--------------------------------------------------------------------

    /**
     * Returns errors.
     *
     * @access public
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    //--------------------------------------------------------------------

    /**
     * Pass the data and the rules to the validator
     *
     * @abstract
     */
    abstract public function passes();

    //--------------------------------------------------------------------

    /**
     * Formats the error message in required structure.
     *
     * @abstract
     */
    abstract public function formatErrorMessages();
}
//end of class AbstractValidator
//end of file AbstractValidator.php
