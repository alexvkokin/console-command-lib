<?php

namespace App\Commands\Calc;

use Alexvkokin\ConsoleCommandLib\Src\Classes\Doc;

class CalcDoc extends Doc
{
    /**
     * @inheritDoc
     */
    public function command(): string
    {
        return 'Калькулятор';
    }

    /**
     * @inheritDoc
     */
    public function arguments(): array
    {
        return [
            'increment' => 'Добавляем некоторое значение к сумме',
        ];
    }

    /**
     * @inheritDoc
     */
    public function options(): array
    {
        return [
            'sum' => 'Сумма всех полученных аргументов',
            'product' => 'Произведение всех полученных аргументов',
        ];
    }

}