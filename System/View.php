<?php

namespace System;

class View
{

    /**
     * @var string
     */
    private $viewBody;

    /**
     * @var array
     */
    private $args;

    /**
     * @param string $viewName
     * @param array $args
     */
    public function __construct(string $viewName, array $args)
    {
        $this->args = $args;
        $this->viewBody = $this->getViewBody($viewName);
    }

    /**
     * Method returns view by given name
     *
     * @param string $viewName
     * @return string
     */
    private function getViewBody(string $viewName) : string
    {
        $viewPath = $this->getViewPath($viewName);

        return $this->serializeViewToString($viewPath);
    }

    /**
     * Method returns full path to view
     *
     * @param string $viewName
     * @return string
     */
    private function getViewPath(string $viewName) : string
    {
        return config('views_directory') . '/' . $viewName . '.php';
    }

    /**
     * Method takes all from view, executes all php code inside it and returns it as string
     *
     * @param string $viewPath
     * @return string
     */
    private function serializeViewToString(string $viewPath) : string
    {
        ob_start();

        extract($this->args);

        include $viewPath;

        return ltrim(ob_get_clean());
    }

    /**
     * Method returns view in string format
     *
     * @return string
     */
    public function render() : string
    {
        return $this->viewBody;
    }

}