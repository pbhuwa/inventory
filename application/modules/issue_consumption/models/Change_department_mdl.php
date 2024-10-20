<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_department_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
        $this->table='sama_salemaster';
	}

    public $validate_settings_department = array(               
        array('field' => 'invoice_no', 'label' => 'Invoice Number ', 'rules' => 'trim|required|xss_clean'),
        );
	
    public function department_save()
    {
        $postdata=$this->input->post();
        $id = $this->input->post('id');
       // echo "<pre>";print_r($this->input->post());die;
         
   
        unset($postdata['id']);
        if($id)
        {
            $insertArray = array(

                'sama_remarks'=>$this->input->post('remarks'),
                'sama_postby'=>$this->input->post('receivedby'),
                'sama_manualbillno'=>$this->input->post('sama_manualbillno'),
                    //'sama_invoiceno'=>$this->input->post('chma_new_invoiceno'),
                'sama_requisitionno'=>$this->input->post('req_no'),
                'sama_invoiceno'=>$this->input->post('invoice_no'),
                'sama_fyear'=>$this->input->post('fiscal_year'),
                'sama_postdatebs'=>$this->input->post('chma_receivedatebs'),
                'sama_storeid'=>$this->input->post('dept_depid'),
                'sama_postdatead'=>CURDATE_EN,
                'sama_postdatebs'=>CURDATE_NP,
                'sama_postdatead'=>date('H:i:s'),
                'sama_postip'=>$this->general->get_real_ipaddr(),
                'sama_postmac'=>$this->general->get_Mac_Address(),
            );
            if(!empty($insertArray))
            {
               $this->db->update($this->table,$insertArray,array('sama_salemasterid'=>$id));
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
      }
    }
}
