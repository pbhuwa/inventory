<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Api_inventory extends CI_Controller {



	function __construct() {

		parent::__construct();

			$this->load->model('api_inventory_mdl');

	}

	

	

	public function index()

	{

		

	}	



	public function supplier_list()

	{

		//echo"call";die;

		$supplier_list=$this->api_inventory_mdl->get_supplier_other_db();	

		// echo "<pre>";

		// print_r($supplier_list);

		// die();

		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));

		$this->db->insert_batch('dist_distributors',$supplier_list);

	}



	public function department_list()

	{

		$department_list=$this->api_inventory_mdl->get_department_other_db();	

		// echo "<pre>";

		// print_r($department_list);

		// die();

		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));

		$this->db->insert_batch('dept_department',$department_list);

	}



	//Sales master Table Data From SALESMASTER =>xw_sama_salesmaster

	

	public function update_all_table()

	{

		$orgid=3;

		$locationid=1;

			$query=$this->db->query("

			UPDATE xw_apta_apitable set apta_orgid= $orgid;

			UPDATE xw_appr_approved set appr_orgid= $orgid,appr_locationid=$locationid;

			UPDATE xw_amta_amctable set amta_orgid= $orgid;

			UPDATE xw_abse_abcsetup set abse_orgid= $orgid,abse_locationid=$locationid;

			UPDATE xw_asen_assetentry set asen_orgid= $orgid,asen_locationid=$locationid;

			UPDATE xw_aufo_autoformat set aufo_orgid= $orgid,aufo_locationid=$locationid;

			UPDATE xw_bise_biomedicalsettingid set bise_orgid= $orgid,bise_locationid=$locationid;

			UPDATE xw_bmin_bmeinventory set bmin_orgid= $orgid,bmin_locationid=$locationid;

			UPDATE xw_budg_budgets set budg_orgid= $orgid,budg_locationid=$locationid;

			UPDATE xw_chde_challandetails set chde_orgid= $orgid,chde_locationid=$locationid;

			UPDATE xw_chdl_challandetaillog set chdl_orgid= $orgid,chdl_locationid=$locationid;

			UPDATE xw_chma_challanmaster set chma_orgid= $orgid,chma_locationid=$locationid;

			UPDATE xw_ci_session set ci_orgid= $orgid;

			UPDATE xw_clsm_closingstockmaster set clsm_orgid= $orgid,clsm_locationid=$locationid;

			UPDATE xw_coin_contractinformation set coin_orgid= $orgid,coin_locationid=$locationid;

			UPDATE xw_colt_commonlogtable set colt_orgid= $orgid,colt_locationid=$locationid;

			UPDATE xw_cons_constant set cons_orgid= $orgid,cons_locationid=$locationid;

			UPDATE xw_conv_conversion set conv_orgid= $orgid,conv_locationid=$locationid;

			UPDATE xw_coty_contracttype set coty_orgid= $orgid,coty_locationid=$locationid;

			UPDATE xw_coun_country set coun_orgid= $orgid,coun_locationid=$locationid;

			UPDATE xw_csde_closingstockdetail set csde_orgid= $orgid,csde_locationid=$locationid;

			UPDATE xw_cuty_currencytype set cuty_orgid= $orgid,cuty_locationid=$locationid;

			UPDATE xw_daba_databasebakup set daba_orgid= $orgid,daba_locationid=$locationid;

			UPDATE xw_dash_dashboard set dash_orgid= $orgid,dash_locationid=$locationid;

			UPDATE xw_deeq_decommission_equipment set deeq_orgid= $orgid;

			UPDATE xw_dein_departmentinformation set dein_orgid= $orgid,dein_locationid=$locationid;

			UPDATE xw_dept_department set dept_orgid= $orgid,dept_locationid=$locationid;

			UPDATE xw_dete_depreciationtemp set dete_orgid= $orgid,dete_locationid=$locationid;

			UPDATE xw_dety_departmenttype set dety_orgid= $orgid,dety_locationid=$locationid;

			UPDATE xw_dety_depreciation set dety_orgid= $orgid,dety_locationid=$locationid;

			UPDATE xw_dist_distributors set dist_orgid= $orgid,dist_locationid=$locationid;

			UPDATE xw_dist_district set dist_orgid= $orgid,dist_locationid=$locationid;

			UPDATE xw_dose_doctorsetup set dose_orgid= $orgid,dose_locationid=$locationid;

			UPDATE xw_educ_education set educ_orgid= $orgid,educ_locationid=$locationid;

			UPDATE xw_eqas_equipmentassign set eqas_orgid= $orgid,eqas_locationid=$locationid;

			UPDATE xw_eqca_equipmentcategory set eqca_orgid= $orgid,eqca_locationid=$locationid;

			UPDATE xw_eqco_equipmentcomment set eqco_orgid= $orgid,eqco_locationid=$locationid;

			UPDATE xw_eqdc_eqdepchange set eqdc_orgid= $orgid,eqdc_locationid=$locationid;

			UPDATE xw_eqli_equipmentlist set eqli_orgid= $orgid,eqli_locationid=$locationid;

			UPDATE xw_eqpa_equipparts set eqpa_orgid= $orgid,eqpa_locationid=$locationid;

			UPDATE xw_eqty_equipmenttype set eqty_orgid= $orgid,eqty_locationid=$locationid;

			UPDATE xw_impd_imagepdf set impd_orgid= $orgid,impd_locationid=$locationid;

			UPDATE xw_ipfi_ipfilter set ipfi_orgid= $orgid,ipfi_locationid=$locationid;

			UPDATE xw_itli_itemslist set itli_orgid= $orgid,itli_locationid=$locationid;

			UPDATE xw_jost_jobstatus set jost_orgid= $orgid,jost_locationid=$locationid;

			UPDATE xw_loac_loginactivity set loac_orgid= $orgid,loac_locationid=$locationid;

			UPDATE xw_loac_loginactivityid set loac_orgid= $orgid,loac_locationid=$locationid;

			UPDATE xw_loca_location set loca_orgid= $orgid;

			UPDATE xw_malo_maintenancelog set malo_orgid= $orgid;

			UPDATE xw_manu_manufacturers set manu_orgid= $orgid,manu_locationid=$locationid;

			UPDATE xw_maty_materialtype set maty_orgid= $orgid,maty_locationid=$locationid;

			UPDATE xw_modu_modules set modu_orgid= $orgid,modu_locationid=$locationid;

			UPDATE xw_mope_modulespermission set mope_orgid= $orgid,mope_locationid=$locationid;

			UPDATE xw_moty_movingtype set moty_orgid= $orgid,moty_locationid=$locationid;

			UPDATE xw_pmta_pmtable set pmta_orgid= $orgid,pmta_locationid=$locationid;

			UPDATE xw_prca_productcategory set prca_orgid= $orgid,prca_locationid=$locationid;

			UPDATE xw_prde_purchasereturndetail set prde_orgid= $orgid,prde_locationid=$locationid;

			UPDATE xw_prod_product set prod_orgid= $orgid,prod_locationid=$locationid;

			UPDATE xw_pude_purchaseorderdetail set pude_orgid= $orgid,pude_locationid=$locationid;

			UPDATE xw_pudo_purchdonate set pudo_orgid= $orgid,pudo_locationid=$locationid;

			UPDATE xw_puor_purchaseordermaster set puor_orgid= $orgid,puor_locationid=$locationid;

			UPDATE xw_puor_purorder set puor_orgid= $orgid,puor_locationid=$locationid;

			UPDATE xw_purd_purchasereqdetail set purd_orgid= $orgid,purd_locationid=$locationid;

			UPDATE xw_pure_purchaserequisition set pure_orgid= $orgid,pure_locationid=$locationid;

			UPDATE xw_purr_purchasereturn set purr_orgid= $orgid,purr_locationid=$locationid;

			UPDATE xw_qude_quotationdetail set qude_orgid= $orgid,qude_locationid=$locationid;

			UPDATE xw_quma_quotationmaster set quma_orgid= $orgid,quma_locationid=$locationid;

			UPDATE xw_recd_receiveddetail set recd_orgid= $orgid,recd_locationid=$locationid;

			UPDATE xw_recm_receivedmaster set recm_orgid= $orgid,recm_locationid=$locationid;

			UPDATE xw_rede_reqdetail set rede_orgid= $orgid,rede_locationid=$locationid;

			UPDATE xw_rede_returndetail set rede_orgid= $orgid,rede_locationid=$locationid;

			UPDATE xw_redt_reqdetailnote set redt_orgid= $orgid,redt_locationid=$locationid;

			UPDATE xw_rema_reqmaster set rema_orgid= $orgid,rema_locationid=$locationid;

			UPDATE xw_rema_returnmaster set rema_orgid= $orgid,rema_locationid=$locationid;

			UPDATE xw_reno_requisitionnote set reno_orgid= $orgid,reno_locationid=$locationid;

			UPDATE xw_requ_requisition set requ_orgid= $orgid,requ_locationid=$locationid;

			UPDATE xw_rere_repairrequests set rere_orgid= $orgid,rere_locationid=$locationid;

			UPDATE xw_rety_renewtype set rety_orgid= $orgid,rety_locationid=$locationid;

			UPDATE xw_rity_risktype set rity_orgid= $orgid,rity_locationid=$locationid;

			UPDATE xw_riva_riskvalues set riva_orgid= $orgid,riva_locationid=$locationid;

			UPDATE xw_rode_roomdepartment set rode_orgid= $orgid,rode_locationid=$locationid;

			UPDATE xw_sade_saledetail set sade_orgid= $orgid,sade_locationid=$locationid;

			UPDATE xw_sama_salemaster set sama_orgid= $orgid,sama_locationid=$locationid;

			UPDATE xw_sete_servicetechs set sete_orgid= $orgid,sete_locationid=$locationid;

			UPDATE xw_stde_stockdetail set stde_orgid= $orgid,stde_locationid=$locationid;

			UPDATE xw_stin_staffinfo set stin_orgid= $orgid,stin_locationid=$locationid;

			UPDATE xw_stma_stockmaster set stma_orgid= $orgid,stma_locationid=$locationid;

			UPDATE xw_store set store_orgid= $orgid;

			UPDATE xw_stpo_staffposition set stpo_orgid= $orgid,stpo_locationid=$locationid;

			UPDATE xw_strd_storetransdetail set strd_orgid= $orgid;

			UPDATE xw_sttr_storetransfer set sttr_orgid= $orgid;

			UPDATE xw_supp_supplier set supp_orgid= $orgid;

			UPDATE xw_tana_tablename set tana_orgid= $orgid,tana_locationid=$locationid;

			UPDATE xw_tava_taxvalue set tava_orgid= $orgid,tava_locationid=$locationid;

			UPDATE xw_teap_tenderapproved set teap_orgid= $orgid,teap_locationid=$locationid;

			UPDATE xw_tfde_transferdetail set tfde_orgid= $orgid,tfde_locationid=$locationid;

			UPDATE xw_tfma_transfermain set tfma_orgid= $orgid,tfma_locationid=$locationid;

			UPDATE xw_titl_title set titl_orgid= $orgid,titl_locationid=$locationid;

			UPDATE xw_trde_transactiondetail set trde_orgid= $orgid,trde_locationid=$locationid;

			UPDATE xw_trlo_tranferlog set trlo_orgid= $orgid;

			UPDATE xw_trma_transactionmain set trma_orgid= $orgid,trma_locationid=$locationid;

			UPDATE xw_unit_unit set unit_orgid= $orgid,unit_locationid=$locationid;

			UPDATE xw_ureq_unrepaireqipment set ureq_orgid= $orgid,ureq_locationid=$locationid;

			UPDATE xw_usac_useraccess set usac_orgid= $orgid,usac_locationid=$locationid;

			UPDATE xw_usal_useraccesslog set usal_orgid= $orgid,usal_locationid=$locationid;

			UPDATE xw_usgr_usergroup set usgr_orgid= $orgid,usgr_locationid=$locationid;

			UPDATE xw_usma_usermain set usma_orgid= $orgid,usma_locationid=$locationid;

			UPDATE xw_uwde_userwisedep set uwde_orgid= $orgid,uwde_locationid=$locationid;

			UPDATE xw_uwgr_userwisegroup set uwgr_orgid= $orgid,uwgr_locationid=$locationid;

			UPDATE xw_vaty_valuetype set vaty_locationid=$locationid;

			UPDATE xw_vdna_vdcname set vdna_orgid= $orgid;

			UPDATE xw_zona_zonename set zona_orgid= $orgid,zona_locationid=$locationid;");

		

		// return false;

		//echo $this->db->last_query(); die;

		

	}

	

	









}



	?>