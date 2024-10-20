<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_item extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('api_item_mdl');
	}
	
	public function item_list()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$itemlist=$this->api_item_mdl->get_itemlistfromotherdb();
	 	$trans=$this->db->insert_batch('xw_itli_itemslist',$itemlist);
		if($trans)
            {
            	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
            	exit;
            }
            else
            {
            	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
            	exit;
            }
		}
	else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
	}

	}

	public function unit_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$unitlist=$this->api_item_mdl->get_unit();
		$trans= $this->db->insert_batch('xw_unit_unit',$unitlist);
		if($trans)
            {
            	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
            	exit;
            }
            else
            {
            	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
            	exit;
            }
		}
	else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
	}
}

	public function category_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$categoryList=$this->api_item_mdl->get_category();
		 $trans=$this->db->insert_batch('xw_eqca_equipmentcategory',$categoryList);
		if($trans)
            {
            	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
            	exit;
            }
            else
            {
            	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
            	exit;
            }
		}
	else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
	}

	}

	// public function materia
}
	