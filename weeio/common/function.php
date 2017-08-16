<?php
/**
 * Weeio - 简单、高效的PHP微框架    http://github.com/aileshe/weeio
 * Copyright (c) 2017 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

// Weeio 公共函数库

function cout($text){
    if(is_array($text)){
        echo '<pre style="font-size:18px;border:dashed 1px blue;padding:5px;display:inline-block;margin:0;">'.print_r($text).'</pre><br/>';
    }else{
        echo '<pre style="font-size:18px;border:dashed 1px blue;padding:5px;display:inline-block;margin:0;">'.$text.'</pre><br/>';
    }
}