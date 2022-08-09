<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Interfaces;

interface ConsoleInterface
{
    /**
     * Конструктор
     *
     * @param array $args Аргументы консольной команды
     */
    public function __construct(array $args);

    /**
     * Регистрация команды
     *
     * @param CommandInterface $command
     * @return ConsoleInterface
     */
    public function register(CommandInterface $command): ConsoleInterface;

    /**
     * Логика запуска команд
     *
     * @return bool
     */
    public function run(): bool;
}