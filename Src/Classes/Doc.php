<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Classes;

use Alexvkokin\ConsoleCommandLib\Src\Interfaces\DocInterface;

class Doc implements DocInterface
{
    /**
     * @inheritDoc
     */
    public function command(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function arguments(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function options(): array
    {
        return [];
    }
}