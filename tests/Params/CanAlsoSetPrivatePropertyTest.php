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
use Vanengers\SymfonyConsoleCommandLib\Tests\Helper\PropertyAccessor;
use Vanengers\SymfonyConsoleCommandLib\Tests\Mock\ConsoleMock;

class CanAlsoSetPrivatePropertyTest extends TestCase
{
    public ?HelloWorldCommand $command = null;
    private CommandTester $commandTester;

    public function setUp(): void
    {
        $this->command = new HelloWorldCommand();
        $this->commandTester = new CommandTester($this->command);
        parent::setUp();
    }

    public function testCanSetPrivateProperty()
    {
        $name = 'SpaceCowboy';
        $args = array_merge(['--private_name'=>$name],ConsoleMock::ARGV_VALID);

        $exit = $this->command->run(new ArrayInput($args), new ConsoleOutput());

        $this->assertEquals(0, $exit);

        $this->assertEquals($name, PropertyAccessor::getProperty($this->command, 'private_name'));
    }
}
