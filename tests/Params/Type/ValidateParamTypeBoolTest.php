<?php

namespace Vanengers\SymfonyConsoleCommandLib\Tests\Params;

use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Tester\CommandTester;
use Vanengers\examples\HelloWorldCommand;
use Vanengers\SymfonyConsoleCommandLib\Tests\Mock\ConsoleMock;

class ValidateParamTypeBoolTest extends TestCase
{
    public ?HelloWorldCommand $command = null;
    private CommandTester $commandTester;

    public function setUp(): void
    {
        $this->command = new HelloWorldCommand();
        $this->commandTester = new CommandTester($this->command);
        parent::setUp();
    }

    public function testParameterIsBoolCannotBeString()
    {
        $name = 'Vanengers';
        $age = 2;
        $male = 'noBool';

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$name,
            '--age'=>$age,
            '--male'=>$male
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid value for option male');

        $exit = $this->commandTester->execute($args);
        $this->assertEquals(0, $exit);
    }

    public function testParameterIsBoolCannotBeIntNoBit()
    {
        $name = 'Vanengers';
        $age = 2;
        $male = 2;

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$name,
            '--age'=>$age,
            '--male'=>$male
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid value for option male');

        $exit = $this->commandTester->execute($args);
        $this->assertEquals(0, $exit);
    }

    public function testParameterIsBoolCanBeIntOneOrZero()
    {
        $name = 'Vanengers';
        $age = 2;
        $male = 1;

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$name,
            '--age'=>$age,
            '--male'=>$male
        ]);

        //$this->expectException(Exception::class);
        //$this->expectExceptionMessage('Invalid value for option male');

        $exit = $this->commandTester->execute($args);
        $this->assertEquals(0, $exit);
    }

    public function testParameterIsBoolCanBeIntOneOrZeroRetrieve()
    {
        $name = 'Vanengers';
        $age = 2;
        $male = 1;

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$name,
            '--age'=>$age,
            '--male'=>$male
        ]);

        //$this->expectException(Exception::class);
        //$this->expectExceptionMessage('Invalid value for option male');

        $exit = $this->commandTester->execute($args);
        $this->assertEquals(0, $exit);
        $this->assertEquals(true, $this->command->male);
    }

    public function testParameterIsBoolCanBeBoolTrueRetrieve()
    {
        $name = 'Vanengers';
        $age = 2;
        $male = true;

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$name,
            '--age'=>$age,
            '--male'=>$male
        ]);

        //$this->expectException(Exception::class);
        //$this->expectExceptionMessage('Invalid value for option male');

        $exit = $this->commandTester->execute($args);
        $this->assertEquals(0, $exit);
        $this->assertEquals(true, $this->command->male);
    }

    public function testParameterIsBoolCanBeBoolfalseRetrieve()
    {
        $name = 'Vanengers';
        $age = 2;
        $male = false;

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$name,
            '--age'=>$age,
            '--male'=>$male
        ]);

        //$this->expectException(Exception::class);
        //$this->expectExceptionMessage('Invalid value for option male');

        $this->command->male = true;

        $exit = $this->commandTester->execute($args);
        $this->assertEquals(0, $exit);
        $this->assertEquals($male, $this->command->male);
    }
}
