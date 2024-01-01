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
use Vanengers\SymfonyConsoleCommandLib\Tests\Mock\ConsoleMock;

class ValidateParamTypeIntTest extends TestCase
{
    public ?HelloWorldCommand $command = null;
    private CommandTester $commandTester;

    public function setUp(): void
    {
        $this->command = new HelloWorldCommand();
        $this->commandTester = new CommandTester($this->command);
        parent::setUp();
    }

    public function testParameterIsIntCannotBeString()
    {
        $age = 'noInt';

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--age'=>$age,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid value for option age');

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
    }

    public function testParameterIsIntCanBeNegative()
    {
        $age = '-1';

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--age'=>$age,
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertEquals((int) $age, $this->command->age);
    }

    public function testParameterIsIntCanBeNegativeAsInt()
    {
        $age = -1;

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--age'=>$age,
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertEquals((int) $age, $this->command->age);
    }

    public function testParameterIsIntCanBePositive()
    {
        $age = '11';

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--age'=>$age,
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertEquals((int) $age, $this->command->age);
    }

    public function testParameterIsIntCanBePositiveAsInt()
    {
        $age = 12;

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--age'=>$age,
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertEquals((int) $age, $this->command->age);
    }
}
