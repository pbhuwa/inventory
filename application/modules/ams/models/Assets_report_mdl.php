<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_report_mdl extends CI_Model 

{

	public function __construct() 

	{

		parent::__construct();

		$this->userid = $this->session->userdata(USER_ID);

        $this->username = $this->session->userdata(USER_NAME);

        $this->curtime = $this->general->get_currenttime();

        $this->mac = $this->general->get_Mac_Address();

        $this->ip = $this->general->get_real_ipaddr();

        $this->locationid=$this->session->userdata(LOCATION_ID);

        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);

        $this->orgid=$this->session->userdata(ORG_ID);

	}    

	public function distinct_department_list($srch = false)

	{

		$asset_category = $this->input->post('asset_category');

      	$asset_status = $this->input->post('asset_status');

      	$asset_condition = $this->input->post('asset_condition');

      	$purdatetype=$this->input->post('purdatetype');

		$frmDate=$this->input->post('fromdate');

		$toDate=$this->input->post('todate');

		if($purdatetype=='range'){

			 if(DEFAULT_DATEPICKER=='NP'){

            	$this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));

             }else{

                $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));

            }

		}	

		$this->db->select('DISTINCT(ae.asen_depid) as asen_depid,dep.dept_depname,ec.eqca_category,ec.eqca_equipmentcategoryid');   

		$this->db->from('asen_assetentry ae');

		$this->db->join('dept_department as dep','dep.dept_depid = ae.asen_depid'); 

		$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','left');

		if(!empty($asset_category)){

			$this->db->where('ae.asen_assettype',$asset_category);

		}

		if(!empty($asset_status)){

			$this->db->where('ae.asen_status',$asset_status);

		}

		if(!empty($asset_condition)){

			$this->db->where('ae.asen_condition',$asset_condition);

		}

		if($srch) 

		{

			$this->db->where($srch); 

		}

		// if($limit && $limit>0)

		// {

		// 	$this->db->limit($limit);

		// }

		// if($offset)

		// {

		// 	$this->db->offset($offset);

		// }

		// if($order_by)

		// {

		// 	$this->db->order_by($order_by,$order);

		// }

		$qry=$this->db->get();

		if($qry->num_rows()>0)

		{

			return $qry->result();

		}

		return false;

	}

	public function distinct_category_list($srch = false)

	{

		$asset_category = $this->input->post('asset_category');

      	$asset_status = $this->input->post('asset_status');

      	$asset_condition = $this->input->post('asset_condition');

      	$purdatetype=$this->input->post('purdatetype');

		$frmDate=$this->input->post('fromdate');

		$toDate=$this->input->post('todate');

		if($purdatetype=='range'){

			 if(DEFAULT_DATEPICKER=='NP'){

            	$this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));

             }else{

                $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));

            }

		}	

		$this->db->select('DISTINCT(ae.asen_assettype) as asen_assettype,ec.eqca_category,ec.eqca_equipmentcategoryid');   

		$this->db->from('asen_assetentry ae'); 

		$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','left');

		if(!empty($asset_category)){

			$this->db->where('ae.asen_assettype',$asset_category);

		}

		if(!empty($asset_status)){

			$this->db->where('ae.asen_status',$asset_status);

		}

		if(!empty($asset_condition)){

			$this->db->where('ae.asen_condition',$asset_condition);

		}

		if($srch)  

		{

			$this->db->where($srch); 

		}

		// if($limit && $limit>0)

		// {

		// 	$this->db->limit($limit);

		// }

		// if($offset)

		// {

		// 	$this->db->offset($offset); 

		// }

		// if($order_by)

		// {

		// 	$this->db->order_by($order_by,$order);

		// }

		$qry=$this->db->get();

		if($qry->num_rows()>0)

		{

			return $qry->result();

		}

		return false;

	}

	public function distinct_status_list($srch = false)

	{

		$asset_category = $this->input->post('asset_category');

      	$asset_status = $this->input->post('asset_status');

      	$asset_condition = $this->input->post('asset_condition');

      	$purdatetype=$this->input->post('purdatetype');

		$frmDate=$this->input->post('fromdate');

		$toDate=$this->input->post('todate');

		if($purdatetype=='range'){

			 if(DEFAULT_DATEPICKER=='NP'){

            	$this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));

             }else{

                $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));

            }

		}	

		$this->db->select('DISTINCT(ae.asen_status) as asen_status,as.asst_asstid,as.asst_statusname');   

		$this->db->from('asen_assetentry ae'); 

		$this->db->join('asst_assetstatus as','ae.asen_status=as.asst_asstid','left');

		if($srch)  

		{

			$this->db->where($srch); 

		}

		if(!empty($asset_category)){

			$this->db->where('ae.asen_assettype',$asset_category);

		}

		if(!empty($asset_status)){

			$this->db->where('ae.asen_status',$asset_status);

		}

		if(!empty($asset_condition)){

			$this->db->where('ae.asen_condition',$asset_condition);

		}

		// if($limit && $limit>0)

		// {

		// 	$this->db->limit($limit);

		// }

		// if($offset)

		// {

		// 	$this->db->offset($offset); 

		// }

		// if($order_by)

		// {

		// 	$this->db->order_by($order_by,$order);

		// }

		$qry=$this->db->get();

		if($qry->num_rows()>0)

		{

			return $qry->result();

		}

		return false;

	}

	public function distinct_condition_list($srch = false)

	{

		$asset_category = $this->input->post('asset_category');

      	$asset_status = $this->input->post('asset_status');

      	$asset_condition = $this->input->post('asset_condition');

      	$purdatetype=$this->input->post('purdatetype');

		$frmDate=$this->input->post('fromdate');

		$toDate=$this->input->post('todate');

		if($purdatetype=='range'){

			 if(DEFAULT_DATEPICKER=='NP'){

            	$this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));

             }else{

                $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));

            }

		}	

		$this->db->select('DISTINCT(ae.asen_condition) as asen_condition,ac.asco_ascoid,ac.asco_conditionname');    

		$this->db->from('asen_assetentry ae'); 

		$this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');

		if($srch)  

		{

			$this->db->where($srch); 

		}

		if(!empty($asset_category)){

			$this->db->where('ae.asen_assettype',$asset_category);

		}

		if(!empty($asset_status)){

			$this->db->where('ae.asen_status',$asset_status);

		}

		if(!empty($asset_condition)){

			$this->db->where('ae.asen_condition',$asset_condition);

		}

		// if($limit && $limit>0)

		// {

		// 	$this->db->limit($limit);

		// }

		// if($offset)

		// {

		// 	$this->db->offset($offset); 

		// }

		// if($order_by)

		// {

		// 	$this->db->order_by($order_by,$order);

		// }

		$qry=$this->db->get();

		if($qry->num_rows()>0)

		{

			return $qry->result();

		}

		return false;

	}

	public function get_asset_entry_list_data($srch = false)

	{	

		$purdatetype=$this->input->post('purdatetype');

		$frmDate=$this->input->post('fromdate');

		$toDate=$this->input->post('todate');

		if($purdatetype=='range'){

			 if(DEFAULT_DATEPICKER=='NP'){

            	$this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));

             }else{

                $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));

            }

		}	

		$this->db->select(' ae.*,as.asst_statusname,ac.asco_conditionname,ec.eqca_category,dep.dept_depname

			,dc.dety_depreciation as depreciation');    

		$this->db->from('asen_assetentry ae'); 

		$this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');

		$this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');

		$this->db->join('dety_depreciation dc','dc.dety_depreciationid = ae.asen_depreciation','LEFT');

		$this->db->join('dept_department as dep','dep.dept_depid = ae.asen_depid');

		$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');

		// $this->db->join('')

		if($srch)

		{

			$this->db->where($srch); 

		}

		// if($limit && $limit>0)

		// {

		// 	$this->db->limit($limit);

		// }

		// if($offset)

		// {

		// 	$this->db->offset($offset);

		// }

		// if($order_by)

		// {

		// 	$this->db->order_by($order_by,$order);

		// }

		$qry=$this->db->get();

		if($qry->num_rows()>0)

		{

			return $qry->result();

		}

		return false;

	}

	public function get_asset_lease_report()

	{

		$islease = $this->input->post('islease');

		$lease_company = $this->input->post('lease_company');

		$frequency = $this->input->post('frequency');

		$filter_type = $this->input->post('filter_type');

		$frmDate = $this->input->post('frmDate');

		$toDate = $this->input->post('toDate');

		$this->db->select('ld.*,lm.*,ae.*,lc.leco_companyname,f.frty_name'); 

		$this->db->from('lede_leasedetail ld');

		$this->db->join('lema_leasemaster as lm','lm.lema_leasemasterid = ld.lede_leasemasterid');

		$this->db->join('asen_assetentry as ae','ae.asen_asenid = ld.lede_assetid');

		$this->db->join('leco_leasocompany as lc','lc.leco_leasecompanyid = lm.lema_companyid');

		$this->db->join('frty_frequencytype as f','f.frty_frtyid = ld.lede_frequencyid');

		$this->db->where('ae.asen_isleased_assets',$islease);

		$this->db->where('ld.lede_status','O'); 

		if(!empty($lease_company)){

			$this->db->where('lm.lema_companyid',$lease_company);

		}

		if(!empty($frequency)){

			$this->db->where('ld.lede_frequencyid',$frequency);

		}

		if($filter_type == "start"){

			if(DEFAULT_DATEPICKER=='NP'){

				// $this->db->where("lema_startdatebs between '".$frmDate."' AND '".$toDate."'");

				$this->db->where("lema_startdatebs >=",$frmDate);

				$this->db->where("lema_startdatebs <=",$toDate); 

			}else{

				// $this->db->where("lema_startdatead between '".$frmDate."' AND '".$toDate."'");

				$this->db->where("lema_startdatead >=",$frmDate);

				$this->db->where("lema_startdatebs <=",$toDate);

			}

		}else{

			if(DEFAULT_DATEPICKER=='NP'){

				// $this->db->where("lema_enddatebs between '".$frmDate."' AND '".$toDate."'");

				$this->db->where("lema_enddatebs >=",$frmDate);

				$this->db->where("lema_enddatebs <=",$toDate);

			}else{

				// $this->db->where("lema_enddatead between '".$frmDate."' AND '".$toDate."'");

				$this->db->where("lema_enddatead >=",$frmDate);

				$this->db->where("lema_enddatead <=",$toDate); 

			}

		}

	 	$result = $this->db->get()->result();

		// return $result;	

		if(!empty($result)){

			return $result;

		}else{

			return false; 

		}

	}

	public function get_asset_insurance_report()

	{

		$insurance_company = $this->input->post('insurance_company');

		$from_date = $this->input->post('from_date');

		$to_date = $this->input->post('to_date');

		$frequency = $this->input->post('frequency');

		$asset_id = $this->input->post('asset_id');

		$this->db->select('ai.*,ic.inco_name,f.frty_name,ae.asen_assetcode,ae.asen_desc'); 

		$this->db->from('asin_assetinsurance as ai');

		$this->db->join('inco_insurancecompany as ic','ic.inco_id = ai.asin_companyid');

		$this->db->join('asen_assetentry as ae','ae.asen_asenid = ai.asin_assetid');

		$this->db->join('frty_frequencytype as f','f.frty_frtyid = ai.asin_frequencyid');

		if(!empty($insurance_company)){

			$this->db->where('ai.asin_companyid',$insurance_company);

		}

		if(!empty($frequency)){

			$this->db->where('ai.asin_frequencyid',$frequency);

		}

		if(!empty($asset_id)){

			$this->db->where('ai.asin_assetid',$asset_id);

		}

		if(!empty($from_date) && !empty($to_date)){

			if(DEFAULT_DATEPICKER=='NP'){

				$this->db->where("asin_startdatebs >=",$from_date);

				$this->db->where("asin_enddatebs <=",$to_date); 

			}else{

				$this->db->where("asin_startdatead >=",$from_date);

				$this->db->where("asin_enddatead <=",$to_date);

			}

		}

	 	$result = $this->db->get()->result();

		// return $result;	

		if(!empty($result)){

			return $result;

		}else{

			return false; 

		}

	}

	public function get_asset_maintenance_report()

	{

		$maintenance_type = $this->input->post('maintenance_type');

		$asset_id = $this->input->post('asset_id');

		$pm_company = $this->input->post('pm_company');

		$frequency = $this->input->post('frequency');

		// $from_date = $this->input->post('from_date');

		// $to_date = $this->input->post('to_date');

		$this->db->select("pm.*,pd.*,asen.asen_assetcode,asen.asen_desc,f.frty_name,dis.dist_distributor")

	   ->from('pmam_pmamcmaster as pm')

	   ->join('pmad_pmamcdetail as pd','pd.pmad_pmamcmasterid = pm.pmam_pmamcmasterid','LEFT')

		->join('asen_assetentry asen','pd.pmad_assetid = asen.asen_asenid','LEFT')

		->join('frty_frequencytype as f','f.frty_frtyid = pm.pmam_frequencyid')

		->join('dist_distributors as dis','dis.dist_distributorid = pm.pmam_contractorid');

		if(!empty($maintenance_type)){

			$this->db->where("pm.pmam_pmamtype =",$maintenance_type);

		}

		if(!empty($asset_id)){

			$this->db->where('pm.pmam_assetid',$asset_id);

		}

		if(!empty($frequency)){

			$this->db->where("pm.pmam_frequencyid");

		}

		if (!empty($pm_company)) {

			$this->db->where("pm.pmam_contractorid");

		}

	 	$result = $this->db->get()->result();

		// return $result;	

		if(!empty($result)){

			return $result;

		}else{

			return false; 

		}

	}

	public function get_asset_disposal_report()

	{

		$disposal_type = $this->input->post('disposal_type');

		$from_date = $this->input->post('from_date');

		$to_date = $this->input->post('to_date');

		$asset_id = $this->input->post('asset_id');

		$range = $this->input->post('range');

		$search_text = $this->input->post('search_text');

		$this->db->select("asde.*,asdd.*,dety.dety_name,asen.asen_assetcode,asen.asen_desc,asen.asen_room,dept.dept_depname")

	   ->from('asde_assetdesposalmaster asde')

	   ->join('asdd_assetdesposaldetail asdd','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')

	   ->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT')

		->join('asen_assetentry asen','asdd.asdd_assetid = asen.asen_asenid','LEFT')

		->join('dept_department dept','dept.dept_depid = asen.asen_depid','LEFT');

		if(!empty($disposal_type)){

			$this->db->where("asde.asde_desposaltypeid =",$disposal_type);

		}

		if(!empty($asset_id)){

			$this->db->where('asdd.asdd_assetid',$asset_id);

		}

		if($range == 'range'){

			if(!empty($from_date) && !empty($to_date)){

				if(DEFAULT_DATEPICKER=='NP'){

					$this->db->where("asde.asde_deposaldatebs >=",$from_date);

					$this->db->where("asde.asde_deposaldatebs <=",$to_date); 

				}else{

					$this->db->where("asde.asde_deposaldatead >=",$from_date);

					$this->db->where("asde.asde_deposaldatead <=",$to_date);

				}

			}

		}

		if(!empty($search_text)){

			$this->db->where("asde.asde_customer_name like '%$search_text%'")

			->or_where("asde.asde_manualno like '%$search_text%'")

			->or_where("asde.asde_disposalno like '%$search_text%'");

		}

	 	$result = $this->db->get()->result();

		// return $result;	

		if(!empty($result)){

			return $result;

		}else{

			return false; 

		}

	}

	public function get_assets_register_rpt()

	{

		$this->db->select('ae.asen_asenid, ae.asen_assetcode,ae.asen_modelno,ae.asen_serialno,	ae.asen_warrentydatead, ae.asen_brand,ae.asen_inservicedatebs,ae.asen_inservicedatead,ae.asen_warrentydatebs, il.itli_itemname, ac.asco_conditionname, ec.eqca_category,ma.manu_manlst,dt.dist_distributor');

      	$this->db->from('asen_assetentry ae');

	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');

	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');

	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');

	    $this->db->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT');

	    $this->db->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');

		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		if ($query->num_rows() > 0) 

		{

			$data=$query->result();		

			return $data;		

		}		

		return false;

	}

	 public function get_assets_summary_report_ku()
    {

        $asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');
        $itemid=$this->input->post('itemid');

        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        // echo "<pre>";
        // print_r($subdeparray);
        // die();
        $condition = '';

        $this->db->start_cache();
        if ($searchDateType == 'range') {
            if ($fromdate &&  $todate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('asen_purchasedatebs >=', $fromdate);
                    $this->db->where('asen_purchasedatebs <=', $todate);
                    $condition .= "AND vacs.asen_purchasedatebs >= '$fromdate' 
					AND vacs.asen_purchasedatebs <= '$todate'";
                } else {
                    $this->db->where('asen_purchasedatead >=', $fromdate);
                    $this->db->where('asen_purchasedatead <=', $todate);
                    $condition .= "AND vacs.asen_purchasedatead >= '$fromdate' 
					AND vacs.asen_purchasedatead <= '$todate'";
                }
            }
        }

        if (!empty($schoolid)) {
            $this->db->where('asen_schoolid', $schoolid);
        }

        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("asen_depid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("asen_depid", $subdeparray);
                } else {
                    $this->db->where("asen_depid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }
         if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }

     	if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }

        if(!empty($itemid)){
        	$this->db->where('asen_description',$itemid);
        }

        $this->db->stop_cache();

        $this->db->select("ds.dist_distributor, asen_distributor,COUNT('*') as cnt,SUM(asen_purchaserate) as prate");
        $this->db->from('asen_assetentry ae');
        $this->db->join('dist_distributors ds', 'ds.dist_distributorid = ae.asen_distributor', 'LEFT');
        // $this->db->where('ds.dist_distributor IS NOT NULL');
        $this->db->group_by('ds.dist_distributor');
        $this->db->order_by('ds.dist_distributor', 'ASC');

        $data['suppliers'] = $this->db->get()->result();
		// echo $this->db->last_query();
		// die();

        if ($rpt_wise == 'supplier'){
        $this->db->flush_cache();
        unset($array);
        $array['suppliers'] = $data['suppliers'];
        return $array;
        } 

       $this->db->select("ec.eqca_category,ae.asen_assettype ,COUNT('*') as cnt,SUM(asen_purchaserate) as prate");
        $this->db->from('asen_assetentry ae');
        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=ae.asen_assettype', "LEFT");
        // $this->db->where("ec.eqca_category IS NOT NULL ");
        $this->db->group_by('ae.asen_assettype');
        $this->db->order_by('ec.eqca_category', 'ASC');
        $data['category'] = $this->db->get()->result();
        if ($rpt_wise == 'category' || $rpt_wise == 'category_items' ){ 
          $this->db->flush_cache();
          unset($array);
          $array['category'] = $data['category'];
          return $array;
        }

		$this->db->select("asen_purchasedatebs,GROUP_CONCAT( DISTINCT il.itli_itemname) as itemname,COUNT('*') as cnt,SUM(asen_purchaserate) as prate");
        $this->db->from('asen_assetentry ae');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = ae.asen_description','LEFT');
        $this->db->group_by('ae.asen_purchasedatebs');
        $this->db->order_by('asen_purchasedatebs','ASC');
        $data['purchase_date'] = $this->db->get()->result();
        if ($rpt_wise == 'purchase_date'){ 
          $this->db->flush_cache();
          unset($array);
          $array['purchase_date'] = $data['purchase_date'];
          return $array;
        }

	    $this->db->select("ae.asen_schoolid,COUNT('*') as cnt,SUM(asen_purchaserate) as prate,sc.loca_name schoolname");
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('loca_location sc','sc.loca_locationid=ae.asen_schoolid','LEFT');
	    // $this->db->where('sc.loca_name IS NOT NULL');
	    $this->db->order_by('sc.loca_name', 'ASC');
	    $this->db->group_by('ae.asen_schoolid,sc.loca_name');
	     $data['school'] = $this->db->get()->result();
	     // echo $this->db->last_query();
	     // die();
	    if ($rpt_wise == 'school'){
	    $this->db->flush_cache();
	    unset($array);
	    $array['school'] = $data['school'];
	      return $array;
	    } 
	   
	 	$this->db->select("de.dept_depid, de.dept_depname, dtfp.dept_depname fromdepparent, COUNT('*') as cnt,SUM(asen_purchaserate) as prate");
		$this->db->from('asen_assetentry as');
        $this->db->join('dept_department de', 'as.asen_depid=de.dept_depid', 'LEFT');
        $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
        $this->db->where('de.dept_depid IS NOT NULL');
	   	$this->db->order_by('dept_depname','ASC');
	    $this->db->group_by('as.asen_depid');
     	$data['department'] = $this->db->get()->result();

     	   if ($rpt_wise=='department_category'){
		    $this->db->flush_cache();
		    unset($array);
		    $array['department'] = $data['department'];
		      return $array;
	    } 

	    /*
	 	$this->db->select("de.dept_depid, de.dept_depname, dtfp.dept_depname fromdepparent, COUNT('*') as cnt,SUM(asen_purchaserate) as prate");
		$this->db->from('asen_assetentry as');
        $this->db->join('dept_department de', 'as.asen_depid=de.dept_depid', 'LEFT');
        $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
        $this->db->where('de.dept_depid IS NOT NULL');
	   	$this->db->order_by('dept_depname','ASC');
	    $this->db->group_by('as.asen_depid');
     	$data['department'] = $this->db->get()->result();
     	*/

	    	$this->db->select("(CASE WHEN(dtfp.dept_depid !='') THEN dtfp.dept_depid ELSE asen_depid END) as dept_depid,
(CASE WHEN(dtfp.dept_depid !='') THEN 'Y' ELSE 'N' END) as is_per,
(CASE WHEN(dtfp.dept_depid !='') THEN dtfp.dept_depname ELSE de.dept_depname END) as dept_depname,
GROUP_CONCAT(DISTINCT as.asen_depid ORDER BY de.dept_depname ASC SEPARATOR ',') as sub_dep,
COUNT('*') as cnt,
SUM(asen_purchaserate) AS prate
");
		$this->db->from('asen_assetentry as');
        $this->db->join('dept_department de', 'as.asen_depid=de.dept_depid', 'LEFT');
        $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
        // $this->db->where('de.dept_depid IS NOT NULL');
	   	$this->db->order_by("(CASE WHEN(dtfp.dept_depid !='') THEN dtfp.dept_depname ELSE de.dept_depname END)",'ASC');
	    $this->db->group_by("(CASE WHEN(dtfp.dept_depid !='') THEN dtfp.dept_depid ELSE asen_depid END)");
     	$data['department'] = $this->db->get()->result();

     	// echo $this->db->last_query();
     	// die();
     	// echo "<pre>";
     	// print_r($data['department']);
     	// die();
	    if ($rpt_wise == 'department'){
	    $this->db->flush_cache();
	    
	    unset($array);
	    $array['department'] = $data['department'];
	      return $array;
		} 

	 	$this->db->select("ae.asen_description,il.itli_itemname as itemname,ae.asen_desc,ut.unit_unitname,COUNT('*') as cnt,SUM(asen_purchaserate) as prate");
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid = ae.asen_description','LEFT');
	    $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
	    $this->db->where('ae.asen_description IS NOT NULL');
	    $this->db->group_by('ae.asen_description');
	    $this->db->order_by('il.itli_itemname', 'ASC');
	     $data['items'] = $this->db->get()->result();
	    if ($rpt_wise == 'items') {
	      $this->db->flush_cache();
	      unset($array);
	      $array['items'] = $data['items'];
	      return $array;
	    }

	    $this->db->select("CONCAT(stin_fname,' ',IFNULL(stin_mname,''),' ',IFNULL(stin_lname,'')) as receiver_name,
		(SELECT GROUP_CONCAT(CONCAT(vacs.itemname,':',vacs.cnt)) as vdes FROM vw_assets_count_staff vacs WHERE vacs.asen_staffid=ae.asen_staffid $condition) as itemname,
	     ae.asen_staffid, COUNT('*') as cnt, SUM(asen_purchaserate) as prate");

	    $this->db->from('asen_assetentry ae');
	    $this->db->join('stin_staffinfo as si','ae.asen_staffid = si.stin_staffinfoid','LEFT');
     	$this->db->join('itli_itemslist il','il.itli_itemlistid = ae.asen_description','LEFT');
	    $this->db->order_by('stin_fname','ASC');
	    $this->db->group_by('ae.asen_staffid');
	    $data['receiver'] = $this->db->get()->result();
	    if ($rpt_wise == 'receiver'){
	    $this->db->flush_cache();
	    unset($array);
	    $array['receiver'] = $data['receiver'];
	      return $array;
	    } 

	    $this->db->flush_cache();
		return $data;

    }

    public function get_sub_department_asset_data($subdepid){
    	// echo $subdepid;
    	$asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        // $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');
        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
         $condition='';
      
        if ($searchDateType == 'range') {
            if ($fromdate &&  $todate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('asen_purchasedatebs >=', $fromdate);
                    $this->db->where('asen_purchasedatebs <=', $todate);
                    $condition .= "AND vacs.asen_purchasedatebs >= '$fromdate' 
					AND vacs.asen_purchasedatebs <= '$todate'";
                } else {
                    $this->db->where('asen_purchasedatead >=', $fromdate);
                    $this->db->where('asen_purchasedatead <=', $todate);
                    $condition .= "AND vacs.asen_purchasedatead >= '$fromdate' 
					AND vacs.asen_purchasedatead <= '$todate'";
                }
            }
        }

        if (!empty($schoolid)) {
            $this->db->where('as.asen_schoolid', $schoolid);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }
         if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }

     	if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }

    	$subarr=explode(',',$subdepid);
    	// print_r($subarr);
    	if(!empty($subarr)){
    		$this->db->select("de.dept_depid, de.dept_depname, dtfp.dept_depname fromdepparent, COUNT('*') as cnt,SUM(asen_purchaserate) as prate");
		$this->db->from('asen_assetentry as');
        $this->db->join('dept_department de', 'as.asen_depid=de.dept_depid', 'LEFT');
        $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
        // $this->db->where('de.dept_depid IS NOT NULL');
        $this->db->where_in("as.asen_depid", $subarr);
	   	$this->db->order_by('dept_depname','ASC');
	    $this->db->group_by('de.dept_depid');
     	$result = $this->db->get()->result();
     	// echo $this->db->last_query();
     	return $result;

    	}
    	return false;
    }

    public function get_category_wise_department_info($depid)
    {
   		 $asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        // $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');
        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
        $condition='';
      
        if ($searchDateType == 'range') {
            if ($fromdate &&  $todate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('asen_purchasedatebs >=', $fromdate);
                    $this->db->where('asen_purchasedatebs <=', $todate);
                    $condition .= "AND vacs.asen_purchasedatebs >= '$fromdate' 
					AND vacs.asen_purchasedatebs <= '$todate'";
                } else {
                    $this->db->where('asen_purchasedatead >=', $fromdate);
                    $this->db->where('asen_purchasedatead <=', $todate);
                    $condition .= "AND vacs.asen_purchasedatead >= '$fromdate' 
					AND vacs.asen_purchasedatead <= '$todate'";
                }
            }
        }

        if (!empty($schoolid)) {
            $this->db->where('ae.asen_schoolid', $schoolid);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }
         if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }

     	if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }	
        $this->db->where('asen_depid',$depid);
    	$this->db->select("ec.eqca_category,ae.asen_assettype ,COUNT('*') as cnt,SUM(asen_purchaserate) as prate");
        $this->db->from('asen_assetentry ae');
        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=ae.asen_assettype', "LEFT");
        // $this->db->where("ec.eqca_category IS NOT NULL ");
        $this->db->group_by('ae.asen_assettype');
        $this->db->order_by('ec.eqca_category', 'ASC');
        $result= $this->db->get()->result();
         return $result;
        }

     public function get_category_wise_items_info($catid)
    {
   		$asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        // $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');
        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
        $itemid=$this->input->post('itemid');
        $condition='';
      
        if ($searchDateType == 'range') {
            if ($fromdate &&  $todate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('asen_purchasedatebs >=', $fromdate);
                    $this->db->where('asen_purchasedatebs <=', $todate);
                    $condition .= "AND vacs.asen_purchasedatebs >= '$fromdate' 
					AND vacs.asen_purchasedatebs <= '$todate'";
                } else {
                    $this->db->where('asen_purchasedatead >=', $fromdate);
                    $this->db->where('asen_purchasedatead <=', $todate);
                    $condition .= "AND vacs.asen_purchasedatead >= '$fromdate' 
					AND vacs.asen_purchasedatead <= '$todate'";
                }
            }
        }

        if (!empty($schoolid)) {
            $this->db->where('ae.asen_schoolid', $schoolid);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }
         if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }

     	if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }
        if(!empty($itemid)){
        	$this->db->where('asen_description',$itemid);
        }	
        $this->db->where('asen_assettype',$catid);
    	$this->db->select("il.itli_itemname,il.itli_itemcode,ae.asen_description ,COUNT('*') as cnt,SUM(asen_purchaserate) as prate");
        $this->db->from('asen_assetentry ae');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=ae.asen_description', "LEFT");
        // $this->db->where("ec.eqca_category IS NOT NULL ");
        $this->db->group_by('ae.asen_description');
        $this->db->order_by('il.itli_itemname', 'ASC');
        $result= $this->db->get()->result();
         return $result;
        }
    
    public function get_assets_detail_report_ku()
    {
    	$asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');

        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
         $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }
		 if ($searchDateType == 'range') {
		            if ($fromdate &&  $todate) {
		                if (DEFAULT_DATEPICKER == 'NP') {
		                    $this->db->where('asen_purchasedatebs >=', $fromdate);
		                    $this->db->where('asen_purchasedatebs <=', $todate);
		                } else {
		                    $this->db->where('asen_purchasedatead >=', $fromdate);
		                    $this->db->where('asen_purchasedatead <=', $todate);
		                }
		            }
		        }

        if (!empty($schoolid)) {
            $this->db->where('asen_schoolid', $schoolid);
        }
	 	if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("asen_depid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("asen_depid", $subdeparray);
                } else {
                    $this->db->where("asen_depid =" . $departmentid . " ");
                }
            }
        }

	 	if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }

        if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

     	if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }

	    $result=$this->asset_entry_report_details_common_query_ku();
	    
	     return $result;

    }

	public function get_assets_item_detail_ku()
	{
        $asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');
        $itemid=	$this->input->post('itemid');

        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
         $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
		 if ($searchDateType == 'range') {
		            if ($fromdate &&  $todate) {
		                if (DEFAULT_DATEPICKER == 'NP') {
		                    $this->db->where('asen_purchasedatebs >=', $fromdate);
		                    $this->db->where('asen_purchasedatebs <=', $todate);
		                } else {
		                    $this->db->where('asen_purchasedatead >=', $fromdate);
		                    $this->db->where('asen_purchasedatead <=', $todate);
		                }
		            }
		        }

        if (!empty($schoolid)) {
            $this->db->where('asen_schoolid', $schoolid);
        }
	 if (!empty($departmentid)) {

	            if (!empty($subdepid)) {
	                $this->db->where("asen_depid =" . $subdepid . " ");
	            } else {
	                if (!empty($subdeparray)) {
	                    $this->db->where_in("asen_depid", $subdeparray);
	                } else {
	                    $this->db->where("asen_depid =" . $departmentid . " ");
	                }
	            }
	        }

        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }

        if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }

     	if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }
        if(!empty($itemid)){
        	$this->db->where('asen_description',$itemid);
        }
        $this->db->stop_cache();

        $this->db->select('DISTINCT(ae.asen_description),ut.unit_unitname ,il.itli_itemname, il.itli_itemlistid,il.itli_itemcode');
        $this->db->from('asen_assetentry ae');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = ae.asen_description', 'LEFT');
        $this->db->join('unit_unit ut', 'il.itli_unitid = ut.unit_unitid', 'LEFT');
        $this->db->where('ae.asen_description IS NOT NULL');

        $items_list = $this->db->get()->result();
        $items = array();
        if (count($items_list)) {
            foreach ($items_list as $key => $item) {
              $items[$key]['item_name'] = $item->itli_itemcode.'-'.$item->itli_itemname;
              $items[$key]['item_unit'] = $item->unit_unitname;
              $items[$key]['item_details'] = $this->asset_entry_report_details_common_query_ku(array('ae.asen_description'=>$item->itli_itemlistid));
            }
        }

        $this->db->flush_cache();   
        return $items;
    }

	public function get_assets_school_detail_ku()
	{
        $asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');

        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
         $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
		 if ($searchDateType == 'range') {
		            if ($fromdate &&  $todate) {
		                if (DEFAULT_DATEPICKER == 'NP') {
		                    $this->db->where('asen_purchasedatebs >=', $fromdate);
		                    $this->db->where('asen_purchasedatebs <=', $todate);
		                } else {
		                    $this->db->where('asen_purchasedatead >=', $fromdate);
		                    $this->db->where('asen_purchasedatead <=', $todate);
		                }
		            }
		        }
 
 			if (!empty($departmentid)) {

	            if (!empty($subdepid)) {
	                $this->db->where("asen_depid =" . $subdepid . " ");
	            } else {
	                if (!empty($subdeparray)) {
	                    $this->db->where_in("asen_depid", $subdeparray);
	                } else {
	                    $this->db->where("asen_depid =" . $departmentid . " ");
	                }
	            }
	        }

        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }

        if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }
        $this->db->stop_cache();

        if (!empty($schoolid)) {
            $this->db->where('asen_schoolid', $schoolid);
        }

     	$this->db->select('DISTINCT(as.asen_schoolid),lc.loca_locationid,lc.loca_name');
        $this->db->from('asen_assetentry as');
        $this->db->join('loca_location lc', 'as.asen_schoolid=lc.loca_locationid', 'LEFT');
        $this->db->order_by('loca_name','ASC');

        $school_list = $this->db->get()->result();
        $school_data = array();
        if (count($school_list)) {
            foreach ($school_list as $key => $school) {
              $school_data[$key]['school_name'] = $school->loca_name;
              $school_data[$key]['school_details'] = $this->asset_entry_report_details_common_query_ku(array('ae.asen_schoolid'=>$school->asen_schoolid));
            }
        }

        $this->db->flush_cache();   
        return $school_data;
    }

	public function get_assets_department_detail_ku()
	{
        $asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');

        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
         $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
		 if ($searchDateType == 'range') {
            if ($fromdate &&  $todate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('asen_purchasedatebs >=', $fromdate);
                    $this->db->where('asen_purchasedatebs <=', $todate);
                } else {
                    $this->db->where('asen_purchasedatead >=', $fromdate);
                    $this->db->where('asen_purchasedatead <=', $todate);
                }
            }
        }
 			
		if (!empty($schoolid)) {
    		$this->db->where('asen_schoolid', $schoolid);
		}

        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }

        if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }
       
        $this->db->stop_cache();

        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("asen_depid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("asen_depid", $subdeparray);
                } else {
                    $this->db->where("asen_depid =" . $departmentid . " ");
                }
            }
        }

     	$this->db->select('DISTINCT(as.asen_depid), de.dept_depid, de.dept_depname, dtfp.dept_depname fromdepparent');
       	$this->db->from('asen_assetentry as');
        $this->db->join('dept_department de', 'as.asen_depid=de.dept_depid', 'LEFT');
        $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
        $this->db->order_by('dept_depname','ASC');

        $department_list = $this->db->get()->result();

        $department = array();
        if (count($department_list)) {
            foreach ($department_list as $key => $item) {
	           if (!empty($item->fromdepparent)) {
	                $dept_name = "$item->fromdepparent ($item->dept_depname)";    
	            }else{
	                $dept_name = $item->dept_depname;
	            }
	        
            $department[$key]['department_name'] = $dept_name;
      		$department[$key]['department_details'] = $this->asset_entry_report_details_common_query_ku(array('ae.asen_depid'=>$item->dept_depid));
            }
        }

        $this->db->flush_cache();   
        return $department;
    }

	public function get_assets_category_detail_ku()
	{
        $asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');

        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
         $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
		 if ($searchDateType == 'range') {
            if ($fromdate &&  $todate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('asen_purchasedatebs >=', $fromdate);
                    $this->db->where('asen_purchasedatebs <=', $todate);
                } else {
                    $this->db->where('asen_purchasedatead >=', $fromdate);
                    $this->db->where('asen_purchasedatead <=', $todate);
                }
            }
        }
 			
		if (!empty($schoolid)) {
    		$this->db->where('asen_schoolid', $schoolid);
		}

		 if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("asen_depid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("asen_depid", $subdeparray);
                } else {
                    $this->db->where("asen_depid =" . $departmentid . " ");
                }
            }
        }
 			
        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }

        if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }
       
        $this->db->stop_cache();

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }

     	$this->db->select('DISTINCT(as.asen_assettype), ec.eqca_equipmentcategoryid, ec.eqca_category');
       	$this->db->from('asen_assetentry as');
        $this->db->join('eqca_equipmentcategory ec', 'as.asen_assettype=ec.eqca_equipmentcategoryid', 'LEFT');
        $this->db->where('ec.eqca_isnonexp','Y');
        $this->db->order_by('eqca_category','ASC');

        $equipment_list = $this->db->get()->result();

        $equipment = array();
        if (count($equipment_list)) {
            foreach ($equipment_list as $key => $item) {
	          
            $equipment[$key]['equipment_name'] = $item->eqca_category;
      		$equipment[$key]['equipment_details'] = $this->asset_entry_report_details_common_query_ku(array('ae.asen_assettype'=>$item->eqca_equipmentcategoryid));
            }
        }

        $this->db->flush_cache();   
        return $equipment;
    }

	public function get_assets_supplier_detail_ku()
	{
        $asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');

        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
         $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
		 if ($searchDateType == 'range') {
            if ($fromdate &&  $todate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('asen_purchasedatebs >=', $fromdate);
                    $this->db->where('asen_purchasedatebs <=', $todate);
                } else {
                    $this->db->where('asen_purchasedatead >=', $fromdate);
                    $this->db->where('asen_purchasedatead <=', $todate);
                }
            }
        }
 			
		if (!empty($schoolid)) {
    		$this->db->where('asen_schoolid', $schoolid);
		}

		 if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("asen_depid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("asen_depid", $subdeparray);
                } else {
                    $this->db->where("asen_depid =" . $departmentid . " ");
                }
            }
        }

        if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }
       
        $this->db->stop_cache();

        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }

        $this->db->select('DISTINCT(as.asen_distributor), s.dist_distributor, s.dist_distributorid,');
        $this->db->from('asen_assetentry as');
        $this->db->join('dist_distributors s', 's.dist_distributorid = as.asen_distributor', 'LEFT');
        $this->db->order_by('dist_distributor','ASC');
        
        $supplier_list = $this->db->get()->result();

        $supplier = array();
        if (count($supplier_list)) {
            foreach ($supplier_list as $key => $item) {
	          
            $supplier[$key]['supplier_name'] = $item->dist_distributor;
      		$supplier[$key]['supplier_details'] = $this->asset_entry_report_details_common_query_ku(array('ae.asen_distributor'=>$item->dist_distributorid));
            }
        }

        $this->db->flush_cache();   
        return $supplier;
    }

	public function get_assets_purchase_date_detail_ku()
	{
        $asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');

        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
         $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
		 	
		if (!empty($schoolid)) {
    		$this->db->where('asen_schoolid', $schoolid);
		}

	 	if (!empty($departmentid)) {

	        if (!empty($subdepid)) {
	            $this->db->where("asen_depid =" . $subdepid . " ");
	        } else {
	            if (!empty($subdeparray)) {
	                $this->db->where_in("asen_depid", $subdeparray);
	            } else {
	                $this->db->where("asen_depid =" . $departmentid . " ");
	            }
	        }
	    }

        if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }
       
        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }
        $this->db->stop_cache();

        if ($searchDateType == 'range') {
            if ($fromdate &&  $todate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('asen_purchasedatebs >=', $fromdate);
                    $this->db->where('asen_purchasedatebs <=', $todate);
                } else {
                    $this->db->where('asen_purchasedatead >=', $fromdate);
                    $this->db->where('asen_purchasedatead <=', $todate);
                }
            }
        }

        $this->db->select('DISTINCT(as.asen_purchasedatebs),asen_purchasedatead');
        $this->db->from('asen_assetentry as');
        $this->db->order_by('asen_purchasedatebs','ASC');
        $purchase_date_list = $this->db->get()->result();

        $date = array();
        if (count($purchase_date_list)) {
            foreach ($purchase_date_list as $key => $item) {
	          
            $date[$key]['purchase_date'] = "$item->asen_purchasedatebs (B.S) - $item->asen_purchasedatead (A.D)";
      		$date[$key]['purchase_details'] = $this->asset_entry_report_details_common_query_ku(array('ae.asen_purchasedatebs'=>$item->asen_purchasedatebs));
            }
        }

        $this->db->flush_cache();   
        return $date;
    }

	public function get_assets_receiver_detail_ku()
	{
        $asset_category = $this->input->post('asset_category');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $searchDateType = $this->input->post('purdatetype');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $asen_dispose = $this->input->post('asen_dispose');
        $asen_staffid = $this->input->post('asen_staffid');
        $supplierid = $this->input->post('asen_distributor');

        $rpt_type = $this->input->post('report_type');
        $rpt_wise = $this->input->post('wise_type');
         $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();

        if ($searchDateType == 'range') {
            if ($fromdate &&  $todate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('asen_purchasedatebs >=', $fromdate);
                    $this->db->where('asen_purchasedatebs <=', $todate);
                } else {
                    $this->db->where('asen_purchasedatead >=', $fromdate);
                    $this->db->where('asen_purchasedatead <=', $todate);
                }
            }
        }
		 	
		if (!empty($schoolid)) {
    		$this->db->where('asen_schoolid', $schoolid);
		}

	 	if (!empty($departmentid)) {

	        if (!empty($subdepid)) {
	            $this->db->where("asen_depid =" . $subdepid . " ");
	        } else {
	            if (!empty($subdeparray)) {
	                $this->db->where_in("asen_depid", $subdeparray);
	            } else {
	                $this->db->where("asen_depid =" . $departmentid . " ");
	            }
	        }
	    }

        if(!empty($asen_dispose)){
        	$this->db->where('asen_isdispose',$asen_dispose);
        }

        if (!empty($asset_category)) {
        	$this->db->where('asen_assettype',$asset_category);
        }
       
        if (!empty($supplierid)) {
            $this->db->where(array('asen_distributor' => $supplierid));
        }
        $this->db->stop_cache();

     	if(!empty($asen_staffid)){
        	$this->db->where('asen_staffid',$asen_staffid);
        }

        $this->db->select('DISTINCT(as.asen_staffid),stin_staffinfoid ,stin_fname, stin_mname, stin_lname,');
        $this->db->from('asen_assetentry as');
        $this->db->join('stin_staffinfo as si','as.asen_staffid = si.stin_staffinfoid','LEFT');
        $this->db->order_by('stin_fname','ASC');
        $receiver_list = $this->db->get()->result();

        $receiver = array();
        if (count($receiver_list)) {
            foreach ($receiver_list as $key => $item) {
	          
            $receiver[$key]['receiver_name'] = "$item->stin_fname $item->stin_mname $item->stin_lname";
      		$receiver[$key]['receiver_details'] = $this->asset_entry_report_details_common_query_ku(array('ae.asen_staffid'=>$item->stin_staffinfoid));
            }
        }

        $this->db->flush_cache();   
        return $receiver;
    }

    public function asset_entry_report_details_common_query_ku($where=false)
    {
    	$this->db->select("ae.asen_description,
	            COUNT('*') as cnt,	
				il.itli_itemname,
				ae.asen_desc,
				ae.asen_purchasedatebs,
				ae.asen_purchaserate,
				ae.asen_remarks,	
				ut.unit_unitname,
				dt.dist_distributor,
				ec.eqca_category,
				as.asst_statusname,
				ac.asco_conditionname,
				stin_fname,
				stin_mname,
				stin_lname,
				recm_supplierbillno,
				recm_invoiceno,
				sc.loca_name AS schoolname,
				dp.dept_depname,
				dtfp.dept_depname depparent,
				rm.recm_others,
				rm.recm_receivedmasterid");
		    $this->db->from('asen_assetentry ae');
		    $this->db->join('assy_assetsync ass','ae.asen_syncid=ass.assy_assyid','LEFT');
		    // $this->db->join('trde_transactiondetail td','td.trde_trdeid=ass.assy_trdeid','LEFT');
		    // $this->db->join('recd_receiveddetail rd','rd.recd_receiveddetailid=td.trde_mtdid','LEFT');
		    // $this->db->join('recm_receivedmaster rm','rm.recm_receivedmasterid=rd.recd_receivedmasterid','LEFT');
		    $this->db->join('trde_transactiondetail td','td.trde_trdeid = ass.assy_trdeid','LEFT');
			$this->db->join('recd_receiveddetail rd','rd.recd_receiveddetailid = td.trde_mtdid','LEFT');
			$this->db->join('recm_receivedmaster rm','rm.recm_receivedmasterid = rd.recd_receivedmasterid','LEFT');
		    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
		    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
		    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
		    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
		    $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
		    $this->db->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
	      	$this->db->join('loca_location sc','sc.loca_locationid=ae.asen_schoolid','LEFT');
	     	$this->db->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT');
	      	$this->db->join('dept_department dtfp','dtfp.dept_depid=dp.dept_parentdepid','LEFT');
	     	$this->db->join('stin_staffinfo st','st.stin_staffinfoid=ae.asen_staffid','LEFT');
		    if ($where) {
		    	$this->db->where($where);
		    }
		    $this->db->group_by("ae.asen_description,il.itli_itemname,ae.asen_desc,ae.asen_purchasedatebs,ae.asen_purchaserate,ae.asen_remarks");
	        $this->db->order_by('ae.asen_purchasedatebs','ASC');
	        return $this->db->get()->result();
    }
		
}