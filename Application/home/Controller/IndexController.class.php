<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
use home\Common\HomeController;
class IndexController extends HomeController {
	public function index(){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);
		$ContactModel = D("Contact");
		$Contact = $ContactModel->where('con_istop = 1')->find();
		$this->assign('Contact',$Contact);

		$CaseModel = D("Case");
		$Cases = $CaseModel->order('c_id DESC')->limit(3)->select();
		$PageModel = D("Page");
		$Pages = $PageModel->order('p_id DESC')->limit(3)->select();
		$this->assign('Cases',$Cases);
		$this->assign('Pages',$Pages);
		$this->display("index");
	}
}
