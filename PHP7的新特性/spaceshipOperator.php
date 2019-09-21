<?php
//太空船操作符
//整数
echo 1 <=> 2, PHP_EOL;//左边小于右边 -1
echo 1 <=> 1, PHP_EOL;//左边等于右边 0
echo 1 <=> 0, PHP_EOL;//左边大于右边 1

//浮点数
echo 1.1 <=> 1.2, PHP_EOL;//左边小于右边 -1
echo 1.1 <=> 1.1, PHP_EOL;//左边等于右边 0
echo 1.1 <=> 0.9, PHP_EOL;//左边大于右边 1

//字符串
echo 'a' <=> 'b', PHP_EOL;//左边小于右边 -1
echo 'a' <=> 'a', PHP_EOL;//左边等于右边 0
echo 'a' <=> 'c', PHP_EOL;//左边大于右边 1

