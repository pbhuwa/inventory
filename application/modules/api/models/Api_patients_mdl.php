<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_patients_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->db2=$this->load->database('dbothers',true);
		// $this->db3=$this->load->database('dbpharmacy',true);
		// echo "<pre>";
		// print_r($this->db3);
		// die();
	}

	function getpatientfromotherdb()
	{
		// print_r($this->db2);
		// die();
		$this->db2->select(
			'PATIENTID 		as pama_patientid,            
		  NONPATIENTID 		as pama_nonpatientid,        
		  TITLE 			as pama_title,               
		  FNAME 			as pama_fname,               
		  MNAME 			as pama_mname,               
		  LNAME 			as pama_lname,               
		  PATIENTNAME 		as pama_patientname,         
		  GENDER 			as pama_gender,              
		  AGE    			as pama_age,              
		  AGETYPE 			as pama_agetype,             
		  DOBVS   			as pama_dobbs,
		  DOBAD   			as pama_dobad,               
		  MARITALSTATUS 	as pama_maritalstatus,        
		  COUNTRYID  		as pama_countryid,           
		  ZONEID     		as pama_zoneid,           
		  DISTRICTID   		as pama_districtid,         
		  VDCID      		as pama_vdcid,           
		  WARDNO       		as pama_wardno,         
		  ADDRESS      		as pama_address,         
		  PHONENO      		as pama_phoneno,         
		  MOBILENO     		as pama_mobileno,         
		  EMAIL       		as pama_email,         
		  COMPANY        	as pama_company,       
		  EDUCATIONID    	as pama_educationid,       
		  OCCUPATIONID     	as pama_occupationid,     
		  PATIENTTYPE    	as pama_patienttype,       
		  NEXTTOKIN       	as pama_nexttokin,      
		  RELATIONID      	as pama_relationid,      
		  CARDNO            as pama_cardno,    
		  REMARKS        	as pama_remarks,      
		  REGDATE           as pama_regdate,    
		  REGTIME          	as pama_regtime,    
		  DATAPOSTDATE      as pama_postdate ,   
		  DATAPOSTTIME     	as pama_posttime  ,   
		  DATAPOSTBY        as pama_postby,    
		  MACID             as pama_macid,   
		  RELIGIONID       	as pama_religionid,     
		  VISITCOUNT        as pama_visitcount,  
		  PINNO             as pama_pinno,  
		  ISPARTY           as pama_isparty, 
		  BLOODGROUP        as pama_bloodgroup, 
		  FILENO             as pama_fileno, 
		  PATIENTCATEGORYNAME as pama_patientcategoryname, 
		  GPHONENO           as pama_gphoneno, 
		  COMMUNITYID        as pama_communityid, 
		  SCHEMEID           as pama_schemeid  ');
		$this->db2->order_by('PATIENTID','ASC');
		$this->db2->limit(43517);
		$query=$this->db2->get('PATIENTMAIN');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

	public function getpatientvisitfromotherdb()
	{
			$this->db2->select(
			 'VISITID            as pavi_visitid,  
			  PATIENTID         as pavi_patientid,  
			  NONPATIENTID      as pavi_nonpatientid,  
			  VISITDATE         as  pavi_visitdate, 
			  VISITTIME         as  pavi_visittime ,
			  APPOINTMENTTIME   as  pavi_appointmenttime,
			  DOCVISITTIME     as   pavi_docvisittime ,
			  SVRCOMPLETETIME  as   pavi_svrcompletetime,
			  DEPCODE          as   pavi_depcode,
			  DEPID            as   pavi_depid,
			  SUBDEP           as   pavi_subdep,
			  SUBDEPID         as   pavi_subdepid,
			  DOCCODE          as   pavi_doccode,
			  DOCID            as   pavi_docid,
			  DUTYDOCCODE      as   pavi_dutydoccode,
			  DUTYDOCID        as   pavi_dutydocid,
			  PATIENTFROM      as   pavi_patientfrom,
			  REFDEPID         as   pavi_refdepid,
			  REFBYID          as   pavi_refbyid,
			  REFHOSID         as   pavi_refhosid,
			  REMARKS          as   pavi_remarks,
			  SCHEMEID         as   pavi_schemeid,
			  COMMUNITYID      as   pavi_communityid,
			  VISITSTATUS      as   pavi_visitstatus,
			  PATIENTTYPE      as   pavi_patienttype,
			  BILLINGSTATUS    as   pavi_billingstatus,
			  VISITTYPE        as   pavi_visittype,
			  CHECKUPSTATUS    as   pavi_checkupstatus,
			  DATAPOSTDATE     as   pavi_datapostdate,
			  DATAPOSTTIME     as   pavi_dataposttime,
			  DATAPOSTBY       as   pavi_datapostby,
			  MACID            as   pavi_macid,
			  VISITCOUNT       as   pavi_visitcount,
			  REFBYTYPE        as   pavi_refbytype,
			  ISVISITCANCEL    as   pavi_isvisitcancel,
			  VISITCATEGORY    as   pavi_visitcategory');
			$this->db2->where('VISITID>136448 and VISITID < 236448');
		$this->db2->order_by('VISITID','ASC');
		$this->db2->limit(195000);
		// $this->db2->offset(95000);
		$query=$this->db2->get('PATIENTVISIT');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	}
	



	public function get_countryfromotherdb()
	{
		$this->db2->select(
				'COUNTRYID   as coun_countryid,
			  COUNTRYCODE  as coun_countrycode,
			  COUNTRYNAME  as coun_countryname,
			  DISCOUNT  as coun_discount'
			);
		$query=$this->db2->get('COUNTRY');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}


	public function get_zonefromotherdb()
	{
		$this->db2->select(
				'ZONEID  as zona_zoneid,
  				ZONENAME  as zona_zonename');
		$query=$this->db2->get('ZONE');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}



	public function get_districtfromotherdb()
	{
		$this->db2->select('
			  DISTRICTID   as dist_districtid,
			  ZONEID as dist_zoneid,   
			  DISTRICTNAME as dist_districtname
			');
		$query=$this->db2->get('DISTRICT');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}


	public function get_relationfromotherdb()
	{
		$this->db2->select('RELATIONID  as rela_relationid,RELATION   as  rela_relation');
		$query=$this->db2->get('RELATION');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}


	public function get_occupationfromotherdb()
	{
		$this->db2->select('
			OCCUPATIONID  as occu_occupationid,
			OCCUPATIONNAME  as occu_occupationname');
		$query=$this->db2->get('OCCUPATION');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

	
	public function get_nurse_triage_fromotherdb()
	{
		$this->db2->select('
			  TRIAGEID                as nutr_triageid ,             
			  VISITID                 as nutr_visitid ,            
			  PATIENTID               as nutr_patientid,          
			  inpatientid             as nutr_inpatientid          
			  physicalfindingdate     as nutr_phyfindingdatead,   
			  physicalfindingtime     as nutr_phyfindingtime,      
			  temperature             as nutr_temp,
			  pulse                   as nutr_pulse,
			  respiration             as nutr_resp,
			  oxygensaturation        as nutr_oxysat,
			  bp                      as nutr_bp,
			  height                  as nutr_height,
			  weight                  as nutr_weight,
			  headcircumference       as nutr_headcirc,
			  datapostby              as nutr_postby,
			  datapostdate            as nutr_postdatead,
			  dataposttime            as nutr_posttime,
			  bmi                     as nutr_bmi,
			  whratio                 as nutr_whratio,
			  avggeneticheight        as nutr_avggeneticheight,
			  waist                   as nutr_waist,
			  hip                     as nutr_hip,
			  motherheight            as nutr_moheight,
			  fatherheight            as nutr_faheight,
			  modifyby                as nutr_modifyby,
			  modifydate              as nutr_modifydatead,
			  modifytime              as nutr_modifytime,
			  modifymacid             as nutr_modifymacid,
			  macid                   as nutr_postmac,
  			  isatthetimeofadmission  as nutr_isatthetimeofadmission');
		$query=$this->db2->get('NURSETRIAGE');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}


	public function get_testnamefromotherdb()
	{
		$this->db2->select('
			  TESTNAMEID              as  tsna_testnameid,        
  TESTNAMECODE            as  tsna_testnamecode,
  DEPID                   as  tsna_depid,
  TESTNAME                as  tsna_testname,
  TESTPRICE               as  tsna_testprice,
  VAT                     as  tsna_vat,
  ISVATABLE               as  tsna_isvatable,
  ISEDITABLE              as tsna_iseditable,             
  ISACTIVE                as tsna_isactive,
  ISOT                    as tsna_isot,
  TESTPRICEFOREIGNER      as tsna_testpriceforeigner,
  TNCATEGORYCODE          as tsna_tncategorycode,
  ISDISCOUNTABLE          as tsna_isdiscountable,
  REMARKS                 as tsna_remarks,
  TAXFRG                  as tsna_taxfrg,
  ISPACKAGETEST           as tsna_ispackagetest,
  ISFRACTIONABLEITEM      as tsna_isfractionableitem,
  DATAPOSTBY              as tsna_postby,
  DATAPOSTDATE            as tsna_postdatead,
  DATAPOSTTIME            as tsna_posttime,
  WORKLIST                as tsna_worklist,
  SAMPLESOURCEID          as tsna_samplesourceid,
  DISPLAYORDER            as tsna_displayorder,
  HIDETESTINPATIENTLIST   as tsna_hidetestinpatientlist,
  TESTTYPE                as tsna_testtype,
  ISCHARGEWITHSVRTAX      as tsna_ischargewithsvrtax,
  CPTCODE                 as tsna_cptcode');
		$this->db2->order_by('TESTNAMEID','ASC');
		$query=$this->db2->get('TESTNAME');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}


	public function get_itemlistfromotherdb()
	{
		$this->db2->select('
		 ITEMSID  				as   itli_itemsid ,              
		  ITEMSNAME            	as   itli_itemsname,
		  ACHEAD                as   itli_achead,
		  ATSTOCK               as	 itli_atstock, 
		  CURRENTLANDINGPRICE   as	 itli_currentlandingprice,
		  REORDERLEVEL          as	 itli_reorderlevel	,
		  LOSSQTY               as	 itli_lossqty        ,         
		  CATEGORYID            as	 itli_categoryid   ,
		  PACKAGING             as	 itli_packaging  ,
		  SALEABLE              as   itli_saleable,
		  OTHERS                as	 itli_others,
		  BRANDID               as	 itli_brandid,
		  PARTNO                as	 itli_partno,
		  ITEMSCODE             as	 itli_itemscode,
		  TYPEID                as	 itli_typeid	,
		  CATID                 as	 itli_catid	,
		  SUBCATID              as	 itli_subcatid,
		  TYPEAID               as   itli_typeaid,
		  GSM                   as   itli_gsm,
		  LENTH                 as   itli_lenth,
		  BREATH                as   itli_breath,
		  UNITID                as   itli_unitid,
		  COLORID               as	 itli_colorid,
		  GSMUNITID             as	 itli_gsmunitid,
		  SUBSTRATE             as	 itli_substrate,
		  SALERATE              as	 itli_salerate,	
		  STOCK                 as	 itli_stock	,
		  PERCENT1              as 	 itli_percent1,
		  PURCHASERATE          as	 itli_purchaserate,
		  TAXABLE               as	 itli_taxable,
		  TSALERATE             as 	 itli_tsalerate,		
		  ACTIVE                as	 itli_active,
		  REORD1                as	 itli_reord1,
		  REORD2               	as 	 itli_reord2,		
		  MAXLIMIT              as	 itli_maxlimit,
		  MAXLIMIT1             as	 itli_maxlimit1,
		  MAXLIMIT2             as	 itli_maxlimit2,
		  MOVINGTYPE            as	 itli_movingtype,
		  VALUETYPE             as	 itli_valuetype,
		  MFGID                 as	 itli_mfgid,
		  LOCATION              as	 itli_location,
		  DRUGCATEGORYID        as	 itli_drugcategoryid,
		  SYSTEMCLASSIFICATIONID as	 itli_systemclassificationid,
		  LOCATIONIP             as	 itli_locationip,
		  LOCATIONOP             as	 itli_locationop,
		  VEDID                  as  itli_vedid, 	 
		  ABCCLASS               as  itli_abcclass, 	 
		  COUNTRYID              as  itli_countryid,
		  CCPCT                  as  itli_ccpct,
		  REMARKS                as  itli_remarks');
		$this->db2->order_by('ITEMSID','ASC');
		$query=$this->db2->get('ITEMSLIST');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

public function get_genericlistfromotherdb()
	{
		$this->db2->select('
			TYPEAID as gena_typeaid ,  
			SUBCATID as gena_subcatid,  
			TYPEANAME as gena_typeaname , 
			TYPEACODE as gena_typeacode  ,
			REORD1 as gena_reord1     ,
			REORD2 as gena_reord2     ,
			REORD3 as gena_reord3     ,
			MAXLIMIT1 as gena_maxlimit1,  
			MAXLIMIT2 as gena_maxlimit2 , 
			MAXLIMIT3 as gena_maxlimit3  
		');
		$this->db2->order_by('TYPEAID','ASC');
		$query=$this->db2->get('GENERICNAME');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

	public function getdepnamefromotherdb()
	{
		$this->db2->select('
		  DEPCODE as dept_depcode ,                  
		  DEPNAME as dept_depname ,                  
		  DEPORDER as dept_deporder,                
		  PARENTDEPID as dept_parentdepid,            
		  REPORTTITLE as dept_reporttitle ');
		$this->db2->order_by('DEPID','ASC');
		$query=$this->db2->get('DEPARTMENT');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	 }   

	 //doctor template

	 public function getcomplainfromotherdb()
	 {
		$this->db2->select('
	 		COMPLAINDETAILID as code_complaindetailid,
	 		VISITID as code_visitid,
	 		PATIENTID as code_patientid,
	 		INPATIENTID as code_inpatientid,
	 		COMPLAINDATE as code_complaindatead,
	 		COMPLAIN as code_complain,
	 		ENTRYBY as code_entryby,
	 		DURATION as code_duration,
	 		ISACTIVECOMPLAIN as code_isactivecomplain,
	 		DATAPOSTBY as code_postby,
	 		DATAPOSTDATE as code_postdatead,
	 		DATAPOSTTIME as code_posttime,
	 		MACID as code_postmac,
	 		MODIFYBY as code_modifyby,
	 		MODIFYDATE as code_modifydatead,
	 		MODIFYTIME as code_modifytime,
	 		MODIFYMACID as code_modifymac'
	 	);
		$this->db2->order_by('COMPLAINDETAILID','ASC');
		$query=$this->db2->get('COMPLAINDETAIL');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	 }

	 public function gethistoryfromotherdb()
	 {
	 	$this->db2->select('
			  HISTORYDETAILID	 as hide_historydetailid,    
			  VISITID         as hide_visitid 
			  PATIENTID        as hide_patientid,
			  INPATIENTID      as hide_inpatientid,
			  HISTORY          as hide_history,
			  ISACTIVEHISTORY  as hide_isactivehistory,
			  DATAPOSTBY       as hide_postby,
			  DATAPOSTDATE     as hide_postdatead,
			  DATAPOSTTIME     as hide_posttime,     
			  MODIFYDATE       as hide_modifydatead,
			  MODIFYTIME      as hide_modifytime,         
			  MODIFYMACID      as hide_modifymac,
			  HISTORYDATE       as hide_historydatead'
	 	);
		$this->db2->order_by('COMPLAINDETAILID','ASC');
		$query=$this->db2->get('COMPLAINDETAIL');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	 }


	 public function get_gen_brand_pharmacy()
	 {
	 	$sql="SELECT   il.itemsid, il.itemsname AS BrandName,
              il.typeaid itemtypeid,gn.typeaid generictypeid,
              gn.typeaname AS GenericName FROM   itemslist il, genericname gn WHERE   gn.typeaid = il.typeaid ORDER BY   il.itemsid";
   		// echo $sql;
   		// die();

   		$this->db3->query($sql);
   		$query=$this->db3->get();
   		echo $this->db->last_query();
   		die();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	 }



    
}
        
                
                 
                
                
              
               
                     
                  
            
    
                
               
                    
                
                
                     
                   