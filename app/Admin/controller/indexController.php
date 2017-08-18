<?php
namespace app\Admin\controller;
use weeio\lib\model;

class indexController extends \weeio\weeio{
    public function index(){
        /*
        $model = new \app\model\user_contentModel();
        $data = $model->lists();
        dump($data);
        */
        header('Content-Type:text/html;charset=utf-8');
        $data = '这是网站后台模块!';
        dump($_GET);
        $this->assign('data',$data);
        $this->display();
    }
    
    public function test(){
        $data = 'test';
        $this->assign('data',$data);
        $this->display();
    }
}