<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
use home\Common\HomeController;
class CaseController extends HomeController {
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

		$this->display("case");
	}
}
