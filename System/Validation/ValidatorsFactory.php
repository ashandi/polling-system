<?php

namespace System\Validation;

use ReflectionClass;

class ValidatorsFactory
{

    /**
     * Method returns exemplar of handler class by given alias
     *
     * @param string $alias
     * @return null|object
     */
    public static function getHandler(string $alias)
    {
        $handler = validationAlias($alias);

        if (isset($handler)) {
            $reflection = new ReflectionClass($handler);

            return $reflection->newInstance();
        }

        return null;
    }
}