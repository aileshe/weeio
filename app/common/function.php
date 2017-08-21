<?php
// 测试公共函数调用方法
function get_path(){
    echo realpath('./')."\n";
}