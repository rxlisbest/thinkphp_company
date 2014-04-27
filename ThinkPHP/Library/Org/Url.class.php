<?php

namespace Org\Url;
/**
 *模块重新添加入口文件后生成路由 
 */
class Url {

	public function ADMIN_URL($method=''){
		return '/admin.php/'.$method;
	}

	public function LOGIN_URL($method=''){
		return "/login.php/".$method;
	}
}
