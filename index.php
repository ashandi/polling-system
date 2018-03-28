<?php
session_start();

require_once('autoload.php');
AutoLoader::register();

require_once('functions.php');

try {

    $container = \System\Container::getInstance();
    $providers = include('config/providers.php');
    $container->registerAll($providers);


    $request = new System\Request();
    $handler = routes($request);
    $response = $handler->invoke($request);


    echo $response;

} catch (Exception $exception) {
    echo  $exception;
}
