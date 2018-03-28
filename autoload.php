<?php

class AutoLoader
{

    /**
     * Method registers class autoloader in app
     */
    public static function register() : void
    {
        spl_autoload_register( [ 'AutoLoader', 'loadClass' ] );
    }

    /**
     * Method defines that directory of class is taken form it's namespace
     *
     * @param string $className
     */
    private static function loadClass(string $className) : void
    {
        $className = str_replace('\\', '/', $className) . '.php';

        require_once($className);
    }

}