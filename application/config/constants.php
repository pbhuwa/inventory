<?php  if ( !defined('BASEPATH')) exit('No direct script access allowed');

/*

|--------------------------------------------------------------------------

| File and Directory Modes

|--------------------------------------------------------------------------

|

| These prefs are used when checking and setting modes when working

| with the file system.  The defaults are fine on servers with proper

| security, but you may wish (or even need) to change the values in

| certain environments (Apache running a separate process for each

| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should

| always be used to set the mode correctly.

|

*/

define('FILE_READ_MODE', 0644);

define('FILE_WRITE_MODE', 0666);

define('DIR_READ_MODE', 0755);

define('DIR_WRITE_MODE', 0777);

/*

|--------------------------------------------------------------------------

| File Stream Modes

|--------------------------------------------------------------------------

|

| These modes are used when working with fopen()/popen()

|

*/

define('FOPEN_READ',							'rb');

define('FOPEN_READ_WRITE',						'r+b');

define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care

define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care

define('FOPEN_WRITE_CREATE',					'ab');

define('FOPEN_READ_WRITE_CREATE',				'a+b');

define('FOPEN_WRITE_CREATE_STRICT',				'xb');

define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*

|--------------------------------------------------------------------------

| Custon define variable 

| Define by sujit shah @ July 10 2012

|--------------------------------------------------------------------------

*/

define('UPLOAD_DIR','uploads/');

define('LOGO_PATH',UPLOAD_DIR.'images/logo/');

define('HEADER_PATH',UPLOAD_DIR.'images/header/');

define('FOOTER_PATH',UPLOAD_DIR.'images/footer/');

define('COMPANY_LOGO_PATH',UPLOAD_DIR.'company/logo/');

define('COMPANY_COVER_PATH',UPLOAD_DIR.'company/cover/');

define('CV_SYSTEM_PATH',UPLOAD_DIR.'cv/system/');

define('CV_MANUAL_PATH',UPLOAD_DIR.'cv/manual/');

define('BANNER_PATH',UPLOAD_DIR.'banners/');

define('GALLERY_PATH',UPLOAD_DIR.'gallerys/');

define('PROFILE_IMG_PATH',UPLOAD_DIR.'images/profile_img');

define('BILL_ATTACHMENT_PATH',UPLOAD_DIR.'images/bill');

define('KNOWN_ATTACHMENT_PATH',UPLOAD_DIR.'images/known_person');

define('SIGNATURE_UPLOAD_PATH',UPLOAD_DIR.'images/signature');

define('AMC_UPLOAD_PATH',UPLOAD_DIR.'images/amc');

define('PM_UPLOAD_PATH',UPLOAD_DIR.'images/pm');

define('CONTRACT_ATTACHMENT_PATH',UPLOAD_DIR.'images/contract');

define('ASSETS_ATTACHMENT_PATH',UPLOAD_DIR.'images/assets');

define('LEASE_ATTACHMENT_PATH',UPLOAD_DIR.'images/lease');

define('INSURANCE_ATTACHMENT_PATH',UPLOAD_DIR.'images/insurance');

define('MAINTENANCE_ATTACHMENT_PATH',UPLOAD_DIR.'images/maintenance');

define('RECEIVED_BILL_ATTACHMENT_PATH',UPLOAD_DIR.'images/received_bill');

define('FORM_FILE_ATTACHMENT_PATH',UPLOAD_DIR.'images/form_file');

define('PROJECT_BILL_ATTACHMENT_PATH',UPLOAD_DIR.'images/project');

define('OUR_TEAM_IMG_PATH',UPLOAD_DIR.'/our_team/');

define('ASSETS_DIR', 'assets/');

define('TEMPLATE_DIR',ASSETS_DIR.'template/');

define('TEMPLATE_CSS',TEMPLATE_DIR.'css/');

define('TEMPLATE_IMG',TEMPLATE_DIR.'images/');
// define('PUR_REQ_TO','प्रबन्ध');

define('WATER_MARK_IMAGE',TEMPLATE_DIR.'images/xelwel.png');

define('TEMPLATE_JS',TEMPLATE_DIR.'js/');

define('PLUGIN_DIR',ASSETS_DIR.'plugins/');

define('MODULE_DIR',ASSETS_DIR.'modules/');

define('ADMIN_LOGIN_PATH',			'admin');

define('ADMIN_DASHBOARD_PATH',		'dashboard');

define('SESSION','hmis_sql');

// define('KUKL_API_URL','http://192.168.10.5:8088/api/');
define('KUKL_API_URL','http://api.kathmanduwater.com:8085/api/');

// define('KUKL_API_KEY','%40ccessKuK!nv!ntegr%40t!0n20!9');
define('KUKL_API_KEY','%40ccessKuK!nv!ntegr%40t!0n20!0');

define('USER_MAT_TYPEID','user_mat_typeid');

define('KVWSMB_ID','4');