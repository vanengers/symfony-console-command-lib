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

class ValidateParamTypeArrayTest extends TestCase
{
    public ?HelloWorldCommand $command = null;
    private CommandTester $commandTester;

    public function setUp(): void
    {
        $this->command = new HelloWorldCommand();
        $this->commandTester = new CommandTester($this->command);
        parent::setUp();
    }

    public function testParameterIsArrayCanBeEmptyAsInNoItems()
    {
        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--jobs' => [],
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertCount(0, $this->command->jobs);
    }

    public function testParameterIsArrayCanBeCommaSeperatedItems()
    {
        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--jobs' => 'john,doe',
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertCount(2, $this->command->jobs);
        $this->assertContains('john', $this->command->jobs);
        $this->assertContains('doe', $this->command->jobs);
    }

    public function testParameterIsArrayCanBeCommaSeperatedItems3()
    {
        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--jobs' => 'john,doe,marry',
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertCount(3, $this->command->jobs);
        $this->assertContains('john', $this->command->jobs);
        $this->assertContains('doe', $this->command->jobs);
        $this->assertContains('marry', $this->command->jobs);
    }

    public function testParameterIsArrayCanAnythingAsInSingleItemString()
    {
        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--jobs' => 'singleItem',
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertContains('singleItem', $this->command->jobs);
        $this->assertCount(1, $this->command->jobs);
    }

    public function testParameterIsArrayCanAnythingAsInSingleItemInt()
    {
        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--jobs' => 22,
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertCount(1, $this->command->jobs);
        $this->assertContains("22", $this->command->jobs);
    }

    public function testParameterIsArrayCanAnythingAsInSingleItemBool()
    {
        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--jobs' => "true",
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertCount(1, $this->command->jobs);
        $this->assertContains("true", $this->command->jobs);
    }
    public function testParameterIsArrayCanAnythingAsInMultipleItemBool()
    {
        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--jobs' => "true,false",
        ]);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());
        $this->assertEquals(0, $exit);
        $this->assertCount(2, $this->command->jobs);
        $this->assertContains("true", $this->command->jobs);
        $this->assertContains("false", $this->command->jobs);
    }
}
