<?php
/*
 *create by roy
 */
namespace admin\Controller;
use admin\Common\YuController;
class FriendController extends YuController {

	public function FriendList($page=1, $f_id=0){
		$FriendModel = D("Friend");
		$url = U('FriendList',array('page'=>$page),'');

		$rowNum = $FriendModel->count();
		$pageSize = 15;
		$pages = ceil($rowNum/$pageSize);
		if($page > $pages)
			$page = $pages;
		if($page < 1)
			$page = 1;
		$curPage = $page ?: 1;
		$offset = ($curPage-1)*$pageSize;
		$FriendList = $FriendModel->limit($offset, $pageSize)->select();
		$pagination = $this->getPagination($curPage, $pages, $url);
		$this->assign('page',$page);
		$this->assign('FriendList',$FriendList);
		if($f_id){
			$Friend = $FriendModel->where("f_id=".$f_id)->find();
			$this->assign('Friend',$Friend);
		}
		$this->assign('pagination',$pagination);

		$this->assign('FriendListUrl',U('FriendList',array('page'=>$page),''));
		$this->assign('FriendSaveUrl',U('FriendSave',array('page'=>$page),''));
		$this->assign('FriendDeleteUrl',U('FriendDelete',array('page'=>$page),''));
		$this->assign('FriendBatchUrl',U('FriendBatch',array('page'=>$page),''));
		$content = $this->fetch("friend_list");
		$this->show($content);
		//$this->display("login");
	}

	public function FriendSave($page=1){
		$post = $_POST;
		if($post){
			$f_id = $post["f_id"];
			unset($post["submit"]);
			unset($post["f_id"]);
			$post["f_time"] = date("Y-m-d H:m:s");
			$FriendModel = D("Friend");
			if($f_id){
				if($id=$FriendModel->where("f_id = ".$f_id)->save($post)){
					$type = "success";
					$infomation = "修改成功!";
				}
				else{
					$type = "error";
					$infomation = "修改失败!";
				}
			}
			else{
				if($id=$FriendModel->data($post)->add()){
					$type = "success";
					$infomation = "添加成功!";
				}
				else{
					$type = "error";
					$infomation = "添加失败!";
				}
			}
			$json["url"] = U('FriendList',array('page'=>$page),'');

			$json["info"] = $this->getInfomation($type, $infomation);
			echo $this->ajaxReturn($json);
		}
	}

	public function FriendDelete($page=1, $f_id=0){
		$FriendModel = D("Friend");
		//$nav = $nav_model->where("n_id = ".$n_id)->find();
		//if($nav_model->where("n_path like '".$nav["n_path"]."%'")->delete()){
		if($FriendModel->where("f_id=".$f_id)->delete()){
			$type = "success";
			$infomation = "删除成功!";
		}
		else{
			$type = "error";
			$infomation = "删除失败!";
		}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = U('FriendList',array('page'=>$page),'');
		echo $this->ajaxReturn($json);
	}

	public function FriendBatch($page=1){
		$post = $_POST;
		$FriendModel = D("Friend");
		if($post["choose"]=='delete'){
			unset($post["choose"]);
			foreach($post as $key=>$value){
				$f_ids[] = $key;
			}
			$delete_num = count($f_ids);
			if($Friend = $FriendModel->where("f_id in (".implode(",",$f_ids).")")->delete()){
				$type = "success";
				$infomation = "删除成功".$delete_num."条!";
			}
			else{
				$type = "error";
				$infomation = "删除失败!";
			}
		}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = U('FriendList',array('page'=>$page),'');
		echo $this->ajaxReturn($json);
	}
}
