<h3><?php echo __('Dokan vendor setup - An intergration with Dokan', 'vendor-setup-wizard');?></h3>
<?php
$this->add_custom_javascript("
	(function($){
		  jQuery(document).ready(function(){
			  jQuery(\"#vendor-setup-wizard-config-tabs\").tabs();
		  });				
	})(jQuery);
", 'jquery-ui-tabs')->burn_media();
?>
<div id="vendor-setup-wizard-config-tabs">
  <ul>
    <li><a href="#tabs-1"><?php echo __('Configures', 'vendor-setup-wizard');?></a></li>   
  </ul>
  <div id="tabs-1">
  	<center><h1><?php $this->loadView('configures');?></h1></center>    
  </div>
</div>