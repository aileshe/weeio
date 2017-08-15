<?php
// +----------------------------------------------------------------------
// | Weeio - 简单、高效的PHP微框架    http://github.com/aileshe/weeio
// +----------------------------------------------------------------------
// | Copyright (c) 2017 Dejan.He All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Dejan.He <673008865@qq.com>
// +----------------------------------------------------------------------

//----------------------------------
// Weeio 日志类驱动文件
//----------------------------------

namespace weeio\lib\drive\log;
use weeio\lib\conf;
class file{
    public $path;#日志存储位置
    public function __construct(){
       $conf = conf::get('OPTION','log');
       $this->path = $conf['PATH'];
    }
    
    public function log($message,$file = 'log'){
        /**
         * 1.确认文件存储位置是否存在
         *  新建目录
         * 2.写入日志
         */
        $this->path=$this->path.date('Ymd-H').'/';
        if(!is_dir($this->path)){
         mkdir($this->path,'0777',true);
        }
        return file_put_contents($this->path.$file.'.php', date('Y-m-d H:i:s').json_encode($message).PHP_EOL,FILE_APPEND);
    }
}
//文件系统