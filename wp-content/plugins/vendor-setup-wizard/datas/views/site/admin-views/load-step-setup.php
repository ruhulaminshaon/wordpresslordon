<?php
$_ask_step = (int) $_REQUEST['setup_step'];
if ($_ask_step <= 0 || $_ask_step > 4){
	$_ask_step = 1;
}
include(dirname(__FILE__).'/step-'.$_ask_step.'.php');
?>