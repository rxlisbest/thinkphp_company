<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
use home\Common\HomeController;
class ContactController extends HomeController {
	public function index(){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);
		$ContactModel = D("Contact");
		$Contact = $ContactModel->where('con_istop = 1')->find();
		$Contacts = $ContactModel->order('con_istop DESC,con_sort ASC')->select();
		$this->assign('Contact',$Contact);
		$this->assign('Contacts',$Contacts);

		$title = "联系我们";
		$this->assign('title',$title);
		$this->display("contact");
	}
}
