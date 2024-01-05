<?php

namespace Vanengers\SymfonyConsoleCommandLib\Param\Validator;

use Symfony\Component\Filesystem\Filesystem;

class FileExistsValidator implements IParamValidate
{
    private string $errorMessage = '';

    public function validate($value): bool
    {
        $fs = new Filesystem();
        if (!$fs->exists($value)) {
            $this->errorMessage = 'File does not exist: '.$value;
            return false;
        }

        return true;
    }

    public static function name(): string
    {
        return 'file_exists';
    }

    public function getMessage(): string
    {
        return $this->errorMessage;
    }
}