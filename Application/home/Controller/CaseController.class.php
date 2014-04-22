<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
class CaseController extends Controller {
	public function index(){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);
		$ContactModel = D("Contact");
		$Contact = $ContactModel->where('con_istop = 1')->find();
		$this->assign('Contact',$Contact);

		$case_model = D("Case");
		$caseclass_model = D("Caseclass");
		$case = $case_model->select();
		$caseclass = $caseclass_model->select();
		$title = "案例展示";
		$this->assign('title',$title);
		$this->assign('case',$case);
		$this->assign('caseclass',$caseclass);

		$this->assign('IndexUrl',U("Index/index","",""));
		$this->assign('CaseUrl',U("Case/index","",""));
		$this->assign('PageUrl',U("Page/index","",""));
		$this->assign('ContactUrl',U("Contact/index","",""));
		$this->assign('BlogUrl',U("Blog/index","",""));
		$this->display("case");
	}
}
