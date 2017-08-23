<?php
namespace app\Home\controller;
use weeio\lib\model;

class indexController extends \weeio\weeio{
    public function index(){
        /*
        $model = new \app\model\user_contentModel();
        $data = $model->lists();
        dump($data);
        */
        header('Content-Type:text/html;charset=utf-8');
        $data = '这是网站前台模块!';
        dump($_GET);
        $this->assign('data',$data);
        $this->display();
    }
    
    public function test(){
        $data = 'test';
        $this->assign('data',$data);
        $this->display();
    }
    
    /**
     * 测试调用公共函数
     */
    public function func(){
        get_path(); // 最外层公共函数库
        get_path_r(); // 模块公共函数库
    }
    
    /**
     * 测试URL参数绑定
     */
    function urlPrmBind($id,$name='Dejan'){
        echo "id:{$id}&nbsp;&nbsp;name:{$name}";
        dump($_GET);
    }
}