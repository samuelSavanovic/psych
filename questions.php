<?php

function permutations($input_array, $processed_array = array()) {
    $return_array = array();
    foreach ($input_array as $k=>$v) {
        $copy = $processed_array;
        $copy[$k] = $v;
        $temp = array_diff_key($input_array, $copy);
        if (count($temp) == 0) {
            $return_array[] = $copy;
        } else {
            $return_array = array_merge($return_array, permutations($temp, $copy));
        }
    }
    return $return_array;
}
function get_index($questions, $ordering) {
    foreach ($questions as $k=>$v) {
        $keys = array_keys($v);
        $str = join($keys);
        if($str == $ordering) {
            return $k;
        }
    }
}
function process($questions = array()) {
    global $order;
    $ret = array();
    foreach ($questions as $k => $v) {
        array_push($ret,'', $v, ' <br> 
                <input type="radio" value="1" 
                    name='. $k .'>Yes
                <input type="radio" value="0" 
                    name='. $k .'>No <br>
            ');
        array_push($order, $k);
    }
    return $ret;
}