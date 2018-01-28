<?php

namespace Lakshmaji\Validators\Laravel;

use Illuminate\Validation\Factory;
use Lakshmaji\Validators\Contracts\AbstractValidator;

/**
 * LaravelValidator class.
 *
 * @package     Validators
 * @version     1.0.0
 * @since       1.0.0
 * @author      Lakshmaji 
 */
abstract class LaravelValidator extends AbstractValidator
{

    /**
     * Validator
     *
     * @access protected
     * @var    Illuminate\Validation\Factory
     */
    protected $validator;

    //--------------------------------------------------------------------

    /**
     * Constructor method.
     *
     * @access public
     * @param Illuminate\Validation\Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    //--------------------------------------------------------------------

    /**
     * Pass the data and the rules to the validator.
     *
     * @return boolean
     */
    public function passes($id = 0)
    {
        if ($id == 0) {
            $validator = $this->validator->make($this->data, $this->rules, $this->messages);
        } else {
            die($id);
            $this->updateRule($id);
            $validator = $this->validator->make($this->data, $this->rules, $this->messages);
        }

        if ($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }
        return true;
    }

    //--------------------------------------------------------------------

    /**
     * Formats the error message to an associative array
     * with data fields as key and error messages as value.
     *
     * @access   public
     * @return   array
     * @since    1.0.0
     */
    public function formatErrorMessages()
    {
        //array to store the error messages
        $arrMsg = [];
        foreach ($this->rules as $key => $value) {
            if ($this->errors->has($key)) {
                $arrMsg[$key] = $this->errors->first($key);
            }
        }
        return $arrMsg;
    }
}
//end of class LaravelValidator
//end of file LaravelValidator.php
