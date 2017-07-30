<?php
namespace weeio;
class weeio{
    public static $classMap = [];
    public $assign;
    static public $module; #访问模块
    static public function run(){
        $route = new \weeio\lib\route();
        self::$module=$route->module;
        $controller= $route->controller;
        $action=$route->action;
        $ctrlFile=APP.'/'.self::$module.'/controller/'.$controller.'Controller.php';
        $ctrlClass='\\app\\'.self::$module.'\\controller\\'.$controller.'Controller';
        if(is_file($ctrlFile)){
            include $ctrlFile;
            $ctrl = new $ctrlClass;
            $ctrl->$action();
            // 日志类初始化
            \weeio\lib\log::init();
            \weeio\lib\log::log('ctrl:'.$ctrlClass.'   '.'action:'.$action);
        }else{
            throw new \Exception('找不到控制器'.$controller);
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
    
    public function display($file){
        $file=APP.'/'.self::$module.'/view/'.$file;
        if(is_file($file)){
            $loader = new \Twig_Loader_Filesystem(APP.'/'.self::$module.'/view');
            $twig = new \Twig_Environment($loader, array(
                'cache' => ROOT.'/runtime/cache',
                'debug' => DEBUG,
            ));
            $template = $twig->load('index.html');
            $template->display($this->assign?$this->assign:array());
        }
    }
}