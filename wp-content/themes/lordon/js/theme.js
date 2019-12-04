$(document).ready(function() {
var a=$(".homeBlogArcContent").height();
$(window).resize(function(){
$(".blogAddsSidebarImgCon, .blogAddsSidebarImgCon img").css("height",a);
});
$(".blogAddsSidebarImgCon, .blogAddsSidebarImgCon img").css("height",a);



$(".mobileMenu").click(function(){
$(".hMenu").slideToggle(500);
});
});

    