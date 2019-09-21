<?php

class singlten
{
    private static $instance = null;

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    public function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}