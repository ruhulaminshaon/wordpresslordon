<?php
$this->add_custom_javascript("
	var fn_step, current_step = 1;
	jQuery(document).ready(function(){
		var main_color = '".get_option('vendor_setup_wizard_processbarcolor', '#2C3D82')."';
		fn_step = jQuery('div#step-available').beautifully_steps({
			processbar_bg_width  : '100%',
			processbar_bg_height : 5,
			processbar_step_width: '25%',
			processbar_extra_style : {
				'margin': 'auto',
				'margin-top': '50px',
				'border': '1px solid '+main_color,
				'border-radius': '60%',
				'-webkit-box-shadow': '0px 0px 5px -1px '+main_color,
				'-moz-box-shadow':    '0px 0px 5px -1px '+main_color,
				'box-shadow':         '0px 0px 5px -1px '+main_color,
				'-webkit-border-radius': '6px',
				'-moz-border-radius': '6px',
			},
			steps : [
				{step: 1, text: '".__('Your Store Details', 'vendor-setup-wizard')."', description: '".get_option('vendor_setup_wizard_store_description', 'Your Store Details')."'},
				{step: 2, text: '".__('Selling', 'vendor-setup-wizard')."', description: '".get_option('vendor_setup_wizard_selling_description', 'Selling')."'},
				{step: 3, text: '".__('Basics of your store', 'vendor-setup-wizard')."', description: '".get_option('vendor_setup_wizard_withdraw_description', 'Basics of your store')."'},
				{step: 4, text: '".__('Ready', 'vendor-setup-wizard')."', description: '".get_option('vendor_setup_wizard_ready_description', 'Ready')."'}
			],
			step_style : {
				'display': 'inline-block',
				'background': main_color,
				'text-align': 'center',
				'font-size': '14px',
				'color': main_color,
				'line-height': '10px',
				'cursor': 'pointer'
			},
			main_color: main_color,
			animate_update_step: ".get_option('vendor_setup_wizard_animate_step', 'true').",
			step_description_hint: ".get_option('vendor_setup_wizard_step_description_hint', 'true')."
		});
		fn_step.compile();
		loadStep();
	});
	function loadStep()
	{
		if (current_step > 4){
			return;
		}
		Wizard_createScreenLoading();
		jQuery.get(Wizard_getUrl('vendor_setup_wizard_task=vendor-setup-step&mod=rawmode'), {setup_step: current_step}, function(data){
			jQuery('div#step-available-html').html(data);
			Wizard_clearScreenLoading();
			fn_step.active_step(current_step);
		});
	}
	function shorAlertComfirm(_this, msg)
	{
		var confirm_assignment = jQuery('<div id=\"confirm-box\"></div>')
		.html('<div>'+msg+'</div>')
		.dialog({
			 autoOpen: false,
			 modal: true,
			 height: 200,
			 width: 350,
			 title: \"".__('Oops ...', 'vendor-setup-wizard')."\",
			 modal: true,
			 draggable: true,
				  buttons: {
					'Ok': function() {
						confirm_assignment.dialog(\"close\");
						jQuery(_this).focus();
					},
					'Cancel': function(){
						confirm_assignment.dialog(\"close\");
					}
				}
		});
		confirm_assignment.dialog('open');
	}
	function save_form_setup(step)
	{
		var allow_call_save = true;
		var serialize = '';
		jQuery('form#vendor-setup-wizard-setup-form').find('input').each(function(){
			if (jQuery(this).attr('type') == 'checkbox'){
				if (jQuery(this).is(':checked')){
					if (jQuery(this).attr('name') == 'enable_tnc'){
						serialize += '&'+jQuery(this).attr('name')+'=on';
					}else{
						serialize += '&'+jQuery(this).attr('name')+'=yes';
					}
				}else if(allow_call_save){
					if (jQuery(this).attr('title') != undefined){
						shorAlertComfirm(this, '".__('Please input this required field ', 'vendor-setup-wizard')."'+jQuery(this).attr('title'));
					}else{
						shorAlertComfirm(this, '".__('Please input this required field ', 'vendor-setup-wizard')."');
					}
					allow_call_save = false;
				}
			}else{
				if (jQuery(this).val() != ''){
					serialize += '&'+jQuery(this).attr('name')+'='+jQuery(this).val();
				}else if(allow_call_save){
					if (jQuery(this).attr('title') != undefined){
						shorAlertComfirm(this, '".__('Please input this required field ', 'vendor-setup-wizard')."'+jQuery(this).attr('title'));
					}else{
						shorAlertComfirm(this, '".__('Please input this required field ', 'vendor-setup-wizard')."');
					}
					allow_call_save = false;
				}
			}
			
		});
		jQuery('form#vendor-setup-wizard-setup-form').find('select').each(function(){
			if (jQuery(this).val() != ''){
				serialize += '&'+jQuery(this).attr('name')+'='+jQuery(this).val();
			}else if(allow_call_save){
				if (jQuery(this).attr('title') != undefined){
					shorAlertComfirm(this, '".__('Please input this required field ', 'vendor-setup-wizard')."'+jQuery(this).attr('title'));
				}else{
					shorAlertComfirm(this, '".__('Please input this required field ', 'vendor-setup-wizard')."');
				}
				allow_call_save = false;
			}
		});
		if (allow_call_save)
		{
			jQuery.post(Wizard_getUrl('vendor_setup_wizard_task=vendor-setup-save&mod=rawmode&dokan-step='+step), serialize, function(){
				current_step++;
				loadStep();
			});
		}
	}
	function getDokanState(value)
	{
		Wizard_createScreenLoading();
		jQuery.post(Wizard_getUrl('vendor_setup_wizard_task=get-dokan-state&mod=rawmode'), {country: value}, function(data){
			jQuery('select#dokan_address_state').html(data);
			Wizard_clearScreenLoading();
		});
	}
	function skip()
	{
		current_step++;
		loadStep();
	}
	function prev()
	{
		current_step--;
		loadStep();
	}
	function choiseTerm(_this){
		setTimeout(function(){
			if (jQuery(_this).is(':checked')){
				jQuery(_this).val('on');
			}else{
				jQuery(_this).val('off');
			}
		}, 500);
	}
	function choiseMoreProduct(_this)
	{
		setTimeout(function(){
			if (jQuery(_this).is(':checked')){
				jQuery(_this).val('yes');
			}else{
				jQuery(_this).val('no');
			}
		}, 500);
	}
	function choiseShowEmail(_this)
	{
		setTimeout(function(){
			if (jQuery(_this).is(':checked')){
				jQuery(_this).val('yes');
			}else{
				jQuery(_this).val('no');
			}
		}, 500);
	}
	function enableSelling(_this)
	{
		setTimeout(function(){
			if (jQuery(_this).is(':checked')){
				jQuery(_this).val('on');
			}else{
				jQuery(_this).val('off');
			}
		}, 500);
	}
");
?>
<div id="vendor-wizard-setup">
	<div id="step-available"></div>
	<div id="step-available-html"></div>
</div>