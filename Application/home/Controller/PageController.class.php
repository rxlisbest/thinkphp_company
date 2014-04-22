<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
class PageController extends Controller {
	public function index(){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);
		$ContactModel = D("Contact");
		$Contact = $ContactModel->where('con_istop = 1')->find();
		$this->assign('Contact',$Contact);

		$PageModel = D("Page");
		$PageClassModel = D("Pageclass");
		$page = $PageModel->select();
		$pageclass = $PageClassModel->select();
		$title = "新闻列表";
		$this->assign('detailUrl',U('detail','',''));
		$this->assign('title',$title);
		$this->assign('page',$page);
		$this->assign('pageclass',$pageclass);

		$this->assign('IndexUrl',U("Index/index","",""));
		$this->assign('CaseUrl',U("Case/index","",""));
		$this->assign('PageUrl',U("Page/index","",""));
		$this->assign('ContactUrl',U("Contact/index","",""));
		$this->assign('BlogUrl',U("Blog/index","",""));
		$this->display("page");
	}
	
	public function detail($id=0){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);
		$ContactModel = D("Contact");
		$Contact = $ContactModel->where('con_istop = 1')->find();
		$this->assign('Contact',$Contact);

		$PageModel = D("Page");
		$page = $PageModel->where('p_id='.$id)->find();
		$LastPage = $PageModel->where('p_id<'.$id)->order(array('p_id'=>'desc'))->find();
		$NextPage = $PageModel->where('p_id>'.$id)->find();
		//var_dump($NextPage);
		$title = "新闻阅览";
		$this->assign('title',$title);
		$this->assign('ListUrl',U('index','',''));
		$this->assign('detailUrl',U('detail','',''));
		$this->assign('page',$page);
		$this->assign('LastPage',$LastPage);
		$this->assign('NextPage',$NextPage);

		$this->assign('IndexUrl',U("Index/index","",""));
		$this->assign('CaseUrl',U("Case/index","",""));
		$this->assign('PageUrl',U("Page/index","",""));
		$this->assign('ContactUrl',U("Contact/index","",""));
		$this->assign('BlogUrl',U("Blog/index","",""));
		$this->display("detail");
	}
}
