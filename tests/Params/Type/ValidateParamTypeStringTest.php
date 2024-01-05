<?php

namespace Vanengers\SymfonyConsoleCommandLib\Tests\Params;

use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Tester\CommandTester;
use Vanengers\examples\HelloWorldCommand;
use Vanengers\examples\HelloWorldCommandFileExistsValidatorWithoutDefaultFile;
use Vanengers\SymfonyConsoleCommandLib\Tests\Mock\ConsoleMock;

class ValidateParamTypeStringTest extends TestCase
{
    public ?HelloWorldCommand $command = null;
    private CommandTester $commandTester;

    public function setUp(): void
    {
        $this->command = new HelloWorldCommand();
        $this->commandTester = new CommandTester($this->command);
        parent::setUp();
    }

    public function testParameterIsString()
    {
        $name = 'Vanengers';

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$name,
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertEquals($name, $this->command->name);
    }

    public function testParameterConfigEmptyThrowsException()
    {
        $command = new HelloWorldCommandFileExistsValidatorWithoutDefaultFile();

        $name = 'Vanengers';

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$name,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Option config is required');

        $exit = $command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertEquals($name, $command->name);
    }
}
