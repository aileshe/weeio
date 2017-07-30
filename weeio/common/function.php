<?php
function cout($text){
    if(is_array($text)){
        echo '<pre style="font-size:18px;border:dashed 1px blue;padding:5px;display:inline-block;margin:0;">'.print_r($text).'</pre><br/>';
    }else{
        echo '<pre style="font-size:18px;border:dashed 1px blue;padding:5px;display:inline-block;margin:0;">'.$text.'</pre><br/>';
    }
}