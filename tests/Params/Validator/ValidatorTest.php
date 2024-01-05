<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Vanengers\examples\HelloWorldCommand;
use Vanengers\SymfonyConsoleCommandLib\Tests\Mock\ConsoleMock;

class ValidatorTest extends TestCase
{
    public function setUp(): void
    {
        $this->command = new \Vanengers\examples\HelloWorldCommandFileExistsValidatorWithDefaultFile();
        $this->commandTester = new CommandTester($this->command);
        $this->name = __DIR__.'/'.'test.json';
        $fs = new Symfony\Component\Filesystem\Filesystem();
        $fs->dumpFile($this->name, 'test');

        parent::setUp();
    }

    public function tearDown(): void
    {
        $fs = new Symfony\Component\Filesystem\Filesystem();
        $fs->remove($this->name);

        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function testCanRunthroughwithFileExistsForNameDefaultValue()
    {
        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$this->name,
        ]);

        $exit = $this->commandTester->execute($args);
        $this->assertEquals(0, $exit);
    }

    public function testCannotRunthroughwithFileExistsForNameDefaultValue()
    {
        $command = new \Vanengers\examples\HelloWorldCommandFileExistsValidatorWithoutDefaultFile();
        $commandTester = new CommandTester($command);

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$this->name,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Option config is required');

        $exit = $commandTester->execute($args);
        $this->assertEquals(0, $exit);
    }

    public function testCannotRunthroughwithFileExistsForNameInvalidValue()
    {
        $command = new \Vanengers\examples\HelloWorldCommandFileExistsValidatorWithoutDefaultFile();
        $commandTester = new CommandTester($command);

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$this->name,
            '--config'=>'testnonexisting.json'
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('File does not exist:');

        $exit = $commandTester->execute($args);
        $this->assertEquals(0, $exit);
    }

    public function testCannotRunthroughwithFileExistsForNameValidValue()
    {
        $command = new \Vanengers\examples\HelloWorldCommandFileExistsValidatorWithoutDefaultFile();
        $commandTester = new CommandTester($command);

        $args = array_merge(ConsoleMock::ARGV_VALID,[
            '--name'=>$this->name,
            '--config'=>$this->name
        ]);

        $exit = $commandTester->execute($args);
        $this->assertEquals(0, $exit);
    }
}