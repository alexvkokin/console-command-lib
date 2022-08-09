<?php

namespace App\Commands\HelloWorld;

use Alexvkokin\ConsoleCommandLib\Src\Classes\BaseCommand;


class HelloWorldCommand extends BaseCommand
{
    /**
     * @var string Название команды
     */
    protected string $name = 'hello_world';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct();

        // Документация для команды
        $this->documentation = new HelloWorldDoc();
    }

    public bool $argumentWithLove;

    /**
     * Приветствие
     *
     * @param $name
     * @return void
     */
    public function optionHello($name): void
    {
        var_dump('Привет', $name);
    }
}
