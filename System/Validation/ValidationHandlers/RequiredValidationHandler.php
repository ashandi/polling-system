<?php

namespace System\Validation\ValidationHandlers;


class RequiredValidationHandler extends ValidationHandler
{

    /**
     * Method defines that given value corresponds to rule of this handler
     *
     * @param $value
     * @param array $args
     * @return bool
     */
    public function validate($value, array $args): bool
    {
        return !empty($value);
    }

}