<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Interfaces;

interface DocInterface
{
    /**
     * Метод возвращает описание команды
     *
     * @return string
     */
    public function command(): string;

    /**
     * Метод возвращает описание аргументов
     * в формате ключ значение
     *
     * @return array
     */
    public function arguments(): array;

    /**
     * Метод возвращает описание опций
     * в формате ключ значение
     *
     * @return array
     */
    public function options(): array;
}