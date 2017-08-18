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
        self::$action=$action=$route->action;
        $ctrlFile=APP.'/'.self::$module.'/controller/'.self::$controller.'Controller.php';
        $ctrlClass='\\app\\'.self::$module.'\\controller\\'.self::$controller.'Controller';
        if(is_file($ctrlFile)){
            include $ctrlFile;
            $ctrl = new $ctrlClass;
            $ctrl->$action();
            // 日志类初始化
            \weeio\lib\log::init();
            \weeio\lib\log::log('ctrl:'.$ctrlClass.'   '.'action:'.self::$action);
        }else{
            throw new \Exception('找不到控制器'.self::$controller);
        }
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
}