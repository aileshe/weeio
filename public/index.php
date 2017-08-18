<?php
/**
 * 入口文件
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 */

define('ROOT',realpath('../')); //当前项目根目录路径
define('CORE', ROOT.'/weeio');//框架的核心文件目录
define('APP', ROOT.'/app');//项目文件目录
define('MODULE', 'Home'); // 默认模块

include '../weeio/vendor/autoload.php';

define('DEBUG', true);//是否开启调试模式
if(DEBUG){
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
    ini_set('display_error','On');
}else{
    ini_set('display_error','Off');
}


include CORE.'/common/function.php';
include CORE.'/weeio.php';

spl_autoload_register('\weeio\weeio::load');

\weeio\weeio::run();