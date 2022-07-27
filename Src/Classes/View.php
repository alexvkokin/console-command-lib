<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Classes;

use Alexvkokin\ConsoleCommandLib\Src\Interfaces\CommandInterface;

/**
 * Вывод в консоль информации
 */
class View
{
    /**
     * Вывод в консоль информации по вызову команды
     *
     * @param string $command
     * @param array|null $arguments
     * @param array|null $options
     * @return void
     */
    public function commandRender(string $command, ?array $arguments, ?array $options): void
    {
        print PHP_EOL . PHP_EOL . 'Called command: ' . $command;

        if (!empty($arguments)) {
            print PHP_EOL . PHP_EOL . 'Arguments';
            print PHP_EOL . '  - ' . implode(PHP_EOL . '  - ', $arguments);
        }

        if (!empty($options)) {
            print PHP_EOL . PHP_EOL . 'Options';
            foreach ($options as $optionName => $optionVals) {
                print PHP_EOL . '  ' . $optionName;

                if (is_array($optionVals)) {
                    print PHP_EOL . '    - ' . implode(PHP_EOL . '    - ', $optionVals);
                } else {
                    print PHP_EOL . '    - ' . $optionVals;
                }
            }
        }
        print PHP_EOL . PHP_EOL;
    }


    /**
     * Вывод в консоль информации по всем командам,
     * с их описанием
     *
     * @param CommandInterface[]|null $commands
     * @return void
     */
    public function commandsRender(?array $commands): void
    {
        if (!empty($commands)) {
            print PHP_EOL . PHP_EOL . 'Commands: ' . PHP_EOL;
            /** @var Command $command */
            foreach ($commands as $command) {
                $commandDescription = $command->documentation->command();
                print PHP_EOL . '  ' . $command->getName() . ($commandDescription ? ' - ' . $commandDescription : '');
            }
        }
        print PHP_EOL . PHP_EOL;
    }


    /**
     * Вывод справки по аргументам и опциям команды
     *
     * @param CommandInterface $command
     * @return void
     */
    public function helpRender(CommandInterface $command): void
    {
        $commandDescription = $command->documentation->command();
        print PHP_EOL . PHP_EOL . 'Called command: ' . $command->getName()
            . ($commandDescription ? PHP_EOL . $commandDescription : '');

        $argumentsDoc = $command->documentation->arguments();
        $arguments = $command->getArguments(false);
        if (!empty($arguments)) {
            print PHP_EOL . PHP_EOL . 'Arguments';
            foreach ($arguments as $argument) {
                $argumentDescription = $argumentsDoc[$argument] ?? '';
                print PHP_EOL . '  - ' . $argument . ($argumentDescription ? ' - ' . $argumentDescription : '');
            }
        }

        $optionsDoc = $command->documentation->options();
        $options = $command->getOptions(false);
        if (!empty($options)) {
            print PHP_EOL . PHP_EOL . 'Options';
            foreach ($options as $optionName => $optionVals) {
                $optionDescription = $optionsDoc[$optionName] ?? '';
                print PHP_EOL . '  - ' . $optionName . ($optionDescription ? ' - ' . $optionDescription : '');
            }
        }
        
        print PHP_EOL . PHP_EOL;
    }
}