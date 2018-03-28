<?php

/**
 * Method returns config value by given key
 *
 * @param string $key
 * @return string
 */
function config(string $key) : string
{
    try {
        $config = include('config/config.php');
        return $config[$key];
    } catch (Exception $exception) {
        echo $exception;
        die();
    }
}

/**
 * Method defines the handler which must to handle given request
 *
 * @param \System\Request $request
 * @return \System\Handler
 */
function routes(\System\Request $request) : \System\Handler
{
    try {
        $routes = include('config/routes.php');
        $handler = $routes[ $request->getType() ] [ $request->getPath() ];

        //Redirect
        if (is_string($handler)) {
            header("Location: $handler");
            exit;
        }

        //404
        if (is_null($handler)) {
            header("HTTP/1.0 404 Not Found");
            echo "Page not found.";
            exit;
        }

        return $handler;
    } catch (Exception $exception) {
        echo $exception;
        die;
    }
}

/**
 * Method defines name of class which must to validate given rule
 *
 * @param string $key
 * @return string
 */
function validationAlias(string $key) :string
{
    try {
        $aliases = include('config/validation.php');
        return $aliases[$key];
    } catch (Exception $exception) {
        echo $exception;
        die();
    }
}

/**
 * Method creates and returns exemplar of Redirect class
 *
 * @param string $path
 * @param mixed|null $messages
 * @return \System\Redirect
 */
function redirect(string $path, $messages = null)
{
    $redirect = new \System\Redirect($path);

    if (!empty($messages)) {
        $with = is_array($messages)
            ? $messages
            : [ $messages ];

        $redirect->with($with);
    }

    return $redirect;
}
/**
 * Method for debug
 *
 * @param mixed $variable
 */
function dd($variable)
{
    var_dump($variable);
    die();
}