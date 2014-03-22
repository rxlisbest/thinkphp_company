$(document).ready(function(){$("[id^='p_nav_']").click(function(){$("[id^='p_nav_']").removeClass("current"),$(this).addClass("current");});});	
$(document).ready(function(){$("[id^='s_nav_']").click(function(){$("[id^='s_nav_']").removeClass("current"),$(this).addClass("current");});});	
$(document).ready(function(){$("[id^='test']").click(function(){$([id^='p_nav_']).hide();});});	
function show_frame(){
	url= arguments[0];
	if(arguments[1]){
		path=arguments[1];
	}
	else{
		path = 0;
	}
	var xmlhttp;
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
	else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState ==4 && xmlhttp.status == 200){
			document.getElementById("main-content-nofoot").innerHTML = xmlhttp.responseText;
			reload_js();
			reload_ajax_js(xmlhttp.responseText);
			if(path){
				p_path = path.substr(0,4);
				$("[id^='nav_ul_']").css("display","none");	
				$("#nav_ul_"+p_path).css("display","block");	
				$("[id^='p_nav_']").removeClass("current");	
				$("[id^='s_nav_']").removeClass("current");	
				$("#p_nav_"+p_path).addClass("current");	
				$("#s_nav_"+path).addClass("current");	
			}
			$("[id^='p_nav_']").click(function(){$("#main-info").html("")});	
			$("[id^='s_nav_']").click(function(){$("#main-info").html("")});	
		}
	}
	xmlhttp.open("POST", url, true);
	xmlhttp.send();
}
function reload_ajax_js(ajaxLoadedData){
	var regDetectJs = /<script(.|\n)*?>(.|\n|\r\n)*?<\/script>/ig;
	var jsContained = ajaxLoadedData.match(regDetectJs);

	// 第二步：如果包含js，则一段一段的取出js再加载执行
	if(jsContained) {
		// 分段取出js正则
		var regGetJS = /<script(.|\n)*?>((.|\n|\r\n)*)?<\/script>/im;

		// 按顺序分段执行js
		var jsNums = jsContained.length;
		for (var i=0; i<jsNums; i++) {
			var jsSection = jsContained[i].match(regGetJS);

			if(jsSection[2]) {
				if(window.execScript) {
					// 给IE的特殊待遇
					window.execScript(jsSection[2]);
				} else {
					// 给其他大部分浏览器用的
					window.eval(jsSection[2]);
				}
			}
		}
	}
}
function form_post(form, url){
	var $form = $(form);
	var _submit = function(){$.ajax({
		type: 'POST',
		url: $form.attr("action"),
		data:$form.serialize(),
		success: form_bridge,
		dataType:"json",
		cache:false, 
	})};
	_submit();
	return false;
}
function url_post(url){
	var _submit = function(){$.ajax({
		type: 'POST',
		url: url, data:"",
		success: form_bridge,
		dataType:"json",
		cache:false, 
	})};
	_submit();
}
function form_bridge(json){
	var obj = eval(json);
	if(obj["info"]){
		$("#main-info").html(obj["info"]);	
	}
	if(obj["nav"]){
		$("#main-nav").html(obj["nav"]);
		//Sidebar Accordion Menu:

		$("#main-nav li ul").hide(); // Hide all sub menus
		$("#main-nav li a.current").parent().find("ul").slideToggle("slow"); // Slide down the current menu item's sub menu

		$("#main-nav li a.nav-top-item").click( // When a top menu item is clicked...
				function () {
				$(this).parent().siblings().find("ul").slideUp("normal"); // Slide up all sub menus except the one clicked
				$(this).next().slideToggle("normal"); // Slide down the clicked sub menu
				return false;
				}
				);

		$("#main-nav li a.no-submenu").click( // When a menu item with no sub menu is clicked...
				function () {
				window.location.href=(this.href); // Just open the link instead of a sub menu
				return false;
				}
				); 

		// Sidebar Accordion Menu Hover Effect:

		$("#main-nav li .nav-top-item").hover(
				function () {
				$(this).stop().animate({ paddingRight: "25px" }, 200);
				}, 
				function () {
				$(this).stop().animate({ paddingRight: "15px" });
				}
				);
		$("[id^='p_nav_']").click(function(){$("[id^='p_nav_']").removeClass("current"),$(this).addClass("current");});
		$("[id^='s_nav_']").click(function(){$("[id^='s_nav_']").removeClass("current"),$(this).addClass("current");});
	}
	show_frame(obj["url"], obj["path"]);
}
