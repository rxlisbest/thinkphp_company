<?php
namespace admin\Common;

use Think\Controller;

class YuController extends Controller
{
	function _initialize(){
		if(!isset($_SESSION["user"])){
			$this->login();
		}
	}

	public function login(){
		$this->display(T("Admin/login"));
		exit;		
	} 

	public function login(){
		$this->display(T("Admin/login"));
		exit;		
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

    //infomation,error,success,attention
    public function getInfomation($type="success", $infomation){
        $info = "";
        $info .= "<div class=\"notification ";
        $info .= $type;
        $info .= " png_bg\">";
        $info .= "<a href=\"#\" class=\"close\"><img src=\"/Public/resources/images/icons/cross_grey_small.png\" title=\"Close this notification\" alt=\"close\" /></a>";
        $info .= "<div>";
        $info .= $infomation;
        $info .= "</div>";
        $info .= "</div>";
        return $info;
    }

    protected function ajax($url,$type = 'success',$infomation = '操作成功')
    {
        $json["info"] = $this->getInfomation($type,$infomation);
        $json["url"]  = U('PageList');
        echo $this->ajaxReturn($json);
    }
}
