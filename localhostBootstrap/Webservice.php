<?php

class Webservice{
	public static $host = "";
	public static $physicalPath = "";
	public static $Online = '';		
	public static $Offline = '';

	public function __construct() {
	
    }   

    public function listFiles(){
    	$option = $_GET['option'];
    	self::$physicalPath .= $option;
    	
		$path = self::$physicalPath;
		$linkpath = self::$host;
		$directory = dir($path);
		while($file = $directory -> read()){
			$pathInfo = pathinfo($file);
			$files[] = array(
				'name' => $file, 
				'date' => date ("Y-m-d H:i:s", filemtime($file)),
				'file-folder'=> ($pathInfo['extension'] ? 0 : 1),
			); 			
		}
		$order_by = strtolower($_GET['order_by']);
		$direction = strtolower($_GET['direction']);
		$directory -> close();

		$files = self::sort_arr_of_obj($files, $order_by, $direction);

		foreach ($files as $key => $value) {		
			$file = $value['name'];
			$pathInfo = pathinfo($file);
			if($pathInfo['extension']){
				$img = "<i class='glyphicon glyphicon-file'></i>";
				$style="style='color:#aaa'";
				$href = self::generateHref($option,$file,'file');
			}else{
				$img = "<i class='glyphicon glyphicon-folder-close'></i>";
				$style="";
				$href = self::generateHref($option,$file,'folder');
			}			
			$list .= "<a $style class='list-group-item' href='".$href."'>".$img.' '.$file."</a>";
		}
		
		return $list;
	}

	private function sort_arr_of_obj($array, $sortby, $direction='asc') {     
	    $sortedArr = array();
	    $tmp_Array = array();
	     
	    foreach($array as $k => $v) {	    	
	        $tmp_Array[] = strtolower($v[$sortby]);
	    }	     
	    if($direction=='asc'){
	        asort($tmp_Array);
	    }else{
	        arsort($tmp_Array);
	    }	     
	    foreach($tmp_Array as $k=>$tmp){
	        $sortedArr[] = $array[$k];
	    }	 

	    return $sortedArr;	 
	}

	private function generateHref($option,$file,$type){
		$queryString = self::remove_querystring_var($_SERVER['QUERY_STRING'],'option');
		if($type == 'file'){
			$absolutePath = self::verifyFolder($option,$file);
			$href = $absolutePath;	
		}else{
			$absolutePath = self::verifyFolder($option,$file);
			$href = "index.php?option=".$absolutePath.'&'.$queryString;	
		}
		return $href;
	}

	public function generateDropDown($class,$name){
		switch ($name) {
			case 'Order by':
				$fieldName = 'order_by';
				$actions = array('Name','Date','File-Folder');
				break;
			case 'Direction':
				$fieldName = 'direction';
				$actions = array('Asc','Desc');
				break;			
			default:
				# code...
				break;
		}
		$dropDown = 
		'<div class="btn-group" ><button type="button" class="btn btn-'.$class.' dropdown-toggle" data-toggle="dropdown">'.$name.' <span class="caret"></span></button>
		<ul class="dropdown-menu" role="menu">';		
		foreach ($actions as $key => $action) {
			$exists = stripos($_SERVER['QUERY_STRING'], $action);
			$active = '';
			if($exists){
				$active = 'class="active"';
			}
			$queryString = self::remove_querystring_var($_SERVER['QUERY_STRING'],$fieldName);		
			$link = self::$host.'/index.php?'.$queryString;
			if(!$active){
				$link.='&'.$fieldName.'='.$action ;
			}
			$dropDown.='<li '.$active.' ><a href="'.$link.'">'.$action.'</a></li>';
		}			  	
		$dropDown.= '</ul></div> <!-- /btn-group -->';

		return $dropDown;
	}

	private function remove_querystring_var($url, $key) {
		parse_str($url, $result_array);
		unset($result_array[$key]);
		$url = http_build_query($result_array);

		return $url;
	}
	private function verifyFolder($option,$file){
		if($file == '.' || $file == '..'){	
			$option = self::backOneFolder($option);
			return $option;
		}else{
			return $option.'/'.$file;
		}
	}

	private function backOneFolder($option){
		$path = (substr($option,0,strripos($option, '/')));
		return $path; 
	}

	public function createBreadcrumb(){
		$list  = '<ul class="breadcrumb">';
		$queryString = self::remove_querystring_var($_SERVER['QUERY_STRING'],'option');
		$list .= '<li><a href="'.self::$host.'/index.php?'.$queryString.'">Home</a> <span class="divider"></span></li>';
		$explode = explode('/', $_GET['option']);
		$href = self::generateHref($option,$file,'file');
		$links = array();
		foreach ($explode as $key => $value) {
			if(!empty($value)){
				$links[$key]['value'] = $value;
				$queryString = self::remove_querystring_var($_SERVER['QUERY_STRING'],'option');
				$links[$key]['link'] = 'index.php?option='.substr($_GET['option'], 0, stripos($_GET['option'], $value)).$value.'&'.$queryString;
				$list .= '<li><a href="'.$links[$key]['link'].'">'.$links[$key]['value'].'</a> <span class="divider"></span></li>';
			}
		}
		$list .= '</ul>';
		return $list;	
	}
}

?>
