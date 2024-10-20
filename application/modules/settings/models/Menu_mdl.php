<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_mdl extends CI_Model 
{
	 public $menuList = '';
  	public $adjacencyList = '';
	public function __construct() 
	{
		parent::__construct();

		$this->table='modu_modules';
	}


	public $validate_settings_menu = array(               
        array('field' => 'modu_modulekey', 'label' => 'Menu Name', 'rules' => 'trim|required|xss_clean|callback_exists_modulekey'),
        array('field' => 'modu_displaytext', 'label' => 'Display Text', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'modu_modulelink', 'label' => 'Menu Link', 'rules' => 'trim|required|xss_clean'),
          array('field' => 'modu_order', 'label' => 'Menu Order', 'rules' => 'trim|numeric|xss_clean'),
        );
	
	public function menu_save()
	{
		$postdata=$this->input->post();

		$isinsert=$this->input->post('modu_isinsert');
		if($isinsert=='Y'){
		$postdata['modu_isinsert']='Y';
		}else
		{
		$postdata['modu_isinsert']='N';
		}

		$isview=$this->input->post('modu_isview');
		if($isview=='Y'){
		$postdata['modu_isview']='Y';
		}else
		{
		$postdata['modu_isview']='N';
		}

		$isupdate=$this->input->post('modu_isupdate');
		if($isupdate=='Y'){
		$postdata['modu_isupdate']='Y';
		}else
		{
		$postdata['modu_isupdate']='N';
		}

		$isdelete=$this->input->post('modu_isdelete');
		if($isdelete=='Y'){
		$postdata['modu_isdelete']='Y';
		}else
		{
		$postdata['modu_isdelete']='N';
		}

		$isapproved=$this->input->post('modu_isapproved');
		if($isapproved=='Y'){
		$postdata['modu_isapproved']='Y';
		}else
		{
		$postdata['modu_isapproved']='N';
		}

		$isverified=$this->input->post('modu_isverified');
		if($isverified=='Y'){
		$postdata['modu_isverified']='Y';
		}else
		{
		$postdata['modu_isverified']='N';
		}


		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['modu_modifydatead']=CURDATE_EN;
		$postdata['modu_modifydatebs']=CURDATE_NP;
		$postdata['modu_modifytime']=date('H:i:s');
		$postdata['modu_modifyby']=$this->session->userdata(USER_ID);
		$postdata['modu_modifyip']=$this->general->get_real_ipaddr();
		$postdata['modu_modifymac']=$this->general->get_Mac_Address();

		if(!empty($postdata))
		{
			$this->general->save_log($this->table,'modu_moduleid',$id,$postdata,'Update');
			$this->db->update($this->table,$postdata,array('modu_moduleid'=>$id));
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
		else
		{
		$postdata['modu_postdatead']=CURDATE_EN;
		$postdata['modu_postdatebs']=CURDATE_NP;
		$postdata['modu_posttime']=date('H:i:s');
		$postdata['modu_postby']=$this->session->userdata(USER_ID);
		$postdata['modu_postip']=$this->general->get_real_ipaddr();
		$postdata['modu_postmac']=$this->general->get_Mac_Address();
		$postdata['modu_orgid']=$this->session->userdata(ORG_ID);
		$postdata['modu_locationid']=$this->session->userdata(LOCATION_ID);
		// echo "<pre>";
		// print_r($postdata);
		// die();


		if(!empty($postdata))
		{
			$this->db->insert($this->table,$postdata);
			$insertid=$this->db->insert_id();
			if($insertid)
			{
				return $insertid;
			}
			else
			{
				return false;
			}
		}
	}
		
		return false;

	}


	 function menu_adjacency($id, $parent, $parent_id, $level) {
     $this->db->select('*');
     $this->db->from('modu_modules');
     $this->db->where('modu_parentmodule',$parent_id);
     $this->db->where('modu_orgid',$this->session->userdata(ORG_ID));
     $this->db->order_by('modu_displaytext','ASC');
     $query=$this->db->get();
     $oMenus=$query->result();
      // $this->adjacencyList.="";
    foreach ( $oMenus as $value ) :
    $this->adjacencyList.="<option value=".$value->modu_moduleid;
       
        if ($parent == $value->modu_moduleid)
          $this->adjacencyList .= " selected";
        
        $this->adjacencyList .= ">".str_repeat('  &minus; ', $level).stripslashes($value->modu_displaytext)."</option>";
        $this->menu_adjacency($id, $parent, $value->modu_moduleid,  $level+1);
      endforeach;
      return $this->adjacencyList;
    }



	public function get_all_menu($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('m.*,mm.modu_displaytext as parentmenu');
		$this->db->from('modu_modules m');
		$this->db->join('modu_modules mm','m.modu_parentmodule =mm.modu_moduleid','left');

		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		if($limit && $limit>0)
		{
			$this->db->limit($limit);
		}
		if($offset)
		{
			$this->db->offset($offset);
		}

		if($order)
		{
			$this->db->order_by($order,$order_by);
		}
		
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

	public function remove_menu()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->general->save_log($this->table,'modu_moduleid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('modu_moduleid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function check_exist_module_for_other($module_key = false, $id = false){
		$data = array();
		if($module_key)
		{
				$this->db->where('modu_modulekey',$module_key);
		}
		if($id)
		{
			$this->db->where('modu_moduleid!=',$id);
		}
		$this->db->where(array('modu_orgid'=>$this->session->userdata(ORG_ID)));

		$query = $this->db->get("modu_modules");
		// echo $this->db->last_query();
		// die();

		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}


	 public function getAllMenusOrder($id = NULL, $level = 0, $first_call = true) {
      $this->menuList .=  $first_call == true ? '<ol class="sortable">' : '<ol>';
      $call = $first_call == true ? false : false;
      $id = isset($id) ? $id : 0;
      $objectMenu=array();

      $this->db->select('m.*');
      $this->db->from('modu_modules m');
      $this->db->where('m.modu_parentmodule',$id);
      $this->db->where('m.modu_orgid',$this->session->userdata(ORG_ID));
     $this->db->where('m.modu_isactive','Y');
      $this->db->order_by('m.modu_order','ASC');

      $query=$this->db->get();
      if($query->num_rows()>0)
      {
        $objectMenu=$query->result();
      }
     
      foreach($objectMenu as $key => $tbl_value) :
        $menu_id = $tbl_value->modu_moduleid;
        $menu_title = stripslashes($tbl_value->modu_displaytext);
        $menu_order = $tbl_value->modu_order;
        $this->menuList .= '<li id="list_'.$menu_id.'"><div><span class="disclose"><span></span></span>'.$menu_title.'</div>';
        $this->getAllMenusOrder($menu_id, $level+1, false);
        $this->menuList .= '</li>';
      endforeach;
      $this->menuList .=  '</ol>';
      return $this->menuList;     
    }



    public function updateAllMenusOrder(){
     
      // print_r($_POST);

      $list = $_POST['list'];
      // an array to keep the sort order for each level based on the parent id as the key
        $sort = array();
      foreach ($list as $id => $parentId) :
        /* a null value is set for parent id by nested sortable for root level elements
                so you set it to 0 to work in your case (from what I could deduct from your code) */
            $parentId = ($parentId === 'null') ? 0 : $parentId;
        // init the sort order value to 1 if this element is on a new level
            if (!array_key_exists($parentId, $sort))
                $sort[$parentId] = 1;
              $data=array(
                'modu_order'=>$sort[$parentId],
                'modu_parentmodule'=>$parentId);
              $this->db->update('modu_modules',$data,array('modu_moduleid'=>$id));
            //   echo $this->db->last_query();
            //   echo"<br>";
            // // increment the sort order for this level
            $sort[$parentId]++;
        
      endforeach;
    }
    

	
}