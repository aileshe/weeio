<?php
/**
 * Weeio - 简单、高效的PHP微框架    http://github.com/aileshe/weeio
 * Copyright (c) 2017 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

// Weeio config配置文件载入类

namespace weeio\lib;
class conf{
    static public $conf=[];
    static public function get($name,$file){
        /**
         * 1.判断配置文件是否存在
         * 2.判断配置是否存在
         * 3.缓存配置
         */
        if(isset(self::$conf[$file])){
            return self::$conf[$file][$name];
        }else{
            $path=ROOT.'/weeio/config/'.$file.'.php';
            if(is_file($path)){
                $conf=include $path;
                if(isset($conf[$name])){
                    self::$conf[$file]=$conf;
                    return $conf[$name];
                }else{
                    throw new \Exception('没有这个配置项'.$name);
                }
            }else{
                throw new \Exception('找不到配置文件'.$file);
            }
        }
    }
    
    static public function all($file){
        if(isset(self::$conf[$file])){
            return self::$conf[$file];
        }else{
            $path=ROOT.'/weeio/config/'.$file.'.php';
            if(is_file($path)){
                $conf=include $path;
                self::$conf[$file]=$conf;
                return $conf;
            }else{
                throw new \Exception('找不到配置文件'.$file);
            }
        }
    }
}