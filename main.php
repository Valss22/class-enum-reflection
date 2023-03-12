<?php

$enumToClassMapper = [
    TestEnum::class => new TestClass
];

enum TestEnum : int 
{
    case one = 1;
    case two = 2;
}

class TestClass
{
    public $two = 2;
    public $one = 1;
}

foreach ($enumToClassMapper as $enum => $class)
{
    $classVars = get_object_vars(new $class);
    $enumReflection = new ReflectionClass($enum);
    $enumCases = $enumReflection->getConstants();
    
    foreach ($enumCases as $name => $value)
    {
        $enumCases[$name] = $value->value;
    }

    $enumCases = ksort($enumCases);
    $classVars = ksort($classVars);

    if ($classVars === $enumCases)
    {
        echo 'ok!';
    }
    else
    {
        echo 'error';
    }
}

?>