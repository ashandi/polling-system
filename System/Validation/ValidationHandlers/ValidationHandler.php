<?php

namespace System\Validation\ValidationHandlers;


abstract class ValidationHandler
{

    /**
     * Method defines that given value corresponds to rule of this handler
     *
     * @param $value
     * @param array $args
     * @return bool
     */
    public abstract function validate($value, array $args) : bool;

}