<?php
namespace admin\Controller;

use admin\Model\PageModel;
use admin\Model\PageclassModel;
use admin\Common\YuController;

class PageController extends YuController {

    public function _initialize()
    {
        $this->Page = new PageModel();
        $this->PageClass = new PageclassModel();
    }

    public function PageClassList($page=1)
    {
        $this->assign('PageClassAddUrl',U('PageClassAdd'));
        $this->assign('PageClassEditUrl',U('PageClassEdit','',''));
        $this->assign('PageClassDelUrl',U('PageClassDel','',''));

	$url = U('PageClassList',array('page'=>$page),'');

	$rowNum = $this->PageClass->count();
	$pageSize = 12;
	$pages = ceil($rowNum/$pageSize);
	if($page > $pages)
		$page = $pages;
	if($page < 1)
		$page = 1;
	$curPage = $page ?: 1;
	$offset = ($curPage-1)*$pageSize;
	$PageClassLists= $this->PageClass->order("pc_id")->limit($offset, $pageSize)->select();

	$blank = $pageSize - count($PageClassLists);
	$this->assign('blank',$blank);

	$pagination = $this->getPagination($curPage, $pages, $url);
	$this->assign('pagination',$pagination);

        $this->assign('PageClassLists', $PageClassLists);
	$this->assign('batchUrl',U('batch',array('page'=>$page),''));
        $this->display();
    }

    public function PageClassAdd()
    {
        $this->assign('PageClassSaveUrl',U('PageClassSave'));
        $this->assign('PageClassLists',$this->PageClass->select());
        $this->display();
    }

    public function PageClassSave()
    {
        if ($_POST) {
            $pc_id = I('post.pc_id');
	    if($pc_id){
            	$data['pc_sort'] = I('post.pc_id');
		$data['pc_title'] = I('post.pc_title');

		if ($this->PageClass->where("pc_id=".$pc_id)->save($data)){
		       	$type = "success";
			$infomation = "操作成功";
		}else{
		       	$type = "error";
			$infomation = "操作失败!";
		}
	    }
	    else{
            	$data['pc_sort']      = I('post.pc_id');
		$data['pc_title']   = I('post.pc_title');

		if ($this->PageClass->add($data,'',TRUE)){
		       	$type = "success";
			$infomation = "操作成功";
		}else{
		       	$type = "error";
			$infomation = "操作失败!";
		}
	    }
            $json["info"] = $this->getInfomation($type,$infomation);
            $json["url"]  = U('PageClassList');
            echo $this->ajaxReturn($json);
        }
    }

    public function PageClassEdit($id)
    {
        $this->assign('PageClassSaveUrl',U('PageClassSave'));
        $this->assign('PageClassInfo',$this->PageClass->find($id));
	$content = $this->fetch("PageClassAdd");
        $this->show($content);
    }

    public function PageClassDel($id)
    {
        if ($this->PageClass->delete($id)) {
            $type = "success";
	    $infomation = "删除成功!";
        }else{
            $type = "error";
	    $infomation = "删除失败!";
        }
	$json["info"] = $this->getInfomation($type,$infomation);
   	$json["url"]  = U('PageClassList');
	echo $this->ajaxReturn($json);
    }

	public function batch($page=1){
		$post = $_POST;
		if($post["choose"]=='delete'){
			unset($post["choose"]);
			foreach($post as $key=>$value){
				$pc_ids[] = $key;
			}
			$delete_num = count($pc_ids);
			if($this->PageClass->where("pc_id in (".implode(",",$pc_ids).")")->delete()){
				$type = "success";
				$infomation = "删除成功".$delete_num."条!";
			}
			else{
				$type = "error";
				$infomation = "删除失败!";
			}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = U('PageClassList',array('page'=>$page),'');
		echo json_encode($json);
		}
	}

