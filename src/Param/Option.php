<?php

namespace Vanengers\SymfonyConsoleCommandLib\Param;

use Exception;
use Vanengers\SymfonyConsoleCommandLib\Param\Validator\IParamValidate;

class Option
{
    public string $name;
    public string $description;
    public $defaultValue;
    public bool $required;
    public string $type;
    public string $property;

    /** @var IParamValidate[] $validaters */
    private array $validaters = [];

    /**
     * @throws Exception
     */
    public function __construct(string $name, string $description, string $type, $defaultValue,
                                bool $required = false, string $property = null, array $validaters = [])
    {
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->defaultValue = $defaultValue;
        $this->required = $required;
        $this->property = is_null($property) ? '' : $property;
        $this->validaters = $validaters;

        $this->validate();
    }

    /**
     * @throws Exception
     */
    public function validateValue($value): bool
    {
        if ($value === null && $this->required) {
            throw new Exception('Option ' . $this->name . ' is required');
        }

        if ($value === null && !$this->required) {
            return true;
        }

        return $this->__validate($value);
    }

    /**
     * @throws Exception
     */
    private function validate(): bool
    {
        if (is_null($this->defaultValue)) {
            return true; // we IMPLICITLY require an INPUT value from the user, when there is no default value
        }

        foreach($this->validaters as $validater) {
            if (!$validater instanceof IParamValidate) {
                throw new Exception('Invalid validater for option ' . $this->name);
            }
        }

        return $this->__validate($this->defaultValue, 'defaultValue');
    }

    /**
     * @param $value
     * @param string $n
     * @return bool
     * @throws Exception
     */
    private function __validate($value, string $n = 'value'): bool
    {
        if ($this->type == 'bool' && !$this->validateBool($value)) {
            throw new Exception('Invalid '.$n.' for option ' . $this->name);
        }

        if ($this->type == 'int' && !$this->validateInt($value)) {
            throw new Exception('Invalid '.$n.' for option ' . $this->name);
        }

        if ($this->type == 'array' && !$this->validateArray($value)) {
            throw new Exception('Invalid '.$n.' for option ' . $this->name);
        }

        if ($this->type == 'string' && !$this->validateString($value)) {
            throw new Exception('Invalid '.$n.' for option ' . $this->name);
        }

        foreach($this->validaters as $validater) {
            if (!$validater->validate($value)) {
                throw new Exception($validater->getMessage());
            }
        }

        return true;
    }

    private function validateBool($value): bool
    {
        if (!is_bool($value)) {
            // exceptions here
            if ($value === 1 || $value === 0 || $value === '1' || $value === '0' || $value === 'true' || $value === 'false') {
                return true;
            }
            return false;
        }

        return true;
    }

    private function validateInt($value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return true;
    }

    private function validateArray($value): bool
    {
        $value = !is_array($value) ? explode(',', $value) : $value;
        if (!is_array($value)) {
            return false;
        }

        return true;
    }

    private function validateString($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        if (empty(trim($value))) {
            return false;
        }

        return true;
    }
}