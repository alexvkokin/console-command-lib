<?php

namespace App\Commands\Order;

use Alexvkokin\ConsoleCommandLib\Src\Classes\BaseCommand;

class OrderCommand extends BaseCommand
{
    protected string $name = 'order';

    public bool $argumentVerbose;
    public bool $argumentOverwrite;
    public bool $argumentUnlimited;
    public bool $argumentLog;

    public function __construct()
    {
        parent::__construct();

        // Документация для команды
        $this->documentation = new OrderDoc();
    }

    public function optionLog_File($params): void
    {
        var_dump('Запуск метода log_file', $params);
    }

    public function optionMethods($params): void
    {
        var_dump('Запуск метода methods', $params);
    }

    public function optionPaginate($params): void
    {
        var_dump('Запуск метода paginate', $params);
    }

}