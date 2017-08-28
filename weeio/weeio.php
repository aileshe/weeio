<?php
/**
 * Weeio - 简单、高效的PHP微框架    http://github.com/aileshe/weeio
 * Copyright (c) 2017 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

// Weeio 公共入口文件

namespace weeio;
class weeio{
    public static $classMap = [];
    public $assign;
    static public $module; #访问模块
    static public $controller; # 访问控制器
    static public $action; # 访问方法
    static public function run(){
        $route = new \weeio\lib\route();
        self::$module=$route->module;
        self::$controller= $route->controller;
        self::$action=$route->action;
        $ctrlClass='\\app\\'.self::$module.'\\controller\\'.self::$controller.'Controller';
        $prm = $_POST?$_POST:$_GET;
        self::url_params_bind($ctrlClass,self::$action,$prm);
        
        // 日志类初始化
        \weeio\lib\log::init();
        \weeio\lib\log::log('ctrl:'.$ctrlClass.'   '.'action:'.self::$action);
    }
    static public function load($class){
        //自动加载类库
        // new \weeio\route();
        // $class = '\weeio\route';
        // ROOT.'/weeio/route.php';
        if(isset($classMap[$class])){
            return true;
        }else{
            $class = str_replace('\\','/',$class);
            if(is_file(ROOT.'/'.$class.'.php')){
                include ROOT.'/'.$class.'.php';
                self::$classMap[$class]=$class;
            }else{
                return false;
            }
        }
    }
    
    public function assign($name,$value){
        $this->assign[$name]=$value;
    }
    
    public function display($file=NULL){
        $file=$file?$file.'.html':self::$action.'.html';
        $path=APP.'/'.self::$module.'/view/'.self::$controller.'/'.$file;
        if(is_file($path)){
            $loader = new \Twig_Loader_Filesystem(APP.'/'.self::$module.'/view/'.self::$controller);
            $twig = new \Twig_Environment($loader, array(
                'cache' => ROOT.'/runtime/cache',
                'debug' => DEBUG,
            ));
            $template = $twig->load($file);
            $template->display($this->assign?$this->assign:array());
        }
    }
    
    /**
     * 通过反射进行参数绑定调起类的方法
     * @param  $ctrlClass  控制器类   xxx::class
     * @param  $action     访问的成员方法名
     * @param  $param_arr  参数数组['id'=>123,'name'=>'Dejan']
     */
    static public function url_params_bind($ctrlClass,$action,$param_arr){
        // 获取类的反射
        $controllerReflection = new \ReflectionClass($ctrlClass);
        // 判断该类是否可实例化对象
        if (!$controllerReflection->isInstantiable()) {
            throw new \RuntimeException("{$controllerReflection->getName()}控制器类不能被实例化!");
        }
    
        // 判断指定成员方法是否存在
        if (!$controllerReflection->hasMethod($action)) {
            throw new \RuntimeException("{$controllerReflection->getName()}找不到类方法:{$action}");
        }
        // 获取对应方法的反射
        $actionReflection = $controllerReflection->getMethod($action);
        // 获取方法的参数的反射列表（多个参数反射组成的数组）
        $paramReflectionList = $actionReflection->getParameters();
        // 参数，用于action
        $params = [];
        # 循环参数反射
        # 如果存在路由参数的名称和参数的名称一致，就压进params里面
        # 如果存在默认值，就将默认值压进params里面
        # 如果。。。没有如果了，异常
        foreach ($paramReflectionList as $paramReflection) {
            # 是否存在同名字的路由参数
            if (isset($param_arr[$paramReflection->getName()])) {
                $params[] = $param_arr[$paramReflection->getName()];
                continue;
            }
            # 是否存在默认值
            if ($paramReflection->isDefaultValueAvailable()) {
                $params[] = $paramReflection->getDefaultValue();
                continue;
            }
            # 异常
            throw new \RuntimeException(
            "{$controllerReflection->getName()}::{$actionReflection->getName()}的参数{$paramReflection->getName()}必须传值"
            );
        }
    
        # 调起
        $actionReflection->invokeArgs($controllerReflection->newInstance(), $params);
    }
}