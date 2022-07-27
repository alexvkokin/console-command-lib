<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Classes;

use Alexvkokin\ConsoleCommandLib\Src\Helpers\CommandHelper;
use Alexvkokin\ConsoleCommandLib\Src\Interfaces\{
    CommandInterface,
    ConsoleInterface
};

/**
 * - Данный класс принимает аргументы из консоли
 * - Регистрирует команды.
 * - Отдает аргументы на распарсиванию специальному классу
 * - После, через хелпер получает нужную команду,
 *   либо выводит все команды, если указанной не нашлось
 */
class Console implements ConsoleInterface
{
    /**
     * @var CommandInterface[] Содержит все классы зарегистрированных команд
     */
    protected array $commands = [];

    /**
     * @var ConsoleParser Парсер аргументов из консоли
     */
    protected ConsoleParser $parser;

    /**
     * @var CommandHelper Функционал для работы с командами (нужен для нахождения команды по ее имени)
     */
    protected CommandHelper $commandHelper;

    /**
     * @var View Вывод отчета в консоль
     */
    protected View $view;


    /**
     * @inheritDoc
     */
    public function __construct(array $args)
    {
        $this->parser = new ConsoleParser($args);
        $this->commandHelper = new CommandHelper();
        $this->view = new View();
    }

    /**
     * @inheritDoc
     */
    public function register(CommandInterface $command): ConsoleInterface
    {
        $this->commands[] = $command;
        return $this;
    }

    /**
     * Регистрируем команды
     *
     * @param CommandInterface[] $commands
     * @return ConsoleInterface
     */
    public function registers(array $commands): ConsoleInterface
    {
        foreach($commands as $command) {
            $this->register($command);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function run(): bool
    {
        // Распарсиваем аргументы из консоли
        $this->parser->parse();

        // Находим класс команды
        $commandName = $this->parser->getCommandName();
        $command = $this->commandHelper->getInstance($commandName, $this->commands);

        if ($command instanceof CommandInterface) {
            // Регистрируем опции и аргументы
            $arguments = $this->parser->getArguments();
            $command->setArguments($arguments);
            $options = $this->parser->getOptions();
            $command->setOptions($options);

            // Запуск команды
            $command->run();
        } else {
            // В случае если команды не нашлось, выводим все зарегистрированные команды
            $this->view->commandsRender($this->commands);
        }
        return true;
    }
}
