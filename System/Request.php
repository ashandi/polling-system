<?php

namespace System;


class Request
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $data;

    public function __construct()
    {
        $this->type = $_SERVER['REQUEST_METHOD'];
        $this->path = $this->getPathFromRequest();

        $this->data = array_merge($_GET, $_POST);
    }

    /**
     * Method returns required route from url
     *
     * @return string
     */
    private function getPathFromRequest() : string
    {
        $path = $_SERVER['REQUEST_URI'] == '/'
            ? $_SERVER['REQUEST_URI']
            : rtrim($_SERVER['REQUEST_URI'], '/');

        return array_shift(
            explode('?', $path, 2)
        );
    }

    /**
     * @return string
     */
    public function getType() :string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * Method returns array of all request params
     *
     * @return array
     */
    public function all() : array
    {
        return $this->data;
    }

    /**
     * Method returns request param by given $key
     *
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }

    /**
     * Method returns path to previous page
     *
     * @return string
     */
    public function getPreviousUrl() : string
    {
        return $_SERVER['HTTP_REFERER'];
    }

}