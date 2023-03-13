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

    foreach ($enumCases as $enumCaseName => $enumCaseValue)
    {
        if (!array_key_exists($enumCaseName, $classConstants))
        {
            $errorLogs[] = "Константа '$enumCaseName' в enum '$enum' не определена в классе '$className'";
        }
        else
        {
            $classConstValue = $classConstants[$enumCaseName];
            $enumCaseValue = $enumCaseValue->value;
            if ($enumCaseValue !== $classConstValue)
            {
                $errorLogs[] = "Значение $enumCaseName=$enumCaseValue в enum '$enum' не совпадает с значением в классе '$className' ($enumCaseName=$classConstValue)";
            }
        }
    }
    foreach ($classConstants as $classConstName => $classConstValue)
    {
        if (!array_key_exists($classConstName, $enumCases))
        {
            $errorLogs[] = "Константа '$classConstName' в классе '$className' должна быть определена в enum '$enum'";
        }
    }
}
if (!empty($errorLogs))
{
    var_dump(...$errorLogs);
}
?>