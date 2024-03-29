<?php

namespace Vanengers\examples;

use Vanengers\SymfonyConsoleCommandLib\AbstractConsoleCommand;
use Vanengers\SymfonyConsoleCommandLib\Param\Option;
use Vanengers\SymfonyConsoleCommandLib\Param\Validator\FileExistsValidator;

class HelloWorldCommandFileExistsValidatorWithoutDefaultFile extends AbstractConsoleCommand
{
    public string $name = '';
    public int $age = 0;

    public bool $male = false;

    public array $jobs = [];

    private string $private_name = '';

    public function executeCommand()
    {
    }

    public function getCommandName()
    {
        return "helloworld"; // what you use on the console to execute this command, use no spaces!
    }

    public function getCommandDescription()
    {
        return "Hello World Command"; // description of the command for the command list
    }

    public function getOptions()
    {
        return [
            new Option('name', 'name param', 'string', 'John', true),
            new Option('age', 'age param', 'int', 2, true),
            new Option('male', 'is male', 'bool', true, true),

            new Option('name_nodef', 'name param', 'string', null, true),
            new Option('jobs', 'jobs array param', 'array', [], true),

            new Option('private_name', 'private param', 'string', 'jantje', true),

            new Option('config', 'name param', 'string', null, true, null, [
                new FileExistsValidator(),
            ]),
        ];
    }
}