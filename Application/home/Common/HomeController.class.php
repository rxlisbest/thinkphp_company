<?php
namespace home\Common;

use Think\Controller;

class HomeController extends Controller
{
	function _initialize(){
		/*路由rewrite前的URL*/
		/*
		$this->assign('IndexUrl',"/");
		$this->assign('CaseUrl',U("Case/index","",""));
		$this->assign('PageUrl',U("Page/index","",""));
		$this->assign('ContactUrl',U("Contact/index","",""));
		$this->assign('BlogUrl',U("Blog/index","",""));

		$this->assign('detailUrl',U('detail','',''));
		$this->assign('ListUrl',U('index','',''));
		$this->assign('PageDetailUrl',U("Page/detail","",""));
		$this->assign('AboutUrl',U("About/index","",""));
		*/
		/*路由rewrite后的URL*/
		$this->assign('IndexUrl',"/");
		$this->assign('CaseUrl',"/case/index");
		$this->assign('PageUrl',"/page/index");
		$this->assign('ContactUrl',"/contact/index");
		$this->assign('BlogUrl',"/blog/index");

		$this->assign('detailUrl','/page/detail');
		$this->assign('ListUrl','/page/index');
		$this->assign('detailUrl','/page/detail');
		$this->assign('PageDetailUrl',"/page/detail");
		$this->assign('AboutUrl',"/about/index");
	}
}
