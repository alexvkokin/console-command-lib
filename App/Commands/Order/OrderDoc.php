<?php

namespace App\Commands\Order;

use Alexvkokin\ConsoleCommandLib\Src\Classes\Doc;

class OrderDoc extends Doc
{
    /**
     * @inheritDoc
     */
    public function command(): string
    {
        return 'Работа с ордером';
    }

    /**
     * @inheritDoc
     */
    public function arguments(): array
    {
        return [
            'verbose' =>  'Аргумент verbose',
            'overwrite' =>  'Аргумент overwrite',
            'unlimited' =>  'Аргумент unlimited',
            'log' =>  'Аргумент log',
        ];
    }

    /**
     * @inheritDoc
     */
    public function options(): array
    {
        return [
            'log_file' =>  'Опция log_file',
            'methods' =>  'Опция method - может содержать параметры {create,update,delete}',
            'paginate' =>  'Опция paginate',
        ];
    }
}