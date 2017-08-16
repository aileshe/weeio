<?php
/**
 * Weeio - 简单、高效的PHP微框架    http://github.com/aileshe/weeio
 * Copyright (c) 2017 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

// Weeio 日志类

namespace weeio\lib;
use weeio\lib\conf;
class log{
    static public $class;
    /**
     * 1.确定日志的储存方式
     * 
     * 2.写日志
     */
    
    static public function init(){
        //确定储存方式
        $drive=conf::get('DRIVE','log');
        $class = '\weeio\lib\drive\log\\'.$drive;
        self::$class = new $class;
    }
    
    static public function log($name,$file = 'log'){
        self::$class->log($name,$file);
    }
}