<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function form_fckeditor($name = '', $value = '', $extra = '', $type ='')
{
	include_once("./themes/ckeditor/ckeditor.php");
	include_once("./themes/ckfinder/ckfinder.php");
	
	$ckeditor = new CKEditor();
	$ckeditor->basePath	= site_url().'themes/ckeditor/';
	
	$config = array();
	$config['width']=970;
	$config['height']=300;
	$config['resize_enabled'] = false;
	if($type == 'Custom')
	{
		$config['toolbar'] = 'Basic';
		// $config['removePlugins'] = 'about, document, insert, clipboard, tools, documnet, editing, forms, source, print';
		$config['width']=507;
		$config['height']=200;
	}

	$parse_url = parse_url(site_url());
	// $config['exctraPlugins'] = 'document';

	$ckfinder_basepath   = $parse_url['path'].'themes/ckfinder/';

	
	CKFinder::SetupCKEditor($ckeditor,$ckfinder_basepath);
	
	return $ckeditor->editor($name,$value,$config);
}
function pp($echo = '', $die = TRUE) {
    echo '<pre>';
    print_r($echo);
    echo '</pre>';
    $die && die;
}

?>