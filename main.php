<?php

$enumToClassMapper = [
    TestEnum::class => TestClass::class,
];

enum TestEnum : int 
{
    case one1 = 1;
    case two = 3;
    case three = 3;
}

class TestClass
{
    const two = 2;
    const one = 1;
    const four = 4;
    const five = 5;
}

$errorLogs = [];

foreach ($enumToClassMapper as $enum => $class)
{
    $classReflection = new ReflectionClass($class);
    $className = $classReflection->getName();
    $classConstants = $classReflection->getConstants();

    $enumReflection = new ReflectionClass($enum);
    $enumCases = $enumReflection->getConstants();

    foreach ($enumCases as $name => $value)
    {
        if (!array_key_exists($name, $classConstants))
        {
            $errorLogs[] = "Константа '$name' в enum '$enum' не определена в классе '$className'";
        }
        else
        {
            $classValue = $classConstants[$name];
            $enumValue = $value->value;
            if ($enumValue !== $classValue)
            {
                $errorLogs[] = "Значение $name=$enumValue в enum '$enum' не совпадает с значением в классе '$className' ($name=$classValue)";
            }
        }
    }
    foreach ($classConstants as $name => $value)
    {
        if (!array_key_exists($name, $enumCases))
        {
            $errorLogs[] = "Константа '$name' в классе '$className' должна быть определена в enum '$enum'";
        }
    }
}
if (!empty($errorLogs))
{
    var_dump(...$errorLogs);
}
?>