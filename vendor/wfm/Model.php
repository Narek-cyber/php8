<?php

namespace Wfm;

use Valitron\Validator;

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

    /**
     * @param $data
     * @return void
     */
    public function load($data): void
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data): bool
    {
        Validator::langDir(APP . '/languages/validator/lang');
        Validator::lang('ru');
        $validator = new Validator($data);
        $validator->rules($this->rules);
        $validator->labels($this->getLabels());
        if ($validator->validate()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            return false;
        }
    }

    /**
     * @return void
     */
    public function getErrors(): void
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>{$item}</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['errors'] = $errors;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
//        $labels = [];
//        foreach ($this->labels as $k => $v) {
//            $labels[$k] = ___($v);
//        }
//        return $labels;
        return array_map(function ($v) {
            return ___($v);
        }, $this->labels);
    }
}