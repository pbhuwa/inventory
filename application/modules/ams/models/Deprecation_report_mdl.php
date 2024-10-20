<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Deprecation_report_mdl extends CI_Model 

{

	public function __construct() 

	{

		parent::__construct();

		$this->org_id=$this->session->userdata(ORG_ID);

		$this->locationid=$this->session->userdata(LOCATION_ID);

		$this->postid=$this->general->get_real_ipaddr();

		$this->postmac=$this->general->get_Mac_Address();

		$this->curtime=$this->general->get_currenttime();

		$this->userid=$this->session->userdata(USER_ID);

		$this->orginalcost=0;





	

	}



	public function generate_dep_report()

	{

		// echo 'Test';

		// die();

		$assettype=$this->input->post('asen_assettype');

		$locationid=$this->input->post('locationname');

		$depreciation=$this->input->post('asen_depreciation');



		if(!empty($assettype))

		{

			$this->db->where(array('asen_assettype'=>$assettype));

		}

		if(!empty($locationid))

		{

			$this->db->where(array('asen_locationid'=>$locationid));

		}

		// if(!empty($deprecation))

		// {



		// }

		$this->db->select('*');

		$this->db->from('asen_assetentry ae');

		$this->db->order_by('asen_asenid','ASC');

		// $this->db->limit(1);



		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		$data=$query->result();		

		// echo "<pre>";

		// print_r($data);

		// die();

		$this->db->query('TRUNCATE TABLE xw_dete_depreciationtemp');



		if(!empty($data))

		{



			foreach ($data as $kd => $ass) {

			

			  	$ass_purate=$ass->asen_purchaserate;

	            $ass_marketval=$ass->asen_marketvalue;

	            $ass_scrapval=$ass->asen_scrapvalue;

	           	$ass_purdate= $ass->asen_purchasedatebs;

	            $ass_exptlife=$ass->asen_expectedlife;

	            $ass_recper=$ass->asen_recoveryperiod;



	            if($depreciation==1)

	            {

	            	$this->assetsid=$ass->asen_asenid;



	            	$start_date_exploded= explode('/', $ass_purdate);

					$year=$start_date_exploded[0];

					$month=$start_date_exploded[1];

					$days=$start_date_exploded[2];

					$this->common_principal=$ass_purate;

					$this->common_month=$month;

					$this->common_year=$year;	

					$this->common_date=$ass_purdate;	





	            	$this->depr_calc_straight_line_partial($ass_purate,0,$ass_scrapval,$ass_recper);

	            }



			}

		}

		







	}





public function depr_calc_straight_line_partial($principal,$pamt=0,$salvage_value,$useful_life,$i=0,$accdepprev=0)

	{

		// error_reporting(0);

		$acc_dep=$accdepprev;

			/* setting header for depreciation for the first time */

		

			$j=$i;



			

			$common_dep=($this->common_principal-$salvage_value)/$useful_life;//dep_formula

			// echo $common_dep;

			// die();

			

			$salvage_value=$salvage_value;

			

			/* calculating partial depreciation for months */

			if($this->common_month<=3)

			{

				$for_year1_dep_amt=((4-$this->common_month)/12)*$common_dep;

				$for_yearLast_dep_amt=(12-(4-$this->common_month))/12*$common_dep;				

			}

			elseif ($this->common_month==4) 

			{

				$for_year1_dep_amt=$common_dep;

				$for_yearLast_dep_amt=$common_dep;

			}

			else

			{

				$for_year1_dep_amt=(((12-$this->common_month+3)+1)/12)*$common_dep;

				$for_yearLast_dep_amt=(12-((12-$this->common_month+3)+1))/12*$common_dep;				

			}	



			$pamt_val_common=$principal-$common_dep;//principal_after_depreciation

			

			/* calculating accumulated depreciation */

			if($accdepprev==0)

			{

				$acc_dep=$for_year1_dep_amt;

				$depreciation_value=$for_year1_dep_amt;

				$pamt_val=$principal-$for_year1_dep_amt;

			}

			

			else if($i<$useful_life && $i>0)

			{

				$depreciation_value=$common_dep;

				$acc_dep +=$common_dep ;

				$for_yearLast_dep_amt=$common_dep;

				$pamt_val=$pamt_val_common;

			}

			else if($i==$useful_life)

			{

			$acc_dep=$acc_dep+$for_yearLast_dep_amt;

			$depreciation_value=$for_yearLast_dep_amt;

			$pamt_val=$principal-$for_yearLast_dep_amt;



			}

			

		if($principal<=0 || $principal<=$salvage_value)

		{

			return false;

		}



		if($i<=$useful_life)

			{

				if ($this->common_month<=3)

				{

					 if ($i==0)

					 {

					 	$initial_date=$this->common_year.'/'.$this->common_month.'/01';

					 	// $this->deptemp.='<td style="text-align:center">'.$this->common_year.'/'.$this->common_month.'/01</td>';

					 }

					 elseif ($i==1) 

					 {

					 	$initial_date=$this->common_year.'/04/01';

					 	// $this->deptemp.='<td style="text-align:center">'.$this->common_year.'/04/01</td>';

					 }

					 else

					 {

					 	$initial_date=($this->common_year+$i-1).'/04/01';

					 	// $this->deptemp.='<td style="text-align:center">'.($this->common_year+$i-1).'/04/01</td>';

					 }	

					 $initial_pri=$principal;

					 // $this->deptemp.='<td style="text-align:center">'.number_format($principal,2).'</td>';

					 // $this->deptemp.='<td style="text-align:center">'.number_format($depreciation_value,2).'</td>';

					 $dep_value=$depreciation_value;



					 $accdep_value=$acc_dep;

					 // $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';

					 

					 if ($i==0) 

					 {

					 	$end_date=($this->common_year).'/03/31';

					 	// $this->deptemp.='<td style="text-align:center">'.($this->common_year).'/03/31</td>';

					 }

					 else if ($i==$useful_life)

					 {

					 	$end_date=($this->common_year+$i).'/'.$this->common_month.'/01';

					 	// $this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/'.$this->common_month.'/01</td>';

					

					 }

					 else

					 {

					 	$end_date=($this->common_year+$i).'/03/31';

					 	// $this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/03/31</td>';

					 }

					 $value_after_dep=$pamt_val;

					 // $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';



					 $tempDepArray=array(

					 	'dete_assetid'=>$this->assetsid,

					 	'dete_purchasedatebs'=>$initial_date,

					 	'dete_inboookval'=>$initial_pri,

					 	'dete_depamt'=>$dep_value,

					 	'dete_accmulateval'=>$accdep_value,

					 	'dete_enddatebs'=>$end_date,

					 	'dete_finaldepval'=>$value_after_dep,

					 	'dete_methodid'=>1,

					 	'dete_locationid'=>$this->locationid,

					 	'dete_orgid'=>$this->org_id,

						'dete_postdatead'=>	CURDATE_EN,

						'dete_postdatebs'=>CURDATE_NP,

						'dete_posttime'=>$this->curtime,

						'dete_postby'=>$this->userid,

						'dete_postip'=>$this->postid,

						'dete_postmac'=>$this->postmac

						 );

					 if(!empty($tempDepArray))

					 {

					 	$this->db->insert('dete_depreciationtemp',$tempDepArray);

					 	// echo $this->db->last_query();

					 }



					 $this->depr_calc_straight_line_partial($pamt_val,$principal,$salvage_value,$useful_life,$j+1,$acc_dep);

				}



				else

				{

					if ($i==0)

					 {

					 	$initial_date=$this->common_date;

					 // $this->deptemp.='<td style="text-align:center">'.$this->common_date.'</td>';

					 }

					 else

					 {

					 	$initial_date=($this->common_year+$i).'/04/01';

					 // $this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/04/01</td>';

					 }	

					 

					 $initial_pri=$principal;

					 // $this->deptemp.='<td style="text-align:center">'.number_format($principal,2).'</td>';

					 // $this->deptemp.='<td style="text-align:center">'.number_format($depreciation_value,2).'</td>';

					 $dep_value=$depreciation_value;



					 // $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';

						 if ($i==$useful_life)

						 {

						 	// $this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/'.$this->common_month.'/01</td>';

						 	$end_date=($this->common_year+$i+1).'/'.$this->common_month.'/01';

						 }

						 else

						 {

						 	$end_date=($this->common_year+$i+1).'/03/31';

						 	// $this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/03/31</td>';

						 }

						 $value_after_dep=$pamt_val;

					 // $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';



					  $tempDepArray=array(

					 	'dete_assetid'=>$this->assetsid,

					 	'dete_purchasedatebs'=>$initial_date,

					 	'dete_inboookval'=>$initial_pri,

					 	'dete_depamt'=>$dep_value,

					 	'dete_accmulateval'=>$acc_dep,

					 	'dete_enddatebs'=>$end_date,

					 	'dete_finaldepval'=>$value_after_dep,

					 	'dete_methodid'=>1,

					 	'dete_locationid'=>$this->locationid,

					 	'dete_orgid'=>$this->org_id,

						'dete_postdatead'=>	CURDATE_EN,

						'dete_postdatebs'=>CURDATE_NP,

						'dete_posttime'=>$this->curtime,

						'dete_postby'=>$this->userid,

						'dete_postip'=>$this->postid,

						'dete_postmac'=>$this->postmac

						 );

					 if(!empty($tempDepArray))

					 {

					 	$this->db->insert('dete_depreciationtemp',$tempDepArray);

					 }



					 $this->depr_calc_straight_line_partial($pamt_val,$principal,$salvage_value,$useful_life,$j+1,$acc_dep);

				}

				return true;

			

		}



		else

		{

			return false;

		}



		

		// $this->deptemp.='</tr>';

		// return $this->deptemp;	

	}

	// public function get_deprecation_/



	public function generate_diminishing_dep_report()

		{

			$assettype=$this->input->post('asen_assettype');

			$locationid=$this->input->post('locationname');

			$depreciation=$this->input->post('asen_depreciation');

			$asen_asenid=$this->input->post('asen_asenid');

			$dtype=$this->input->post('dtype');

			// echo $dtype;

			// die();

			if($dtype=='partialgen'){

			if(!empty($assettype))

			{

				$this->db->where(array('asen_assettype'=>$assettype));

			}

			if(!empty($locationid))

			{

				$this->db->where(array('asen_locationid'=>$locationid));

			}

			if(!empty($asen_asenid))

			{

				$this->db->where(array('asen_asenid'=>$asen_asenid));

			}



			$this->db->select('ae.*,ec.eqca_deprate');

			$this->db->from('asen_assetentry ae');

			$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');

			$this->db->order_by('asen_asenid','ASC');

		// $this->db->limit(1);



			$query = $this->db->get();

		

			$data=$query->result();	

		// 	echo $this->db->last_query();

		// die();

			// $this->db->query('TRUNCATE TABLE xw_dete_depreciationtemp');

		// echo "<pre>";

		// print_r($data);

		// die();



			if(!empty($data))

			{

				foreach ($data as $kd => $ass) {



					if($depreciation==5)

					{

						$this->orginalcost=$ass->asen_purchaserate;

						$assetsid=$ass->asen_asenid;

						$ass_purate=$ass->asen_purchaserate;

						$purchase_date= $ass->asen_purchasedatebs;

						$ass_deprate= $ass->asen_deppercentage;



	            	// $purchase_date= explode('/', $ass_purdate);

	            	// $purchase_rate=$ass_purate;



						$curfiscalyrs=CUR_FISCALYEAR;

						$this->depr_calc_diminishing_balance_dep_partial(true,$assetsid,$ass_purate,$purchase_date,$ass_deprate,false,false,false,$curfiscalyrs);

					}



				$ass_purate=$ass->asen_purchaserate;



				$ass_marketval=$ass->asen_marketvalue;

				$ass_scrapval=$ass->asen_scrapvalue;

				$ass_purdate= $ass->asen_purchasedatebs;

				$ass_servicedate= $ass->asen_inservicedatebs;

				$ass_exptlife=$ass->asen_expectedlife;

				$ass_explife=$ass->asen_expectedlife;



				if($depreciation==1)

				{

					$this->assetsid=$ass->asen_asenid;



					$start_date_exploded= explode('/', $ass_servicedate);

					$year=$start_date_exploded[0];

					$month=$start_date_exploded[1];

					$days=$start_date_exploded[2];

					$this->common_principal=$ass_purate;

					$this->common_month=$month;

					$this->common_year=$year;	

					$this->common_date=$ass_servicedate;

					$this->common_purdate=$ass_purdate;	

					$this->common_original_cost=$ass_purate;







					$this->depr_calc_straight_line_partial($ass_purate,0,$ass_scrapval,$ass_explife);

				 }

			  }

			 }



				

			}

			if($dtype=='totalgen')

			{

				// echo $asen_asenid;

				// die();

			if(!empty($assettype))

			{

				$this->db->where(array('asen_assettype'=>$assettype));

			}

			if(!empty($locationid))

			{

				$this->db->where(array('asen_locationid'=>$locationid));

			}

			if(!empty($asen_asenid))

			{

				$this->db->where(array('asen_asenid'=>$asen_asenid));

			}



			$this->db->select('ae.*,ec.eqca_deprate');

			$this->db->from('asen_assetentry ae');

			$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');

			$this->db->order_by('asen_asenid','ASC');

		// $this->db->limit(1);



			$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

			$data=$query->result();	

			$this->db->query('TRUNCATE TABLE xw_dete_depreciationtemp');

		// echo "<pre>";

		// print_r($data);

		// die();



			if(!empty($data))

			{

				foreach ($data as $kd => $ass) {



					if($depreciation==5)

					{

						$this->orginalcost=$ass->asen_purchaserate;

						$assetsid=$ass->asen_asenid;

						$ass_purate=$ass->asen_purchaserate;

						$purchase_date= $ass->asen_purchasedatebs;

						$ass_deprate= $ass->asen_deppercentage;



	            	// $purchase_date= explode('/', $ass_purdate);

	            	// $purchase_rate=$ass_purate;



						$curfiscalyrs=CUR_FISCALYEAR;

						$this->depr_calc_diminishing_balance_dep(true,$assetsid,$ass_purate,$purchase_date,$ass_deprate,false,false,false,$curfiscalyrs);

					}



				$ass_purate=$ass->asen_purchaserate;



				$ass_marketval=$ass->asen_marketvalue;

				$ass_scrapval=$ass->asen_scrapvalue;

				$ass_purdate= $ass->asen_purchasedatebs;

				$ass_servicedate= $ass->asen_inservicedatebs;

				$ass_exptlife=$ass->asen_expectedlife;

				$ass_explife=$ass->asen_expectedlife;



				if($depreciation==1)

				{

					$this->assetsid=$ass->asen_asenid;



					$start_date_exploded= explode('/', $ass_servicedate);

					$year=$start_date_exploded[0];

					$month=$start_date_exploded[1];

					$days=$start_date_exploded[2];

					$this->common_principal=$ass_purate;

					$this->common_month=$month;

					$this->common_year=$year;	

					$this->common_date=$ass_servicedate;

					$this->common_purdate=$ass_purdate;	

					$this->common_original_cost=$ass_purate;







					$this->depr_calc_straight_line_partial($ass_purate,0,$ass_scrapval,$ass_explife);

				 }

			  }

			 }

			}



		

		}



		public function depr_calc_diminishing_balance_dep($firstcall=false,$assid,$purrate,$purdate,$deprate,$prvyrsaccdep=false,$status=false,$strtdate=false,$curfiscalyrs)

		{

	// echo "test";

	// die();



			$purchase_date= explode('/', $purdate);

			$year=$purchase_date[0];

			$month=$purchase_date[1];

			$days=$purchase_date[2];

			$next_yrs=$year+1;

			$prev_yrs=$year-1;





			if($month>=4 && $month<=12)

			{

				$fyrs=substr($year, 1).'/'.substr($next_yrs,2);

			}

			elseif($month>=1 && $month<=3)

			{

				$fyrs=substr($prev_yrs,1).'/'.substr($year,2);

			}







			if($firstcall==true)

			{





				if($month>=4 && $month <=9)

				{

					$mnthrate=3/3;

				}

				if($month>=10 && $month <=12)

				{

					$mnthrate=2/3;

				}



				if($month>=1 && $month <=3)

				{

					$mnthrate=1/3;

				}

				// $mnthrate=1;

				$enddateplusOne=$year+0;

				$endatebs=$enddateplusOne.'/03/31';



				$dete_accmulateval=$purrate*($deprate)*$mnthrate;	

				$prev_yrs_acc_dep=0;

				$totaldeptilldateval=$dete_accmulateval+$prev_yrs_acc_dep;



				$netvalue=$purrate-$totaldeptilldateval;

				$prevyrsaccdep=$dete_accmulateval;

				$tempDepArray=array(

					'dete_assetid'=>$assid,

					'dete_purchasedatebs'=>$purdate,

					'dete_startdatebs'=>$purdate,

					'dete_orginalcost'=>$purrate,

					'dete_opbalance'=>$purrate,

					'dete_deprate'=>$deprate,

					'dete_fiscalyrs'=>$fyrs,

					'dete_accmulateval'=>$dete_accmulateval,

					'dete_accmulatdepprevyrs'=>$prev_yrs_acc_dep,

					'dete_totaldeptilldateval'=>$totaldeptilldateval,

					'dete_netvalue'=>$netvalue,

					'dete_enddatebs'=>$endatebs,

					'dete_methodid'=>5,

					'dete_locationid'=>$this->locationid,

					'dete_orgid'=>$this->org_id,

					'dete_postdatead'=>	CURDATE_EN,

					'dete_postdatebs'=>CURDATE_NP,

					'dete_posttime'=>$this->curtime,

					'dete_postby'=>$this->userid,

					'dete_postip'=>$this->postid,

					'dete_postmac'=>$this->postmac,

					'remarks'=>'First Call',

				);

				if(!empty($tempDepArray))

				{

					$this->db->insert('dete_depreciationtemp',$tempDepArray);

				}



				$this->depr_calc_diminishing_balance_dep(false,$assid,$netvalue,$purdate,$deprate,$prevyrsaccdep,'go',$purdate,$curfiscalyrs);

			}

			else

			{

				$purchase_date= explode('/', $strtdate);

				$year=$purchase_date[0];

				$month=$purchase_date[1];

				$days=$purchase_date[2];



				if($month >='4' && $month <= '12')

				{

					$startyear=$year+1;

				}

				else

				{

					$startyear=$year;

				}



				$startdate=$startyear.'/04/01';	

				$endplusOne=($startyear)+1;

				$enddate=$endplusOne.'/03/31';



				$start_date= explode('/', $startdate);

				$year=$start_date[0];

				$month=$start_date[1];

				$days=$start_date[2];

				$next_yrs=$year+1;

				$prev_yrs=$year-1;



				if($month>=4 && $month<=12)

				{

					$fyrs=substr($year, 1).'/'.substr($next_yrs,2);

				}

				elseif($month>=1 && $month<=4)

				{

					$fyrs=substr($prev_yrs,1).'/'.substr($year,2);

				}



				$dete_accmulateval=$purrate*($deprate);	

				$prev_yrs_acc_dep=$dete_accmulateval;

				$totaldeptilldateval=$prvyrsaccdep+$prev_yrs_acc_dep;

				$netvalue=$purrate-$dete_accmulateval;



				$check_orginal_n_prevaccdep=$this->orginalcost-$prvyrsaccdep;





				$new_netval=round($netvalue,2);

				// echo "<br>".$new_netval;



				if((float)$new_netval=='0.00' || $curfiscalyrs==$fyrs)

				{

					$stus='stop';

				}

				else

				{

					$stus='go';

				}







				$tempDepArray=array(

					'dete_assetid'=>$assid,

					'dete_purchasedatebs'=>$purdate,

					'dete_startdatebs'=>$startdate,

					'dete_orginalcost'=>$this->orginalcost,

					'dete_opbalance'=>$purrate,

					'dete_deprate'=>$deprate,

					'dete_fiscalyrs'=>$fyrs,

					'dete_accmulateval'=>$dete_accmulateval,

					'dete_accmulatdepprevyrs'=>$prvyrsaccdep,

					'dete_totaldeptilldateval'=>$totaldeptilldateval,

					'dete_netvalue'=>$netvalue,

					'dete_enddatebs'=>$enddate,

					'dete_methodid'=>5,

					'dete_locationid'=>$this->locationid,

					'dete_orgid'=>$this->org_id,

					'dete_postdatead'=>	CURDATE_EN,

					'dete_postdatebs'=>CURDATE_NP,

					'dete_posttime'=>$this->curtime,

					'dete_postby'=>$this->userid,

					'dete_postip'=>$this->postid,

					'dete_postmac'=>$this->postmac,

					'remarks'=>'Running Execution'

				);

				

				if($stus=='go')

				{

					if(!empty($tempDepArray))

					{

						$this->db->insert('dete_depreciationtemp',$tempDepArray);

					}



					$this->depr_calc_diminishing_balance_dep(false,$assid,$netvalue,$purdate,$deprate,$totaldeptilldateval,$stus,$startdate,$curfiscalyrs); 

				}

				else

				{

					// echo $stus;

					$new_netval=round($netvalue,2);

					if($netvalue=='0.00')

					{

						$remark='Write Off';

					}

					else

					{

						$remark='Execution Stop';

					}

					$tempDepArray=array(

						'dete_assetid'=>$assid,

						'dete_purchasedatebs'=>$purdate,

						'dete_startdatebs'=>$startdate,

						'dete_orginalcost'=>$this->orginalcost,

						'dete_opbalance'=>$purrate,

						'dete_deprate'=>$deprate,

						'dete_fiscalyrs'=>$fyrs,

						'dete_accmulateval'=>$dete_accmulateval,

						'dete_accmulatdepprevyrs'=>$prvyrsaccdep,

						'dete_totaldeptilldateval'=>$totaldeptilldateval,

						'dete_netvalue'=>$netvalue,

						'dete_enddatebs'=>$enddate,

						'dete_methodid'=>5,

						'dete_locationid'=>$this->locationid,

						'dete_orgid'=>$this->org_id,

						'dete_postdatead'=>	CURDATE_EN,

						'dete_postdatebs'=>CURDATE_NP,

						'dete_posttime'=>$this->curtime,

						'dete_postby'=>$this->userid,

						'dete_postip'=>$this->postid,

						'dete_postmac'=>$this->postmac,

						'remarks'=>$remark,

					);

					if(!empty($tempDepArray))

					{

						$this->db->insert('dete_depreciationtemp',$tempDepArray);

					}

				}

			}

		}





		public function depr_calc_diminishing_balance_dep_partial($firstcall=false,$assid,$purrate,$purdate,$deprate,$prvyrsaccdep=false,$status=false,$strtdate=false,$curfiscalyrs)

		{

	// echo "test";

	// die();



			$purchase_date= explode('/', $purdate);

			$year=$purchase_date[0];

			$month=$purchase_date[1];

			$days=$purchase_date[2];

			$next_yrs=$year+1;

			$prev_yrs=$year-1;





			if($month>=4 && $month<=12)

			{

				$fyrs=substr($year, 1).'/'.substr($next_yrs,2);

			}

			elseif($month>=1 && $month<=3)

			{

				$fyrs=substr($prev_yrs,1).'/'.substr($year,2);

			}







			if($firstcall==true)

			{





				if($month>=4 && $month <=9)

				{

					$mnthrate=3/3;

				}

				if($month>=10 && $month <=12)

				{

					$mnthrate=2/3;

				}



				if($month>=1 && $month <=3)

				{

					$mnthrate=1/3;

				}

				// $mnthrate=1;

				$enddateplusOne=$year+0;

				$endatebs=$enddateplusOne.'/03/31';



				$dete_accmulateval=$purrate*($deprate)*$mnthrate;	

				$prev_yrs_acc_dep=0;

				$totaldeptilldateval=$dete_accmulateval+$prev_yrs_acc_dep;



				$netvalue=$purrate-$totaldeptilldateval;

				$prevyrsaccdep=$dete_accmulateval;

				$tempDepArray=array(

					'dete_assetid'=>$assid,

					'dete_purchasedatebs'=>$purdate,

					'dete_startdatebs'=>$purdate,

					'dete_orginalcost'=>$purrate,

					'dete_opbalance'=>$purrate,

					'dete_deprate'=>$deprate,

					'dete_fiscalyrs'=>$fyrs,

					'dete_accmulateval'=>$dete_accmulateval,

					'dete_accmulatdepprevyrs'=>$prev_yrs_acc_dep,

					'dete_totaldeptilldateval'=>$totaldeptilldateval,

					'dete_netvalue'=>$netvalue,

					'dete_enddatebs'=>$endatebs,

					'dete_methodid'=>5,

					'dete_locationid'=>$this->locationid,

					'dete_orgid'=>$this->org_id,

					'dete_postdatead'=>	CURDATE_EN,

					'dete_postdatebs'=>CURDATE_NP,

					'dete_posttime'=>$this->curtime,

					'dete_postby'=>$this->userid,

					'dete_postip'=>$this->postid,

					'dete_postmac'=>$this->postmac,

					'remarks'=>'First Call',

				);

				if(!empty($tempDepArray))

				{

					$this->db->insert('dete_depreciationtemp',$tempDepArray);

				}



				$this->depr_calc_diminishing_balance_dep_partial(false,$assid,$netvalue,$purdate,$deprate,$prevyrsaccdep,'go',$purdate,$curfiscalyrs);

			}

			else

			{

				$purchase_date= explode('/', $strtdate);

				$year=$purchase_date[0];

				$month=$purchase_date[1];

				$days=$purchase_date[2];



				if($month >='4' && $month <= '12')

				{

					$startyear=$year+1;

				}

				else

				{

					$startyear=$year;

				}



				$startdate=$startyear.'/04/01';	

				$endplusOne=($startyear)+1;

				$enddate=$endplusOne.'/03/31';



				$start_date= explode('/', $startdate);

				$year=$start_date[0];

				$month=$start_date[1];

				$days=$start_date[2];

				$next_yrs=$year+1;

				$prev_yrs=$year-1;



				if($month>=4 && $month<=12)

				{

					$fyrs=substr($year, 1).'/'.substr($next_yrs,2);

				}

				elseif($month>=1 && $month<=4)

				{

					$fyrs=substr($prev_yrs,1).'/'.substr($year,2);

				}



				$dete_accmulateval=$purrate*($deprate);	

				$prev_yrs_acc_dep=$dete_accmulateval;

				$totaldeptilldateval=$prvyrsaccdep+$prev_yrs_acc_dep;

				$netvalue=$purrate-$dete_accmulateval;



				$check_orginal_n_prevaccdep=$this->orginalcost-$prvyrsaccdep;





				$new_netval=round($netvalue,2);

				// echo "<br>".$new_netval;



				if((float)$new_netval=='0.00' || $curfiscalyrs==$fyrs)

				{

					$stus='stop';

				}

				else

				{

					$stus='go';

				}







				$tempDepArray=array(

					'dete_assetid'=>$assid,

					'dete_purchasedatebs'=>$purdate,

					'dete_startdatebs'=>$startdate,

					'dete_orginalcost'=>$this->orginalcost,

					'dete_opbalance'=>$purrate,

					'dete_deprate'=>$deprate,

					'dete_fiscalyrs'=>$fyrs,

					'dete_accmulateval'=>$dete_accmulateval,

					'dete_accmulatdepprevyrs'=>$prvyrsaccdep,

					'dete_totaldeptilldateval'=>$totaldeptilldateval,

					'dete_netvalue'=>$netvalue,

					'dete_enddatebs'=>$enddate,

					'dete_methodid'=>5,

					'dete_locationid'=>$this->locationid,

					'dete_orgid'=>$this->org_id,

					'dete_postdatead'=>	CURDATE_EN,

					'dete_postdatebs'=>CURDATE_NP,

					'dete_posttime'=>$this->curtime,

					'dete_postby'=>$this->userid,

					'dete_postip'=>$this->postid,

					'dete_postmac'=>$this->postmac,

					'remarks'=>'Running Execution'

				);

				

				if($stus=='go')

				{

					if(!empty($tempDepArray))

					{

						$this->db->insert('dete_depreciationtemp',$tempDepArray);

					}



					$this->depr_calc_diminishing_balance_dep_partial(false,$assid,$netvalue,$purdate,$deprate,$totaldeptilldateval,$stus,$startdate,$curfiscalyrs); 

				}

				else

				{

					// echo $stus;

					$new_netval=round($netvalue,2);

					if($netvalue=='0.00')

					{

						$remark='Write Off';

					}

					else

					{

						$remark='Execution Stop';

					}

					$tempDepArray=array(

						'dete_assetid'=>$assid,

						'dete_purchasedatebs'=>$purdate,

						'dete_startdatebs'=>$startdate,

						'dete_orginalcost'=>$this->orginalcost,

						'dete_opbalance'=>$purrate,

						'dete_deprate'=>$deprate,

						'dete_fiscalyrs'=>$fyrs,

						'dete_accmulateval'=>$dete_accmulateval,

						'dete_accmulatdepprevyrs'=>$prvyrsaccdep,

						'dete_totaldeptilldateval'=>$totaldeptilldateval,

						'dete_netvalue'=>$netvalue,

						'dete_enddatebs'=>$enddate,

						'dete_methodid'=>5,

						'dete_locationid'=>$this->locationid,

						'dete_orgid'=>$this->org_id,

						'dete_postdatead'=>	CURDATE_EN,

						'dete_postdatebs'=>CURDATE_NP,

						'dete_posttime'=>$this->curtime,

						'dete_postby'=>$this->userid,

						'dete_postip'=>$this->postid,

						'dete_postmac'=>$this->postmac,

						'remarks'=>$remark,

					);

					if(!empty($tempDepArray))

					{

						$this->db->insert('dete_depreciationtemp',$tempDepArray);

					}

				}

			}

		}

				// }

	public function get_depreciation_list($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)

	{

	    $this->db->select('*');

	    $this->db->from('dete_depreciationtemp');

	    //$this->db->join('coun_country c','c.coun_countryid=di.dist_countryid','left');



	    if($srchcol)

	    {

	       $this->db->where($srchcol); 

	    }



	   $qry=$this->db->get();

	    // echo $this->db->last_query();

	    // die();

	   if($qry->num_rows()>0)

	   {

	    return $qry->result();

	   }

	   return false;

	  }



	  public function get_fiscal_list($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)

	{

	    $this->db->select('*');

	    $this->db->distinct();

	    $this->db->from('fiye_fiscalyear');

	    //$this->db->join('coun_country c','c.coun_countryid=di.dist_countryid','left');



	    if($srchcol)

	    {

	       $this->db->where($srchcol); 

	    }



	   $qry=$this->db->get();

	    // echo $this->db->last_query();

	    // die();

	   if($qry->num_rows()>0)

	   {

	    return $qry->result();

	   }

	   return false;

	  }







	 public function remove_depreciation()

	{

		$id=$this->input->post('id');

		if($id)

		{

			$this->general->save_log($this->table,'dete_deteid',$id,$postdata=array(),'Delete');

			$this->db->delete($this->table,array('dete_deteid'=>$id));

			$rowaffected=$this->db->affected_rows();

			if($rowaffected)

			{

				return $rowaffected;

			}

			return false;

		}

		return false;

	}



public function get_dete_depreciation_list($cond = false)

	{

		$fiscal_year=$this->input->get('fiscal_year');

		$asset_type=$this->input->get('assettype');



		$get = $_GET;

 

      	foreach ($get as $key => $value) {

        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

      	}

     	if(!empty($get['sSearch_0'])){

            $this->db->where("dete_deteid like  '%".$get['sSearch_0']."%'  ");

        }



        if(!empty($get['sSearch_1'])){

            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%'  ");

        }



        if(!empty($get['sSearch_2'])){

            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");

        }



        if(!empty($get['sSearch_3'])){

            $this->db->where("dete_purchasedatebs like  '%".$get['sSearch_3']."%'  ");

        }



        if(!empty($get['sSearch_4'])){

            $this->db->where("dete_startdatebs like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("dete_orginalcost like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("dete_opbalance like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("dete_deprate like  '%".$get['sSearch_7']."%'  ");

        }

        if(!empty($get['sSearch_8'])){

            $this->db->where("dete_fiscalyrs like  '%".$get['sSearch_8']."%'  ");

        }

        if(!empty($get['sSearch_9'])){

            $this->db->where("dete_accmulateval like  '%".$get['sSearch_9']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("dete_accmulatdepprevyrs like  '%".$get['sSearch_10']."%'  ");

        }

        if(!empty($get['sSearch_11'])){

            $this->db->where("dete_totaldeptilldateval like  '%".$get['sSearch_11']."%'  ");

        }

        if(!empty($get['sSearch_12'])){

            $this->db->where("dete_netvalue like  '%".$get['sSearch_12']."%'  ");

        }

        

        if(!empty(($fiscal_year)))

        {

           

                $this->db->where('dete_fiscalyrs',$fiscal_year);           

        }



        if(!empty(($asset_type)))

        {

           

                $this->db->where('asen_assettype',$asset_type);           

        }

        

          if($cond) {

          $this->db->where($cond);

        }

      



        $resltrpt=$this->db->select("COUNT(*) as cnt")

  					->from('dete_depreciationtemp de')

  					->join('asen_assetentry ae','ae.asen_asenid= de.dete_assetid','left')

  					->join('itli_itemslist it','it.itli_itemlistid = ae.asen_description','left')

  					->get()

  					->row(); 

      	// echo $this->db->last_query();die(); 

      	$totalfilteredrecs=$resltrpt->cnt; 



      	$order_by = 'dete_deteid';

      	$order = 'asc';	

      	if($this->input->get('sSortDir_0'))

  		{

  				$order = $this->input->get('sSortDir_0');

  		}

  

      	$where='';

      	if($this->input->get('iSortCol_0')==0)

        	$order_by = 'dete_deteid';

      	else if($this->input->get('iSortCol_0')==1)

        	$order_by = 'dete_purchasedatebs';

      	else if($this->input->get('iSortCol_0')==2)

       		$order_by = 'dete_startdatebs';

       	else if($this->input->get('iSortCol_0')==3)

      	 	$order_by = 'dete_orginalcost';

      	else if($this->input->get('iSortCol_0')==4)

      	 	$order_by = 'dete_opbalance';

      	 else if($this->input->get('iSortCol_0')==5)

      	 	$order_by = 'dete_deprate';

      	 else if($this->input->get('iSortCol_0')==6)

      	 	$order_by = 'dete_fiscalyrs';

      	 else if($this->input->get('iSortCol_0')==7)

      	 	$order_by = 'dete_accmulateval';

      	 else if($this->input->get('iSortCol_0')==8)

      	 	$order_by = 'dete_accmulatdepprevyrs ';

      	 else if($this->input->get('iSortCol_0')==9)

         	$order_by = 'dete_totaldeptilldateval';

      	 else if($this->input->get('iSortCol_0')==10)

      	 	$order_by = 'dete_netvalue';

      	 else if($this->input->get('iSortCol_0')==11)

      	 	$order_by = 'dete_postdatead';

      	 else if($this->input->get('iSortCol_0')==12)

      	 	$order_by = 'dete_postdatebs';

      	 else if($this->input->get('iSortCol_0')==13)

      	 	$order_by = 'dete_posttime';

      	 else if($this->input->get('iSortCol_0')==14)

      	 	$order_by = 'dete_postip ';

      	 else if($this->input->get('iSortCol_0')==15)

      	 	$order_by = 'remarks ';

      	 

      	

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

        if(!empty($get['sSearch_0'])){

            $this->db->where("dete_deteid like  '%".$get['sSearch_0']."%'  ");

        }



        if(!empty($get['sSearch_1'])){

            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%'  ");

        }



        if(!empty($get['sSearch_2'])){

            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");

        }



        if(!empty($get['sSearch_3'])){

            $this->db->where("dete_purchasedatebs like  '%".$get['sSearch_3']."%'  ");

        }



        if(!empty($get['sSearch_4'])){

            $this->db->where("dete_startdatebs like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("dete_orginalcost like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("dete_opbalance like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("dete_deprate like  '%".$get['sSearch_7']."%'  ");

        }

        if(!empty($get['sSearch_8'])){

            $this->db->where("dete_fiscalyrs like  '%".$get['sSearch_8']."%'  ");

        }

        if(!empty($get['sSearch_9'])){

            $this->db->where("dete_accmulateval like  '%".$get['sSearch_9']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("dete_accmulatdepprevyrs like  '%".$get['sSearch_10']."%'  ");

        }

        if(!empty($get['sSearch_11'])){

            $this->db->where("dete_totaldeptilldateval like  '%".$get['sSearch_11']."%'  ");

        }

        if(!empty($get['sSearch_12'])){

            $this->db->where("dete_netvalue like  '%".$get['sSearch_12']."%'  ");

        }

       

       if(!empty(($fiscal_year)))

        {

           

                $this->db->where('dete_fiscalyrs',$fiscal_year);           

        }

         if(!empty(($asset_type)))

        {

           

                $this->db->where('asen_assettype',$asset_type);           

        }



        



        if($cond) {

          $this->db->where($cond);

        }



        $this->db->select('de.*, ae.asen_assetcode, it.itli_itemname');

	    $this->db->from('dete_depreciationtemp de');

	   	$this->db->join('asen_assetentry ae','ae.asen_asenid= de.dete_assetid','left');

	    $this->db->join('itli_itemslist it','it.itli_itemlistid = ae.asen_description','left');



        $this->db->order_by($order_by,$order);

	    // echo $this->db->last_query();die();

      



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

        if(!empty($_GET['iDisplayLength'])) {

          $totalrecs = sizeof( $nquery);

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







	  public function distinct_category()

  {

    $fiscal_year=$this->input->get('fiscal_year');

	$asset_type=$this->input->get('assettype');

  



          if(!empty(($fiscal_year)))

        {

           

                $this->db->where('dete_fiscalyrs',$fiscal_year);           

        }



        if(!empty(($asset_type)))

        {

           

                $this->db->where('asen_assettype',$asset_type);           

        }

        





     $data= $this->db->query('SELECT DISTINCT(asen_assettype) as asset_type, eqca_category FROM (

SELECT

	`de`.*, `ae`.`asen_assetcode`, `ae`.`asen_assettype`,eq.eqca_category,

	`it`.`itli_itemname`

FROM

	`xw_dete_depreciationtemp` `de`

LEFT JOIN `xw_asen_assetentry` `ae` ON `ae`.`asen_asenid` = `de`.`dete_assetid`

LEFT JOIN `xw_itli_itemslist` `it` ON `it`.`itli_itemlistid` = `ae`.`asen_description`

LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = ae.asen_assettype

ORDER BY

	`dete_deteid` ASC ) X') ->result();

   return $data;

  }







  	  public function get_deprecation_report($cat_id=false)

  {

    $fiscal_year=$this->input->get('fiscal_year');

	// $asset_type=$this->input->get('assettype');

	$asset_type= $cat_id;



	

	// echo $fiscal_year;

	// echo "Asset Type:";

	// echo $asset_type;

	// die();

	$cond='';

  



          if(!empty(($fiscal_year)))

        {

           $cond.=" dete_fiscalyrs ='$fiscal_year'";

                // $this->db->where('dete_fiscalyrs',$fiscal_year);           

        }



        if(empty($fiscal_year))

        {

        	$cond.=" asen_assettype ='$asset_type'";

        }

        else

        {

	        if(!empty(($asset_type)))

	        {

	           $cond.=" AND asen_assettype ='$asset_type'";

	                // $this->db->where('asen_assettype',$asset_type);           

	        }

	    }

        



     $data= $this->db->query('SELECT `de`.*, `ae`.`asen_assetcode`, `ae`.`asen_assettype`,

	`it`.`itli_itemname` FROM 	`xw_dete_depreciationtemp` `de`

	LEFT JOIN `xw_asen_assetentry` `ae` ON `ae`.`asen_asenid` = `de`.`dete_assetid`

	LEFT JOIN `xw_itli_itemslist` `it` ON `it`.`itli_itemlistid` = `ae`.`asen_description`

	LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = ae.asen_assettype where

	'.$cond.' ORDER BY `dete_deteid` ASC ') ->result();

   return $data;



  }

  public function distinct_category_list($srch=false,$limit=false,$offset=false,$order_by=false,$order=false)  

		{  

			$this->db->select('DISTINCT(ae.asen_assettype) asen_assettype, ec.eqca_category,ec.eqca_equipmentcategoryid');  

			$this->db->from('dete_depreciationtemp dt ');

			$this->db->join('asen_assetentry ae','ae.asen_asenid=dt.dete_assetid','left'); 

			$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','left');



			if($srch)

			{

				$this->db->where($srch); 

			}





			if($limit && $limit>0)

			{

				$this->db->limit($limit);

			}

			if($offset)

			{

				$this->db->offset($offset);

			}

			if($order_by)

			{

				$this->db->order_by($order_by,$order);

			}





			$qry=$this->db->get();

     // echo $this->db->last_query();

	    // die();



			if($qry->num_rows()>0)

			{

				return $qry->result();

			}

			return false;

		}



public function get_depreciation_list_data($srch=false,$limit=false,$offset=false,$order_by=false,$order=false)

		{

			$location=$this->input->post('locationname');

			$fiscal_year=$this->input->post('fiscal_year');

			$asen_assettype=$this->input->post('asen_assettype');

			$asen_asenid=$this->input->post('asen_asenid');



			$this->db->select('de.*, ae.asen_assetcode,ae.asen_assettype,ae.asen_description itli_itemname,ae.asen_desc,ec.eqca_category,ec.eqca_equipmentcategoryid');

			$this->db->from('dete_depreciationtemp de');

			$this->db->join('asen_assetentry ae','ae.asen_asenid= de.dete_assetid','left');

			$this->db->join('itli_itemslist it','it.itli_itemlistid = ae.asen_description','left');

			$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','left');



			if($srch)

			{

				$this->db->where($srch); 

			}

	  //    if(!empty($asen_assettype))

      //    	{

      //        $this->db->where('ae.asen_assettype',$asen_assettype);

     //    	}



		//  if(!empty($asen_asenid))

		// {

		// 	$this->db->where('ae.asen_asenid',$asen_asenid);

		// }

		//  if(!empty($location))

		// {

		// 	$this->db->where('ae.asen_locationid',$location);

		// }







			if($limit && $limit>0)

			{

				$this->db->limit($limit);

			}

			if($offset)

			{

				$this->db->offset($offset);

			}

			if($order_by)

			{

				$this->db->order_by($order_by,$order);

			}





			$qry=$this->db->get();

	    // echo $this->db->last_query();

	    // die();

			if($qry->num_rows()>0)

			{

				return $qry->result();

			}

			return false;

		}



		public function distinct_fiscalyear($srch=false,$limit=false,$offset=false,$order_by=false,$order=false)  

		{  

			$this->db->select('DISTINCT(dete_fiscalyrs)');  

			$this->db->from('xw_dete_depreciationtemp dt');





			if($srch)

			{

				$this->db->where($srch); 

			}



			if($limit && $limit>0)

			{

				$this->db->limit($limit);

			}

			if($offset)

			{

				$this->db->offset($offset);

			}

			if($order_by)

			{

				$this->db->order_by($order_by,$order);

			}





			$qry=$this->db->get();

     // echo $this->db->last_query();die();  

			if($qry->num_rows()>0)

			{

				return $qry->result();

			}

			return false;

		}



public function generate_diminishing_dep_report_main()

{

		$assettype=$this->input->post('asen_assettype');

		$locationid=$this->input->post('locationname');

		$depreciation=$this->input->post('asen_depreciation');

		// $depreciation=5;

		if(!empty($assettype))

		{

			$this->db->where(array('asen_assettype'=>$assettype));

		}

		if(!empty($locationid))

		{

			$this->db->where(array('asen_locationid'=>$locationid));

		}



		$subqry="(SELECT dete_deteid FROM xw_dete_depreciationtemp dt WHERE dt.dete_assetid=ae.asen_asenid ORDER BY dete_deteid DESC LIMIT 1) as dtid";

		$this->db->select("$subqry,ae.*,ec.eqca_deprate");

		$this->db->from('asen_assetentry ae');

		$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','INNER');

		$this->db->order_by('asen_asenid','ASC');

		// $this->db->limit(1);

		$query = $this->db->get();



		$data=$query->result();	

		// echo $this->db->last_query();

		// die();	

		// echo "<pre>";

		// print_r($data);

		// die();

		if(!empty($data))

			{

				$curfiscalyrs='076/77';

				foreach ($data as $kd => $ass) {

					$this->orginalcost=$ass->asen_purchaserate;

					if($depreciation==5)

					{



						$deptempid=$ass->dtid;

						if(!empty($deptempid)){

								$this->db->select("dt.*");

								$this->db->from('dete_depreciationtemp dt');

								$this->db->where('dete_deteid',$deptempid);

								$query = $this->db->get();

								$dresult=$query->row();	

								

								if(!empty($dresult)){

									$assetsid=$dresult->dete_assetid;

									$ass_purate=$dresult->dete_netvalue;

									$dep_start_date= $dresult->asen_depreciationstartdatebs;

									$ass_deprate= $dresult->dete_deprate;

									$prevyrsaccdep=$dresult->dete_accmulatdepprevyrs;

									$startdate=$dresult->dete_startdatebs;

									$last_fiscalyrs=$dresult->dete_fiscalyrs;

									if($last_fiscalyrs!=$curfiscalyrs && $last_fiscalyrs<$curfiscalyrs){

										$this->depr_calc_diminishing_balance_dep_main(false,$assetsid,$ass_purate,$dep_start_date,$ass_deprate,$prevyrsaccdep,'go',$startdate,$curfiscalyrs);

									}

									

									}

								}

								else{

								$assetsid=$ass->asen_asenid;

								$ass_purate=$ass->asen_purchaserate;

								$dep_start_date= $ass->asen_depreciationstartdatebs;

								$ass_deprate= $ass->eqca_deprate;

								$prevyrsaccdep=0;

								$startdate=$dep_start_date;

								$last_fiscalyrs='';

								$this->depr_calc_diminishing_balance_dep_main(true,$assetsid,$ass_purate,$dep_start_date,$ass_deprate,false,false,false,$curfiscalyrs);

						}

						

						

						// $this->depr_calc_diminishing_balance_dep_main(true,$assetsid,$ass_purate,$purchase_date,$ass_deprate,false,false,false,$curfiscalyrs);

						

					}

					if($depreciation==1){

						

					}

				}

			}

}



public function depr_calc_diminishing_balance_dep_main($firstcall=false,$assid,$purrate,$purdate,$deprate,$prvyrsaccdep=false,$status=false,$strtdate=false,$curfiscalyrs)

		{

	// echo "test";

	// die();



			$purchase_date= explode('/', $purdate);

			$year=$purchase_date[0];

			$month=$purchase_date[1];

			$days=$purchase_date[2];

			$next_yrs=$year+1;

			$prev_yrs=$year-1;





			if($month>=4 && $month<=12)

			{

				$fyrs=substr($year, 1).'/'.substr($next_yrs,2);

			}

			elseif($month>=1 && $month<=3)

			{

				$fyrs=substr($prev_yrs,1).'/'.substr($year,2);

			}







			if($firstcall==true)

			{





				if($month>=4 && $month <=9)

				{

					$mnthrate=3/3;

				}

				if($month>=10 && $month <=12)

				{

					$mnthrate=2/3;

				}



				if($month>=1 && $month <=3)

				{

					$mnthrate=1/3;

				}

				// $mnthrate=1;

				$enddateplusOne=$year+0;

				$endatebs=$enddateplusOne.'/03/31';



				$dete_accmulateval=$purrate*($deprate/100)*$mnthrate;	

				$prev_yrs_acc_dep=0;

				$totaldeptilldateval=$dete_accmulateval+$prev_yrs_acc_dep;



				$netvalue=$purrate-$totaldeptilldateval;

				$prevyrsaccdep=$dete_accmulateval;

				$prev_status=$this->check_previous_depreciation_fiscalyrs($assid,$fyrs);

				// echo $prev_status;

				// die();

				// echo $this->db->last_query();

				// die();

				if($prev_status==0){

					$tempDepArray=array(

					'dete_assetid'=>$assid,

					'dete_purchasedatebs'=>$purdate,

					'dete_startdatebs'=>$purdate,

					'dete_orginalcost'=>$purrate,

					'dete_opbalance'=>$purrate,

					'dete_deprate'=>$deprate,

					'dete_fiscalyrs'=>$fyrs,

					'dete_accmulateval'=>$dete_accmulateval,

					'dete_accmulatdepprevyrs'=>$prev_yrs_acc_dep,

					'dete_totaldeptilldateval'=>$totaldeptilldateval,

					'dete_netvalue'=>$netvalue,

					'dete_enddatebs'=>$endatebs,

					'dete_methodid'=>5,

					'dete_locationid'=>$this->locationid,

					'dete_orgid'=>$this->org_id,

					'dete_postdatead'=>	CURDATE_EN,

					'dete_postdatebs'=>CURDATE_NP,

					'dete_posttime'=>$this->curtime,

					'dete_postby'=>$this->userid,

					'dete_postip'=>$this->postid,

					'dete_postmac'=>$this->postmac,

					'remarks'=>'First Call',

				);

					if(!empty($tempDepArray))

					{

						$this->db->insert('dete_depreciationtemp',$tempDepArray);

					}

				}

				$this->depr_calc_diminishing_balance_dep_main(false,$assid,$netvalue,$purdate,$deprate,$prevyrsaccdep,'go',$purdate,$curfiscalyrs);

				

				

			}

			else

			{

				$purchase_date= explode('/', $strtdate);

				$year=$purchase_date[0];

				$month=$purchase_date[1];

				$days=$purchase_date[2];



				if($month >='4' && $month <= '12')

				{

					$startyear=$year+1;

				}

				else

				{

					$startyear=$year;

				}



				$startdate=$startyear.'/04/01';	

				$endplusOne=($startyear)+1;

				$enddate=$endplusOne.'/03/31';



				$start_date= explode('/', $startdate);

				$year=$start_date[0];

				$month=$start_date[1];

				$days=$start_date[2];

				$next_yrs=$year+1;

				$prev_yrs=$year-1;



				if($month>=4 && $month<=12)

				{

					$fyrs=substr($year, 1).'/'.substr($next_yrs,2);

				}

				elseif($month>=1 && $month<=4)

				{

					$fyrs=substr($prev_yrs,1).'/'.substr($year,2);

				}



				$dete_accmulateval=$purrate*($deprate/100);	

				$prev_yrs_acc_dep=$dete_accmulateval;

				$totaldeptilldateval=$prvyrsaccdep+$prev_yrs_acc_dep;

				$netvalue=$purrate-$dete_accmulateval;



				$check_orginal_n_prevaccdep=$this->orginalcost-$prvyrsaccdep;





				$new_netval=round($netvalue,2);

				// echo "<br>".$new_netval;



				if((float)$new_netval=='0.00' || $curfiscalyrs==$fyrs)

				{

					$stus='stop';

				}

				else

				{

					$stus='go';

				}







				$tempDepArray=array(

					'dete_assetid'=>$assid,

					'dete_purchasedatebs'=>$purdate,

					'dete_startdatebs'=>$startdate,

					'dete_orginalcost'=>$this->orginalcost,

					'dete_opbalance'=>$purrate,

					'dete_deprate'=>$deprate,

					'dete_fiscalyrs'=>$fyrs,

					'dete_accmulateval'=>$dete_accmulateval,

					'dete_accmulatdepprevyrs'=>$prvyrsaccdep,

					'dete_totaldeptilldateval'=>$totaldeptilldateval,

					'dete_netvalue'=>$netvalue,

					'dete_enddatebs'=>$enddate,

					'dete_methodid'=>5,

					'dete_locationid'=>$this->locationid,

					'dete_orgid'=>$this->org_id,

					'dete_postdatead'=>	CURDATE_EN,

					'dete_postdatebs'=>CURDATE_NP,

					'dete_posttime'=>$this->curtime,

					'dete_postby'=>$this->userid,

					'dete_postip'=>$this->postid,

					'dete_postmac'=>$this->postmac,

					'remarks'=>'Running Execution'

				);

				

				if($stus=='go')

				{

					$prev_status=$this->check_previous_depreciation_fiscalyrs($assid,$fyrs);

				// echo $prev_status;

				// die();

				if($prev_status==0){

					if(!empty($tempDepArray)){

						$this->db->insert('dete_depreciationtemp',$tempDepArray);

					}



				$this->depr_calc_diminishing_balance_dep_main(false,$assid,$netvalue,$purdate,$deprate,$totaldeptilldateval,$stus,$startdate,$curfiscalyrs); 

				}

			}

				else

				{

					// echo $stus;

					$new_netval=round($netvalue,2);

					if($netvalue=='0.00')

					{

						$remark='Write Off';

					}

					else

					{

						$remark='Execution Stop';

					}

					$tempDepArray=array(

						'dete_assetid'=>$assid,

						'dete_purchasedatebs'=>$purdate,

						'dete_startdatebs'=>$startdate,

						'dete_orginalcost'=>$this->orginalcost,

						'dete_opbalance'=>$purrate,

						'dete_deprate'=>$deprate,

						'dete_fiscalyrs'=>$fyrs,

						'dete_accmulateval'=>$dete_accmulateval,

						'dete_accmulatdepprevyrs'=>$prvyrsaccdep,

						'dete_totaldeptilldateval'=>$totaldeptilldateval,

						'dete_netvalue'=>$netvalue,

						'dete_enddatebs'=>$enddate,

						'dete_methodid'=>5,

						'dete_locationid'=>$this->locationid,

						'dete_orgid'=>$this->org_id,

						'dete_postdatead'=>	CURDATE_EN,

						'dete_postdatebs'=>CURDATE_NP,

						'dete_posttime'=>$this->curtime,

						'dete_postby'=>$this->userid,

						'dete_postip'=>$this->postid,

						'dete_postmac'=>$this->postmac,

						'remarks'=>$remark,

					);

					$prev_status=$this->check_previous_depreciation_fiscalyrs($assid,$fyrs);

					if($prev_status==0){

						if(!empty($tempDepArray))

						{

							$this->db->insert('dete_depreciationtemp',$tempDepArray);

						}

					}

					

				}

			}

		}





	public function check_previous_depreciation_fiscalyrs($assid,$fyrs){

		$this->db->select('*');

		$this->db->from('dete_depreciationtemp');

		$this->db->where(array('dete_assetid'=>$assid,'dete_fiscalyrs'=>$fyrs));

		$result=$this->db->get()->result();

		if($result){

			return 1;

		}

		return 0;

	}



	public function get_fiscalyrs_ass_cat_with_summary(){

		$fiscal_year=!empty($this->input->post('fiscal_year'))?$this->input->post('fiscal_year'):'';

		if(!empty($fiscal_year)){

			$this->db->where('dt.dete_fiscalyrs',$fiscal_year);

		}

		$assettype=!empty($this->input->post('asen_assettype'))?$this->input->post('asen_assettype'):'';

		if(!empty($assettype)){

			$this->db->where('ae.asen_assettype',$assettype);

		}



		$this->db->select('asen_assettype, ec.eqca_category,

						SUM(dete_opbalance) as openbalance,

						SUM(dete_accmulateval) as accmulateval,

						SUM(dete_accmulatdepprevyrs) as accmulatdepprevyrs,

						SUM(dete_totaldeptilldateval) as totaldeptilldateval,

						SUM(dete_netvalue) as netvalue');

		$this->db->from('asen_assetentry ae');

		$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','INNER');

		$this->db->join('dete_depreciationtemp dt','dt.dete_assetid=ae.asen_asenid','INNER');

		$this->db->group_by('asen_assettype');

		$this->db->order_by('ec.eqca_category','ASC');





		$result=$this->db->get()->result();

		if($result){

			return $result;

		}

		return 0;

	}





	public function get_fiscalyrs_ass_cat_with_detail($fiscal_year,$assettypeid,$assetsid=false){

	

		if(!empty($fiscal_year)){

			$this->db->where('dt.dete_fiscalyrs',$fiscal_year);

		}

		if(!empty($assettypeid)){

			$this->db->where('ae.asen_assettype',$assettypeid);

		}



		if(!empty($assetsid)){

			$this->db->where('ae.asen_asenid',$assetsid);

		}



		$this->db->select('asen_description,asen_desc,dt.dete_orginalcost rate,COUNT("*") as qty, dt.dete_purchasedatebs,dete_fiscalyrs,dete_deprate,

			SUM(dt.dete_orginalcost) as orginalcost,

			SUM(dete_opbalance) as openbalance,

			SUM(dete_accmulateval) as accmulateval,

			SUM(dete_accmulatdepprevyrs) as accmulatdepprevyrs,

			SUM(dete_totaldeptilldateval) as totaldeptilldateval,

			SUM(dete_netvalue) as netvalue');

		$this->db->from('asen_assetentry ae');

		$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','INNER');

		$this->db->join('dete_depreciationtemp dt','dt.dete_assetid=ae.asen_asenid','INNER');

		$this->db->group_by('asen_description,dt.dete_orginalcost,dt.dete_purchasedatebs,dete_fiscalyrs');

		$this->db->order_by('ae.asen_asenid','ASC');





		$result=$this->db->get()->result();

		if($result){

			return $result;

		}

		return 0;

	}


public function generate_diminishing_dep_report_main_ku()
{

		$assettype=$this->input->post('asen_assettype');

		$locationid=$this->input->post('locationname');

		$depreciation=$this->input->post('asen_depreciation');

		// $depreciation=5;

		if(!empty($assettype))

		{

			$this->db->where(array('asen_assettype'=>$assettype));

		}

		if(!empty($locationid))

		{

			$this->db->where(array('asen_locationid'=>$locationid));

		}



		$subqry="(SELECT dete_deteid FROM xw_dete_depreciationtemp dt WHERE dt.dete_assetid=ae.asen_asenid ORDER BY dete_deteid DESC LIMIT 1) as dtid";

		$this->db->select("$subqry,ae.*,ec.eqca_deprate");

		$this->db->from('asen_assetentry ae');

		$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','INNER');

		$this->db->order_by('asen_asenid','ASC');

		// $this->db->limit(1);

		$query = $this->db->get();



		$data=$query->result();	

		// echo $this->db->last_query();

		// die();	

		// echo "<pre>";

		// print_r($data);

		// die();

		if(!empty($data))

			{

				$curfiscalyrs='077/78';

				foreach ($data as $kd => $ass) {

					$this->orginalcost=$ass->asen_purchaserate;

					if($depreciation==5)

					{



						$deptempid=$ass->dtid;

						if(!empty($deptempid)){

								$this->db->select("dt.*");

								$this->db->from('dete_depreciationtemp dt');

								$this->db->where('dete_deteid',$deptempid);

								$query = $this->db->get();

								$dresult=$query->row();	

								

								if(!empty($dresult)){

									$assetsid=$dresult->dete_assetid;

									$ass_purate=$dresult->dete_netvalue;

									$dep_start_date= $dresult->asen_depreciationstartdatebs;

									$ass_deprate= $dresult->dete_deprate;

									$prevyrsaccdep=$dresult->dete_accmulatdepprevyrs;

									$startdate=$dresult->dete_startdatebs;

									$last_fiscalyrs=$dresult->dete_fiscalyrs;

									if($last_fiscalyrs!=$curfiscalyrs && $last_fiscalyrs<$curfiscalyrs){

									$this->depr_calc_diminishing_balance_dep_main_ku(false,$assetsid,$ass_purate,$dep_start_date,$ass_deprate,$prevyrsaccdep,'go',$startdate,$curfiscalyrs);

									}

									

									}

								}

								else{

								$assetsid=$ass->asen_asenid;

								$ass_purate=$ass->asen_purchaserate;

								$dep_start_date= $ass->asen_depreciationstartdatebs;

								$ass_deprate= $ass->eqca_deprate;

								$prevyrsaccdep=0;

								$startdate=$dep_start_date;

								$last_fiscalyrs='';

								$this->depr_calc_diminishing_balance_dep_main_ku(true,$assetsid,$ass_purate,$dep_start_date,$ass_deprate,false,false,false,$curfiscalyrs);

						}

						

						

						// $this->depr_calc_diminishing_balance_dep_main(true,$assetsid,$ass_purate,$purchase_date,$ass_deprate,false,false,false,$curfiscalyrs);

						

					}

					if($depreciation==1){

						

					}

				}

			}

}


public function depr_calc_diminishing_balance_dep_main_ku($firstcall=false,$assid,$purrate,$purdate,$deprate,$prvyrsaccdep=false,$status=false,$strtdate=false,$curfiscalyrs)

		{

	// echo $purdate;

	// die();



			$purchase_date= explode('/', $purdate);

			$year=$purchase_date[0];

			$month=$purchase_date[1];

			$days=$purchase_date[2];

			$next_yrs=$year+1;

			$prev_yrs=$year-1;





			if($month>=4 && $month<=12)

			{

				$fyrs=substr($year, 1).'/'.substr($next_yrs,2);

			}

			elseif($month>=1 && $month<=3)

			{

				$fyrs=substr($prev_yrs,1).'/'.substr($year,2);

			}







			if($firstcall==true)

			{





				// if($month>=4 && $month <=9)

				// {

				// 	$mnthrate=3/3;

				// }

				// if($month>=10 && $month <=12)

				// {

				// 	$mnthrate=2/3;

				// }



				// if($month>=1 && $month <=3)

				// {

					$mnthrate=1/3;

				// }

				// $mnthrate=1;

				$enddateplusOne=$year+0;

				$endatebs=$enddateplusOne.'/09/30';



				$dete_accmulateval=$purrate*($deprate/100)*$mnthrate;	

				$prev_yrs_acc_dep=0;

				$totaldeptilldateval=$dete_accmulateval+$prev_yrs_acc_dep;



				$netvalue=$purrate-$totaldeptilldateval;

				$prevyrsaccdep=$dete_accmulateval;

				$prev_status=$this->check_previous_depreciation_fiscalyrs($assid,$fyrs);

				// echo $prev_status;

				// die();

				// echo $this->db->last_query();

				// die();

				if($prev_status==0){

					$tempDepArray=array(

					'dete_assetid'=>$assid,

					'dete_purchasedatebs'=>$purdate,

					'dete_startdatebs'=>$purdate,

					'dete_orginalcost'=>$purrate,

					'dete_opbalance'=>$purrate,

					'dete_deprate'=>$deprate,

					'dete_fiscalyrs'=>$fyrs,

					'dete_accmulateval'=>$dete_accmulateval,

					'dete_accmulatdepprevyrs'=>$prev_yrs_acc_dep,

					'dete_totaldeptilldateval'=>$totaldeptilldateval,

					'dete_netvalue'=>$netvalue,

					'dete_enddatebs'=>$endatebs,

					'dete_methodid'=>5,

					'dete_locationid'=>$this->locationid,

					'dete_orgid'=>$this->org_id,

					'dete_postdatead'=>	CURDATE_EN,

					'dete_postdatebs'=>CURDATE_NP,

					'dete_posttime'=>$this->curtime,

					'dete_postby'=>$this->userid,

					'dete_postip'=>$this->postid,

					'dete_postmac'=>$this->postmac,

					'remarks'=>'First Call',

				);

					if(!empty($tempDepArray))

					{

						$this->db->insert('dete_depreciationtemp',$tempDepArray);

					}

				}

				$this->depr_calc_diminishing_balance_dep_main_ku(false,$assid,$netvalue,$purdate,$deprate,$prevyrsaccdep,'go',$purdate,$curfiscalyrs);

				

				

			}

			else

			{

				$purchase_date= explode('/', $strtdate);

				$year=$purchase_date[0];

				$month=$purchase_date[1];

				$days=$purchase_date[2];



				if($month >='4' && $month <= '12')

				{

					$startyear=$year+1;

				}

				else

				{

					$startyear=$year;

				}



				$startdate=$startyear.'/10/01';	

				$endplusOne=($startyear)+1;

				$enddate=$endplusOne.'/09/30';



				$start_date= explode('/', $startdate);

				$year=$start_date[0];

				$month=$start_date[1];

				$days=$start_date[2];

				$next_yrs=$year+1;

				$prev_yrs=$year-1;



				if($month>=4 && $month<=12)

				{

					$fyrs=substr($year, 1).'/'.substr($next_yrs,2);

				}

				elseif($month>=1 && $month<=4)

				{

					$fyrs=substr($prev_yrs,1).'/'.substr($year,2);

				}



				$dete_accmulateval=$purrate*($deprate/100);	

				$prev_yrs_acc_dep=$dete_accmulateval;

				$totaldeptilldateval=$prvyrsaccdep+$prev_yrs_acc_dep;

				$netvalue=$purrate-$dete_accmulateval;



				$check_orginal_n_prevaccdep=$this->orginalcost-$prvyrsaccdep;





				$new_netval=round($netvalue,2);

				// echo "<br>".$new_netval;



				if((float)$new_netval=='0.00' || $curfiscalyrs==$fyrs)

				{

					$stus='stop';

				}

				else

				{

					$stus='go';

				}







				$tempDepArray=array(

					'dete_assetid'=>$assid,

					'dete_purchasedatebs'=>$purdate,

					'dete_startdatebs'=>$startdate,

					'dete_orginalcost'=>$this->orginalcost,

					'dete_opbalance'=>$purrate,

					'dete_deprate'=>$deprate,

					'dete_fiscalyrs'=>$fyrs,

					'dete_accmulateval'=>$dete_accmulateval,

					'dete_accmulatdepprevyrs'=>$prvyrsaccdep,

					'dete_totaldeptilldateval'=>$totaldeptilldateval,

					'dete_netvalue'=>$netvalue,

					'dete_enddatebs'=>$enddate,

					'dete_methodid'=>5,

					'dete_locationid'=>$this->locationid,

					'dete_orgid'=>$this->org_id,

					'dete_postdatead'=>	CURDATE_EN,

					'dete_postdatebs'=>CURDATE_NP,

					'dete_posttime'=>$this->curtime,

					'dete_postby'=>$this->userid,

					'dete_postip'=>$this->postid,

					'dete_postmac'=>$this->postmac,

					'remarks'=>'Running Execution'

				);

				

				if($stus=='go')

				{

					$prev_status=$this->check_previous_depreciation_fiscalyrs($assid,$fyrs);

				// echo $prev_status;

				// die();

				if($prev_status==0){

					if(!empty($tempDepArray)){

						$this->db->insert('dete_depreciationtemp',$tempDepArray);

					}



				$this->depr_calc_diminishing_balance_dep_main_ku(false,$assid,$netvalue,$purdate,$deprate,$totaldeptilldateval,$stus,$startdate,$curfiscalyrs); 

				}

			}

				else

				{

					// echo $stus;

					$new_netval=round($netvalue,2);

					if($netvalue=='0.00')

					{

						$remark='Write Off';

					}

					else

					{

						$remark='Execution Stop';

					}

					$tempDepArray=array(

						'dete_assetid'=>$assid,

						'dete_purchasedatebs'=>$purdate,

						'dete_startdatebs'=>$startdate,

						'dete_orginalcost'=>$this->orginalcost,

						'dete_opbalance'=>$purrate,

						'dete_deprate'=>$deprate,

						'dete_fiscalyrs'=>$fyrs,

						'dete_accmulateval'=>$dete_accmulateval,

						'dete_accmulatdepprevyrs'=>$prvyrsaccdep,

						'dete_totaldeptilldateval'=>$totaldeptilldateval,

						'dete_netvalue'=>$netvalue,

						'dete_enddatebs'=>$enddate,

						'dete_methodid'=>5,

						'dete_locationid'=>$this->locationid,

						'dete_orgid'=>$this->org_id,

						'dete_postdatead'=>	CURDATE_EN,

						'dete_postdatebs'=>CURDATE_NP,

						'dete_posttime'=>$this->curtime,

						'dete_postby'=>$this->userid,

						'dete_postip'=>$this->postid,

						'dete_postmac'=>$this->postmac,

						'remarks'=>$remark,

					);

					$prev_status=$this->check_previous_depreciation_fiscalyrs($assid,$fyrs);

					if($prev_status==0){

						if(!empty($tempDepArray))

						{

							$this->db->insert('dete_depreciationtemp',$tempDepArray);

						}

					}

					

				}

			}

		}




}