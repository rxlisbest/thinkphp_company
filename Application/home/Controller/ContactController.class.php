<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
class ContactController extends Controller {
	public function index(){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);
		$ContactModel = D("Contact");
		$Contact = $ContactModel->where('con_istop = 1')->find();
		$Contacts = $ContactModel->order('con_istop DESC,con_sort ASC')->select();
		$this->assign('Contact',$Contact);
		$this->assign('Contacts',$Contacts);

		$this->assign('IndexUrl',U("Index/index","",""));
		$this->assign('CaseUrl',U("Case/index","",""));
		$this->assign('PageUrl',U("Page/index","",""));
		$this->assign('ContactUrl',U("Contact/index","",""));
		$this->assign('BlogUrl',U("Blog/index","",""));

		$title = "联系我们";
		$this->assign('title',$title);
		$this->display("contact");
	}
}
