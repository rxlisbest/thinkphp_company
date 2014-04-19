<?php

namespace Org\Url;
/**
 *模块重新添加入口文件后生成路由 
 */
class Url {

	public function ADMIN_URL($method=''){
		$url = "/admin.php";
		if($method){
			$url .= '/'.$method;
		}
		return $url;
	}

	public function LOGIN_URL($method=''){
		$url = "/login.php";
		if($method){
			$url .= '/'.$method;
		}
		return $url;
	}
}
