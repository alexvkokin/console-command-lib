<?php

namespace App\Commands\Calc;

use Alexvkokin\ConsoleCommandLib\Src\Classes\BaseCommand;

class CalcCommand extends BaseCommand
{
    /**
     * @var string Название команды
     */
    protected string $name = 'calc';

    /**
     * @var bool Аргумент increment
     */
    public bool $argumentIncrement;


    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct();

        // Документация для команды
        $this->documentation = new CalcDoc();
    }

    /**
     * Расчет суммы
     *
     * @param $params
     * @return void
     */
    public function optionSum($params): void
    {
        if (!is_array($params)) {
            $params = [$params];
        }
        var_dump('Суммируем полученные аргументы: ', array_sum($params));

        if ($this->argumentIncrement) {
            var_dump('Используем Increment');
        }
    }

    /**
     * Расчет произведения
     *
     * @param $params
     * @return void
     */
    public function optionProduct($params): void
    {
        if (!is_array($params)) {
            $params = [$params];
        }
        var_dump('Произведение полученных аргументов: ', array_product($params));
    }

}