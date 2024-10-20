<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bio_inventory_setting extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('bio_inventory_setting_mdl');
		$this->load->Model('equipment_mdl');
		$this->load->Model('bio_medical_mdl');
	
		
	}
	
	public function index()
	{
		
		
	}

	public function get_primary_equipid()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$eqidescid = $this->input->post('eqidescid');
			if(empty($eqidescid))
			{
				/*print_r(json_encode(array('status'=>'success','equikey'=>'','message'=>'Can Perform Operation')));*/
				print_r(json_encode(array('status'=>'error','equikey'=>'','message'=>'Cannot Perform Operation')));
	       			 exit;
			}
			$autoarray=$this->bio_inventory_setting_mdl->get_auto_generated_id();
			

			// print_r($equip_data);
			// die();
			if($autoarray->bise_isautogenerate=='Y')
			{
				$equipment_list=$this->equipment_mdl->get_all_equipment(array('eq.eqli_equipmentlistid'=>$eqidescid));
				$equ_code=$equipment_list[0]->eqli_code;
				$maxval=$equipment_list[0]->eqli_maxval;
				// echo $maxval;
				// die();
				$plusone=$maxval+1;

				$autogenid=$autoarray->bise_autogenerateid;
				if($autogenid=='1')
				{
					$format=$equ_code.'-'.$plusone.'-'.date('Y');
				}
				if($autogenid=='2')
				{
					$format=$equ_code.'-'.$plusone;
				}
				if($autogenid=='3')
				{
					$format=$plusone;
				}

				// echo $format;
				// die();

				
				// echo "<pre>";
				// print_r($equ_code);
				// die();
			}
			else
			{
				$equip_data= $this->bio_medical_mdl->get_biomedical_inventory(false,1,false,'bm.bmin_equipid','DESC');
				$equip=!empty($equip_data[0]->bmin_equipid)?$equip_data[0]->bmin_equipid:0;
				$format=$equip+1;
			}

			print_r(json_encode(array('status'=>'success','equikey'=>$format,'message'=>'Can Perform Operation')));
	       			 exit;
			
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */