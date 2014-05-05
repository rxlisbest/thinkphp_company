<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
use home\Common\HomeController;
class AboutController extends HomeController {
	public function index(){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);
		$ContactModel = D("Contact");
		$Contact = $ContactModel->where('con_istop = 1')->find();
		$this->assign('Contact',$Contact);

		$title = "关于本站";
		$this->assign('title',$title);

		$this->display("about");
	}
}
