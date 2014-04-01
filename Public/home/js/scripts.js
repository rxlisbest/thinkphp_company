$(function(){


//ABOUT PAGE Stuffs
            
//Tabs on about
$('#tabs > div').hide();
$('#tabs div:first').show();
$('#tabs ul li:first').addClass('current');
 
$('#tabs ul li a').click(function(){
$('#tabs ul li').removeClass('current');
$(this).parent().addClass('current');
var currentTab = $(this).attr('href');
$('#tabs > div').hide();
$(currentTab).show();
return false;
});

//About tabs fade ins
$(".btn-tab2").click(function () {
$("#tab-2 img").addClass("slide-up")
$("#tab-2").addClass("fade-in")
}); 
$(".btn-tab1").click(function () {
$("#tab-1 img").addClass("fade-in")
$("#tab-1").addClass("fade-in")
}); 

//About team bios Accordion
$(".trigger").click(function() {
$(".trigger").removeClass("active");

var activeTab = $(this).attr("href");

if($(activeTab).is(":visible")) {
$(".team_bio").slideUp().removeClass("is_showing");
$(this).removeClass("active");

} else {
if ($(".is_showing").length > 0) {
$(".is_showing").slideUp(function() {
$(activeTab).hide().slideDown().addClass("is_showing");
} ).removeClass("is_showing");

} else {
$(activeTab).hide().slideDown().addClass("is_showing");
} $(this).addClass("active");
} return false;
});

//Scroll down to bio - needed for mobile
$(".trigger").click(function() {$.scrollTo($("#team-bios-section").position().top += 200, 1300 )});

//NAVIGATION & SCROLLING

//Sticky Nav on scroll down
$(window).scroll(function() {if ($("#header-bar").offset().top > 0) {$("#header-bar").addClass("sticky")} 
else {$("#header-bar").removeClass("sticky")}
});

// Navigation and Scrolling
if( $(window).width() < 568 ){top_offset = -285;} 
else {top_offset = -360;}

$('.mobilenav, #masthead, #header, #hero-section, #copyright, .mobileNav, #mobileNav').localScroll({
	offset: {left: 0, top: top_offset}	
});

$(".scroll_to_top").click(function() {$.scrollTo($("body").position().top, 300 )});
$(".contact_us").click(function() {$.scrollTo($("body").position().top, 1100)});
//$(".menu-btn").click(function() {$.scrollTo($("body").position().top, 1100)});

//Scroll To Top
$(window).scroll(function(){
if ($(this).scrollTop() > 100) {
$('.scroll_to_top').fadeIn();
} else {
$('.scroll_to_top').fadeOut();
}
});

//Set up NiceScroll
//$("html").niceScroll({bouncescroll:"true", cursorborder:"",cursorcolor:"#000000",boxzoom:false,autohidemode: false,cursorwidth:7}); 


//Go to the Top of page on load
$('html, body').animate({ scrollTop: 0 }, 'slow');

//BLOG SECTION AND PAGE STUFF

//Blog boxes on home
$("#blog-section .box").hoverIntent(function(){
$("#blog-section .box").not(this).animate({opacity:0.35},200)},
function(){$("#blog-section .box").not(this).animate({opacity:1},200)});
$("#blog-section .box, #blog-posts .box").click(function(){window.location=$(this).find("a.divlink").attr("href");return false});
});

//Drop Down for blog cat sorting
$('.ddwrap').click(function(){
$(this)
.toggleClass('active');
}, function(){
$(this)
.toggleClass('active');
});

// MIXITUP INIT (Grid Sorting)

$('#Grid').mixitup({
effects: ['fade','','blur']
});


// TWITTER FEED
// uses getmytweets api to keep client side
// TODO: find something more stable

$(function() {
$('#tweets').tweetable({
username: 'ttackpattern', 
time: true,
rotate: false,
speed: 4000, 
limit: 1,
replies: false,
position: 'append',
failed: "Sorry, twitter is currently unavailable for this user.",
html5: true,
onComplete:function($ul){
	$('time').timeago();
}
});
});

//PORTFOLIO
// Portfolio Image Hovers	
$(function() {
$('.folio-img').hoverIntent(over, out);
});

function over(event) {
$('.hover-over', this).fadeIn(600);
$('.hover-over', this).css("display", "normal");
}
function out(event) {
$('.hover-over', this).fadeOut(600);
}


//MOBILE NAV DRAWER
//with fallback via modernizer

