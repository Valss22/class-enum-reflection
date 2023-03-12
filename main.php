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
    
    foreach ($enumCases as $name => $value)
    {
        $enumCases[$name] = $value->value;
    }

    // $enumCases = ksort($enumCases);
    // $classVars = ksort($classVars);

    // if ($classVars === $enumCases)
    // {
    //     echo 'ok!';
    // }
    // else
    $classAttributes = var_dump(...array_keys($classVars));
    if (count($classVars) === count($enumCases))
    {
        foreach ($classVars as $name => $value)
        {
            if (!array_key_exists($name, $enumCases))
            {
                
                $array[] = "название case '$name' в enum '$enum' не верное. Возможные варианты $classAttributes";
            }
        }
    }
    echo var_dump(...$array);
}

?>