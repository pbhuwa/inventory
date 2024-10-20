<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart_of_assets extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->Model('chart_of_assets_mdl');

		$this->load->library('upload');

		$this->load->library('image_lib');

		$this->load->helper('file');

		$this->load->helper('form');

	}

	public function index()

	{

		//echo "aa";die;

	$result=$this->assets_category_list();

    $this->data['category_type']=$result;

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

		$this->data['breadcrumb']='Chart of Assets';

		$this->data['tab_type']="list";

		$this->page_title='Chart of Assets';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('chart_of_assets/v_chart_of_assets_common', $this->data);

	}

	public function assets_category_list(){

	// $this->db->select('*');

 //    $this->db->from('eqca_equipmentcategory ec');

 //    $this->db->where('eqca_isnonexp','Y');

 //    $result=$this->db->get()->result();

    // echo "<pre>";

    // print_r($result);

    // die();

		$assets_type = $this->general->get_tbl_data('*','asty_assettype',array('asty_isactive'=>'Y'),'asty_astyid','ASC'); 

		// print_r($assets_type);

		// die();	

		$temp ='';

		$temp ='<ul>';

		if($assets_type){

		foreach ($assets_type as $kat => $atype) {

			$temp .='<li>'.$atype->asty_typename;

				$this->db->select('asen_assettype eqca_equipmentcategoryid,eqca_code,ec.eqca_deprate,eqca_category,COUNT("*") as cnt');

				$this->db->from('eqca_equipmentcategory ec'); 

				$this->db->join('asen_assetentry ae','ae.asen_assettype=ec.eqca_equipmentcategoryid','LEFT');

				$this->db->where('ec.eqca_isnonexp="Y" AND asen_assettype IS NOT NULL');

				$this->db->where('asen_assettypeid',$atype->asty_astyid);

				$this->db->group_by('asen_assettype');

				$this->db->having('COUNT("*")>0');

				$this->db->order_by('eqca_category','ASC');

				$mat_result=$this->db->get()->result();

				if(!empty($mat_result)){

					$tempsub ='';

					$tempsub .='<ul>';

					$tempass='';

				foreach ($mat_result as $kr => $rslt) {

					$assettype=$rslt->eqca_equipmentcategoryid;

		    		$this->db->select('ae.asen_assetcode,ae.asen_desc,ec.eqca_deprate');

					$this->db->from('asen_assetentry ae');

					$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');

					$this->db->where(array('asen_assettype'=>$assettype));

					$this->db->where('asen_assettypeid',$atype->asty_astyid);

					$this->db->order_by('asen_asenid','ASC');

					$query = $this->db->get();

					$ass_data=$query->result();

					if(!empty($ass_data)){

						foreach ($ass_data as $dk => $asrlt) {

							$tempass .='<li>'.$asrlt->asen_assetcode.' | '.$asrlt->asen_desc.'</li>';

						}

					}

					if(!empty($ass_data)){

					$tempsub .= '<li>'.$rslt->eqca_code.' | '.$rslt->eqca_category.' ('.$rslt->cnt.' ) ';

					$tempsub .= '<ul>'.$tempass.'</ul>';

					$tempsub .= '</li>';

					}else{

					$tempsub .='<li>'.$rslt->eqca_code.' | '.$rslt->eqca_category.' ('.$rslt->cnt.' ) ';	

					$tempsub .='</li>';

					}

							// $tempsub .= '<li>'.$rslt->eqca_code.' | '.$rslt->eqca_category.' ('.$rslt->cnt.' ) ';

							// $tempsub .= '</li>';

						}

				$tempsub .='</ul>';

				}

				$temp .= $tempsub;

		}

		$temp .='<ul>';

    	 return $temp;

    	}

    	return false;

	}

}
