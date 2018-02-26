<?php

/**
 * 此类为JSON输出 HelperFunctions
 */

class JSON{

    /**
     * 将array生成JSON String
     * @param $data
     * @param null $indent
     * @return string
     */
	function jsonFormat($data, $indent=null){  
  
	    // 对数组中每个元素递归进行urlencode操作，保护中文字符  
//	    array_walk_recursive($data, 'jsonFormatProtect');
	  
	    // json encode  
	    $data = json_encode($data);  
	  
	    // 将urlencode的内容进行urldecode  
	    $data = urldecode($data);  
	  
	    // 缩进处理  
	    $ret = '';  
	    $pos = 0;  
	    $length = strlen($data);  
	    $indent = isset($indent)? $indent : '    ';  
	    $newline = "\r\n";  
	    $prevchar = '';  
	    $outofquotes = true;  
	  
	    for($i=0; $i<=$length; $i++){  
	  
	        $char = substr($data, $i, 1);  
	  
	        if($char=='"' && $prevchar!='\\'){  
	            $outofquotes = !$outofquotes;  
	        }elseif(($char=='}' || $char==']') && $outofquotes){  
	            $ret .= $newline;  
	            $pos --;  
	            for($j=0; $j<$pos; $j++){  
	                $ret .= $indent;  
	            }  
	        }  
	  
	        $ret .= $char;  
	          
	        if(($char==',' || $char=='{' || $char=='[') && $outofquotes){  
	            $ret .= $newline;  
	            if($char=='{' || $char=='['){  
	                $pos ++;  
	            }  
	  
	            for($j=0; $j<$pos; $j++){  
	                $ret .= $indent;  
	            }  
	        }  
	  
	        $prevchar = $char;  
	    }  
	  
	    return $ret;  
	}  
  
	/** 将数组元素进行urlencode 
	* @param String $val 
	*/  
	function jsonFormatProtect(&$val){  
	    if($val!==true && $val!==false && $val!==null){  
	        $val = urlencode($val);  
	    }  
	}  


}