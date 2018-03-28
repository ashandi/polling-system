<?php

namespace System\Validation\ValidationHandlers;

class MustBeMinValidationHandler extends ValidationHandler
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
        $field = $args[0];
        $necessaryValue = $args[1];

        foreach ($value as $item) {
            if ($item[$field] == $necessaryValue) {
                return true;
            }
        }

        return false;
    }

}