<?php
/*
 *create by roy
 */
namespace admin\Controller;
use Think\Controller;
class AdminController extends Controller {
	public function index(){
		//echo 111;
		//$nav_model = \admin\Model\NavModel();
		$nav_model = D("Nav");
		$nav = $nav_model->select();
		//var_dump($nav);
		$this->assign('nav',$nav);
		$view = $this->display("index");
	}

	public function helloworld(){
		//$this->display("login");
		echo 111;
	}

	public function add_nav($page=1){
		$nav_model = D("Nav");
		$url = "/index.php/admin/Admin/add_nav";

		$rowNum = $nav_model->count();
		$pageSize = 2;
		$pages = ceil($rowNum/$pageSize);
		if($page > $pages)
			$page = $pages;
		if($page < 1)
			$page = 1;
		$curPage = $page ?: 1;
		$offset = ($curPage-1)*$pageSize;
		$nav_list = $nav_model->order("n_path")->limit($offset, $pageSize)->select();
		$pagination = $this->getPagination($curPage, $pages, $url);
		$nav_class = $nav_model->order("n_path")->select();
		$this->assign('page',$page);
		$this->assign('nav_class',$nav_class);
		$this->assign('nav_list',$nav_list);
		$this->assign('pagination',$pagination);
		$content = $this->fetch("nav_list");
		$this->show($content);
	}

	public function edit_nav($page=1, $n_id=0){
		$nav_model = D("Nav");
		$url = "/index.php/admin/Admin/add_nav";

		$rowNum = $nav_model->count();
		$pageSize = 2;
		$pages = ceil($rowNum/$pageSize);
		if($page > $pages)
			$page = $pages;
		if($page < 1)
			$page = 1;
		$curPage = $page ?: 1;
		$offset = ($curPage-1)*$pageSize;
		$curPage = $page ?: 1;
		$nav_list = $nav_model->order("n_path")->limit($offset, $pageSize)->select();
		$pagination = $this->getPagination($curPage, $pages, $url);
		$nav = $nav_model->where("n_id = ".$n_id)->find();
		$nav_class = $nav_model->order("n_path")->select();
		$this->assign('page',$page);
		$this->assign('nav_class',$nav_class);
		$this->assign('nav_list',$nav_list);
		$this->assign('nav',$nav);
		$this->assign('nav_list',$nav_list);
		$this->assign('pagination',$pagination);
		$content = $this->fetch("nav_list");
		$this->show($content);
	}

	public function nav_save($page=1){
		$post = $_POST;
		if($post){
			$n_id = $post["n_id"];
			unset($post["submit"]);
			unset($post["n_id"]);
			$path = $post["n_path"];		
			$nav_model = D("Nav");
			if($n_id){
				$old_nav = $nav_model->where("n_id = ".$n_id)->find();
				if($path == $old_nav["n_path"])	{
					unset($post["n_path"]);
				}
				else{
					$s_path = $nav_model->query("select (case count(0) when 0 then 10 else max(cast(substr(n_path,length(".$path.")+1,2) as signed))+1 end) as current_path from admin_nav where left(n_path,length(".$path."))='".$path."' and n_path <> '".$path."'");
					$post["n_path"] .= $s_path[0]["current_path"];
				}
				$nav_model->where("n_id = ".$n_id)->save($post);
			}
			else{
				$s_path = $nav_model->query("select (case count(0) when 0 then 10 else max(cast(substr(n_path,length(".$path.")+1,2) as signed))+1 end) as current_path from admin_nav where left(n_path,length(".$path."))='".$path."' and n_path <> '".$path."'");
				$post["n_path"] .= $s_path[0]["current_path"];
				$nav_model->data($post)->add();
			}

			$json["value"] = $post["n_path"] ;
			$json["url"] = "/index.php/admin/Admin/add_nav/page/".$page;
			$json["path"] = "last_1";
			$json["nav"] = $this->getNavHtml();
			echo json_encode($json);
		}
	}

