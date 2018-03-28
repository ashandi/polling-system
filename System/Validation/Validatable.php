<?php

namespace System\Validation;

interface Validatable
{

    /**
     * Method returns array of rules for validation
     *
     * @return array
     */
    public static function getRules() : array;

}