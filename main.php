<?php

$enumToClassMapper = [
    TestEnum::class => new TestClass
];

enum TestEnum : int 
{
    case one1 = 1;
    case two = 2;
}

class TestClass
{
    public $two = 2;
    public $one = 1;
}

$errorLogs = [];

foreach ($enumToClassMapper as $enum => $class)
{
    $classVars = get_object_vars(new $class);
    $enumReflection = new ReflectionClass($enum);
    $enumCases = $enumReflection->getConstants();

    if (count($classVars) === count($enumCases))
    {
        foreach ($classVars as $name => $value)
        {
            if (!array_key_exists($name, $enumCases))
            {
                
                $errorLogs[] = "название case '$name' в enum '$enum' не правильное";
            }
            else
            {
                if ($value !== $enumCases[$name]->value)
                {
                    $errorLogs[] = "значение case '$name' в enum '$enum' не совпадает с значением в классе";
                }
            }
        }
    }
    echo var_dump(...$errorLogs);
}

?>