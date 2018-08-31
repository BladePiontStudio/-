<?php
/**
 * Created by PhpStorm.
 * User: randolfjay
 * Date: 2018/8/30
 * Time: 下午6:19
 */
include_once "Hash.php";
$servers = array(array('host' => '', 'port'), array('host' => '', 'port'));
$key = "sadasdsadsadasa1da1";
$hash = new Hash();
$index = $hash->getCommonHash($key) % 2;