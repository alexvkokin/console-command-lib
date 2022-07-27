# Библиотека для создания консольных команд
Библиотека предоставляет функционал для быстрого создания консольных команд


## Создание консольной команды

### Создание класса
Консольная команда по сути является обычным классом, где будут прописаны все аргументы и опции, данный класс должен быть наследован от базового класса библиотеки ```BaseCommand``` 

Директория, в которую вы поместите новый класс, может находиться в любом месте вашего проекта, но все же рекомендуется создавать его в специально отведенную для этого папку.

К примеру для команды калькулятора структура может выглядеть так
```
- App
  - Commands
    - Calс
       CalcCommand
```

Название класса может быть произвольным, но рекомендуется называть его созвучно с названием консольной команды, а в конце присоединять ключевое слово ```Command```. К примеру для калькулятора, название класса будет ```CalcCommand```

Далее будем рассматривать создание команды на примере калькулятора

### Регистрация нового класса

Следующий шаг - зарегистрировать новый класс, сделать это можно в единой точке входа, для всех консольных команд, в файле ```app.php```  

```php
(new Console($argv))
    ->registers([
        new App\Commands\HelloWorld\HelloWorldCommand(),
        new App\Commands\Calc\CalcCommand(),
        
        // другие команды
        
    ])
    ->run(); 
```

### Название команды
По умолчание название команды будет совпадать с названием класса (в нижнем регистре), вы можете изменить имя команды прописав его в классе ```CalcCommand``` в свойстве ```name```.

```php
namespace App\Commands\Calc;

use Alexvkokin\ConsoleCommandLib\Src\Classes\BaseCommand;

class CalcCommand extends BaseCommand
{
    /**
     * @var string Название команды
     */
    protected string $name = 'calc';

    // ...
}
```

Вызов команды из консоли
```
$/usr/bin/php app.php calc
```

### Добавление аргументов

Аргументы это свойства класса. Чтобы добавить новый аргумент, необходимо в классе создать свойство с соответствующим именем (с заглавной буквы), перед которым будет добавлено ключевое слово ```argument```. ```Свойство должно иметь тип bool и быть публичный```. Аргументов может быть неограниченное количество

```php
namespace App\Commands\Calc;

use Alexvkokin\ConsoleCommandLib\Src\Classes\BaseCommand;

class CalcCommand extends BaseCommand
{
    // ... 
    
    /**
     * @var bool Аргумент increment
     */
    public bool $argumentIncrement;

    // ...
}
```

Вызов команды из консоли
```
$/usr/bin/php app.php calc {increment}
```

### Добавление опций

Опция это методы класса. Чтобы добавить новую опцию, нужно создать соответствующий названию опции, метод, с заглавной буквы, перед которым будет добавлено ключевое слово ```option```. Опций может быть неограниченное количество. В названии допускается символ нижнего подчеркивания _

```php
namespace App\Commands\Calc;

use Alexvkokin\ConsoleCommandLib\Src\Classes\BaseCommand;

class CalcCommand extends BaseCommand
{
    // ...

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
    
    // ...
}
```

Вызов команды из консоли
```
$/usr/bin/php app.php calc {increment} [sum={10,20,30}]
```

### Документация для команды

Чтобы добавить документацию для команды, нужно создать отдельный специализированный класс, с названием созвучным с командой и присоединить в конце ключевого слова ```Doc``` (класс может быть назван произвольно). Данный класс должен быть наследован от базового класса ```Doc``` 

Пример файла CalcDoc.php
```php
namespace App\Commands\Calc;

use Alexvkokin\ConsoleCommandLib\Src\Classes\Doc;

class CalcDoc extends Doc
{
    // ...
}
```

Внутри класса можно реализовать три метода (реализация не обязательна, можно реализовать только часть методов или не реализовывать вовсе):
- документация для команды
- документация для аргументов
- документация для опций

```php
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
```

Теперь нужно зарегистрировать данную документацию в классе команды калькулятора, для этого нужно вызвать конструктор и в нем прописать класс документации в свойство ```documentation```

```php
namespace App\Commands\Calc;

use Alexvkokin\ConsoleCommandLib\Src\Classes\BaseCommand;

class CalcCommand extends BaseCommand
{
    // ...

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct();

        // Документация для команды
        $this->documentation = new CalcDoc();
    }
```

## Правила оформления входящих аргументов в консоли

1) название команды передается первым аргументом в произвольном формате;
2) аргументы запуска передаются в фигурных скобках через запятую в следующем  формате:
* одиночный аргумент: {arg}
* несколько аргументов: {arg1,arg2,arg3} ИЛИ {arg1} {arg2} {arg3} ИЛИ {arg1,arg2} {arg3}
3) параметры запуска передаются в квадратных скобках в следующем формате:
* параметр с одним значением: [name=value]
* параметр с несколькими значениями: [name={value1,value2,value3}]

4) При запуске приложения без указания конкретной команды или команды, которой не существует, выведется список всех зарегистрированных в нём команд и их описания.

5) При запуске любой из команд с аргументом {help} будет выводиться описание команды.

```bash
$/usr/bin/php app.php order {verbose,overwrite} [log_file=app.log] {unlimited} [methods={create,update,delete}] [paginate=50] {log}

$/usr/bin/php app.php

$/usr/bin/php app.php calc {help}
```
