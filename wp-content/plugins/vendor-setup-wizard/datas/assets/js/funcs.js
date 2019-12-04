function Wizard_createScreenLoading()
{
	var bg_load = jQuery('<div />');
	bg_load.attr('id', 'pre-load');
	bg_load.css({
		'position': 'absolute',
		'width': jQuery(window).width(),
		'height': jQuery(document).height(),
		'background': '#fff',
		'opacity': 0,
		'top': '0px',
		'left': '0px',
		'z-index': 9999
	});
	var container_load = jQuery('<div />');
	container_load.css({
		'background': '#fff',
		'width': '50px',
		'height': '50px',
		'position': 'absolute',
		'left': jQuery(window).width()/2 - 25,
		'top': jQuery(document).scrollTop()+(jQuery(window).height() / 2 - 25),
		'z-index': '99990'
	});
	var container_img = jQuery('<img />');
	container_img.attr('src', vendor_setup_wizard_base_url+'/datas/assets/images/ajax-loader.gif');
	container_img.attr('width', '50px');
	container_load.append(container_img);
	bg_load.append(container_load);
	jQuery('body').append(bg_load);
	jQuery(window).resize(function(){
		container_load.css({
			'opacity': 0,
			'background': '#fff',
			'width': '50px',
			'height': '50px',
			'position': 'absolute',
			'left': jQuery(window).width()/2 - 25,
			'top': jQuery(window).height() / 2 - 25
		});
	});
	jQuery(window).scroll(function(){
		container_load.css({
			'background': '#fff',
			'width': '50px',
			'height': '50px',
			'position': 'absolute',
			'left': jQuery(window).width()/2 - 25,
			'top': (jQuery(document).scrollTop() + (jQuery(window).height() / 2 - 25))
		});
	});
	window.onbeforeunload = function(e) {
	  return "Are you sure to refresh page while it is working!";
	};
}
function Wizard_clearScreenLoading()
{
	window.onbeforeunload = null;
	if (jQuery('#pre-load').length > 0){
		jQuery('#pre-load').remove();
	}
}
function Wizard_getUrl(extraUrl)
{
	return (vendor_setup_wizard_baseUrl.indexOf('?') != -1)?vendor_setup_wizard_baseUrl+'&'+extraUrl:vendor_setup_wizard_baseUrl+'?'+extraUrl;
}