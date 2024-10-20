<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->load->model('home_mdl');
		$this->load->model('biomedical/repair_information_mdl');
		$this->load->model('biomedical/bio_medical_mdl');
		$this->load->model('ams/assets_mdl');
	
		$this->orgid= $this->session->userdata(ORG_ID);
		$this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
		$this->username = $this->session->userdata(USER_NAME);
		$this->sess_dept = $this->session->userdata(USER_DEPT);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->storeid=$this->session->userdata(STORE_ID);
		$this->depid=$this->session->userdata(USER_DEPT);

		// echo "<pre>";
		// print_r($this->session);
	}

	public function index()
	{
		$this->data = array();
		// Diect Purchase//

		// echo "tes";
		// die();
		
		$this->data=array(
			'module_title'=>'Dashboard',
			'depid'=>'2');

		if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
			$new_sess_dept = explode(',',$this->sess_dept);
		}else{
			$new_sess_dept = array();
		}

		if($this->orgid==1)
		{
			// $this->data['inventory_total_bio']=$this->general->get_tbl_data('COUNT(bmin_equipid) as total_inventory','bmin_bmeinventory',array('bmin_orgid'=>1));

			// $this->data['inventory_today_bio']=$this->general->get_tbl_data('COUNT(bmin_equipid) as todays_inventory','bmin_bmeinventory',array('bmin_postdatead' => CURDATE_EN,'bmin_orgid'=>1));

			// $this->data['under_repair_total_bio']=$this->general->get_tbl_data('COUNT(rere_repairrequestid) as total_repairreq','rere_repairrequests',array('rere_status' => 0,'rere_orgid'=>1));
			// $this->data['under_repair_today_bio']=$this->general->get_tbl_data('COUNT(rere_repairrequestid) as today_repairreq','rere_repairrequests',array('rere_status' => 0,'rere_postdatead'=>CURDATE_EN,'rere_orgid'=>1));

			$this->data['inventory_total_bio'] = $this->home_mdl->count_equipentlist_by_dep(array('bmin_orgid'=>'1','bmin_locationid'=>$this->locationid),$new_sess_dept);

			$this->data['inventory_today_bio'] = $this->home_mdl->count_equipentlist_by_dep(array('bmin_postdatead'=>CURDATE_EN,'bmin_orgid'=>'1','bmin_locationid'=>$this->locationid),$new_sess_dept);

			$this->data['under_repair_total_bio'] = $this->home_mdl->count_repairrequestlist_by_dep(array('rere_status' => 0,'rere_orgid'=>'1'),$new_sess_dept);

			$this->data['under_repair_today_bio'] = $this->home_mdl->count_repairrequestlist_by_dep(array('rere_status' => 0,'rere_postdatead'=>CURDATE_EN,'rere_orgid'=>'1'),$new_sess_dept);

			
			$this->data['distributors_total_bio']=$this->general->get_tbl_data('COUNT(dist_distributorid) as total_distributers','dist_distributors',array('dist_orgid'=>1));
			$this->data['distributors_today_bio']=$this->general->get_tbl_data('COUNT(dist_distributorid) as todays_distributers','dist_distributors',array('dist_postdatead' => CURDATE_EN,'dist_orgid'=>1));

			$this->data['manufactures_total_bio']=$this->general->get_tbl_data('COUNT(manu_manlistid) as total_manufactures','manu_manufacturers',array('manu_orgid'=>1));
			$this->data['manufactures_today_bio']=$this->general->get_tbl_data('COUNT(manu_manlistid) as todays_manufactures','manu_manufacturers',array('manu_postdatead' => CURDATE_EN,'manu_orgid'=>1));

			$this->data['servicetech_total_bio']=$this->general->get_tbl_data('COUNT(sete_techid) as total_servicetech','sete_servicetechs',array('sete_orgid'=>1));
			$this->data['servicetech_today_bio']=$this->general->get_tbl_data('COUNT(sete_techid) as todays_servicetech','sete_servicetechs',array('sete_postdatead' => CURDATE_EN,'sete_orgid'=>1));
			
			$this->data['pm_data_today']=$this->general->get_tbl_data('COUNT(pmta_pmtableid) as today_pmdata','pmta_pmtable',array('pmta_pmdatead'=>CURDATE_EN));
			$this->data['pm_weekly']=$this->home_mdl->get_weekly_pm();
			$this->data['pm_last5week']=$this->home_mdl->get_last5_pm();
			$this->data['pm_year']=$this->home_mdl->get_year_pm();
			$this->data['pm_yearwise']=$this->home_mdl->get_year_wise_pm();

			// echo "<pre>";
			// print_r($this->data);
			// die();
		}
		if($this->orgid==2)
		{
			//For Assets
			$this->data['inventory_total_asset']=$this->general->get_tbl_data('COUNT(bmin_equipid) as total_inventory','bmin_bmeinventory',array('bmin_orgid'=>2));
			$this->data['inventory_today_asset']=$this->general->get_tbl_data('COUNT(bmin_equipid) as todays_inventory','bmin_bmeinventory',array('bmin_postdatead' => CURDATE_EN,'bmin_orgid'=>2));

			$this->data['distributors_total_asset']=$this->general->get_tbl_data('COUNT(dist_distributorid) as total_distributers','dist_distributors',array('dist_orgid'=>2));
			$this->data['distributors_today_asset']=$this->general->get_tbl_data('COUNT(dist_distributorid) as todays_distributers','dist_distributors',array('dist_postdatead' => CURDATE_EN,'dist_orgid'=>2));

			$this->data['manufactures_total_asset']=$this->general->get_tbl_data('COUNT(manu_manlistid) as total_manufactures','manu_manufacturers',array('manu_orgid'=>2));
			$this->data['manufactures_today_asset']=$this->general->get_tbl_data('COUNT(manu_manlistid) as todays_manufactures','manu_manufacturers',array('manu_postdatead' => CURDATE_EN,'manu_orgid'=>2));

			$this->data['servicetech_total_asset']=$this->general->get_tbl_data('COUNT(sete_techid) as total_servicetech','sete_servicetechs',array('sete_orgid'=>2));
			$this->data['servicetech_today_asset']=$this->general->get_tbl_data('COUNT(sete_techid) as todays_servicetech','sete_servicetechs',array('sete_postdatead' => CURDATE_EN,'sete_orgid'=>2));
			$this->data['under_repair_total_asset']=$this->general->get_tbl_data('COUNT(rere_repairrequestid) as total_repairreq','rere_repairrequests',array('rere_status' => 0,'rere_orgid'=>2));
			$this->data['under_repair_today_asset']=$this->general->get_tbl_data('COUNT(rere_repairrequestid) as total_repairreq','rere_repairrequests',array('rere_status' => 0,'rere_postdatead'=>CURDATE_EN,'rere_orgid'=>2));
			$this->data['pm_weekly']=$this->home_mdl->get_weekly_pm();
			$this->data['pm_last5week']=$this->home_mdl->get_last5_pm();
			$this->data['pm_year']=$this->home_mdl->get_year_pm();
			$this->data['pm_yearwise']=$this->home_mdl->get_year_wise_pm();
		}
		// echo $this->orgid;
		// die();
		if($this->orgid==3)
		{
			$dashboardaccess_array=$this->home_mdl->get_access_dashboard_list();
			// echo "<pre>";
			// print_r($dashboardaccess_array);
			// die();
			 // echo "test";
    // die();
			$this->data['dashboardaccess_array']=$dashboardaccess_array;

			$this->data['req_iss_data']=$this->home_mdl->get_requisition_issue_data();
			$fromDate=!empty($this->input->post('fromDate'))?$this->input->post('fromDate'):CURMONTH_DAY1;
			$toDate=!empty($this->input->post('toDate'))?$this->input->post('toDate'):DISPLAY_DATE;
			$this->load->model('purchase_receive/quotation_mdl','quotation_mdl');
			$this->load->model('purchase_receive/purchase_order_mdl','purchase_order_mdl');
			
			$this->data['req_iss_weekly']=$this->home_mdl->get_weekly_req_issue();
			$this->data['req_iss_yearwise']=$this->home_mdl->get_year_wise_req_issue();
			$this->data['req_iss_year']=$this->home_mdl->get_year_req_issue();
			//echo "<pre>"; print_r($this->data['req_iss_year']); die;
			$this->data['req_chart']=$this->home_mdl->get_pie_chart(1);
			// echo "<prE>";
			// print_r($this->data['req_chart']);
			// die();

			$this->data['issue_chart']=$this->home_mdl->get_pie_chart(2);
			 //echo "<pre>"; print_r($this->data['req_chart']); die;

			
			if(DEFAULT_DATEPICKER=='NP')
			{
							// Purchase Requistion
				$this->data['purchaserequisitiondetail']=$this->general->get_tbl_data('COUNT(pure_purchasereqid) as total_purchaserequisitiondetail','pure_purchaserequisition',array('pure_reqdatebs >='=>$fromDate,'pure_reqdatebs  <='=>$toDate,'pure_locationid'=>$this->locationid));

				$this->data['purchaserequisitionapproved']=$this->general->get_tbl_data('COUNT(pure_purchasereqid) as total_purchaserequisitionapproved','pure_purchaserequisition',array('pure_reqdatebs >='=>$fromDate,'pure_reqdatebs  <='=>$toDate,'pure_isapproved'=>'Y','pure_locationid'=>$this->locationid));

				$this->data['purchaserequisitionpending']=$this->general->get_tbl_data('COUNT(pure_purchasereqid) as total_purchaserequisitionpending','pure_purchaserequisition',array('pure_reqdatebs >='=>$fromDate,'pure_reqdatebs  <='=>$toDate,'pure_isapproved'=>'N','pure_locationid'=>$this->locationid));
			}
			else
			{
				$this->data['purchaserequisitiondetail']=$this->general->get_tbl_data('COUNT(pure_purchasereqid) as total_purchaserequisitiondetail','pure_purchaserequisition',array('pure_reqdatead >='=>$fromDate,'pure_reqdatead  <='=>$toDate,'pure_locationid'=>$this->locationid));
				$this->data['purchaserequisitionapproved']=$this->general->get_tbl_data('COUNT(pure_purchasereqid) as total_purchaserequisitionapproved','pure_purchaserequisition',array('pure_reqdatead >='=>$fromDate,'pure_reqdatead  <='=>$toDate,'pure_isapproved'=>'Y','pure_locationid'=>$this->locationid));

				$this->data['purchaserequisitionpending']=$this->general->get_tbl_data('COUNT(pure_purchasereqid) as total_purchaserequisitionpending','pure_purchaserequisition',array('pure_reqdatead >='=>$fromDate,'pure_reqdatead  <='=>$toDate,'pure_isapproved'=>'N','pure_locationid'=>$this->locationid));
			}

			if(DEFAULT_DATEPICKER=='NP')
			{
				$this->data['purchase_quotation']=$this->quotation_mdl->get_summary_quotation('COUNT(qude_quotationdetailid) as total_purchase_quotation',array('quma_quotationdatebs >='=>$fromDate,'quma_quotationdatebs <='=>$toDate,'quma_locationid'=>$this->locationid));
				$this->data['approved_quotation']=$this->quotation_mdl->get_summary_quotation('COUNT(qude_quotationdetailid) as total_approved_quotation',array('quma_quotationdatebs >='=>$fromDate,'quma_quotationdatebs <='=>$toDate,'qude_approvestatus'=>'A','quma_locationid'=>$this->locationid));

				$this->data['pending_quotation']=$this->quotation_mdl->get_summary_quotation('COUNT(qude_quotationdetailid) as total_pending_quotation',array('quma_quotationdatebs >='=>$fromDate,'quma_quotationdatebs <='=>$toDate,'qude_approvestatus'=>'P','quma_locationid'=>$this->locationid));
				$this->data['verified_quotation']=$this->quotation_mdl->get_summary_quotation('COUNT(qude_quotationdetailid) as total_verified_quotation',array('quma_quotationdatebs >='=>$fromDate,'quma_quotationdatebs <='=>$toDate,'qude_approvestatus'=>'FA','quma_locationid'=>$this->locationid));
			}
			else
			{
				$this->data['purchase_quotation']=$this->quotation_mdl->get_summary_quotation('COUNT(qude_quotationdetailid) as total_purchase_quotation',array('quma_quotationdatead >='=>$fromDate,'quma_quotationdatead <='=>$toDate,'quma_locationid'=>$this->locationid));
				$this->data['approved_quotation']=$this->quotation_mdl->get_summary_quotation('COUNT(qude_quotationdetailid) as total_approved_quotation',array('quma_quotationdatead >='=>$fromDate,'quma_quotationdatead <='=>$toDate,'qude_approvestatus'=>'FA','quma_locationid'=>$this->locationid));
				$this->data['pending_quotation']=$this->quotation_mdl->get_summary_quotation('COUNT(qude_quotationdetailid) as total_pending_quotation',array('quma_quotationdatead >='=>$fromDate,'quma_quotationdatead <='=>$toDate,'qude_approvestatus'=>'P','quma_locationid'=>$this->locationid));
				$this->data['verified_quotation']=$this->quotation_mdl->get_summary_quotation('COUNT(qude_quotationdetailid) as total_verified_quotation',array('quma_quotationdatead >='=>$fromDate,'quma_quotationdatead <='=>$toDate,'qude_approvestatus'=>'A','quma_locationid'=>$this->locationid));
			}
			// echo "<pre>";
			// print_r($this->data['approved_quotation']);
			// die();
			if(DEFAULT_DATEPICKER=='NP')
			{
				$this->data['purchaseorderdetail']=$this->purchase_order_mdl->summary_purchase_order('COUNT(puor_purchaseordermasterid) as total_purchaseorderdetail',array('puor_orderdatebs >='=>$fromDate,'puor_orderdatebs <='=>$toDate,'puor_locationid'=>$this->locationid));

				$this->data['purchaseorderpending']=$this->purchase_order_mdl->summary_purchase_order('COUNT(puor_purchaseordermasterid) as total_purchaseorderpending',array('puor_orderdatebs >='=>$fromDate,'puor_orderdatebs <='=>$toDate,'puor_purchased'=>0,'puor_locationid'=>$this->locationid));

				$this->data['purchaseorderpratially']=$this->purchase_order_mdl->summary_purchase_order('COUNT(puor_purchaseordermasterid) as total_purchaseorderpratially',array('puor_orderdatebs >='=>$fromDate,'puor_orderdatebs <='=>$toDate,'puor_purchased'=>1,'puor_locationid'=>$this->locationid));
			}
			else
			{
				$this->data['purchaseorderdetail']=$this->purchase_order_mdl->summary_purchase_order('COUNT(puor_purchaseordermasterid) as total_purchaseorderdetail',array('puor_orderdatead >='=>$fromDate,'puor_orderdatead <='=>$toDate,'puor_locationid'=>$this->locationid));
				$this->data['purchaseorderpending']=$this->purchase_order_mdl->summary_purchase_order('COUNT(puor_purchaseordermasterid) as total_purchaseorderpending',array('puor_orderdatead >='=>$fromDate,'puor_orderdatead <='=>$toDate,'puor_purchased'=>0,'puor_locationid'=>$this->locationid));

				$this->data['purchaseorderpratially']=$this->purchase_order_mdl->summary_purchase_order('COUNT(puor_purchaseordermasterid) as total_purchaseorderpratially',array('puor_orderdatead >='=>$fromDate,'puor_orderdatead <='=>$toDate,'puor_purchased'=>1,'puor_locationid'=>$this->locationid));
			}

			if(DEFAULT_DATEPICKER=='NP')
			{
            	

				$this->data['direct_purchase']=$this->general->get_tbl_data('COUNT(recm_receivedmasterid) as total_direct_purchase','recm_receivedmaster',array('recm_purchasestatus'=>'D','recm_receiveddatebs >='=>$fromDate,'recm_receiveddatebs <='=>$toDate,'recm_locationid'=>$this->locationid));

				$this->data['direct_purchase_receive']=$this->general->get_tbl_data('COUNT(trma_trmaid) as total_direct_purchase_receive','trma_transactionmain',array('trma_transactiontype'=>'PURCHASE','trma_fromdepartmentid'=>$this->storeid,'trma_received'=>1,'trma_status'=>'O','trma_transactiondatebs >='=>$fromDate,'trma_transactiondatebs <='=>$toDate,'trma_locationid'=>$this->locationid));

				$this->data['direct_purchase_cancel']=$this->general->get_tbl_data('COUNT(trma_trmaid) as total_direct_purchase_cancel','trma_transactionmain',array('trma_transactiontype'=>'PURCHASE','trma_fromdepartmentid'=>$this->storeid,'trma_received'=>1,'trma_status'=>'C','trma_transactiondatebs >='=>$fromDate,'trma_transactiondatebs <='=>$toDate,'trma_locationid'=>$this->locationid));

			}
			else
			{
				$this->data['direct_purchase']=$this->general->get_tbl_data('COUNT(trma_trmaid) as total_direct_purchase','trma_transactionmain',array('trma_transactiontype'=>'PURCHASE','trma_fromdepartmentid'=>$this->storeid,'trma_received'=>1,'trma_transactiondatebs >='=>$fromDate,'trma_transactiondatebs <='=>$toDate,'trma_locationid'=>$this->locationid));

				$this->data['direct_purchase_receive']=$this->general->get_tbl_data('COUNT(trma_trmaid) as total_direct_purchase_receive','trma_transactionmain',array('trma_transactiontype'=>'PURCHASE','trma_fromdepartmentid'=>$this->storeid,'trma_received'=>1,'trma_status'=>'O','trma_transactiondatebs >='=>$fromDate,'trma_transactiondatebs <='=>$toDate,'trma_locationid'=>$this->locationid));

				$this->data['direct_purchase_cancel']=$this->general->get_tbl_data('COUNT(trma_trmaid) as total_direct_purchase_cancel','trma_transactionmain',array('trma_transactiontype'=>'PURCHASE','trma_fromdepartmentid'=>$this->storeid,'trma_received'=>1,'trma_status'=>'C','trma_transactiondatebs >='=>$fromDate,'trma_transactiondatebs <='=>$toDate,'trma_locationid'=>$this->locationid));
			}
            //Stock Requistion

			if(DEFAULT_DATEPICKER=='NP')
			{
				
					$this->data['stock_requisition_total']=$this->general->get_tbl_data('COUNT(rema_reqmasterid) as total_requisition','rema_reqmaster',array('rema_storeid'=>$this->storeid,'rema_reqdatebs >='=>$fromDate,'rema_reqdatebs <='=>$toDate,'rema_isdep'=>'Y','rema_locationid'=>$this->locationid));
					$this->data['stock_requistion_pending']=$this->general->get_tbl_data('COUNT(rema_reqmasterid) as total_requisition_pending','rema_reqmaster',array('rema_storeid'=>$this->storeid,'rema_reqdatebs >='=>$fromDate,'rema_reqdatebs <='=>$toDate,'rema_isdep'=>'Y','rema_approved'=>'0','rema_locationid'=>$this->locationid));

					$this->data['stock_requistion_approved']=$this->general->get_tbl_data('COUNT(rema_reqmasterid) as total_requisition_approve','rema_reqmaster',array('rema_storeid'=>$this->storeid,'rema_reqdatebs >='=>$fromDate,'rema_reqdatebs <='=>$toDate,'rema_isdep'=>'Y','rema_approved'=>'1','rema_locationid'=>$this->locationid));

				




			}
			else{
				


					$this->data['stock_requisition_total']=$this->general->get_tbl_data('COUNT(rema_reqmasterid) as total_requisition','rema_reqmaster',array('rema_storeid'=>$this->storeid,'rema_reqdatead >='=>$fromDate,'rema_reqdatead <='=>$toDate,'rema_isdep'=>'Y','rema_locationid'=>$this->locationid));
					$this->data['stock_requistion_pending']=$this->general->get_tbl_data('COUNT(rema_reqmasterid) as total_requisition_pending','rema_reqmaster',array('rema_storeid'=>$this->storeid,'rema_reqdatead >='=>$fromDate,'rema_reqdatead <='=>$toDate,'rema_isdep'=>'Y','rema_approved'=>'0','rema_locationid'=>$this->locationid));


					$this->data['stock_requistion_approved']=$this->general->get_tbl_data('COUNT(rema_reqmasterid) as total_requisition_approve','rema_reqmaster',array('rema_storeid'=>$this->storeid,'rema_reqdatead >='=>$fromDate,'rema_reqdatead <='=>$toDate,'rema_isdep'=>'Y','rema_approved'=>'1','rema_locationid'=>$this->locationid));
			
			}
	 //end Stock Requistion

	 // issue dashboard

			if(DEFAULT_DATEPICKER=='NP'){

				$this->data['issue_count'] = $this->general->get_tbl_data('COUNT(sama_salemasterid) as iss_count','sama_salemaster',array('sama_storeid'=>$this->storeid,'sama_st'=>'N','sama_billdatebs>='=>$fromDate,'sama_billdatebs<='=>$toDate,'sama_locationid'=>$this->locationid));
				$this->data['issue_return_count'] = $this->general->get_tbl_data('COUNT(rema_returnmasterid) as ir_count','rema_returnmaster',array('rema_storeid'=>$this->storeid,'rema_st'=>'N','rema_returndatebs>='=>$fromDate,'rema_returndatebs<='=>$toDate,'rema_locationid'=>$this->locationid));
				
				$this->data['issue_cancel_count'] = $this->general->get_tbl_data('COUNT(sama_salemasterid) as cancel_count','sama_salemaster',array('sama_storeid'=>$this->storeid,'sama_st'=>'C','sama_billdatebs>='=>$fromDate,'sama_billdatebs<='=>$toDate,'sama_locationid'=>$this->locationid));

			}
		else
		    {
				
				$this->data['issue_count'] = $this->general->get_tbl_data('COUNT(sama_salemasterid) as iss_count','sama_salemaster',array('sama_storeid'=>$this->storeid,'sama_st'=>'N','sama_billdatead>='=>$fromDate,'sama_billdatead<='=>$toDate,'sama_locationid'=>$this->locationid));
				$this->data['issue_return_count'] = $this->general->get_tbl_data('COUNT(rema_returnmasterid) as ir_count','rema_returnmaster',array('rema_storeid'=>$this->storeid,'rema_st'=>'N','rema_returndatead>='=>$fromDate,'rema_returndatead<='=>$toDate,'rema_locationid'=>$this->locationid));
				$this->data['issue_cancel_count'] = $this->general->get_tbl_data('COUNT(sama_salemasterid) as cancel_count','sama_salemaster',array('sama_storeid'=>$this->storeid,'sama_st'=>'C','sama_billdatead>='=>$fromDate,'sama_billdatead<='=>$toDate,'sama_locationid'=>$this->locationid));

				
				
			}

			if(DEFAULT_DATEPICKER=='NP'){
				$this->data['expenses_sum']= $this->general->get_tbl_data('SUM(recm_clearanceamount) as total_expenses','recm_receivedmaster',array('recm_status'=>'O','recm_locationid'=>$this->locationid,'recm_storeid'=>$this->storeid,'recm_receiveddatebs >='=>$fromDate,'recm_receiveddatebs<='=>$toDate,'recm_locationid'=>$this->locationid));
			}
			else{
				$this->data['expenses_sum']= $this->general->get_tbl_data('SUM(recm_clearanceamount) as total_expenses','recm_receivedmaster',array('recm_status'=>'O','recm_locationid'=>$this->locationid,'recm_storeid'=>$this->storeid,'recm_receiveddatead >='=>$fromDate,'recm_receiveddatead<='=>$toDate,'recm_locationid'=>$this->locationid));
			}
			// end issue details


			// humanresource
			if(ORGANIZATION_NAME=='KUKL')
			{
				if(DEFAULT_DATEPICKER=='NP')
				{

					$this->data['total_reguser']=$this->general->get_tbl_data('COUNT(usre_userid) as total_reguserdetail','usre_userregister',array('usre_postdatebs >='=>$fromDate,'usre_postdatebs  <='=>$toDate,'usre_locationid'=>$this->locationid));
			// echo "</pre>";print_r($this->data['total_reguser']);die();

					$this->data['approve_requser']=$this->general->get_tbl_data('COUNT(usre_userid) as total_reguserapproved','usre_userregister',array('usre_postdatebs >='=>$fromDate,'usre_postdatebs  <='=>$toDate,'usre_status'=>'1','usre_locationid'=>$this->locationid));


					$this->data['pending_requser']=$this->general->get_tbl_data('COUNT(usre_userid) as total_reguserpending','usre_userregister',array('usre_postdatebs >='=>$fromDate,'usre_postdatebs  <='=>$toDate,'usre_status'=>'0','usre_locationid'=>$this->locationid));

					$this->data['cancel_requser']=$this->general->get_tbl_data('COUNT(usre_userid) as total_regusercancel','usre_userregister',array('usre_postdatebs >='=>$fromDate,'usre_postdatebs  <='=>$toDate,'usre_status'=>'2','usre_locationid'=>$this->locationid));

					$this->data['total_today']=$this->general->get_tbl_data('COUNT(usre_userid) as total_regusertoday','usre_userregister',array('usre_postdatebs'=>CURDATE_NP,'usre_locationid'=>$this->locationid));
				}
				else
				{
					$this->data['total_reguser']=$this->general->get_tbl_data('COUNT(usre_userid) as total_reguserdetail','usre_userregister',array('usre_postdatead >='=>$fromDate,'usre_postdatead  <='=>$toDate,'usre_locationid'=>$this->locationid));

					$this->data['approve_requser']=$this->general->get_tbl_data('COUNT(usre_userid) as total_reguserapproved','usre_userregister',array('usre_postdatead >='=>$fromDate,'usre_postdatead  <='=>$toDate,'usre_status'=>'1','usre_locationid'=>$this->locationid));

					$this->data['pending_requser']=$this->general->get_tbl_data('COUNT(usre_userid) as total_reguserpending','usre_userregister',array('usre_postdatead >='=>$fromDate,'usre_postdatead  <='=>$toDate,'usre_status'=>'0','usre_locationid'=>$this->locationid));

					$this->data['cancel_requser']=$this->general->get_tbl_data('COUNT(usre_userid) as total_regusercancel','usre_userregister',array('usre_postdatead >='=>$fromDate,'usre_postdatead  <='=>$toDate,'usre_status'=>'2','usre_locationid'=>$this->locationid));

					$this->data['total_today']=$this->general->get_tbl_data('COUNT(usre_userid) as total_regusertoday','usre_userregister',array('usre_postdatebs'=>CURDATE_EN,'usre_locationid'=>$this->locationid));

				}
			}

			//end humanresource
			if($this->session->userdata(USER_GROUPCODE)=='SA')
			{
				$this->data['depname']=array();

			}else{

				$this->data['depname']=$this->general->get_tbl_data('dept_depname','dept_department',array('dept_depid'=>$this->depid));
			}

			

			$this->data['issuetotal']=$this->general->get_tbl_data('COUNT(sama_salemasterid) as total_issue','sama_salemaster',array('sama_locationid'=>$this->locationid,'sama_storeid'=>$this->storeid));

			$this->data['issueToday']=$this->general->get_tbl_data('COUNT(sama_salemasterid) as total_today','sama_salemaster',array('sama_requisitiondatead'=>CURDATE_EN,'sama_locationid'=>$this->locationid,'sama_storeid'=>$this->storeid));
			$this->data['issueReturn']=$this->general->get_tbl_data('COUNT(sama_salemasterid) as total_return','sama_salemaster',array('sama_st'=>'N','sama_requisitiondatead'=>CURDATE_EN,'sama_locationid'=>$this->locationid,'sama_storeid'=>$this->storeid));

			if($this->locationid){
				$where = "AND trde_locationid = $this->locationid";
			}
			$this->data['stock_count'] = $this->home_mdl->get_stock_count($where);

			//department stock for nphl lab test
		if(ORGANIZATION_NAME=='NPHL'):

			if($this->session->userdata(USER_GROUPCODE)=='SA'){
				
                  $dep = "";
			}else{
				$dep = "WHERE depid = $this->depid";

			}

			$this->data['department_stock_count'] =array();
			// $this->data['department_stock_count'] = $this->home_mdl->get_stock_count_department($dep);
         	endif;
			//end dep stock
			


		//issue
	// if($this->session->userdata(USER_GROUPCODE)=='SA'){
 //    		$where = "AND sama_depid = $this->depid";
 //    	}else{
 //    		$where = '';
 //    	}
	// 	$this->data['receive_stock_count'] = $this->home_mdl->get_receive_stock_count($where);


		}


		//assets dashboard
		if($this->orgid == '2'){
			$fromDate=!empty($this->input->post('fromDate'))?$this->input->post('fromDate'):CURMONTH_DAY1;
			$toDate=!empty($this->input->post('toDate'))?$this->input->post('toDate'):DISPLAY_DATE;

			$this->data['assets_dashboard_count'] = $this->home_mdl->get_assets_dashboard_count($fromDate,$toDate);
		}

		if($this->orgid==1)
		{
			$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->build('v_home_bio_dashboard', $this->data);
		}
		else if($this->orgid == 2)
		{
			$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->build('v_home_assets_dashboard', $this->data);
		}

		else if($this->orgid == 3){
			$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->build('v_home_inventory_dashboard', $this->data);
		}
	}


	public function get_repair_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['commentid']=$id = $this->input->post('equipcommentid');
			$equipid = $this->input->post('equipid');
			$statusid = $this->input->post('statusid');

			if($statusid ==0){
				$this->update_repair_request_status($id);
			}
			$tempform='';
			// $this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipid'=>$equipid));
			$this->data['org_id']=$org_id=$this->session->userdata(ORG_ID);

			if($org_id=='2'){
				$this->data['comment'] = $this->home_mdl->get_repair_data_assets(array('ec.eqco_equipmentcommentid'=>$id));
				$this->data['previousComment'] = $this->home_mdl->get_repair_data_assets(array('ec.eqco_eqid'=>$equipid,'ec.eqco_equipmentcommentid !='=>$id));
				//echo $this->db->last_query(); die;
			}else{
				$this->data['comment'] = $this->home_mdl->get_repair_data(array('ec.eqco_equipmentcommentid'=>$id));
				$this->data['previousComment'] = $this->home_mdl->get_repair_data(array('ec.eqco_eqid'=>$equipid,'ec.eqco_equipmentcommentid !='=>$id));
			}
			
			$this->data['previousRepairReq'] = $this->repair_information_mdl->get_all_repair_information(array('m.rere_equid'=>$id));
			
			$tempform .= $this->load->view('v_repaircomment',$this->data,true);

			if($this->data['comment'])
			{
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
				exit;	
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Unsuccessfully Selected')));
				exit;	
			}
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function update_repair_request_status($id){

		$this->db->where("eqco_equipmentcommentid", $id);
		$this->db->update("eqco_equipmentcomment",array('eqco_comment_status'=>2));
          // echo $this->db->last_query();
		$rowaffected=$this->db->affected_rows();
		if($rowaffected)
		{
			return $rowaffected;
		}
		else
		{
			return false;
		}
	}



	public function comment_list()
	{
		$this->data = array();
		$this->data['listurl']=base_url().'home/get_repair_request';
		$this->data['breadcrumb']='Equipments/Comments List';
		// $this->template
		// 	->set_layout('general')
		// 	->enable_parser(FALSE)
		// 	->build('v_comment_lists', $this->data);

		$this->data['tab_type']='inventory_comment_list';

		$this->template
		->set_layout('general')
		->enable_parser(FALSE)
		->title($this->page_title)
		->build('bio_medical_inventory/v_comment_common_tab', $this->data);
	}

	public function bio_dashboard()
	{ 
		$this->data = array();
		$this->data=array(
			'module_title'=>'Dashboard',
			'depid'=>'2');
		$this->data['inventory_total']=$this->general->get_tbl_data('COUNT(bmin_equipid) as total_inventory','bmin_bmeinventory');
		$this->data['inventory_today']=$this->general->get_tbl_data('COUNT(bmin_equipid) as todays_inventory','bmin_bmeinventory',array('bmin_postdatead' => date("Y/m/d")));

		$this->data['distributors_total']=$this->general->get_tbl_data('COUNT(dist_distributorid) as total_distributers','dist_distributors');
		$this->data['distributors_today']=$this->general->get_tbl_data('COUNT(dist_distributorid) as todays_distributers','dist_distributors',array('dist_postdatead' => date("Y/m/d")));

		$this->data['manufactures_total']=$this->general->get_tbl_data('COUNT(manu_manlistid) as total_manufactures','manu_manufacturers');
		$this->data['manufactures_today']=$this->general->get_tbl_data('COUNT(manu_manlistid) as todays_manufactures','manu_manufacturers',array('manu_postdatead' => date("Y/m/d")));

		$this->data['servicetech_total']=$this->general->get_tbl_data('COUNT(sete_techid) as total_servicetech','sete_servicetechs');
		$this->data['servicetech_today']=$this->general->get_tbl_data('COUNT(sete_techid) as todays_servicetech','sete_servicetechs',array('sete_postdatead' => date("Y/m/d")));
		// $this->data['pmrepoprt']=$this->home_mdl->count_pm();
		// echo $this->db->last_query();
		// die();
		//echo "<pre>"; print_r($data);die;
        //echo "gfgg";print_r($this->data['pmrepoprt']);die;
		$this->data['repair_request'] = $this->general->get_tbl_data('*','rere_repairrequests');



		$this->template
		->set_layout('general')
		->enable_parser(FALSE)
		->build('v_home_bio_dashboard', $this->data);
	}

	public function get_pm_alert()
	{
		$data = $this->home_mdl->get_all_pm_alert();
		// echo $this->db->last_query(); die();
		// echo "<pre>";
		// print_r($data);
		// die();
		// echo "<pre>"; print_r($data);die;
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			$date1=strtotime($row->pmta_pmdatead);
			$date2=strtotime(CURDATE_EN);
			$days=$this->general->get_left_days($date1,$date2);
			if($days!=='Expiry')
			{
				$status='<span class="text-success">'.$days.' Days Left</span>';;
				if($days<7)
				{
					$status='<span class="text-danger">'.$days.' Days Left</span>';;
				}
			}
			else
			{
				$status='<span class="text-danger">Expiry</span>';
			}
			$array[$i]["equiid"] = '<a href="javascript:void(0)" class="patlist" data-equipid='.$row->pmta_equipid.'>'.$row->bmin_equipmentkey.'</a>';
			$array[$i]["equipmentkey"] = '<a href="javascript:void(0)" class="overview" data-equipkey='.$row->bmin_equipmentkey.'>'.$row->bmin_equipmentkey.'</a>';
			$array[$i]["datead"] = $row->pmta_pmdatead;
			$array[$i]["datebs"] = $row->pmta_pmdatebs;
			$array[$i]["department"] = $row->dein_department;
			$array[$i]["risk_val"] = $row->riva_risk;

			$array[$i]["pmcount"] ='<a href="javascript:void(0)" class="pmcount" data-equipid='.$row->pmta_equipid.'>'.$row->pmcount.'</a>';
			$array[$i]["status"]=$status;

			$i++;
		}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function get_contractor()
	{

		$org_id=$this->session->userdata(ORG_ID);		
		$data = $this->home_mdl->get_all_contractor($org_id);

		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			$date1=strtotime($row->coin_contractstartdatead);
			$date2=strtotime($row->coin_contractenddatead);
			$days=$this->general->get_left_days($date1,$date2);
			if($days!=='Expiry')
			{
				$status='<span class="text-success">'.$days.' Days Left</span>';
				if($days<7)
				{
					$status='<span class="text-danger">'.$days.' Days Left</span>';
				}
			}
			else
			{
				$status='<span class="text-danger">Expiry</span>';
			}
			$array[$i]["coin_contractinformationid"] = '<a href="javascript:void(0)" class="patlist" data-equipid='.$row->coin_contractinformationid.'>'.$row->coin_contractinformationid.'</a>';
			$array[$i]["coin_contracttypeid"] = $row->coty_contracttype;
			$array[$i]["coin_distributorid"] = $row->dist_distributor;
			$array[$i]["coin_contracttitle"] = $row->coin_contracttitle;
			$array[$i]["coin_contractstartdatead"] = $row->coin_contractstartdatead;
			$array[$i]["coin_contractenddatead"] = $row->coin_contractenddatead;
			$array[$i]["coin_contractvalue"] = $row->coin_contractvalue;
			$array[$i]["status"]=$status;


			$i++;
		}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


	public function get_repair_request()
	{
		// echo MODULES_VIEW;die;
		// if(MODULES_VIEW=='N')
		// 	{
		// 	  	$array["eqco_equipmentcommentid"] ='';
		// 	  	$array["equipmentkey"] ='';
		// 	  	$array["description"] ='';
		// 	    $array["department"] = '';
		// 	    $array["comment"] =''; '';
		// 	    $array["reported_by"] = '';
		// 	    $array["repairdatead"] = '';
		// 	    $array["status"] = '';
  //               $array["action"]='';
  //               echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
  //               exit;
		// 	}
		$org_id=$this->session->userdata(ORG_ID);
		// echo $org_id; die;
		if($org_id=='2'){
			$data = $this->home_mdl->get_all_repairinfo_assets();
			//echo $this->db->last_query(); die;
		}else{
			$data = $this->home_mdl->get_all_repairinformation();
		}
		
		//echo "<pre>"; print_r($data);die;
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			if($row->eqco_comment_status == 1)
			{
				$penf = "Completed"; 
				$class='label-success';
				$row_class = 'bg-success text-white ';
			}

			if($row->eqco_comment_status == 2){ 
				$penf = "Seen"; 
				$class='label-info';
				$row_class = 'bg-info text-white ';
			}

			if($row->eqco_comment_status == 0){ 
				$penf = "Pending"; 
				$class='label-warning';
				$row_class = 'bg-warning text-white ';

			}
			if($row->eqco_comment_status == 3){ 
				$penf = "Cancelled"; 
				$class='label-danger';
				$row_class = 'bg-danger text-white ';
			}
			if($row->eqco_comment_status == 4){ 
				$penf = "In Progress"; 
				$class='label-primary';
				$row_class = 'bg-primary text-white ';
			}

			$array[$i]["eqco_equipmentcommentid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->eqco_equipmentcommentid.'>'.$row->eqco_equipmentcommentid.'</a>';
			if($org_id=='2'){
				$array[$i]["equipmentkey"]  =$row->bmin_equipmentkey;

			}else{
				$array[$i]["equipmentkey"] = '<a href="javascript:void(0)" class="overview '.$row_class.'" data-equipkey='.$row->bmin_equipmentkey.'>'.$row->bmin_equipmentkey.'</a>';
			}
			$array[$i]["description"] = $row->eqli_description;
			$array[$i]["department"] = $row->dein_department;
			$array[$i]["comment"] = $row->eqco_comment;
			$array[$i]["reported_by"] = $row->usma_fullname;
			$array[$i]["repairdatead"] = $row->eqco_postdatead;
			$array[$i]["request_no"] = $row->eqco_requestno;
			$array[$i]["row_class"] = $row_class;

			$array[$i]["status"] ='<a href="javascript:void(0)" class=" label '.$class.' btn-xs">' .$penf . ' </a>';
			$array[$i]["action"] ='<a href="javascript:void(0)" data-equipid='.$row->eqco_eqid.' data-statusid='.$row->eqco_comment_status.' data-id='.$row->eqco_equipmentcommentid.' class="myModalRepair"><i class="fa fa-info-circle" aria-hidden="true" ></i></a>';

			$i++;
		}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}

	public function get_warrenty_alert()
	{
		//echo $this->input->post($type); die;
		// $condition=array('bmin_endwarrentydatead'=>)
		$add_date=  date('Y/m/d',strtotime(CURDATE_EN . "+15 days"));
	     // $this->db->where('pmta_pmdatead >=', CURDATE_EN);
      //   $this->db->where('pmta_pmdatead <=', $add_date);

		$data = $this->bio_medical_mdl->get_biomedical_inventory_list(array('bm.bmin_endwarrantydatead >='=>CURDATE_EN,'bm.bmin_endwarrantydatead <='=>$add_date));
		// echo $this->db->last_query();
		// die();
		// echo "<pre>"; print_r($data);die;
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			$date1=strtotime($row->bmin_endwarrantydatead);
			$date2=strtotime(CURDATE_EN);
			$days=$this->general->get_left_days($date1,$date2);
			if($days!=='Expiry')
			{
				$status='<span class="text-success">'.$days.' Days Left</span>';;
				if($days<7)
				{
					$status='<span class="text-danger">'.$days.' Days Left</span>';;
				}

			}
			else
			{
				$status='<span class="text-danger">Expiry</span>';
			}		  
			$array[$i]["equipmentkey"] = '<a href="javascript:void(0)" class="overview" data-equipkey='.$row->bmin_equipmentkey.'>'.$row->bmin_equipmentkey.'</a>';
			$array[$i]["description"] = $row->eqli_description;
			$array[$i]["department"] = $row->dept_depname;
			$array[$i]["risk_val"] = $row->riva_risk;
			$array[$i]["datead"] = $row->bmin_endwarrantydatead;
			$array[$i]["datebs"] = $row->bmin_endwarrantydatebs;
			$array[$i]["status"]=$status;
			$i++;
		}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}


	public function get_warrenty_alert_asset()
	{
		//echo $this->input->post($type); die;
		// $condition=array('bmin_endwarrentydatead'=>)
		$add_date=  date('Y/m/d',strtotime(CURDATE_EN . "+15 days"));
	    //echo $add_date; die;
	     // $this->db->where('pmta_pmdatead >=', CURDATE_EN);
      //   $this->db->where('pmta_pmdatead <=', $add_date);
		$data = $this->assets_mdl->get_asset_list(array('ae.asen_warrentydatead >='=>CURDATE_EN,'ae.asen_warrentydatead <='=>$add_date));
		// echo $this->db->last_query();
		// die();
		// echo "<pre>"; print_r($data);die;
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			$date1=strtotime($row->asen_warrentydatead);
			$date2=strtotime(CURDATE_EN);
			$days=$this->general->get_left_days($date1,$date2);
			if($days!=='Expiry')
			{
				$status='<span class="text-success">'.$days.' Days Left</span>';;
				if($days<7)
				{
					$status='<span class="text-danger">'.$days.' Days Left</span>';;
				}

			}
			else
			{
				$status='<span class="text-danger">Expiry</span>';
			}		  
			    // $array[$i]["asset_code"] = '<a href="javascript:void(0)" class="overview" data-equipkey='.$row->asen_assetcode.'>'.$row->asen_assetcode.'</a>';
			$array[$i]["asset_code"] = $row->asen_assetcode;
			$array[$i]["description"] = $row->itli_itemname;
			$array[$i]["manufacture"] = $row->manu_manlst;
			$array[$i]["condition"] = $row->asco_conditionname;
			$array[$i]["datead"] = $row->asen_warrentydatead;
			$array[$i]["datebs"] = $row->asen_warrentydatebs;
			$array[$i]["status"]=$status;
			$i++;
		}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}

	public function save_repair_information_comment()
	{
		$id = $this->input->post('rere_repairrequestid');
		$post = $this->input->post();
		 //echo "<pre>"; print_r($post); die;


		if ($_SERVER['REQUEST_METHOD'] === 'POST') {		
			$problemtype=$this->input->post('rere_problemtype');

			if($problemtype=='Ex')	
			{
				$this->form_validation->set_rules('rere_dispatchtype','Dispatch Type','required|trim');
				$this->form_validation->set_rules('rere_dispatchto','Dispatch To','required|trim');
				$this->form_validation->set_rules('rere_disexpcost','Expected Cost','required|trim');
				$this->form_validation->set_rules('dispatchdate','Dispatch Date','required|trim');
			}
			if($id){
				$this->form_validation->set_rules($this->home_mdl->validate_repair_request_ex);
			}else{
				$this->form_validation->set_rules($this->home_mdl->validate_repair_request);
			}

			if($this->form_validation->run()==TRUE )
			{
				$trans = $this->home_mdl->rere_information_update();
				if($trans)
				{
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
					exit;
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
				exit;
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function approveRepairRequest(){
		try{
			$commentid = $this->input->post('commentid');

			if($this->checkBeforeApproval($commentid)){
				if($this->home_mdl->approveRepairRequest($commentid)){
					print_r(json_encode(array('status'=>'success', 'message'=>'Approved')));
					exit;
				}else{
					print_r(json_encode(array('status'=>'error', 'message'=>'Operation Unsuccessful')));
					exit;
				}
			}else{
				print_r(json_encode(array('status'=>'error', 'message'=>'You are not authorized to approve this request.')));
				exit;
			}
		}catch(Exception $e){
			throw $e;
		}
	}

	public function checkBeforeApproval(){
		try{
			$user_id = $this->session->userdata(USER_ID);
			$user_dept = $this->session->userdata(USER_DEPT);

			$data = $this->home_mdl->checkBeforeApproval($user_id, $user_dept);

			$user_dept = 35;

			// $departments[] = $data->usma_departmentid;

			$departments = explode(',',$data->usma_departmentid);

			if(in_array($user_dept, $departments)){
				// echo "yes";
				return true;
			}else{
				// echo "no";
				return false;
			}
		}catch(Exception $e){
			throw $e;
		}
	}

	public function e404(){
		$this->data['title'] = "Page Missing";
		$this->template
		->set_layout('general')
		->enable_parser(FALSE)
		->build('v_e404', $this->data);
	}

	function pm_record()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equid = $this->input->post('equipid');
			$data['history'] = $this->bio_medical_mdl->get_pm_history(array('pmta_equipid'=>$equid));
			$templateData=$this->load->view('home/v_pmrecord',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'PM Data Record Successfully Fetched','hisDetail'=>$templateData)));
			exit;
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	

	public function pm_dashboard()
	{

		$this->data['pm_weekly']=$this->home_mdl->get_weekly_pm();

	}

	public function req_iss_detail()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//echo "<pre>"; print_r($this->input->post()); die;
			$type=$this->data['type']=$this->input->post('type');


			$requisition=$this->data['requisition']=$this->home_mdl->get_req_iss_detail('rema_reqno');
    		//$this->data['requisition_list']=$this->home_mdl->get_req_item_list();

			$issue=$this->data['issue']=$this->home_mdl->get_issue_detail('sama_invoiceno');


			if($type=='pm_weekly'){
				$tempform= $this->load->view('home/v_req_issue_list',$this->data,true);

			}else{
				$tempform= $this->load->view('home/v_req_iss_list',$this->data,true);

			}
    		// $tempform= $this->load->view('home/v_req_issue_list');

			if($this->data['requisition'] || $this->data['issue'])
			{
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
				exit;	
			}
			else
			{
				$tempform='<span class="col-sm-12 alert  alert-danger text-center">Record Not Found!!</span>';
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Unsuccessfully Selected')));
				exit;	
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	
	public function get_amc_assets()
	{

		$org_id=$this->session->userdata(ORG_ID);		

		$add_date=  date('Y/m/d',strtotime(CURDATE_EN . "+15 days"));

		$data = $this->home_mdl->get_all_amc_assets(array('amta_orgid'=>$org_id,'amta_amcenddatead >='=>CURDATE_EN,'amta_amcenddatead <='=>$add_date));
		//echo $this->db->last_query(); die;

		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach($data as $row)
		{

			$date1=strtotime($row->amta_amcenddatead);
			$curyear= strtotime(CURDATE_EN);
		    	//echo $curyear; die;
			$days=$this->general->get_left_days($date1,$curyear);
				//print_r($days); die;
			if($days!=='Expiry')
			{
				$status='<span class="text-success">'.$days.' Days Left</span>';;
				if($days<7)
				{
					$status='<span class="text-danger">'.$days.' Days Left</span>';;
				}

			}
			else
			{
				$status='<span class="text-danger">Expiry</span>';
			}

			$array[$i]["amcid"] = $row->amta_amctableid;
			$array[$i]["assetcode"] = $row->asen_assetcode;
			$array[$i]["description"] = $row->itli_itemname;
			$array[$i]["manufacture"] = $row->manu_manlst;
			$array[$i]["amcdatead"] = $row->amta_amcdatead;
			$array[$i]["amcdatebs"] = $row->amta_amcdatebs;
			$array[$i]["status"]=$status;


			$i++;
		}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function cancel_comment($commentid=false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//echo "<pre>"; print_r($this->input->post()); die;
			$equipcommentid=$this->data['equipcommentid']=$this->input->post('equipcommentid');

			$trans = $this->home_mdl->update_comment($equipcommentid);
			if($trans)
			{
				print_r(json_encode(array('status'=>'success','message'=>'Comment Cancelled Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
				exit;
			}

		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function list_comment()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('v_comment_lists',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));
			exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}

	}

	public function list_amc()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('v_amc_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));
			exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}

	}

	public function list_warrenty()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('v_warrenty_assets',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));
			exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}

	}

	public function list_contract()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('v_contract_assets',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));
			exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}

	}

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */