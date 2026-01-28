<?php

namespace Wfm;

abstract class Model
{
    /**
     * @var array
     */
    public array $attributes = [];
    /**
     * @var array
     */
    public array $errors = [];
    /**
     * @var array
     */
    public array $rules = [];
    /**
     * @var array
     */
    public array $labels = [];

    public function __construct()
    {
        Db::getInstance();
    }
}