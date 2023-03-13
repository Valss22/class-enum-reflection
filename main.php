<?php

$enumToClassMapper = [
    TestEnum::class => new TestClass
];

enum TestEnum : int 
{
    case one1 = 1;
    case two = 3;
    case three = 3;
}

class TestClass
{
    private $two = 2;
    private $one = 1;
    private $four = 4;
    private $five = 5;
}

$errorLogs = [];

foreach ($enumToClassMapper as $enum => $class)
{
    $classReflection = new ReflectionClass($class);
    $className = $classReflection->getName();

    $privateProperties = $classReflection->getProperties(ReflectionProperty::IS_PRIVATE);
    $classAttributes = [];

    foreach ($privateProperties as $property)
    {
        $property->setAccessible(true);
        $classAttributes[$property->getName()] = $property->getValue($class);
    }

    $enumReflection = new ReflectionClass($enum);
    $enumCases = $enumReflection->getConstants();

    foreach ($enumCases as $name => $value)
    {
        if (!array_key_exists($name, $classAttributes))
        {
            $errorLogs[] = "Константа '$name' в enum '$enum' не определенна в классе '$className'";
        }
        else
        {
            $classValue = $classAttributes[$name];
            $enumValue = $value->value;
            if ($enumValue !== $classValue)
            {
                $errorLogs[] = "Значение $name=$enumValue в enum '$enum' не совпадает с значением в классе '$className' ($name=$classValue)";
            }
        }
    }
    foreach ($classAttributes as $name => $value)
    {
        if (!array_key_exists($name, $enumCases))
        {
            $errorLogs[] = "Атрибут '$name' в классе '$className' должен быть определен в enum '$enum'";
        }
    }
    echo var_dump(...$errorLogs);
}

?>