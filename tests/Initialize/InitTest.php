<?php

namespace Vanengers\SymfonyConsoleCommandLib\Tests\Initialize;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Tester\CommandTester;
use Vanengers\examples\HelloWorldCommand;
use Vanengers\SymfonyConsoleCommandLib\Tests\Mock\ConsoleMock;

class InitTest extends TestCase
{
    public ?HelloWorldCommand $command = null;
    private CommandTester $commandTester;

    public function setUp(): void
    {
        $this->command = new HelloWorldCommand();
        $this->commandTester = new CommandTester($this->command);
        parent::setUp();
    }

    public function testCanInstatiateHelloWorld()
    {
        $exit = $this->commandTester->execute(ConsoleMock::ARGV_VALID);
        $this->assertNotNull($exit);
    }
}