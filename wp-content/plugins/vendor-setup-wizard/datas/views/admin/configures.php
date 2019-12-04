<?php
$this->add_custom_javascript("
	function saveConfigs()
	{
		createScreenLoading();
		var config_fields = new Array(), i=0;
		jQuery('table.table-config-field-list').find('input').each(function(){
			config_fields[i++] = {'name': jQuery(this).attr('name'), 'value': jQuery(this).val()};			
		});
		jQuery('table.table-config-field-list').find('textarea').each(function(){
			config_fields[i++] = {'name': jQuery(this).attr('name'), 'value': jQuery(this).val()};			
		});
		jQuery('table.table-config-field-list').find('select').each(function(){
			config_fields[i++] = {'name': jQuery(this).attr('name'), 'value': jQuery(this).val()};			
		});
		jQuery.get(getUrl('vendor_setup_wizard_task=save_configs'), {config_fields: config_fields}, function(){
			clearScreenLoading();
		});
	}
")->burn_media();
$this->add_custom_style("
	table.table-config-field-list input{
		width: 400px;
	}
	button.btn-save{
		margin-left: 270px!important; 
		height: 45px!important; 
		line-height: 45px!important; 
	}
")->burn_media();
?>
<table class="wp-list-table widefat fixed striped pages table-config-field-list">
	<thead>
		<tr>
			<th width="250px"><?php echo __('Field Name', 'vendor-setup-wizard');?></th>
			<th width="80%"><?php echo __('Value', 'vendor-setup-wizard');?></th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td><?php echo __('Google Map API key', 'vendor-setup-wizard');?></td>
		<td>
			<input type="text" name="vendor_setup_wizard_googlemapapikey" value="<?php echo get_option('vendor_setup_wizard_googlemapapikey', '');?>" />
		</td>
	</tr>
	<tr>
		<td><?php echo __('Processbar Color', 'vendor-setup-wizard');?></td>
		<td>
			<input type="text" name="vendor_setup_wizard_processbarcolor" value="<?php echo get_option('vendor_setup_wizard_processbarcolor', '#2C3D82');?>" />
		</td>
	</tr>
	<tr>
		<td><?php echo __('Store Description', 'vendor-setup-wizard');?></td>
		<td>
			<textarea name="vendor_setup_wizard_store_description"><?php echo get_option('vendor_setup_wizard_store_description', 'Store Setup');?></textarea>
		</td>
	</tr>
	<tr>
		<td><?php echo __('Selling Description', 'vendor-setup-wizard');?></td>
		<td>
			<textarea name="vendor_setup_wizard_selling_description"><?php echo get_option('vendor_setup_wizard_selling_description', 'Selling');?></textarea>
		</td>
	</tr>
	<tr>
		<td><?php echo __('Withdraw Description', 'vendor-setup-wizard');?></td>
		<td>
			<textarea name="vendor_setup_wizard_withdraw_description"><?php echo get_option('vendor_setup_wizard_withdraw_description', 'Withdraw');?></textarea>
		</td>
	</tr>
	<tr>
		<td><?php echo __('Ready Description', 'vendor-setup-wizard');?></td>
		<td>
			<textarea name="vendor_setup_wizard_ready_description"><?php echo get_option('vendor_setup_wizard_ready_description', 'Ready');?></textarea>
		</td>
	</tr>
	<tr>
		<td><?php echo __('Animate Step', 'vendor-setup-wizard');?></td>
		<td>
			<select name="vendor_setup_wizard_animate_step">
				<?php $vendor_setup_wizard_animate_step = get_option('vendor_setup_wizard_animate_step', 'true');?>
				<option value="true" <?php if ($vendor_setup_wizard_animate_step=='true'){echo ' selected="selected"';}?>><?php echo __('Yes', 'vendor-setup-wizard');?></option>
				<option value="false" <?php if ($vendor_setup_wizard_animate_step=='false'){echo ' selected="selected"';}?>><?php echo __('No', 'vendor-setup-wizard');?></option>				
			</select>
		</td>
	</tr>
	<tr>
		<td><?php echo __('Step description hint', 'vendor-setup-wizard');?></td>
		<td>
			<select name="vendor_setup_wizard_step_description_hint">
				<?php $vendor_setup_wizard_step_description_hint = get_option('vendor_setup_wizard_step_description_hint', 'true');?>
				<option value="true" <?php if ($vendor_setup_wizard_step_description_hint=='true'){echo ' selected="selected"';}?>><?php echo __('Yes', 'vendor-setup-wizard');?></option>
				<option value="false" <?php if ($vendor_setup_wizard_step_description_hint=='false'){echo ' selected="selected"';}?>><?php echo __('No', 'vendor-setup-wizard');?></option>				
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<button class="button btn-save" type="button" onClick="javascript:saveConfigs();">
				<i class="icon-save" style="float: left;" title="<?php echo __('Save', 'vendor-setup-wizard');?>">
					<img src="<?php echo vendor_setup_wizard_url;?>/datas/assets/images/save.png"/>
				</i>
				<?php echo __('Save configures', 'vendor-setup-wizard');?>
			</button>
		</td>
	</tr>
	</tbody>
</table>
