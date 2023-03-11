<?php

enum TestEnum : int 
{
    case one = 1;
    case two = 2;
}

$reflection = new ReflectionClass(TestEnum::class);
$constants = $reflection->getConstants();

foreach ($constants as $name => $value) {
    $constants["$name"] = $value->value;
}
echo var_dump($constants);


class TestClass {
    public $one = 1;
    public $two = 2;
}

$props = get_object_vars(new TestClass());
echo var_dump($props);

echo $constants === $props;
?>