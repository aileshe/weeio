<?php
// 测试公共函数调用方法
function get_path_r(){
    echo realpath('./')."\n";
}