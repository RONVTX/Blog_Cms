<?php

class Validator {
    private $errors = [];

    public function validate($data, $rules) {
        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode('|', $ruleSet);
            
            foreach ($rulesArray as $rule) {
                $this->applyRule($field, $data[$field] ?? null, $rule);
            }
        }
        
        return empty($this->errors);
    }

    private function applyRule($field, $value, $rule) {
        if (strpos($rule, ':') !== false) {
            list($rule, $param) = explode(':', $rule);
        }

        switch ($rule) {
            case 'required':
                if (empty($value)) {
                    $this->errors[$field] = "El campo es requerido";
                }
                break;
            
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field] = "Email inválido";
                }
                break;
            
            case 'min':
                if (strlen($value) < $param) {
                    $this->errors[$field] = "Mínimo {$param} caracteres";
                }
                break;
            
            case 'max':
                if (strlen($value) > $param) {
                    $this->errors[$field] = "Máximo {$param} caracteres";
                }
                break;
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getFirstError() {
        return reset($this->errors);
    }
}