$(function() {
var pushy = $('.mobilenav'), //menu css class
body = $('body'),
menuNav = $('.mobilenav ul li a'), //menu css class
container = $('#content-slide'), //container css class
siteOverlay = $('.site-overlay'), //site overlay
pushyClass = "pushy-right pushy-open", //menu position & menu open class
pushyActiveClass = "pushy-active", //css class to toggle site overlay
containerClass = "container-push", //container open class
menuBtn = $('.menu-btn, .pushy a'), //css classes to toggle the menu
menuSpeed = 200, //jQuery fallback menu speed
menuWidth = pushy.width() + "px"; //jQuery fallback menu width

function togglePushy(){
body.toggleClass(pushyActiveClass); //toggle site overlay
pushy.toggleClass(pushyClass);
container.toggleClass(containerClass);
}

function openPushyFallback(){
body.addClass(pushyActiveClass);
pushy.animate({right: "0px"}, menuSpeed);
container.animate({right: menuWidth}, menuSpeed);
}

function closePushyFallback(){
body.removeClass(pushyActiveClass);
pushy.animate({right: "-" + menuWidth}, menuSpeed);
container.animate({right: "0px"}, menuSpeed);
}

if(Modernizr.csstransforms3d){

//toggle menu
menuBtn.click(function() {
	togglePushy();
});
menuNav.click(function() {
	togglePushy();
});

//close menu when clicking site overlay
siteOverlay.click(function(){ 
	togglePushy();
});
}else{

//jQuery fallback
pushy.css({right: "-" + menuWidth}); //hide menu by default
container.css({"overflow-x": "hidden"}); //fixes IE scrollbar issue

//keep track of menu state (open/close)
var state = true;

//toggle menu
menuBtn.click(function() {
	if (state) {
		openPushyFallback();
		state = false;
	} else {
		closePushyFallback();
		state = true;
	}
});
//close menu when clicking site overlay
siteOverlay.click(function(){ 
	if (state) {
		openPushyFallback();
		state = false;
	} else {
		closePushyFallback();
		state = true;
	}
});

}
});

// SHUFFLE LETTERS IN FROM BINARY CODE

//First lets hide the button, for fade in from callback
$(".fademe").addClass("hide")

//Now the Meats
$(function(){
var text1 = $("#hero-section h3"); 
text1.shuffleLetters();

var text3 = $("#banner-section h2"); 
text3.shuffleLetters();

var text4 = $("#banner-section p"); 
text4.shuffleLetters();

var text5 = $("li.shuffletext"); 
text5.shuffleLetters();

setTimeout(function(){
text1.shuffleLetters({
	"text": "专业建站——From 1.0.2.4"
});
},3800);

var text2 = $("#hero-section h2"); 
text2.shuffleLetters();

setTimeout(function(){
$(".fademe").removeClass("hide")
$(".fademe").addClass("fade-up")
},5000);
});


// IN VIEW - 
// add classes to section when in viewport

$(function () {

$('.js-sect1').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) {$(".js-sect1").addClass("fade-up");} 
  else {$(".js-sect1").removeClass("fade-up");}
});

$('.js-sect2').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) { $(".js-sect2").addClass("fade-up"); } 
  else {$(".js-sect2").removeClass("fade-up");}
});

$('.js-sect3').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) {$(".js-sect3").addClass("fade-up");} 
  else {$(".js-sect3").removeClass("fade-up");}
});

$('.js-sect4').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) {$(".js-sect4").addClass("fade-up");} 
  else {$(".js-sect4").removeClass("fade-up");}
});

$('.js-sect5').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) {$(".js-sect5").addClass("fade-up");} 
  else {$(".js-sect5").removeClass("fade-up");}
});

$('.js-sect6').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) {$(".js-sect6").addClass("fade-up");} 
  else {$(".js-sect6").removeClass("fade-up");}
});
$('.js-sect7').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) {$(".js-sect7").addClass("fade-up");} 
  else {$(".js-sect7").removeClass("fade-up");}
});

$('.js-sect8').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) {$(".js-sect8").addClass("fade-up");} 
  else {$(".js-sect8").removeClass("fade-up");}
});
$('.js-sect9').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) { $(".js-sect9").addClass("fade-up");} 
  else {$(".js-sect9").removeClass("fade-up");}
});
$('ul.highlights').one('inview', function (event, visible, topOrBottomOrBoth) {
  if (visible == true) { $("ul.highlights li").addClass("shuffletext");} 
  else {$("ul.highlights li").removeClass("shuffletext");}
});
$('.graphs').one('inview', function (event, visible, topOrBottomOrBoth) {
 { $('.graphs li').attr('data-provide', 'circular');}
 
});
$('.graphs').one('inview', function (event, visible, topOrBottomOrBoth) {
 { $.getScript("http://citrusapps.com/wp-content/themes/attackpattern/js/circularcharts.js");}
 
});
});

// FLEX SLIDER
// Testimonials Slider on Homepage initialize
$('#testimonial-slider').flexslider({
directionNav: false
//Manual Nav Control for Flex Slider
}).flexsliderManualDirectionControls();
$('#testimonial-slider').flexslider({
animation: "fade",
slideshowSpeed: 14000,
controlNav: false,    
touch: false,     
directionNav: false
});

//PAGE TRANSITIONS - Leaving page fades
$.fn.leavePage = function() {   
this.click(function(event){

// Hold up on heading to the next page.
event.preventDefault();
linkLocation = this.href;

// Fade out first - all sexy like.
$('#header-bar').animate({'opacity':'0', 'top':'-92px'}, 500, 'easeOutExpo');
//$('body').fadeOut(600, function(){
//$('body').css({backgroundColor: '#00aabb'}, 'slow').fadeOut(600, function(){
$('body').animate('slow').fadeOut(500, function(){

// Alighty - now head over to new page.
window.location = linkLocation;
$('#header').stop().animate({'opacity': '1', 'top':'0'}, 1000);
});      
}); 
};

//apply the leave page transition to certian links
//note - leave Work link out of this - mucks up the page anchor scroll to.
$('.transition a, #services-section a, #folio-section a, #blog-section a, footer a, blog-posts a, .metas a').leavePage();
