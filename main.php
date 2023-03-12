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
    private $two = 2;
    private $one = 1;
}

$errorLogs = [];

foreach ($enumToClassMapper as $enum => $class)
{
    $classReflection = new ReflectionClass($class);
    $privateProperties = $classReflection->getProperties(ReflectionProperty::IS_PRIVATE);
    $privateValues = [];

    foreach ($privateProperties as $property)
    {
        $property->setAccessible(true);
        $privateValues[$property->getName()] = $property->getValue($class);
    }

    $enumReflection = new ReflectionClass($enum);
    $enumCases = $enumReflection->getConstants();

    if (count($privateValues) === count($enumCases))
    {
        foreach ($privateValues as $name => $value)
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