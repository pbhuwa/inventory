<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_sales_desposal_mdl extends CI_Model 

{

	public function __construct()  

	{

		parent::__construct();

		$this->tableMaster='asde_assetdesposalmaster';

		$this->tableDetail='asdd_assetdesposaldetail';

		$this->curtime = $this->general->get_currenttime();

		$this->userid = $this->session->userdata(USER_ID);

		$this->username = $this->session->userdata(USER_NAME);

		$this->userdepid = $this->session->userdata(USER_DEPT); //storeid

		$this->mac = $this->general->get_Mac_Address();

		$this->ip = $this->general->get_real_ipaddr();

		$this->locationid=$this->session->userdata(LOCATION_ID);

		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);

		$this->orgid=$this->session->userdata(ORG_ID);  

	}  

	public $validate_settings_assets_desposal = array(

	    array('field' => 'asde_fiscalyrs', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),
	    array('field' => 'asde_desposaltypeid', 'label' => 'Project', 'rules' => 'trim|required|xss_clean'),
	    array('field' => 'asde_disposalno', 'label' => 'Disposal Order No', 'rules' => 'trim|required|xss_clean'),
	    array('field' => 'asde_desposaldate', 'label' => 'Disposal Date ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'asdd_assetid[]', 'label' => 'Assets ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'assets_salesval[]', 'label' => 'Sales ', 'rules' => 'trim|required|xss_clean')

		 );

	public function sales_desposal_assets_save(){       

        try{

				// echo "<pre>";

				// print_r($this->input->post());

				// die();        	

            $id = $this->input->post('id');

            $fyear=$this->input->post('asde_fiscalyrs');

          	$asde_disposalno =$this->input->post('asde_disposalno');

		    $asde_manualno =$this->input->post('asde_manualno');

		    $asde_desposaldate =$this->input->post('asde_desposaldate');

		    $asde_desposaltypeid =$this->input->post('asde_desposaltypeid');

		    $asde_customer_name =$this->input->post('asde_customer_name');

		    $asde_sale_taxper =$this->input->post('asde_sale_taxper');

			$full_remarks  =$this->input->post('full_remarks');

		    $assets_code =$this->input->post('assets_code');

		    $asdd_assetid =$this->input->post('asdd_assetid');

		    $assets_desc =$this->input->post('assets_desc');

		    $assets_orginalval=$this->input->post('assets_orginalval');

		    $assets_currentval =$this->input->post('assets_currentval');

		    $last_dep_date =$this->input->post('last_dep_date');

		    $assets_salesval=$this->input->post('assets_salesval');

		    $remarks  =$this->input->post('remarks');

            if(DEFAULT_DATEPICKER=='NP')

            {

                $asde_deposaldatebs=$asde_desposaldate;

                $asde_desposaldatead=$this->general->NepToEngDateConv($asde_desposaldate);

            }

            else

            {

                $asde_desposaldatead=$asde_desposaldate;

                $asde_deposaldatebs=$this->general->EngToNepDateConv($asde_desposaldate);

            }

            $locationid=$this->session->userdata(LOCATION_ID);

		$currentfyrs=CUR_FISCALYEAR;

		$cur_fiscalyrs_invoiceno=$this->db->select('prin_code,prin_fiscalyrs')

									->from('prin_projectinfo')

									->where('prin_locationid',$locationid)

									// ->where('prin_fiscalyrs',$currentfyrs)

									->order_by('prin_fiscalyrs','DESC')

									->limit(1)

									->get()->row();

		// echo "<pre>";

		// print_r($cur_fiscalyrs_invoiceno);

		// die();

		if(!empty($cur_fiscalyrs_invoiceno)){

			$invoice_format=$cur_fiscalyrs_invoiceno->prin_code;

			$invoice_string=str_split($invoice_format);

			// echo "<pre>";

			// print_r($invoice_string);

			// die();

			$invoice_prefix_len=strlen(ASSET_DISPOSAL_NO_PREFIX);

			$chk_first_string_after_invoice_prefix=!empty($invoice_string[$invoice_prefix_len])?$invoice_string[$invoice_prefix_len]:'';

			// echo $chk_first_string_after_invoice_prefix;

			// die();

			if($chk_first_string_after_invoice_prefix =='0'){

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs==$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix !='0' ) {

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else{

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX;

			}

		}

		else{

			$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

		}

			$disposal_code = $this->general->generate_invoiceno('asde_disposalno','asde_disposalno','asde_assetdesposalmaster',$invoice_no_prefix,ASSET_DISPOSAL_NO_LENGTH,false,'asde_locationid');

            $desposalArr=array(

            	'asde_fiscalyrs'=>$fyear,

				'asde_desposaltypeid'=>$asde_desposaltypeid,

				'asde_disposalno'=>$disposal_code,

				'asde_manualno'=>$asde_manualno,

				'asde_desposaldatead'=>$asde_desposaldatead,

				'asde_deposaldatebs'=>$asde_deposaldatebs,

				'asde_customer_name'=>$asde_customer_name,

				'asde_sale_taxper'=>$asde_sale_taxper,

				'asde_remarks'=>$full_remarks,

				'asde_status'=>'O',

				'asde_postdatead'=>CURDATE_EN,

				'asde_postdatebs'=>CURDATE_NP,

				'asde_posttime'=>$this->curtime,

				'asde_postby'=> $this->userid,

				'asde_postip'=> $this->ip,

				'asde_postmac'=>$this->mac,

				'asde_locationid'=> $this->locationid,

				'asde_orgid'=>$this->orgid

            );

            if(!empty($desposalArr)){

            	$this->db->insert('asde_assetdesposalmaster',$desposalArr);

            	  $insertid=$this->db->insert_id();

            	  $ass_desposaldArray=array();

                    if($insertid){

                    	if(!empty($asdd_assetid)):

                            foreach ($asdd_assetid as $kdw => $dlist) {

                            	$ass_desp_arr[]=array(

                            		'asen_asenid'=>!empty($asdd_assetid[$kdw])?$asdd_assetid[$kdw]:'',

                            		'asen_isdispose'=>'Y'

                            	);

                            	$samount=!empty($assets_salesval[$kdw])?$assets_salesval[$kdw]:'0.00';

                            	$tsamount=$samount*($asde_sale_taxper)/100;

                            	$ldepdate=!empty($last_dep_date[$kdw])?$last_dep_date[$kdw]:'';

                        	   if(DEFAULT_DATEPICKER=='NP'){

					                $ldepdatebs=$ldepdate;

					                $ldepdatead=$this->general->NepToEngDateConv($ldepdate);

					            }

					            else{

					                $ldepdatead=$ldepdate;

					                $ldepdatebs=$this->general->EngToNepDateConv($ldepdate);

					            }

                                $ass_desposaldArray[]=array(

                                	'asdd_assetdesposalmasterid'=>$insertid,

									'asdd_assetid'=>!empty($asdd_assetid[$kdw])?$asdd_assetid[$kdw]:'',

									'asdd_originalvalue'=>!empty($assets_orginalval[$kdw])?$assets_orginalval[$kdw]:'0.00',

									'asdd_currentvalue'=>!empty($assets_currentval[$kdw])?$assets_currentval[$kdw]:'0.00',

									'asdd_lastdepriciationdatead'=>$ldepdatead,

									'asdd_lastdepriciationdatebs'=>$ldepdatebs,

									'asdd_sales_amount'=>!empty($assets_salesval[$kdw])?$assets_salesval[$kdw]:'0.00',

									'asdd_sales_tax_per'=>$asde_sale_taxper,

									'asdd_sales_totalamt'=>$tsamount,

									'asdd_remarks'=>!empty($remarks[$kdw])?$remarks[$kdw]:'',

									'asdd_status'=>'O',

									'asdd_postdatead'=>CURDATE_EN,

									'asdd_postdatebs'=>CURDATE_NP,

									'asdd_posttime'=>$this->curtime,

									'asdd_postby'=>$this->userid,

									'asdd_postip'=>$this->ip,

									'asdd_postmac'=>$this->mac,

									'asdd_locationid'=>$this->locationid,

									'asdd_orgid'=>$this->orgid

                                ); 

                    }

                endif;

                    if(!empty($ass_desposaldArray)){

                    	$this->db->insert_batch('asdd_assetdesposaldetail',$ass_desposaldArray);

                    	$this->db->update_batch('asen_assetentry',$ass_desp_arr,'asen_asenid');

                    }

            }

        }

         $this->db->trans_complete();

         $this->db->trans_commit();

           return true;

	 }catch(Exception $e){

	 	 	$this->db->trans_rollback();

                return false;

            throw $e;

        }

    }

	public function get_sales_disposal_summary_list($cond=false)

	{

		$get = $_GET;

        $frmDate=$this->input->get('frmDate');

        $toDate=$this->input->get('toDate');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $range=!empty($get['range'])?$get['range']:'all';

        $search_text=!empty($get['search_text'])?$get['search_text']:'';

        $disposal_type=!empty($get['disposal_type'])?$get['disposal_type']:'';

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        if($this->location_ismain=='Y')

          {

            if($input_locationid)

            {

                $this->db->where('asde.asde_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('asde.asde_locationid',$this->locationid);

        }

		if($range == 'range'){

			if(!empty(($frmDate && $toDate))){

				if(DEFAULT_DATEPICKER == 'NP'){

					$this->db->where('asde.asde_deposaldatebs >=',$frmDate);

					$this->db->where('asde.asde_deposaldatebs <=',$toDate);    

				}else{

					$this->db->where('asde.asde_desposaldatead >=',$frmDate);

					$this->db->where('asde.asde_desposaldatead <=',$toDate);

				}

			}

		}

        if(!empty($disposal_type)){

			$this->db->where("asde.asde_desposaltypeid =",$disposal_type);

        }

        if(!empty($search_text)){

			$this->db->where("asde.asde_customer_name like '%$search_text%'")

			->or_where("asde.asde_manualno like '%$search_text%'")

			->or_where("asde.asde_disposalno like '%$search_text%'");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("asde_desposaldatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("asde_deposaldatebs like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("asde_desposaltypeid like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("asde_disposalno like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("asde_customer_name like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("asdd.asdd_sales_totalamt like  '%".$get['sSearch_6']."%'  ");

        }

         if(!empty($get['sSearch_7'])){

            $this->db->where("asdd.asdd_originalvalue like  '%".$get['sSearch_7']."%'  ");

        }

         if(!empty($get['sSearch_8'])){

            $this->db->where("asdd.asdd_currentvalue like  '%".$get['sSearch_8']."%'  ");

        }

         if(!empty($get['sSearch_9'])){

            $this->db->where("asdd.asdd_sales_amount like  '%".$get['sSearch_9']."%'  ");

        }

          if($cond) {

          $this->db->where($cond);

        }

       //  

        $resltrpt=$this->db->select("COUNT('asde_assetdesposalmasterid') as cnt")

                    ->from('asde_assetdesposalmaster asde')

                    ->join('asdd_assetdesposaldetail asdd','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')

					->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT')

                    ->get()->row();

        //echo $this->db->last_query();die(); 

         $totalfilteredrecs=0;

         if(!empty($resltrpt)){

        	$totalfilteredrecs=$resltrpt->cnt;  	

         }

        $order_by = 'asde_assetdesposalmasterid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

       	if($this->input->get('iSortCol_0')==1)

            $order_by = 'asde_desposaldatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'asde_deposaldatebs';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'asde_desposaltypeid';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'asde_disposalno';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'asde_customer_name';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'asdd.asdd_sales_totalamt';

         else if($this->input->get('iSortCol_0')==7)

            $order_by = 'asdd.asdd_originalvalue';

         else if($this->input->get('iSortCol_0')==8)

            $order_by = 'asdd.asdd_currentvalue';

         else if($this->input->get('iSortCol_0')==9)

            $order_by = 'asdd.asdd_sales_amount';

        $totalrecs='';

        $limit = 15;

        $offset = 1;

        $get = $_GET;

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        if(!empty($_GET["iDisplayLength"])){

           $limit = $_GET['iDisplayLength'];

           $offset = $_GET["iDisplayStart"];

        }

		if($this->location_ismain=='Y')

		{

		if($input_locationid)

		{

			$this->db->where('asde.asde_locationid',$input_locationid);

		}

		}

		else

		{

			$this->db->where('asde.asde_locationid',$this->locationid);

		}

		if($range == 'range'){

			if(!empty(($frmDate && $toDate))){

				if(DEFAULT_DATEPICKER == 'NP'){

					$this->db->where('asde.asde_deposaldatebs >=',$frmDate);

					$this->db->where('asde.asde_deposaldatebs <=',$toDate);    

				}else{

					$this->db->where('asde.asde_desposaldatead >=',$frmDate);

					$this->db->where('asde.asde_desposaldatead <=',$toDate);

				}

			}

		}

		if(!empty($disposal_type)){

			$this->db->where("asde.asde_desposaltypeid =",$disposal_type);

        }

		if(!empty($search_text)){

			$this->db->where("asde.asde_customer_name like '%$search_text%'")

			->or_where("asde.asde_manualno like '%$search_text%'")

			->or_where("asde.asde_disposalno like '%$search_text%'");

		}

        if(!empty($get['sSearch_1'])){

            $this->db->where("asde_desposaldatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("asde_deposaldatebs like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("asde_desposaltypeid like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("asde_disposalno like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("asde_customer_name like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("asdd.asdd_sales_totalamt like  '%".$get['sSearch_6']."%'  ");

        }

         if(!empty($get['sSearch_7'])){

            $this->db->where("asdd.asdd_originalvalue like  '%".$get['sSearch_7']."%'  ");

        }

         if(!empty($get['sSearch_8'])){

            $this->db->where("asdd.asdd_currentvalue like  '%".$get['sSearch_8']."%'  ");

        }

         if(!empty($get['sSearch_9'])){

            $this->db->where("asdd.asdd_sales_amount like  '%".$get['sSearch_9']."%'  ");

        }

        if($cond) {

          $this->db->where($cond);   

        } 

       $this->db->select("asde.*,SUM(asdd_sales_totalamt) as asdd_sales_totalamt ,SUM(asdd_originalvalue) as asdd_originalvalue,SUM(asdd_currentvalue) as asdd_currentvalue,SUM(asdd_sales_amount) as asdd_sales_amount,dety.dety_name,SUM(asdd_disposalqty) as item_count")

	   ->from('asde_assetdesposalmaster asde')

	   ->join('asdd_assetdesposaldetail asdd','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')

	   ->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT');

        $this->db->order_by($order_by,$order);

        if($limit && $limit>0)

        {  

            $this->db->limit($limit);

        }

        if($offset)

        {

            $this->db->offset($offset); 

        }

		$this->db->group_by('asde_assetdesposalmasterid');

       $nquery=$this->db->get();

       $num_row=$nquery->num_rows();

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {

            $totalrecs = sizeof($nquery);

        }

       if($num_row>0){

          $ndata=$nquery->result();

          $ndata['totalrecs'] = $totalrecs;

          $ndata['totalfilteredrecs'] = $totalfilteredrecs;

        } 

        else

        {

            $ndata=array();

            $ndata['totalrecs'] = 0;

            $ndata['totalfilteredrecs'] = 0;

        }

        // echo $this->db->last_query();die();

      return $ndata;

	}		

// ** =================================================================================================================================================================================================== **//

	public function get_sales_disposal_detail_list($cond = false)

	{ 

		$get = $_GET;

        $frmDate=$this->input->get('frmDate');

        $toDate=$this->input->get('toDate');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $range=!empty($get['range'])?$get['range']:'all';

        $search_text=!empty($get['search_text'])?$get['search_text']:'';

        $disposal_type=!empty($get['disposal_type'])?$get['disposal_type']:'';

        $department_id=!empty($get['department_id'])?$get['department_id']:'';

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        if($this->location_ismain=='Y')

          {

            if($input_locationid)

            {

                $this->db->where('asde.asde_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('asde.asde_locationid',$this->locationid);

        }

		if($range == 'range'){

			if(!empty(($frmDate && $toDate))){

				if(DEFAULT_DATEPICKER == 'NP'){

					$this->db->where('asde.asde_deposaldatebs >=',$frmDate);

					$this->db->where('asde.asde_deposaldatebs <=',$toDate);    

				}else{

					$this->db->where('asde.asde_desposaldatead >=',$frmDate);

					$this->db->where('asde.asde_desposaldatead <=',$toDate);

				}

			}

		}

        if(!empty($disposal_type)){

			$this->db->where("asde.asde_desposaltypeid =",$disposal_type);

        }

        if(!empty($department_id)){

			$this->db->where("dept.dept_depid =",$department_id);

        }

        if(!empty($search_text)){

			$this->db->where("asde.asde_customer_name like '%$search_text%'")

			->or_where("asde.asde_manualno like '%$search_text%'")

			->or_where("asde.asde_disposalno like '%$search_text%'");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("asen.asen_assetcode like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("asen.asen_description like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("dept.dept_depname like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("asen.asen_room like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("asdd.asdd_originalvalue like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("asdd.asdd_currentvalue like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("asdd.asdd_sales_totalamt like  '%".$get['sSearch_7']."%'  ");

        }

		if(!empty($get['sSearch_8'])){

            $this->db->where("asdd.asdd_remarks like  '%".$get['sSearch_8']."%'  ");

        }

		if($cond) {

		$this->db->where($cond);

        }

       //  

        $resltrpt=$this->db->select("COUNT('asde_assetdesposalmasterid') as cnt")

                    ->from('asde_assetdesposalmaster asde')

					->join('asdd_assetdesposaldetail asdd','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')

					->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT')

					->join('asen_assetentry asen','asdd.asdd_assetid = asen.asen_asenid','LEFT')

					->join('dept_department dept','dept.dept_depid = asen.asen_depid','LEFT')

                    ->get()->row();

        //echo $this->db->last_query();die(); 

         $totalfilteredrecs=0;

         if(!empty($resltrpt)){

        	$totalfilteredrecs=$resltrpt->cnt;  	

         }

        $order_by = 'asde_assetdesposalmasterid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

       	if($this->input->get('iSortCol_0')==1)

            $order_by = 'asen.asen_assetcode';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'asen.asen_description';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'dept.dept_depname';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'asen.asen_room';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'asdd.asdd_originalvalue';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'asdd.asdd_currentvalue';

         else if($this->input->get('iSortCol_0')==7)

            $order_by = 'asdd.asdd_sales_amount';

         else if($this->input->get('iSortCol_0')==8)

            $order_by = 'asdd.asdd_remarks';

        $totalrecs='';

        $limit = 15;

        $offset = 1;

        $get = $_GET;

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        if(!empty($_GET["iDisplayLength"])){

           $limit = $_GET['iDisplayLength'];

           $offset = $_GET["iDisplayStart"];

        }

		if($this->location_ismain=='Y')

		{

		if($input_locationid)

		{

			$this->db->where('asde.asde_locationid',$input_locationid);

		}

		}

		else

		{

			$this->db->where('asde.asde_locationid',$this->locationid);

		}

		if($range == 'range'){

			if(!empty(($frmDate && $toDate))){

				if(DEFAULT_DATEPICKER == 'NP'){

					$this->db->where('asde.asde_deposaldatebs >=',$frmDate);

					$this->db->where('asde.asde_deposaldatebs <=',$toDate);    

				}else{

					$this->db->where('asde.asde_desposaldatead >=',$frmDate);

					$this->db->where('asde.asde_desposaldatead <=',$toDate);

				}

			}

		}

		if(!empty($disposal_type)){

			$this->db->where("asde.asde_desposaltypeid =",$disposal_type);

		}

		if(!empty($department_id)){

			$this->db->where("dept.dept_depid =",$department_id);

        }

		if(!empty($search_text)){

			$this->db->where("asde.asde_customer_name like '%$search_text%'")

			->or_where("asde.asde_manualno like '%$search_text%'")

			->or_where("asde.asde_disposalno like '%$search_text%'");

		}

        if(!empty($get['sSearch_0'])){

            $this->db->where("asde_assetdesposalmasterid like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("asen.asen_assetcode like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("asen.asen_description like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("dept.dept_depname like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("asen.asen_room like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("asdd.asdd_originalvalue like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("asdd.asdd_currentvalue like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("asdd.asdd_sales_totalamt like  '%".$get['sSearch_7']."%'  ");

        }

		if(!empty($get['sSearch_8'])){

            $this->db->where("asdd.asdd_remarks like  '%".$get['sSearch_8']."%'  ");

        }

        if($cond) {

          $this->db->where($cond);   

        } 

       $this->db->select("asde.*,asdd.*,dety.dety_name,asen.asen_assetcode,asen.asen_description,asen.asen_room,dept.dept_depname")

	   ->from('asde_assetdesposalmaster asde')

	   ->join('asdd_assetdesposaldetail asdd','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')

	   ->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT')

		->join('asen_assetentry asen','asdd.asdd_assetid = asen.asen_asenid','LEFT')

		->join('dept_department dept','dept.dept_depid = asen.asen_depid','LEFT');

        $this->db->order_by($order_by,$order);

        if($limit && $limit>0)

        {  

            $this->db->limit($limit);

        }

        if($offset)

        {

            $this->db->offset($offset); 

        }

       $nquery=$this->db->get();

       $num_row=$nquery->num_rows();

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {

            $totalrecs = sizeof($nquery);

        }

       if($num_row>0){

          $ndata=$nquery->result();

          $ndata['totalrecs'] = $totalrecs;

          $ndata['totalfilteredrecs'] = $totalfilteredrecs;

        } 

        else

        {

            $ndata=array();

            $ndata['totalrecs'] = 0;

            $ndata['totalfilteredrecs'] = 0;

        }

        // echo $this->db->last_query();die();

      return $ndata; 

	}

	public function get_sales_desposal_master_data($srchcol = false)

	{

		try{

			$this->db->select("asde.*,dety_name")
			->from('asde_assetdesposalmaster asde')
			->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT');	

			if($srchcol)

				{

				$this->db->where($srchcol); 

				}

				$query = $this->db->get();

				 if($query->num_rows() > 0){

					return $query->result();

				}
				return false;
			}
			catch(Exception $e){
				throw $e;
			}

	}

	public function get_sales_desposal_detail_data($srchcol = false)

	{

		try{

			if(ORGANIZATION_NAME == 'NPHL'){
				$this->db->select("asdd.*,itli_itemcode as asen_assetcode,itli_itemname as asen_description,SUM(asdd_disposalqty) as asdd_disposalqty,SUM(asdd_sales_totalamt) as asdd_sales_totalamt")
				->from('asdd_assetdesposaldetail asdd')
				->join('itli_itemslist il','asdd.asdd_assetid = il.itli_itemlistid','LEFT');
			
			}else {
			
				$this->db->select("asdd.*,asen.asen_assetcode,asen.asen_description")
				->from('asdd_assetdesposaldetail asdd')
				->join('asen_assetentry asen','asdd.asdd_assetid = asen.asen_asenid','LEFT');

			}

			if($srchcol)

				{
				$this->db->where($srchcol); 
				}

			if(ORGANIZATION_NAME == 'NPHL'){
				$this->db->group_by('asdd_assetid');
			}

				$query = $this->db->get();
				 if($query->num_rows() > 0){
					return $query->result();
				}
				return false;
			}

			catch(Exception $e){

				throw $e;
			}
		}

}