<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Classes;

/**
 * Содержит базовый функционал для всех дочерних команд
 * Здесь же реализован аргумент {help}
 */
class BaseCommand extends Command
{
    /**
     * @var bool Аргумент {help} для вывода справочной информации
     */
    public bool $argumentHelp;

    /**
     * Переопределяем метод для вывода справки.
     * Выводим только справку, даже если в консоли есть другие аргументы и опции
     *
     * @inheritDoc
     */
    public function run(bool $isRun = true): void
    {
        parent::run(!$this->argumentHelp);

        if ($this->argumentHelp) {
            $this->view->helpRender($this);
        }
    }
}