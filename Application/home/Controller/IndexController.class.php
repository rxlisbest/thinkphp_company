<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function index(){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);

		$CaseModel = D("Case");
		$Cases = $CaseModel->order('c_id DESC')->limit(3)->select();
		$PageModel = D("Page");
		$Pages = $PageModel->order('p_id DESC')->limit(3)->select();
		$this->assign('Cases',$Cases);
		$this->assign('Pages',$Pages);
		$this->assign('CaseUrl',U("Case/index","",""));
		$this->assign('PageUrl',U("Page/detail","",""));
		$this->display("index");
	}
}
