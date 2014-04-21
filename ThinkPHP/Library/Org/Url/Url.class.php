<?php

namespace Org\Url;
/**
 *模块重新添加入口文件后生成路由 
 */
class Url {

	public function ADMIN_URL($method=''){
		$url = "/admin/index.php";
		if($method){
			$url .= '/'.$method;
		}
		return $url;
	}

	public function LOGIN_URL($method=''){
		$url = "/admin/login.php";
		if($method){
			$url .= '/'.$method;
		}
		return $url;
	}
}
