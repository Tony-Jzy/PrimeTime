<?php

/**
 * 此类为JSON输出 HelperFunctions
 */

require_once 'Config.php';

class JSON{
	function json_encode_string($in_str) {
		    mb_internal_encoding("UTF-8");
			$convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
			$mb = function_exists('mb_ereg')?'mb_ereg':'preg_match';
			$regex = function_exists('mb_ereg')?"&#(\\d+);":"/&#(\\d+);/u";
			$str = "";
			for($i=mb_strlen($in_str)-1; $i>=0; $i--) {
				$mb_char = mb_substr($in_str, $i, 1);
				if($mb($regex, mb_encode_numericentity($mb_char, $convmap, "UTF-8"), $match)) {
					$str = sprintf("\\u%04x", $match[1]) . $str;
				} else {
					$str = $mb_char . $str;
				}
			}
			return $str;
	}
	function _array2json($array) {
		
			$piece = array();
			foreach ($array as $k => $v) {
				$piece[] = '"'.$k . '":' . $this->php2json($v);
			}
			if ($piece) {
				$json = '{' . implode(",\r", $piece) . '}';
			} else {
				$json = '[]';
			}
			return $json;
		}
	
	function php2json($value) {
			if (is_array($value)) {
				return $this->_array2json($value);
			}
			if (is_string($value)) {
				$value = str_replace(array("\n", "\t"), array(), $value);
				$value = addslashes($value);
				$value = $this->json_encode_string($value);
				return '"'.$value.'"';
			}
			if (is_bool($value)) {
				return $value ? 'true' : 'false';
			}
			if (is_null($value)) {
				return 'null';
			}
			return $value;
	}

    /**
     * 生成json数据
     * @param $array
     * @param $message
     * @param $code
     * @param string $count
     * @return string
     */
	function ArrayGetjson($array, $message, $code,$count=''){
		$temp_array = array();
		if(!empty($array)){
			foreach ($array as $k=>$v){
				$temp_array[] = $this->_array2json($v);
			}
		}
		$json_string = "{\r";
		$json_string.= "'code':".$code.",\r";
		$json_string.= "'message':".$message.",\r";
		$json_string.= "'datas':\r";
		if(!empty($temp_array)){
			foreach ($temp_array as $k=>$v){
				$json_string .= $v.",\r";
			}
		}
		if($count == ''){
			$json_string = trim($json_string,',')."}\n}";
		}else{
			$json_string = trim($json_string,',').'],"count":"'.$count.'"}';
		}
		return $json_string;
	}

    /**
     * 将array生成JSON String
     * @param $data
     * @param null $indent
     * @return string
     */
	function jsonFormat($data, $indent=null){  
  
	    // 对数组中每个元素递归进行urlencode操作，保护中文字符  
	    array_walk_recursive($data, 'jsonFormatProtect');  
	  
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