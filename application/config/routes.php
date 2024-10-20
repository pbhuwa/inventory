<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";


$route['404_override'] = 'home/e404';

$route['register'] = "home/registers";
$route['register/save_user_reg'] = "home/registers/save_user_reg";

$route['purchase/quotation_book'] = 'purchase_receive/quotation/quotation_book/quotation';
$route['purchase/tender'] = 'purchase_receive/quotation/quotation_book/tender';
$route['purchase_receive/quotation'] = 'purchase_receive/quotation/index/quotation';
$route['purchase_receive/tender'] = 'purchase_receive/quotation/index/tender';
$route['purchase_receive/quotation_details'] = 'purchase_receive/quotation_details/index/quotation';
$route['tender_details'] = 'purchase_receive/quotation_details/index/tender';
$route['purchase_receive/quotation_details/quotation_approved'] = 'purchase_receive/quotation_details/quotation_approved/quotation';
$route['tender_approved'] = 'purchase_receive/quotation_details/quotation_approved/tender';
$route['purchase_receive/quotation/quotation_comparitive_table'] = 'purchase_receive/quotation/quotation_comparitive_table/quotation';
$route['tender_comparitive_table'] = 'purchase_receive/quotation/quotation_comparitive_table/tender';
$route['stock_inventory/current_stock/branch_wise_item_stock']='stock_inventory/current_stock/location_wise_item_stock';

$route['stock_inventory/items_ledger_report']='stock_inventory/items_ledger/report';
$route['stock_inventory/items_ledger_report_i']='stock_inventory/items_ledger/type_i';
