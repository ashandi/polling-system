<?php

namespace System;


class Redirect extends Response
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Method adds given $messages to session
     *
     * @param array $messages
     */
    public function with(array $messages) : void
    {
        $_SESSION['messages'] = $messages;
    }

    public function __toString()
    {
        header("Location: {$this->path}");
        exit;
    }
}