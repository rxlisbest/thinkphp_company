<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
class AboutController extends Controller {
	public function index(){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);
		$ContactModel = D("Contact");
		$Contact = $ContactModel->where('con_istop = 1')->find();
		$this->assign('Contact',$Contact);

		$title = "关于本站";
		$this->assign('title',$title);

		$this->assign('IndexUrl',U("Index/index","",""));
		$this->assign('CaseUrl',U("Case/index","",""));
		$this->assign('PageUrl',U("Page/index","",""));
		$this->assign('ContactUrl',U("Contact/index","",""));
		$this->assign('BlogUrl',U("Blog/index","",""));
		$this->display("about");
	}
}
