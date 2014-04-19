<?php
/*
 *create by roy
 */
namespace admin\Controller;
use Think\Controller;
use admin\Model\UserModel;

class LoginController extends Controller {

	public function index($message="欢迎登陆后台系统!"){
		$Url = new \Org\Url\Url;
		//var_dump($Url->LOGIN_URL());
		if($this->islogin()){
			redirect($Url->ADMIN_URL());
		}
		$this->assign('LoginCheck', $Url->LOGIN_URL('LoginCheck'));
		$this->assign('Message', $message);
		$this->assign('AdminUrl', $Url->ADMIN_URL());
		$this->display();
	} 

	public function islogin(){
		if(isset($_SESSION["user"]) AND isset($_SESSION["password"])){
			$u_name = $_SESSION["user"];
			$u_password = $_SESSION["password"];
			$UM = new UserModel();
			$user = $UM->where("u_name='".$u_name."' AND u_password='".$u_password."'")->find();
			if($user){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}		
	}

	public function LoginCheck(){
		$post = $_POST;
		if(!$post["u_name"] OR !$post["u_password"]){
			if(!$post["u_name"]){
				$json["message"] = "用户名不能为空!";
				echo $this->ajaxReturn($json);
			}
			else{
				$json["message"] = "密码不能为空!";
				echo $this->ajaxReturn($json);
			}
		}
		else{
			$UM = new UserModel();
			$user = $UM->where("u_name='".$post["u_name"]."'")->find();
			if(!$user){
				$json["message"] = "用户不存在!";
				echo $this->ajaxReturn($json);

			}
			else{
				if($user["u_password"]!=md5($post["u_password"])){
					$json["message"] = "密码错误!";
					echo $this->ajaxReturn($json);
				}
				else{
					if($post["remember"]==1){
						cookie(session_name(), session_id(), 3600);
					}
					$_SESSION["user"] = $user["u_name"];
					$_SESSION["password"] = $user["u_password"];
					$json["message"] = "欢迎登陆!";
					$json["login"] = 1;
					echo $this->ajaxReturn($json);
				}
			}
		}
	}

	public function Logout(){
		unset($_SESSION["user"]);
		unset($_SESSION["password"]);
		cookie(session_name(), null);
		$Url = new \Org\Url\Url;
		//var_dump($Url->LOGIN_URL());
		redirect($Url->LOGIN_URL());
	}
}
