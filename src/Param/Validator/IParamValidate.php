<?php

namespace Vanengers\SymfonyConsoleCommandLib\Param\Validator;

interface IParamValidate
{
    public function validate($value): bool;
    public function getMessage(): string;
}