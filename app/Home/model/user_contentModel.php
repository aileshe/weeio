<?php
namespace app\Home\model;

use weeio\lib\model;

class user_contentModel extends model{
    public $table = 'user_content';
    public function lists(){
        $result = $this->select($this->table,'*');
        return $result;
    }
}