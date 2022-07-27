<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Helpers;

use Alexvkokin\ConsoleCommandLib\Src\Interfaces\CommandInterface;

class CommandHelper
{
    /**
     * Получаем класс команды
     *
     * @param string|null $commandName Название команды
     * @param CommandInterface[] $commands Все зарегистрированные команды
     * @return CommandInterface|null
     */
    public function getInstance(?string $commandName, ?array $commands): ?CommandInterface
    {
        if (!empty($commandName) && !empty($commands)) {
            foreach ($commands as $command) {
                if ($command->getName() == $commandName) {
                    return $command;
                }
            }
        }
        return null;
    }
}