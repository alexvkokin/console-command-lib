<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Interfaces;

interface CommandInterface
{
    /**
     * Конструктор
     */
    public function __construct();

    /**
     * Устанавливаем название команды
     *
     * @param string|null $name
     * @return void
     */
    public function setName(?string $name): void;

    /**
     * Получаем название команды
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Инициализация аргументов
     *
     * @param array $arguments
     * @return void
     */
    public function setArguments(array $arguments): void;

    /**
     * Получаем все аргументы
     *
     * @param bool $isFromConsole Получить аргументы из консоли, в противном случае все имеющиеся в команде
     * @return string[]
     */
    public function getArguments(bool $isFromConsole = true): array;

    /**
     * Определяем какие опции зарегистрированы в команде
     *
     * @param $options
     * @return void
     */
    public function setOptions($options): void;

    /**
     * Получаем все опции
     *
     * @param bool $isFromConsole Получить опции из консоли, в противном случае все имеющиеся в команде
     * @return string[]
     */
    public function getOptions(bool $isFromConsole = true): array;

    /**
     * Запуск методов из класса команды
     *
     * @return void
     */
    public function runOptions(): void;

    /**
     * Выводим в консоль подробный отчет о запуске команды.
     * Запускаем методы(опции)
     *
     * @param bool $isRun Подтверждаем вывод в консоль и запуск команд
     * @return void
     */
    public function run(bool $isRun = true): void;
}
