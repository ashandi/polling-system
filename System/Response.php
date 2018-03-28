<?php

namespace System;

class Response
{

    /**
     * @var View
     */
    private $view;

    /**
     * @param string $viewName
     * @param array $args
     */
    public function __construct(string $viewName, array $args = [])
    {
        $this->view = $this->getView($viewName, $args);
    }

    /**
     * Method returns View object of this response
     *
     * @param string $viewName
     * @param array $args
     * @return View
     */
    private function getView(string $viewName, array $args) : View
    {
        return new View($viewName, $args);
    }

    public function __toString()
    {
        return $this->view->render();
    }
}