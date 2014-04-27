<?php
/*
 *create by roy
 */
namespace admin\Controller;
use admin\Common\YuController;
class ContactController extends YuController {

	public function ContactList($page=1, $con_id=0){
		$ContactModel = D("Contact");
		$url = U('ContactList',array('page'=>$page),'');

		$rowNum = $ContactModel->count();
		$pageSize = 15;
		$pages = ceil($rowNum/$pageSize);
		if($page > $pages)
			$page = $pages;
		if($page < 1)
			$page = 1;
		$curPage = $page ?: 1;
		$offset = ($curPage-1)*$pageSize;
		$ContactList = $ContactModel->order("con_istop DESC")->limit($offset, $pageSize)->select();
		$pagination = $this->getPagination($curPage, $pages, $url);
		$this->assign('page',$page);
		$this->assign('ContactList',$ContactList);
		if($con_id){
			$Contact = $ContactModel->where("con_id=".$con_id)->find();
			$this->assign('Contact',$Contact);
		}
		$this->assign('pagination',$pagination);

		$this->assign('ContactListUrl',U('ContactList',array('page'=>$page),''));
		$this->assign('ContactSaveUrl',U('ContactSave',array('page'=>$page),''));
		$this->assign('ContactDeleteUrl',U('ContactDelete',array('page'=>$page),''));
		$this->assign('ContactBatchUrl',U('ContactBatch',array('page'=>$page),''));
		$content = $this->fetch("contact_list");
		$this->show($content);
		//$this->display("login");
	}

	public function ContactSave($page=1){
		$post = $_POST;
		$old_img = $post["con_pic_old"];
		unset($post["con_pic_old"]);
		if($post["con_pic"]==""){
			$type = "error";
			$infomation = "图片没上传，添加失败!";
			$json["info"] = $this->getInfomation($type, $infomation);
			echo json_encode($json);
			return ;
		} 
		if($post){
			$con_id = $post["con_id"];
			unset($post["submit"]);
			unset($post["con_id"]);
			$post["con_time"] = date("Y-m-d H:m:s");
			$ContactModel = D("Contact");
			if($post["con_istop"]){
				$ContactModel->where("con_istop = 1")->save(array('con_istop'=>0));
			}
			if($con_id){
				if($id=$ContactModel->where("con_id = ".$con_id)->save($post)){
					$type = "success";
					$infomation = "修改成功!";
				}
				else{
					$type = "error";
					$infomation = "修改失败!";
				}
			}
			else{
				if($id=$ContactModel->data($post)->add()){
					$type = "success";
					$infomation = "添加成功!";
				}
				else{
					$type = "error";
					$infomation = "添加失败!";
				}
			}
			$json["url"] = U('ContactList',array('page'=>$page),'');

			$json["info"] = $this->getInfomation($type, $infomation);
			echo $this->ajaxReturn($json);
		}
	}

	public function ContactDelete($page=1, $con_id=0){
		$ContactModel = D("Contact");
		//$nav = $nav_model->where("n_id = ".$n_id)->find();
		//if($nav_model->where("n_path like '".$nav["n_path"]."%'")->delete()){
		if($ContactModel->where("con_id=".$con_id)->delete()){
			$type = "success";
			$infomation = "删除成功!";
		}
		else{
			$type = "error";
			$infomation = "删除失败!";
		}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = U('ContactList',array('page'=>$page),'');
		echo $this->ajaxReturn($json);
	}

	public function ContactBatch($page=1){
		$post = $_POST;
		$ContactModel = D("Contact");
		if($post["choose"]=='delete'){
			unset($post["choose"]);
			foreach($post as $key=>$value){
				$con_ids[] = $key;
			}
			$delete_num = count($con_ids);
			if($Contact = $ContactModel->where("con_id in (".implode(",",$con_ids).")")->delete()){
				$type = "success";
				$infomation = "删除成功".$delete_num."条!";
			}
			else{
				$type = "error";
				$infomation = "删除失败!";
			}
		}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = U('ContactList',array('page'=>$page),'');
		echo $this->ajaxReturn($json);
	}
	
	public function upload(){
		$time = date("YmdHms");
		$file = $_FILES["image"];
		$path = "./Public/uploads/images/Contact/";
		if(!file_exists($path)){
			mkdir($path);
			chmod($path,0777);
		}
		$types = array("image/gif","image/pjpeg","image/jpeg","image/png");
		if(!in_array($file["type"],$types)){
			$type = "error";
			$infomation = "图片类型不正确!";
			$json["info"] = $this->getInfomation($type, $infomation);
			return json_encode($json);
		}
		$types = array("image/gif"=>".gif","image/pjpeg"=>".pjpeg","image/jpeg"=>".jpeg","image/png"=>".png"); 
		$image_type = $types[$file["type"]];
		$image_name = $path.$time.$image_type;
		move_uploaded_file($file["tmp_name"],$image_name);
		$image_url = str_replace("./","/",$image_name);
		echo '{error:"",msg:"'.$image_url.'"}';
	}
}
