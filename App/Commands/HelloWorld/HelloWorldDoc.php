<?php

namespace App\Commands\HelloWorld;

use Alexvkokin\ConsoleCommandLib\Src\Classes\Doc;

class HelloWorldDoc extends Doc
{
    /**
     * @inheritDoc
     */
    public function command(): string
    {
        return 'Команда предназначена посылать приветствие';
    }

    /**
     * @inheritDoc
     */
    public function arguments(): array
    {
        return [
            'verbose' =>  'Аргумент verbose',
        ];
    }

    /**
     * @inheritDoc
     */
    public function options(): array
    {
        return [
            'method' =>  'Опция method - может содержать параметры {create,update,delete}',
        ];
    }
}