<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class purchase_analysis extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->model('purchase_analysis_mdl');
		$this->storeid = $this->session->userdata(STORE_ID);
        $this->locationid = $this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}

	public function index($analysis_type=false)
	{ 
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['mat_type_list']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['eqcat_all']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false);
        $this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',array('itli_typeid'=>$this->storeid),'itli_itemlistid','DESC');
		if($analysis_type)
		{
			$this->data['pur_analysis']=$analysis_type;
		}
		else
		{
			$this->data['pur_analysis']='pur_mrn';
		}
		
		$seo_data='';
		if($seo_data)
		{
			//set SEO data
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
			->build('purchase_analysis/v_purchase_analysis_main', $this->data);
	}

    //Purchase MRN
	public function purchase_analysis_mrn_report()
	{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(MODULES_VIEW=='N')
            {
                
                print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
                exit;
            }

            $template = $this->get_purchase_analysis_mrn_report_data();
            // print_r($template);
            // die();
            // print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
            // exit;

            
            if(!empty($template))
            {
                print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
                exit;
            }
            else{
                print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
                exit;
            }
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }  
    }

    public function generate_purchase_analysis_mrn_pdf()
    {
        $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
        if ($page_orientation == 'L') {
            $page_size = 'A4-L';
        } else {
            $page_size = 'A4';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->get_purchase_analysis_mrn_report_data();

            $filename = 'purchase_analysis_mrn_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize, $page_size);
            
            exit();
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_purchase_analysis_mrn_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=purchase_analysis_mrn_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->get_purchase_analysis_mrn_report_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function get_purchase_analysis_mrn_report_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data['excel_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_mrn_excel";
            $this->data['pdf_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_mrn_pdf";
            $this->data['report_title'] = $this->lang->line('purchase_analysis_mrn');

            $this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');

            $locationid = $this->input->post('locationid');
            $supplierid = $this->input->post('supplierid');

            $supp_mrn_list=$this->data['supp_mrn_list'] =  $this->purchase_analysis_mdl->get_mrn_supplier_info();
           
            if(!empty($supp_mrn_list)){
                foreach ($supp_mrn_list as $key => $supp) {
                $this->data['return_data'] = $this->purchase_analysis_mdl->get_mrn_return_analysis(array('pr.purr_supplierid'=>$supp->supplierid));
                } 
            }
       
            
            // echo "test";
            // die();
            // echo "<pre>"; print_r($this->data['return_data']); die;
           if($this->location_ismain=='Y'){
              if($locationid){
               $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
           }else{
             $this->data['location'] = 'All';

           }
       }else{
           $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

       }
            // if($locationid):
            //     $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
            // else:
            //     $this->data['location'] = 'All';
            // endif;

            if($supplierid):
                $this->data['supplier']=$this->general->get_tbl_data('dist_distributor','dist_distributors',array('dist_distributorid'=>$supplierid));
            else:
                $this->data['supplier'] = 'All';
            endif;

            if(!empty($this->data['supp_mrn_list'])){
                $template=$this->load->view('purchase_analysis/v_purchase_analysis_mrn_list', $this->data,true);
            }else{
                $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
            }

            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    //purchase return analysis
    public function purchase_analysis_purchase_return_report()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(MODULES_VIEW=='N')
            {
                
                print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
                exit;
            }

            $template = $this->get_purchase_analysis_purchase_return_report_data();

            if(!empty($template))
            {
                print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
                exit;
            }
            else{
                print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
                exit;
            }
        }
    }

    public function generate_purchase_analysis_purchase_return_pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->get_purchase_analysis_purchase_return_report_data();

            $filename = 'purchase_analysis_purchase_return_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_purchase_analysis_purchase_return_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=purchase_analysis_purchase_return_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->get_purchase_analysis_purchase_return_report_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function get_purchase_analysis_purchase_return_report_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data['excel_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_purchase_return_excel";
            $this->data['pdf_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_purchase_return_pdf";
            $this->data['report_title'] = $this->lang->line('purchase_return');

            $this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');

            $locationid = $this->input->post('locationid');
            $supplierid = $this->input->post('supplierid');

            $this->data['pur_ret_list'] =  $this->purchase_analysis_mdl->get_purchase_analysis_purchase_return();

            // if($locationid):
            //     $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
            // else:
            //     $this->data['location'] = 'All';
            // endif;
            if($this->location_ismain=='Y'){
              if($locationid){
               $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
           }else{
             $this->data['location'] = 'All';

           }
       }else{
           $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

       }

            if($supplierid):
                $this->data['supplier']=$this->general->get_tbl_data('dist_distributor','dist_distributors',array('dist_distributorid'=>$supplierid));
            else:
                $this->data['supplier'] = 'All';
            endif;

            if(!empty($this->data['pur_ret_list'])){
                $template=$this->load->view('purchase_analysis/v_purchase_analysis_purchase_return_list', $this->data,true);
            }else{
                $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
            }
            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }
    
    //purchase analysis by date
    public function purchase_analysis_by_date_report(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(MODULES_VIEW=='N')
            {
                
                print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
                exit;
            }

            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $template = $this->get_purchase_analysis_by_date_report_data();

                if(!empty($template))
                {
                    print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
                    exit;
                }
                else{
                    print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
                    exit;
                }
            }
        } 
    }

    public function generate_purchase_analysis_by_date_pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->get_purchase_analysis_by_date_report_data();

            $filename = 'purchase_analysis_by_date_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_purchase_analysis_by_date_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=purchase_analysis_by_date_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->get_purchase_analysis_by_date_report_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function get_purchase_analysis_by_date_report_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data['excel_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_by_date_excel";
            $this->data['pdf_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_by_date_pdf";
            $this->data['report_title'] = $this->lang->line('purchase_by_date');

            $this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');

            $locationid = $this->input->post('locationid');
            $supplierid = $this->input->post('supplierid');

            $this->data['item_category'] =  $this->purchase_analysis_mdl->get_item_cat_info('date_wise');

            // if($locationid):
            //     $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
            // else:
            //     $this->data['location'] = 'All';
            // endif;
                if($this->location_ismain=='Y'){
                if($locationid){
                  $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
                }else{
                  $this->data['location'] = 'All';
                }
                }else{
                  $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

                }

            if($supplierid):
                $this->data['supplier']=$this->general->get_tbl_data('dist_distributor','dist_distributors',array('dist_distributorid'=>$supplierid));
            else:
                $this->data['supplier'] = 'All';
            endif;

            if(!empty($this->data['item_category'])){
                $template=$this->load->view('purchase_analysis/v_purchase_analysis_by_date_list', $this->data,true);
            }else{
                $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
            }
            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    //purchase analysis by supplier
    public function purchase_analysis_by_supplier_report(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $template = $this->get_purchase_analysis_by_supplier_data();

                if(!empty($template))
                {
                    print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
                    exit;
                }
                else{
                    print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
                    exit;
                }
            }
        } 
    }

    public function generate_purchase_analysis_by_supplier_pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->get_purchase_analysis_by_supplier_data();

            $filename = 'purchase_analysis_by_supplier_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_purchase_analysis_by_supplier_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=purchase_analysis_by_supplier_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->get_purchase_analysis_by_supplier_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function get_purchase_analysis_by_supplier_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data['excel_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_by_supplier_excel";
            $this->data['pdf_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_by_supplier_pdf";
            $this->data['report_title'] = $this->lang->line('purchase_by_supplier');

            $this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');

            $locationid = $this->input->post('locationid');
            $supplierid = $this->input->post('supplierid');
            
            $this->data['item_category'] =  $this->purchase_analysis_mdl->get_item_cat_info('supplier_wise');

            // if($locationid):
            //     $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
            // else:
            //     $this->data['location'] = 'All';
            // endif;
            if($this->location_ismain=='Y'){
              if($locationid){
               $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
           }else{
             $this->data['location'] = 'All';

           }
       }else{
           $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

       }

            if($supplierid):
                $this->data['supplier']=$this->general->get_tbl_data('dist_distributor','dist_distributors',array('dist_distributorid'=>$supplierid));
            else:
                $this->data['supplier'] = 'All';
            endif;

            if(!empty($this->data['item_category'])){
                $template=$this->load->view('purchase_analysis/v_purchase_analysis_by_supplier_list', $this->data,true);
            }else{
                $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
            }
            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    //purchase analysis by item
    public function purchase_analysis_by_item_report(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $template = $this->get_purchase_analysis_by_item_data();

                if(!empty($template))
                {
                    print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
                    exit;
                }
                else{
                    print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
                    exit;
                }
            }
        } 
    }

    public function generate_purchase_analysis_by_item_pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->get_purchase_analysis_by_item_data();

            $filename = 'purchase_analysis_by_item_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_purchase_analysis_by_item_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=purchase_analysis_by_item_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->get_purchase_analysis_by_item_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function get_purchase_analysis_by_item_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data['excel_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_by_item_excel";
            $this->data['pdf_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_by_item_pdf";
            $this->data['report_title'] = $this->lang->line('purchase_by_item');

            $this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');

            $locationid = $this->input->post('locationid');
            $itemid = $this->input->post('itemid');

            $this->data['item_category'] =  $this->purchase_analysis_mdl->get_item_cat_info('item_wise');

            $this->data['opening_stock'] = $this->purchase_analysis_mdl->get_stock_data();

            // if($locationid):
            //     $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
            // else:
            //     $this->data['location'] = 'All';
            // endif;
            if($this->location_ismain=='Y'){
              if($locationid){
               $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
           }else{
             $this->data['location'] = 'All';

           }
       }else{
           $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

       }

            if($itemid):
                $this->data['item']=$this->general->get_tbl_data('itli_itemname','itli_itemslist',array('itli_itemlistid'=>$itemid));
            else:
                $this->data['item'] = 'All';
            endif;

            // if(!empty($itemid)){
            //     $template=$this->load->view('purchase_analysis/v_purchase_analysis_by_item_list', $this->data,true);
            // }else{
            //     $template='<span class="col-sm-12 alert alert-danger text-center">Please check an item!!!</span>';
            // }
           $template=$this->load->view('purchase_analysis/v_purchase_analysis_by_item_list', $this->data,true);
            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    //Purchase summary credit
    public function purchase_analysis_credit_report()
    {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $template = $this->get_purchase_analysis_credit_report_data();
            print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
            exit;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }  
    }

    public function generate_purchase_analysis_credit_pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->get_purchase_analysis_credit_report_data();

            $filename = 'purchase_analysis_credit_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_purchase_analysis_credit_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=purchase_analysis_credit_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->get_purchase_analysis_credit_report_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function get_purchase_analysis_credit_report_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data['excel_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_credit_excel";
            $this->data['pdf_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_credit_pdf";
            $this->data['report_title'] = $this->lang->line('purchase_summary');

            $this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');

            $locationid = $this->input->post('locationid');
            $supplierid = $this->input->post('supplierid');

            $pur_analysis_list=$this->data['pur_analysis_list'] =  $this->purchase_analysis_mdl->get_item_cat_info('purchase_analysis');
            //echo "<pre>"; print_r($this->data['pur_analysis_list']); die;

            $this->data['return_data'] = "";
            if(!empty($pur_analysis_list)):
                foreach ($pur_analysis_list as $key => $supp) {
                $this->data['return_data'] = $this->purchase_analysis_mdl->get_mrn_return_analysis(array('pr.purr_supplierid'=>$supp->recm_supplierid));
                }
            endif;
            
            //echo "<pre>"; print_r($return_data); die;

            // if($locationid):
            //     $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
            // else:
            //     $this->data['location'] = 'All';
            // endif;
            if($this->location_ismain=='Y'){
              if($locationid){
               $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
           }else{
             $this->data['location'] = 'All';

           }
       }else{
           $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

       }

            if($supplierid):
                $this->data['supplier']=$this->general->get_tbl_data('dist_distributor','dist_distributors',array('dist_distributorid'=>$supplierid));
            else:
                $this->data['supplier'] = 'All';
            endif;

            // if($supplierid){
            //     $template=$this->load->view('purchase_analysis/v_purchase_analysis_credit_list', $this->data,true);
            // }else{
            //     $template='<span class="col-sm-12 alert alert-danger text-center">Please select a supplier!!!</span>';
            // }

            $template=$this->load->view('purchase_analysis/v_purchase_analysis_credit_list', $this->data,true);
            
            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    //Purchase summary
    public function purchase_analysis_report()
    {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $template = $this->get_purchase_analysis_report_data();
            print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
            exit;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }  
    }

    public function generate_purchase_analysis_pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->get_purchase_analysis_report_data();

            $filename = 'purchase_analysis_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_purchase_analysis_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=purchase_analysis_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->get_purchase_analysis_report_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function get_purchase_analysis_report_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data['excel_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_excel";
            $this->data['pdf_url'] = "purchase_receive/purchase_analysis/generate_purchase_analysis_pdf";
            $this->data['report_title'] = $this->lang->line('purchase_summary');

            $this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');

            $locationid = $this->input->post('locationid');
            $supplierid = $this->input->post('supplierid');

            $summary_type = $this->input->post('summary_type');

            $this->data['pur_summary_supplier_wise'] = $this->data['pur_summary_supplier_wise'] = $this->data['pur_summary_item_wise'] = $this->data['pur_summary_category_wise'] = '';

            if($summary_type == 'supplier_wise'){
                $this->data['pur_summary_supplier_wise'] =  $this->purchase_analysis_mdl->get_item_cat_info('supplier_wise');
            }else if($summary_type == 'date_wise'){
                $this->data['pur_summary_date_wise'] =  $this->purchase_analysis_mdl->get_item_cat_info('date_wise');
            }else if($summary_type == 'item_wise'){
                $this->data['pur_summary_item_wise'] =  $this->purchase_analysis_mdl->get_item_cat_info('item_wise');
            }else if($summary_type == 'category_wise'){
                $this->data['pur_summary_category_wise'] =  $this->purchase_analysis_mdl->get_item_cat_info('category_wise');
            }else{
                $this->data['pur_summary_supplier_wise'] =  $this->purchase_analysis_mdl->get_item_cat_info('supplier_wise');

                $this->data['pur_summary_date_wise'] =  $this->purchase_analysis_mdl->get_item_cat_info('date_wise');

                $this->data['pur_summary_item_wise'] =  $this->purchase_analysis_mdl->get_item_cat_info('item_wise');

                $this->data['pur_summary_category_wise'] =  $this->purchase_analysis_mdl->get_item_cat_info('category_wise'); 
            }

            //echo "<pre>"; print_r($this->data['pur_analysis_list']); die;

            $this->data['return_data'] = "";
            if(!empty($pur_analysis_list)):
                foreach ($pur_analysis_list as $key => $supp) {
                $this->data['return_data'] = $this->purchase_analysis_mdl->get_mrn_return_analysis(array('pr.purr_supplierid'=>$supp->recm_supplierid));
                }
            endif;
            
            //echo "<pre>"; print_r($return_data); die;

            // if($locationid):
            //     $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
            // else:
            //     $this->data['location'] = 'All';
            // endif;
                if($this->location_ismain=='Y'){
                if($locationid){
                $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
                }else{
                $this->data['location'] = 'All';

                }
                }else{
                $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

                }

            if($supplierid):
                $this->data['supplier']=$this->general->get_tbl_data('dist_distributor','dist_distributors',array('dist_distributorid'=>$supplierid));
            else:
                $this->data['supplier'] = 'All';
            endif;

            $template=$this->load->view('purchase_analysis/v_purchase_analysis_list', $this->data,true);
            
            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */