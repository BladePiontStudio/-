<?php
$a = [];

$a[1] = "a";

$a[] = "b";

$a["k1"] = "v1";
$a["k2"] = "v2";

echo $a["k1"];

$a["k1"] = "c";

unset($a["k2"]);

