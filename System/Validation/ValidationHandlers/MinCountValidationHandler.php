<?php

namespace System\Validation\ValidationHandlers;


class MinCountValidationHandler extends ValidationHandler
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
        $count = $args[0];

        return count($value) >= $count;
    }

}