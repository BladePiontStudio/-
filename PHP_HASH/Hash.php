<?php

/**
 * @description Hash任意长度的输入（又叫做预映射pre-image）通过散列算法变换成固定长度的输出，该输出就是散列值。
 * Class Hash
 */
class Hash {

    /**
     * @description 获取普通的hash
     * @param $key
     * @return int
     */
    public function getCommonHash($key){
        $md5 = substr(md5($key), 0, 8);
        $seed = 31;
        $hash = 0;
        for ($i=0;$i<8;$i++){
            $hash = $hash*$seed+ord($md5{$i});
            $i++;
        }
        return $hash & 0x7FFFFFFF;
    }
}