	public function delete($page=1, $n_id = 0){
		$nav_model = D("Nav");
		$nav = $nav_model->where("n_id = ".$n_id)->find();
		$nav_model->where("n_path like '".$nav["n_path"]."%'")->delete();
		$json["url"] = "/index.php/admin/Admin/add_nav/page/".$page;
		$json["path"] = "last_1";
		$json["nav"] = $this->getNavHtml();
		echo json_encode($json);
	}

	public function batch($page=1){
		$post = $_POST;
		$nav_model = D("Nav");
		if($post["choose"]=='delete'){
			unset($post["choose"]);
			foreach($post as $key=>$value){
				$n_ids[] = $key;
			}
			$nav = $nav_model->where("n_id in (".implode(",",$n_ids).")")->delete();
		}
		$json["url"] = "/index.php/admin/Admin/add_nav/page/".$page;
		$json["path"] = "last_1";
		$json["nav"] = $this->getNavHtml();
		echo json_encode($json);
	}

	public function getNavHtml(){
		$nav_model = D("Nav");
		$nav_list = $nav_model->select();
		$nav .= "<li>";
		$nav .= "<a id=\"p_nav_0\" href=\"\" class=\"nav-top-item no-submenu current\"> <!-- Add the class \"no-submenu\" to menu items with no sub menu -->";
		$nav .=	"Dashboard";
		$nav .=	"</a>";
		$nav .=	"</li>";
		foreach($nav_list as $value){
			if(strlen($value["n_path"]) == 4){
				$nav .=	"<li>";
				$nav .=	"<a id=\"p_nav_".$value["n_path"]."\" class=\"nav-top-item\"> <!-- Add the class \"current\" to current menu item -->";
				$nav .=	$value["n_title"];
				$nav .=	"</a>";
				$nav .=	"<ul id=\"nav_ul_".$value["n_path"]."\">";
				foreach($nav_list as $v){
					if(strlen($v["n_path"]) == 6 && substr($v["n_path"],0,4) == $value["n_path"]){
						$nav .= "<li><a id=\"s_nav_".$v["n_path"]."\" onclick=\"show_frame('".$v['n_url']."')\">";
						$nav .=	$v["n_title"]."</a></li>";
					}
				}
				$nav .=	"</ul>";
				$nav .= "</li>";
			}
		}	
		$nav .= "<li>";
		$nav .= "<a id=\"p_nav_last\" class=\"nav-top-item\">";
		$nav .= "导航管理";	
		$nav .= "</a>";
		$nav .= "<ul id=\"nav_ul_last\">";
		$nav .= "<li><a id=\"s_nav_last_1\" onclick=\"show_frame('/index.php/admin/Admin/add_nav')\">导航管理</a></li>";
		$nav .= "</ul>";
		$nav .= "</li>";
		return $nav;
	}

	public function getPagination($curPage, $pages, $url){
		if($curPage==1)
			$prePage = 1;
		else
			$prePage = $curPage - 1;
		if($curPage==$pages)
			$nextPage = $pages;
		else
			$nextPage = $curPage + 1;
		$pagination = "";
		$pagination .= "<div class=\"pagination\">";
		$pagination .= "<a href=\"#\" onclick=\"show_frame('".$url."/page/1')\" title=\"First Page\">&laquo; First</a><a href=\"#\" onclick=\"show_frame('".$url."/page/".$prePage."')\" title=\"Previous Page\">&laquo; Previous</a>";
		for($i=1;$i<=$pages;$i++){
			$pagination .= "<a href=\"#\" onclick=\"show_frame('".$url."/page/".$i."')\" class=\"number";
			if($i==$curPage){
				$pagination .= " current";
			}
			$pagination .= "\" title=\"".$i."\">".$i."</a>";
		}
		$pagination .= "<a href=\"#\" onclick=\"show_frame('".$url."/page/".$nextPage."')\" title=\"Next Page\">Next &raquo;</a><a href=\"#\" onclick=\"show_frame('".$url."/page/".$pages."')\" title=\"Last Page\">Last &raquo;</a>";
		$pagination .= "</div> <!-- End .pagination -->";
		return $pagination;
	}
}
