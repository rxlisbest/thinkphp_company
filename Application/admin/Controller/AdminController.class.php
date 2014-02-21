<?php
// 本类由系统自动生成，仅供测试用途
namespace admin\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function index(){
    	echo 111;
	//$nav_model = \admin\Model\NavModel();
	$nav_model = D("Nav");
	$nav = $nav_model->select();
	var_dump($nav);
	$this->assign('nav',$nav);
    	$view = $this->display("index");
    }

    public function helloworld(){
    	$this->display("login");
    }
}
