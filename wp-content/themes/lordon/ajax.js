$(function(){
	var $shopInnerProductWrap=$('shopInnerProductWrap'),
	$cat_links=$('ul.categories-filters li a');
	$cat_links.on('click',function(e){
		e.preventDefault();
		var value=$(this).attr("href");
		$shopInnerProductWrap.animate({opacity:"0.5"});
		$shopInnerProductWrap.load(value+"#inside",function(){
			$shopInnerProductWrap.animate({opacity:'1'});
		});
	});
});