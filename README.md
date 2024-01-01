# symfony-console-command-lib
Library for Symfony console commands

## Installation

```
composer require vanengers/symfony-console-command-lib
```

## Usage

```php
class MyCommand extends AbstractConsoleCommand {}
```
Implement the abstract methods and you are good to go.

### executeCommand():
the method that actually executes the command, do not use the execute() method from the parent class

### getCommandName():
this should return the name of the command for the command line

### getCommandDescription():
this should return a description of the command for the command line

## getOptions():
this should return an array of options for the command line
Each Option will be checked for default value and value inputed by the user
Look at the [example](https://github.com/vanengers/symfony-console-command-lib/blob/530536fdae404d2564a3b8fbfc4299e81330971b/examples/HelloWorldCommand.php#L34)

only simple types are expected: array, bool, int, string