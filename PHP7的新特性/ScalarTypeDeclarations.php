<?php
declare(strict_types=1);
function output(int $a)
{
    echo $a;
}

output(1);

//函数返回值类型声明
function output2(): ? int
{
    return null;
}

//try catch捕获error报错
try {
    output('a');
}catch (Error $e){
    var_dump($e);
}