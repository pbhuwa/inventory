<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Item_life_cycle extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('item_life_cycle_mdl');
		
	}

	public function index()
    {

		$this->data['current_stock']='summary';
		$seo_data='';
		if($seo_data)
		{	//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys']= ORGA_NAME;
			$this->data['meta_desc']= ORGA_NAME;
		}
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('item_life_cycle/v_item');
    }

    public function list_of_item()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$this->data=array();
	  	//$data = $this->item_life_cycle->get_item_list();

				// echo $this->db->last_query(); die;
				
				$template=$this->load->view('stock_inventory/item_life_cycle/v_item_popup.php',$this->data,true);

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));

		   		 exit;	

			}

			else

			{

				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		        exit;

			}
    }


     public function list_of_item_auto_suggest()
	{
	    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	    {
			try {
				$this->data['items_data'] = $this->item_life_cycle_mdl->get_all_itemlist(false,5,false,false,'ASC');
				  // echo "<pre>";
				  // print_r($this->data['items_data']);
				  // die();
			$template=$this->load->view('stock_inventory/item_life_cycle/v_item_list_auto',$this->data,true);
		        
		        if($template){
		           	print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
		            exit;
		        }
		        else
		        {
		           	print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
		            exit;
		        }
			}
			catch (Exception $e) {
	          
	            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	        }
		}
		else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
    }
	public function get_itemlist($rowno=false,$orgid=false,$result=false)
	{

		$data = $this->item_life_cycle_mdl->get_item_list();
	  	$i = 0;
	  	$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)	
		    {	
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                } 
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
		   		$array[$i]['itli_itemname'] = $req_itemname;
		   		$array[$i]['itli_itemlistid'] = $row->itli_itemlistid;
		   		$array[$i]['maty_material'] = $row->maty_material;
		   		$array[$i]['unitname'] = $row->unit_unitname;
		   		$array[$i]['category'] = $row->eqca_category;
		   		
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs,"data"=>$array));
	}

	function get_overview_item($id=false)
	{
		// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//print_r($this->input->post()); die;
		$id=$this->input->post('id')?$this->input->post('id'):'';
			
		$this->data['detail']=$this->item_life_cycle_mdl->get_detail(array('itli_itemlistid='=>$id));
		$this->data['detail_log']=$this->item_life_cycle_mdl->get_detail_log(array('itpl_itemid='=>$id));

		$this->data['opening']=$this->item_life_cycle_mdl->get_opening($id);
		//echo "<pre>"; print_r($this->data['detail']); die;
		$this->data['order']=$this->item_life_cycle_mdl->get_pur_order($id);
		$this->data['pur_req']=$this->item_life_cycle_mdl->get_pur_req($id);
		//echo "<pre>"; print_r($this->data['pur_req']); die;
		$this->data['pur_rec']=$this->item_life_cycle_mdl->get_pur_received($id,'N','N');
		$this->data['return']=$this->item_life_cycle_mdl->get_pur_return($id);
		$this->data['direct_pur']=$this->item_life_cycle_mdl->get_pur_received($id,'D','S');
		$this->data['requisition']=$this->item_life_cycle_mdl->get_requisition($id);
		$this->data['issue']=$this->item_life_cycle_mdl->get_issue($id);
		$this->data['sales_return']=$this->item_life_cycle_mdl->get_sales_return($id);
		$this->data['challan']=$this->item_life_cycle_mdl->get_challan($id);
		$this->data['conv_in']=$this->item_life_cycle_mdl->get_convin($id);
		$this->data['conv_out']=$this->item_life_cycle_mdl->get_convout($id);

		//echo $this->db->last_query(); die;

      
		$tempform= $this->load->view('item_life_cycle/v_overview',$this->data,true);
      // echo $tempform;die();
      if($this->data['opening'] || $this->data['detail'])
      {
        print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
            exit; 
      }
      else
      {
        $tempform='<span class="text-danger">Record Not Found!!</span>';
        print_r(json_encode(array('status'=>'success','message'=>'Unsuccessfully Selected')));
            exit; 
      }


		// }else{
  //       print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
  //       exit;
  //   }
	 }
}