<?php

namespace Alexvkokin\ConsoleCommandLib\Src\Classes;

use Alexvkokin\ConsoleCommandLib\Src\Helpers\StrHelper;
use Alexvkokin\ConsoleCommandLib\Src\Interfaces\{CommandInterface, DocInterface};
use ReflectionClass;

class Command implements CommandInterface
{
    /**
     * @var string|null Название команды, если не задана, то присваивается название класса команды
     */
    protected string $name = '';

    /**
     * @var DocInterface Документация
     */
    public DocInterface $documentation;

    /**
     * @var string[] Список всех отфильтрованных аргументов полученных из консоли
     */
    protected array $consoleArguments = [];

    /**
     * @var string[] Список всех аргументов команды
     */
    protected array $allArguments = [];

    /**
     * @var string[] Список всех отфильтрованных опций полученных из консоли
     */
    protected array $consoleOptions = [];

    /**
     * @var string[] Список всех опций команды
     */
    protected array $allOptions = [];

    /**
     * @var View Вывод отчета в консоль
     */
    protected View $view;

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $this->setName($this->name);
        $this->view = new View();
        $this->documentation = new Doc();
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function setName($name): void
    {
        if (empty($name)) {
            try {
                $reflect = new ReflectionClass(static::class);
                $name = StrHelper::normalizeCommand($reflect->getShortName());
                $this->name = $name;
            } catch (\ReflectionException $e) {
                throw new \ReflectionException('Задан не верный класс, при установки названия команды');
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getArguments(bool $isFromConsole = true): array
    {
        return $isFromConsole ? $this->consoleArguments : $this->allArguments;
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function setArguments(array $arguments): void
    {
        try {
            $reflect = new ReflectionClass(static::class);
            foreach ($reflect->getProperties() as $prop) {

                if (substr($prop->name, 0, 8) == 'argument') {
                    $propName = $prop->name;
                    $propNameNormalize = StrHelper::normalizeArgument($propName);

                    $this->$propName = in_array($propNameNormalize, $arguments);

                    // Регистрируем аргумент
                    if ($this->$propName) {
                        $this->consoleArguments[] = $propNameNormalize;
                    }
                    $this->allArguments[] = $propNameNormalize;
                }
            }
        } catch (\ReflectionException $e) {
            throw new \ReflectionException('Задан не верный класс, при присваивании аргументов');
        }
    }

    /**
     * @inheritDoc
     */
    public function getOptions(bool $isFromConsole = true): array
    {
        return $isFromConsole ? $this->consoleOptions : $this->allOptions;
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function setOptions($options): void
    {
        try {
            $reflect = new ReflectionClass(static::class);
            foreach ($reflect->getMethods() as $method) {

                if (substr($method->name, 0, 6) == 'option') {
                    $methodName = $method->name;
                    $methodNameNormalize = StrHelper::normalizeOption($methodName);

                    // Регистрируем опцию
                    if (isset($options[$methodNameNormalize])) {
                        $this->consoleOptions[$methodNameNormalize] = $options[$methodNameNormalize];
                    }
                    $this->allOptions[$methodNameNormalize] = $options[$methodNameNormalize];
                }
            }
        } catch (\ReflectionException $e) {
            throw new \ReflectionException('При сборе данных об опциях произошла непредвиденная ошибка');
        }
    }


    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function runOptions(): void
    {
        if (empty($this->consoleOptions)) {
            return;
        }
        try {
            foreach ($this->consoleOptions as $optionName => $optionVals) {
                $optionMethod = StrHelper::denormalizeOption($optionName);
                if (method_exists($this, $optionMethod)) {
                    $this->$optionMethod($optionVals);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('При вызове методов произошла непредвиденная ошибка');
        }
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function run(bool $isRun = true): void
    {
        if ($isRun) {
            // Выводим подробную информацию
            $this->view->commandRender($this->getName(), $this->consoleArguments, $this->consoleOptions);

            // Запуск методов команды
            $this->runOptions();
        }
    }
}
