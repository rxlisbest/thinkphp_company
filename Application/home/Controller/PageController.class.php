<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
class PageController extends Controller {
	public function index(){
		$PageModel = D("Page");
		$PageClassModel = D("Pageclass");
		$page = $PageModel->select();
		$pageclass = $PageClassModel->select();
		$title = "新闻阅览";
		$this->assign('detailUrl',U('detail','',''));
		$this->assign('title',$title);
		$this->assign('page',$page);
		$this->assign('pageclass',$pageclass);
		$this->display("page");
	}
	
	public function detail($id){
		$page = $PageModel->where('p_id='.$id)->find();
		$this->assign('page',$page);
		$this->display("detail");
	}
}
