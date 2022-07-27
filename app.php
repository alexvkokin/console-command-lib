<?php

use Alexvkokin\ConsoleCommandLib\Src\Classes\Console;

require __DIR__.'/vendor/autoload.php';

try{
    (new Console($argv))
        ->registers([
            new App\Commands\HelloWorld\HelloWorldCommand(),
            new App\Commands\Calc\CalcCommand(),
            new App\Commands\Order\OrderCommand(),
        ])
        ->run();
} catch (\Exception $e) {
    print PHP_EOL . $e->getMessage() . PHP_EOL;
}

