<?php
/*
 *create by roy
 */
namespace admin\Controller;
use admin\Common\YuController;
class UserController extends YuController {

	public function UserList($page=1, $u_id=0){
		$UserModel = D("User");
		$url = U('UserList',array('page'=>$page),'');

		$rowNum = $UserModel->count();
		$pageSize = 15;
		$pages = ceil($rowNum/$pageSize);
		if($page > $pages)
			$page = $pages;
		if($page < 1)
			$page = 1;
		$curPage = $page ?: 1;
		$offset = ($curPage-1)*$pageSize;
		$UserList = $UserModel->limit($offset, $pageSize)->select();
		$pagination = $this->getPagination($curPage, $pages, $url);
		$this->assign('page',$page);
		$this->assign('UserList',$UserList);
		if($u_id){
			$User = $UserModel->where("u_id=".$u_id)->find();
			$this->assign('User',$User);
		}
		$this->assign('pagination',$pagination);

		$this->assign('UserListUrl',U('UserList',array('page'=>$page),''));
		$this->assign('UserSaveUrl',U('UserSave',array('page'=>$page),''));
		$this->assign('UserDeleteUrl',U('UserDelete',array('page'=>$page),''));
		$this->assign('UserBatchUrl',U('UserBatch',array('page'=>$page),''));
		$content = $this->fetch("user_list");
		$this->show($content);
		//$this->display("login");
	}

	public function UserSave($page=1){
		$post = $_POST;
		if($post){
			if($post["u_password"]!=$post["d_password"]){
				$type = "error";
				$infomation = "两次密码输入不同!";
			}
			else{
				unset($post["d_password"]);
				$post["u_password"] = md5($post["u_password"]);
				$u_id = $post["u_id"];
				unset($post["submit"]);
				unset($post["u_id"]);
				$post["u_time"] = date("Y-m-d H:m:s");
				$UserModel = D("User");
				if($u_id){
					if($id=$UserModel->where("u_id = ".$u_id)->save($post)){
						$type = "success";
						$infomation = "修改成功!";
					}
					else{
						$type = "error";
						$infomation = "修改失败!";
					}
				}
				else{
					if($id=$UserModel->data($post)->add()){
						$type = "success";
						$infomation = "添加成功!";
					}
					else{
						$type = "error";
						$infomation = "添加失败!";
					}
				}
				$json["url"] = U('UserList',array('page'=>$page),'');
			}

			$json["info"] = $this->getInfomation($type, $infomation);
			echo $this->ajaxReturn($json);
		}
	}

	public function UserDelete($page=1, $u_id=0){
		$UserModel = D("User");
		//$nav = $nav_model->where("n_id = ".$n_id)->find();
		//if($nav_model->where("n_path like '".$nav["n_path"]."%'")->delete()){
		if($UserModel->where("u_id=".$u_id)->delete()){
			$type = "success";
			$infomation = "删除成功!";
		}
		else{
			$type = "error";
			$infomation = "删除失败!";
		}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = U('UserList',array('page'=>$page),'');
		echo $this->ajaxReturn($json);
	}

	public function UserBatch($page=1){
		$post = $_POST;
		$UserModel = D("User");
		if($post["choose"]=='delete'){
			unset($post["choose"]);
			foreach($post as $key=>$value){
				$u_ids[] = $key;
			}
			$delete_num = count($u_ids);
			if($User = $UserModel->where("u_id in (".implode(",",$u_ids).")")->delete()){
				$type = "success";
				$infomation = "删除成功".$delete_num."条!";
			}
			else{
				$type = "error";
				$infomation = "删除失败!";
			}
		}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = U('UserList',array('page'=>$page),'');
		echo $this->ajaxReturn($json);
	}
}
