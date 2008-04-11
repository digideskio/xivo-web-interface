<?php

$info = $error = array();

$return = &$info;

$apphnumbersemergency = $ipbx->get_application('handynumbers',array('type' => 'emergency'));
$apphnumbersspecial = $ipbx->get_application('handynumbers',array('type' => 'special'));

$info['emergency'] = $apphnumbersemergency->get();
$info['special'] = $apphnumbersspecial->get();

$fm_save = false;
$fm_smenu_tab = $fm_smenu_part = '';

if(isset($_QR['fm_send']) === true)
{
	$fm_save = true;

	if(isset($_QR['fm_smenu-tab'],$_QR['fm_smenu-part']) === true)
	{
		$fm_smenu_tab = strval($_QR['fm_smenu-tab']);
		$fm_smenu_part = strval($_QR['fm_smenu-part']);
	}

	$return = &$result;

	if(xivo_issa('emergency',$_QR) === false
	|| ($emergency = xivo_group_array('trunkfeaturesid',$_QR['emergency'])) === false)
		$emergency = array();

	if($apphnumbersemergency->set_save_all($emergency) === false)
		$result['emergency'] = false;
	else
		$result['emergency'] = $apphnumbersemergency->get_result();

	if($apphnumbersemergency->get_errnb() === 0)
		$error['emergency'] = false;
	else
	{
		$fm_save = false;
		$error['emergency'] = $apphnumbersemergency->get_error();
	}

	if(xivo_issa('special',$_QR) === false
	|| ($special = xivo_group_array('trunkfeaturesid',$_QR['special'])) === false)
		$special = array();

	if($apphnumbersspecial->set_save_all($special) === false)
		$result['special'] = false;
	else
		$result['special'] = $apphnumbersspecial->get_result();

	if($apphnumbersspecial->get_errnb() === 0)
		$error['special'] = false;
	else
	{
		$fm_save = false;
		$error['special'] = $apphnumbersspecial->get_error();
	}
}

if(xivo_issa('emergency',$return) === true
&& isset($return['emergency']['handynumbers'],$return['emergency']['handynumbers'][0]) === true)
	$return['emergency'] = $return['emergency']['handynumbers'];
else
	$return['emergency'] = false;

if(xivo_issa('special',$return) === true
&& isset($return['special']['handynumbers'],$return['special']['handynumbers'][0]) === true)
	$return['special'] = $return['special']['handynumbers'];
else
	$return['special'] = false;

$apptrunk = &$ipbx->get_application('trunk',null,false);
if(($trunkslist = $apptrunk->get_all_trunks(null,null,null,true)) !== false)
{
	xivo::load_class('xivo_sort');
	$trunksort = new xivo_sort(array('key' => 'identity'));
	uasort($trunkslist,array(&$trunksort,'str_usort'));
}

$_HTML->set_var('fm_save',$fm_save);
$_HTML->set_var('fm_smenu_tab',$fm_smenu_tab);
$_HTML->set_var('fm_smenu_part',$fm_smenu_part);
$_HTML->set_var('element',$apphnumbersemergency->get_elements());
$_HTML->set_var('info',$return);
$_HTML->set_var('error',$error);
$_HTML->set_var('trunkslist',$trunkslist);

$dhtml = &$_HTML->get_module('dhtml');
$dhtml->set_js('js/service/ipbx/'.$ipbx->get_name().'/general.js');
$dhtml->set_js('js/service/ipbx/'.$ipbx->get_name().'/submenu.js');

$menu = &$_HTML->get_module('menu');
$menu->set_top('top/user/'.$_USR->get_info('meta'));
$menu->set_left('left/service/ipbx/'.$ipbx->get_name());

$_HTML->set_bloc('main','service/ipbx/'.$ipbx->get_name().'/pbx_services/handynumbers');
$_HTML->set_struct('service/ipbx/'.$ipbx->get_name());
$_HTML->display('index');

?>
