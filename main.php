<?php

$classToEnumMapper = [
    TestClass::class => TestEnum::class
];

enum TestEnum : int 
{
    case one = 1;
    case two = 2;
}

// class TestClass
// {
//     public $one = 1;
//     public $two = 2;
// }

// $props = get_object_vars(new TestClass);

foreach ($classToEnumMapper as $class => $enum)
{
    $reflection = new ReflectionClass($enum);
    $constants = $reflection->getConstants();

    foreach ($constants as $name => $value)
    {
        $constants["$name"] = $value->value;
    }
    echo var_dump($constants);
}

?>