<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Classes;

/**
 * Парсер аргументов из консоли
 */
class ConsoleParser
{
    /**
     * @var array Аргументы из консоли
     */
    private array $args;

    /**
     * @var string Файл
     */
    private string $fileName;

    /**
     * @var string|null Команда
     */
    private ?string $commandName;

    /**
     * @var string[] Аргументы
     */
    private array $arguments = [];

    /**
     * @var mixed Опции
     */
    private array $options = [];


    /**
     * Конструктор
     *
     * @param array $args Аргументы консольной команды
     */
    public function __construct(array $args)
    {
        $this->args = $args;
    }

    /**
     * Название файла
     *
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * Аргументы
     *
     * @return string|null
     */
    public function getCommandName(): ?string
    {
        return $this->commandName;
    }

    /**
     * Название команды
     *
     * @return string[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Запись команды
     *
     * @param string|null $argument
     */
    public function setArguments(?string $argument): void
    {
        if (!empty($argument)) {
            $this->arguments[] = $argument;
            $this->arguments = array_unique($this->arguments);
            $this->arguments = array_values($this->arguments);
        }
    }

    /**
     * Опции
     *
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Запись Опций
     *
     * @param string $option
     * @param string $arguments
     */
    public function setOption(string $option, string $arguments): void
    {
        if (!empty($option) && !empty($arguments)) {
            $this->options[$option][] = $arguments;
            $this->options[$option] = array_unique($this->options[$option]);
            $this->options[$option] = array_values($this->options[$option]);
        }
    }

    /**
     * Парсер
     *
     * @return void
     */
    public function parse()
    {
        // Файл
        $this->fileName = array_shift($this->args);

        // Команда
        $this->commandName = !empty($this->args) ? array_shift($this->args) : null;

        // Аргументы
        foreach ($this->args as $str) {
            if (preg_match('/^\{([\w]+)\}$/i', $str, $match)) {
                $arg = $match[1];
            } else if (preg_match('/^([\w]+)$/i', $str, $match)) {
                $arg = $match[1];
            } else {
                $arg = null;
            }
            $this->setArguments($arg);
        }

        // Опции
        foreach ($this->args as $str) {
            if (preg_match('/^\[([\w]+)=([.\w]+)\]$/i', $str, $match)) {
                $this->setOption($match[1], $match[2]);
            }
        }
    }
}
