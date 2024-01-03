<?php

namespace Vanengers\SymfonyConsoleCommandLib;
use ReflectionClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Vanengers\SymfonyConsoleCommandLib\Param\Option;

abstract class AbstractConsoleCommand extends Command
{
    /** @var ?OutputInterface output */
    private ?OutputInterface $output = null;
    /** @var ?InputInterface input */
    private ?InputInterface $input = null;

    /** @var ?SymfonyStyle io */
    protected ?SymfonyStyle $io = null;

    public abstract function executeCommand();
    public abstract function getCommandName();
    public abstract function getCommandDescription();
    public abstract function getOptions();

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    protected function configure() : void
    {
        $this
            ->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription());

        $this->configureOptions();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $this->executeCommand();

        return 0;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->output = $output;
        $this->input = $input;

        $this->io = new SymfonyStyle($input, $output);

        $params = $this->getOptions();
        foreach ($params as $param) {
            /** @var Option $param */
            $value = $this->input->getOption($param->name);
            if ($param->validateValue($value)) {
                $assign = !empty($param->property) ? $param->property : $param->name;
                if ($assign && property_exists($this, $assign)) {
                    if ($param->type == 'array') {
                        $exploded = is_array($value) ? $value : explode(',', $value);
                        foreach ($exploded as $item) {
                            if (!empty($item)) {
                                $get = $this->getProperty($assign);
                                $get[] = $item;
                                $this->setProperty($assign, $get);
                            }
                        }
                    } else {
                        $this->setProperty($assign, $value);
                    }

                }
            }
        }
    }

    private function getProperty($name)
    {
        $reset = false;
        $reflectedClass = new ReflectionClass($this);
        $reflection = $reflectedClass->getProperty($name);
        if (!$reflection->isPublic()) {
            $reflection->setAccessible(true);
            $reset = true;
        }
        $value = $reflection->getValue($this);
        if ($reset) {
            $reflection->setAccessible(false);
        }
        return $value;
    }

    private function setProperty($name, $value)
    {
        $reset = false;
        $reflectedClass = new ReflectionClass($this);
        $reflection = $reflectedClass->getProperty($name);
        if (!$reflection->isPublic()) {
            $reflection->setAccessible(true);
            $reset = true;
        }
        $reflection->setAccessible(true);
        $reflection->setValue($this, $value);
        if ($reset) {
            $reflection->setAccessible(false);
        }
    }

    private function configureOptions()
    {
        $options = $this->getOptions();

        foreach ($options as $option) {
            /** @var Option $option */
            $this->addOption(
                $option->name,
                null,
                $option->required ? InputOption::VALUE_REQUIRED : InputOption::VALUE_OPTIONAL,
                $option->description,
                $option->defaultValue
            );
        }
    }
}