<?php

namespace Vanengers\SymfonyConsoleCommandLib\Tests\Mock;

class ConsoleMock
{
    public const ARGV_VALID = [
        '--name' => "Vanengers",
        '--age' => 12,
        '--male' => 'true',
        '--name_nodef' => "Vanengers",
    ];

    public const ARGV_NO_NAMEDEF = [
        '--name' => "Vanengers",
        '--age' => 12,
        '--male' => 'true',
    ];
}