    public function PageList($page=1)
    {
        $this->assign('PageAddUrl',U('PageAdd'));
        $this->assign('PageEditUrl',U('PageEdit','',''));
        $this->assign('PageDelUrl',U('PageDel','',''));

	$url = U('PageList',array('page'=>$page),'');

	$rowNum = $this->Page->count();
	$pageSize = 15;
	$pages = ceil($rowNum/$pageSize);
	if($page > $pages)
		$page = $pages;
	if($page < 1)
		$page = 1;
	$curPage = $page ?: 1;
	$offset = ($curPage-1)*$pageSize;
	$PageLists= $this->Page->order("p_id")->limit($offset, $pageSize)->select();

	$blank = $pageSize - count($PageLists);
	$this->assign('blank',$blank);
	$pagination = $this->getPagination($curPage, $pages, $url);

	$this->assign('pagination',$pagination);
	
	$PC = $this->PageClass->select();
	$PageClass = array();
	foreach($PC as $value){
		$PageClass[$value["pc_id"]] = $value["pc_title"];
	}
	
        $this->assign('PageClass', $PageClass);
        $this->assign('PageLists', $PageLists);
	$this->assign('batchUrl',U('page_batch',array('page'=>$page),''));
        $this->display();
    }

    public function PageAdd()
    {
        $this->assign('PageSaveUrl',U('PageSave','',''));
        $this->assign('PageLists',$this->Page->select());
        $this->assign('PageClassLists',$this->PageClass->select());
        $this->display();
    }

    public function PageEdit($id="")
    {
        $this->assign('PageSaveUrl',U('PageSave'));
        $this->assign('PageInfo',$this->Page->find($id));
        $this->assign('PageClassLists',$this->PageClass->select());
	$content = $this->fetch("PageAdd");
        $this->show($content);
    }

    public function PageDel($id)
    {
        if ($this->Page->delete($id)) {
            $type = "success";
	    $infomation = "删除成功!";
        }else{
            $type = "error";
	    $infomation = "删除失败!";
        }
	$json["info"] = $this->getInfomation($type,$infomation);
   	$json["url"]  = U('PageList');
	echo $this->ajaxReturn($json);
    }

	public function page_batch($page=1){
		$post = $_POST;
		if($post["choose"]=='delete'){
			unset($post["choose"]);
			foreach($post as $key=>$value){
				$p_ids[] = $key;
			}
			$delete_num = count($p_ids);
			if($this->Page->where("p_id in (".implode(",",$p_ids).")")->delete()){
				$type = "success";
				$infomation = "删除成功".$delete_num."条!";
			}
			else{
				$type = "error";
				$infomation = "删除失败!";
			}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = U('PageList',array('page'=>$page),'');
		echo json_encode($json);
		}
	}

    public function PageSave()
    {
        if ($_POST) {
            $p_id = I('post.p_id');
	    if($p_id){
            	$data['pc_id']      = I('post.pc_id');
		$data['p_title']   = I('post.p_title');
		$data['p_author']   = I('post.p_author');
		$data['p_content'] = $_POST["p_content"];
		$data['p_date']    = date("Y-m-d H:m:s");

		if ($this->Page->where("p_id=".$p_id)->save($data)){
		       	$type = "success";
			$infomation = "操作成功";
		}else{
		       	$type = "error";
			$infomation = "操作失败!";
		}
	    }
	    else{
            	$data['pc_id']      = I('post.pc_id');
		$data['p_title']   = I('post.p_title');
		$data['p_author']   = I('post.p_author');
		$data['p_content'] = $_POST["p_content"];
		$data['p_date']    = date("Y-m-d H:m:s");

		if ($this->Page->add($data,'',TRUE)){
		       	$type = "success";
			$infomation = "操作成功";
		}else{
		       	$type = "error";
			$infomation = "操作失败!";
		}
	    }
            $json["info"] = $this->getInfomation($type,$infomation);
            $json["url"]  = U('PageList');
            echo $this->ajaxReturn($json);
        }
    }
}
