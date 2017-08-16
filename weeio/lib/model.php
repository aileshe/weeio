<?php
/**
 * Weeio - 简单、高效的PHP微框架    http://github.com/aileshe/weeio
 * Copyright (c) 2017 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

// Weeio Model模型类

namespace weeio\lib;
use weeio\lib\conf;
class model extends \Medoo\Medoo{
    public function __construct(){
        $option = conf::all('database');
        parent::__construct($option);
    }
}