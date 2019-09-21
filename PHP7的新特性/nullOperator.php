<?php
//原来的格式
$a      = 'a';
$b      = 'b';
$result = $a ? $a : $b;

//新格式，如果??左侧存在且不为null，则返回左侧变量
$result = $a ?? $b;
echo $result, PHP_EOL;

$a = 0;
$result = $a ?? $b;//$a = 0 ,仍然返回$a
echo $result, PHP_EOL;

$result = $c ?? $b;//用不存在的变量$c
echo $result, PHP_EOL;