<?php

namespace App\Library;

class ValidationObject
{
    private array $arrayMessages;
    private array $arrayValidation;

    public function __construct()
    {
        $this->arrayValidation = [];
        $this->arrayMessages   = [];
    }

    
    public function add(string $key, array $validationMessages, ?array $validationValues = null): void
    {
        $parts = [];

        foreach ($validationMessages as $rule => $message) {
            
            if ($validationValues !== null && isset($validationValues[$rule])) {
                $parts[] = $rule . ":" . $validationValues[$rule];
            } else {
                $parts[] = $rule;
            }

            
            $this->arrayMessages[$key . "." . $rule] = $message;
        }

        
        if (isset($this->arrayValidation[$key])) {
            $this->arrayValidation[$key] .= "|" . implode("|", $parts);
        } else {
            $this->arrayValidation[$key] = implode("|", $parts);
        }
    }

    
    public function validate(): array
    {
        return request()->validate($this->arrayValidation, $this->arrayMessages);
    }

    
    public function validate_and_clear(): array
    {
        $result = $this->validate();
        $this->clear();
        return $result;
    }

    
    public function clear(): void
    {
        $this->arrayValidation = [];
        $this->arrayMessages   = [];
    }
}

const VALIDATION = new ValidationObject();

trait ValidationMethods{
    public static function validate(){
        return VALIDATION->validate_and_clear();
    }
}

