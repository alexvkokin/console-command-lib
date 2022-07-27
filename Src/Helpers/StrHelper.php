<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Helpers;

/**
 * Хелпер по работе со строками
 */
class StrHelper
{
    /**
     * Приведение название команды к единому стандарту
     *
     * @param string $str
     * @return string
     */
    public static function normalizeCommand(string $str): string
    {
        $str = mb_strtolower($str);
        return $str;
    }

    /**
     * Приведение аргумента к единому стандарту
     *
     * @param string $str
     * @return string
     */
    public static function normalizeArgument(string $str): string
    {
        $str = substr($str, 0, 8) == 'argument' ? substr($str, 8) : $str;
        $str = mb_strtolower($str);
        return $str;
    }

    /**
     * Приведение опции к единому стандарту
     *
     * @param string $str
     * @return string
     */
    public static function normalizeOption(string $str): string
    {
        $str = substr($str, 0, 6) == 'option' ? substr($str, 6) : $str;
        $str = mb_strtolower($str);
        return $str;
    }

    /**
     * Приведение опции к единому стандарту
     *
     * @param string $str
     * @return string
     */
    public static function denormalizeOption(string $str): string
    {
        $str = mb_strtolower($str);
        $str = ucfirst($str);
        $str = 'option' . $str;

        return $str;
    }
}