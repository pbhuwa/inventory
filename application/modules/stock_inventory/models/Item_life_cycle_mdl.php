<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_life_cycle_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		
	}
	function get_item_list($srch=false)
	{
		$get = $_GET;
        foreach ($get as $key => $value) {
          $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        $categoryid=!empty($get['categoryid'])?$get['categoryid']:'';
        if(!empty($get['sSearch_1'])){
            $this->db->where("il.itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("il.itli_itemname like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("mn.maty_material like  '%".$get['sSearch_3']."%'  ");
        }

         if(!empty($get['searchtext']))
        {
          $this->db->where("lower(il.itli_itemname) like  '%".htmlspecialchars_decode($get['searchtext'])."%' OR lower(il.itli_itemnamenp) like  '%".htmlspecialchars_decode($get['searchtext'])."%'  OR lower(il.itli_itemcode) like  '%".htmlspecialchars_decode($get['searchtext'])."%'  ");
        }

        if(!empty($categoryid)){
        	$this->db->where('itli_catid',$categoryid);
        }
      $resltrpt=$this->db->select("COUNT(*) as cnt")
                ->from('itli_itemslist il')
                ->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT')
                ->join('maty_materialtype mn','mn.maty_materialtypeid=il.itli_materialtypeid','LEFT')
                ->get()
                ->row();

      // echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'il.itli_itemname';
        $order = 'ASC';
        if($this->input->get('sSortDir_0'))
      {
          $order = $this->input->get('sSortDir_0');
      }
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
          $order_by = 'il.itli_itemcode';
        if($this->input->get('iSortCol_0')==2)
         $order_by = 'il.itli_itemname';
       if($this->input->get('iSortCol_0')==3)
         $order_by = 'mn.maty_material';
        
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
      
      if(!empty($get['sSearch_1'])){
            $this->db->where("il.itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }
      if(!empty($get['sSearch_2'])){
            $this->db->where("il.itli_itemname like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("mn.maty_material like  '%".$get['sSearch_3']."%'  ");
        }
         if(!empty($get['searchtext']))
        {
          $this->db->where("lower(il.itli_itemname) like  '%".htmlspecialchars_decode($get['searchtext'])."%' OR lower(il.itli_itemnamenp) like  '%".htmlspecialchars_decode($get['searchtext'])."%'  OR lower(il.itli_itemcode) like  '%".htmlspecialchars_decode($get['searchtext'])."%'  ");
        }
          if(!empty($categoryid)){
        	$this->db->where('itli_catid',$categoryid);
        }
        
  		$this->db->select('il.itli_itemlistid,il.itli_itemcode, il.itli_itemname, il.itli_itemnamenp, itli_purchaserate, itli_salesrate, itli_reorderlevel, itli_maxlimit, mn.maty_material,unit_unitname,ec.eqca_code,ec.eqca_category');
		$this->db->from('itli_itemslist il');
		 $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
    	$this->db->join('maty_materialtype mn','mn.maty_materialtypeid=il.itli_materialtypeid', 'left');
		$this->db->join('unit_unit un','un.unit_unitid=il.itli_unitid','left');

      $this->db->order_by($order_by,$order);
      if($limit && $limit>0)
      {  
          $this->db->limit($limit,$offset);
      }
    
      if($srch)
      {
        $this->db->where($srch);
      }
      
       $nquery=$this->db->get();
         // echo $this->db->last_query();
       // die();
       $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
        }


       if($num_row>0)
       {
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
        //echo $ndata['totalfilteredrecs'];die;
      	// echo $this->db->last_query();die();
    return $ndata;


	}
	function get_detail($srch=false)
	{
		 $this->db->select('il.itli_itemlistid,il.itli_itemcode, il.itli_itemname, il.itli_itemnamenp, itli_purchaserate, itli_salesrate, itli_reorderlevel, itli_maxlimit, mn.maty_material,unit_unitname');
		$this->db->from('itli_itemslist il');
		$this->db->join('maty_materialtype mn','mn.maty_materialtypeid=il.itli_materialtypeid', 'left');
		$this->db->join('unit_unit un','un.unit_unitid=il.itli_unitid','left');

		if($srch){
			$this->db->where($srch);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
		function get_detail_log($srch=false)
	{
		 $this->db->select('pl.*');
		 $this->db->from('itpl_itempricelog pl');
		if($srch){
			$this->db->where($srch);
		}
		
		$query = $this->db->get();
		 // echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	function get_opening($id=false)
	{
		$this->db->select('il.itli_itemname,il.itli_itemnamenp, itli_itemcode, trma_transactiondatebs, trma_transactiondatead, trma_fyear, trde_requiredqty, trde_issueqty, trde_unitprice');
		$this->db->from('xw_trde_transactiondetail td');
		$this->db->join('xw_trma_transactionmain tm','tm.trma_trmaid = td.trde_trmaid','left');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=td.trde_itemsid ','left');

		$this->db->where('trma_transactiontype="OPENING"');

		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}
	function get_pur_order($id=false)
	{
		$this->db->select('itli_itemcode,
							itli_itemname,
							itli_itemnamenp,
							puor_orderdatebs,
							puor_orderdatead,
							pude_quantity,
							pude_rate,
							pude_discount,
							pude_vat,
							pude_amount');
		
		$this->db->from('xw_pude_purchaseorderdetail pd');
		$this->db->join('xw_puor_purchaseordermaster pm','pm.puor_purchaseordermasterid=pd.pude_purchasemasterid','left');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=pd.pude_itemsid','left');
		

		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}

	function get_pur_req($id=false)
	{
		$this->db->select('itli_itemcode,
							itli_itemname,
							itli_itemnamenp,

							pure_reqdatebs,
							pure_reqdatead,
							pure_fyear,
							purd_stock,
							purd_qty,
							purd_rate');
		$this->db->from('xw_purd_purchasereqdetail pd');
		$this->db->join('xw_pure_purchaserequisition pr','pr.pure_purchasereqid=pd.purd_reqid','left');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=pd.purd_itemsid','left');

		// $limit = 15;
  //       $offset = 1;
		// if($limit && $limit>0)
	 //      {  
	 //          $this->db->limit($limit,$offset);
	 //      }
    
		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;


		// $get = $_GET;
  //       foreach ($get as $key => $value) {
  //         $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
  //       }
  //       if(!empty($get['sSearch_1'])){
  //           $this->db->where("il.itli_itemcode like  '%".$get['sSearch_1']."%'  ");
  //       }
  //       if(!empty($get['sSearch_2'])){
  //           $this->db->where("il.itli_itemname like  '%".$get['sSearch_2']."%'  ");
  //       }
  //       if(!empty($get['sSearch_3'])){
  //           $this->db->where("pr.pure_reqdatebs like  '%".$get['sSearch_3']."%'  ");
  //       }
  //       if(!empty($get['sSearch_4'])){
  //           $this->db->where("pr.pure_reqdatead like  '%".$get['sSearch_4']."%'  ");
  //       }

  //     	$resltrpt=$this->db->select("COUNT(*) as cnt")
  //               ->from('xw_purd_purchasereqdetail pd')
  //               ->get()
  //               ->row();

  //     // echo $this->db->last_query();die(); 
  //       $totalfilteredrecs=$resltrpt->cnt; 

  //       $order_by = 'il.itli_itemname';
  //       $order = 'ASC';
  //       if($this->input->get('sSortDir_0'))
  //     {
  //         $order = $this->input->get('sSortDir_0');
  //     }
  
  //       $where='';
  //       if($this->input->get('iSortCol_0')==1)
  //         $order_by = 'il.itli_itemcode';
  //       if($this->input->get('iSortCol_0')==2)
  //        $order_by = 'il.itli_itemname';
  //       if($this->input->get('iSortCol_0')==3)
  //        $order_by = 'pr.pure_reqdatebs';
  //    	if($this->input->get('iSortCol_0')==3)
  //        $order_by = 'pr.pure_reqdatead';
        
  //       $totalrecs='';
  //       $limit = 15;
  //       $offset = 1;
  //       $get = $_GET;
 
  //     foreach ($get as $key => $value) {
  //         $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
  //     }
      
  //       if(!empty($_GET["iDisplayLength"])){
  //          $limit = $_GET['iDisplayLength'];
  //          $offset = $_GET["iDisplayStart"];
  //       } 
      
  //     if(!empty($get['sSearch_1'])){
  //           $this->db->where("il.itli_itemcode like  '%".$get['sSearch_1']."%'  ");
  //       }
  //     if(!empty($get['sSearch_2'])){
  //           $this->db->where("il.itli_itemname like  '%".$get['sSearch_2']."%'  ");
  //       }
  //       if(!empty($get['sSearch_3'])){
  //           $this->db->where("pr.pure_reqdatebs like  '%".$get['sSearch_3']."%'  ");
  //       }
  //       if(!empty($get['sSearch_4'])){
  //           $this->db->where("pr.pure_reqdatead like  '%".$get['sSearch_4']."%'  ");
  //       }
        
  // 		$this->db->select('itli_itemcode,
		// 					itli_itemname,
		// 					itli_itemnamenp,
		// 					pure_reqdatebs,
		// 					pure_reqdatead,
		// 					pure_fyear,
		// 					purd_stock,
		// 					purd_qty,
		// 					purd_rate');
		// $this->db->from('xw_purd_purchasereqdetail pd');
		// $this->db->join('xw_pure_purchaserequisition pr','pr.pure_purchasereqid=pd.purd_reqid','left');
		// $this->db->join('xw_itli_itemslist il','il.itli_itemlistid=pd.purd_itemsid','left');

  //     $this->db->order_by($order_by,$order);
  //     if($limit && $limit>0)
  //     {  
  //         $this->db->limit($limit,$offset);
  //     }
    
  //     if($id)
		// {
		// 	$this->db->where('itli_itemlistid=',$id);
		// }
      
  //      $nquery=$this->db->get();
  //      // echo $this->db->last_query();
  //      // die();
  //      $num_row=$nquery->num_rows();
  //       if(!empty($_GET['iDisplayLength'])) {
  //         $totalrecs = sizeof( $nquery);
  //       }


  //      if($num_row>0){
  //         $ndata=$nquery->result();
  //         $ndata['totalrecs'] = $totalrecs;
  //         $ndata['totalfilteredrecs'] = $totalfilteredrecs;
  //       } 
  //       else
  //       {
  //           $ndata=array();
  //           $ndata['totalrecs'] = 0;
  //           $ndata['totalfilteredrecs'] = 0;
  //       }
  //     	// echo $this->db->last_query();die();
  //   return $ndata;


	}

	function get_pur_received($id=false,$dstat=false,$tstat=false)
	{
		$this->db->select('itli_itemcode,
							itli_itemname,
							itli_itemnamenp,

							recm_receiveddatebs,
							recm_receiveddatead,
							recm_fyear,
							recd_purchasedqty,
							recd_unitprice,
							recd_salerate,
							recd_discountamt,
							recd_vatamt,
							recd_amount');
		$this->db->from('xw_recd_receiveddetail rd');
		$this->db->join('xw_recm_receivedmaster rm','rm.recm_receivedmasterid=rd.recd_receivedmasterid','left');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=rd.recd_itemsid','left');

		$this->db->where('recm_dstat=',$dstat);
		$this->db->where('recm_tstat=',$tstat);
		
		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}

	function get_pur_return($id=false)
	{
		$this->db->select('itli_itemcode,
							itli_itemname,
							itli_itemnamenp,
							purr_returndatebs,
							purr_returndatead,
							purr_fyear,
							prde_receivedqty,
							prde_returnqty,
							prde_purchaserate');
		
		$this->db->from('xw_prde_purchasereturndetail pd');
		$this->db->join('xw_purr_purchasereturn pr','pr.purr_purchasereturnid=pd.prde_purchasereturnid','left');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=pd.prde_itemsid','left');
			
		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}

	function get_requisition($id=false)
	{
		$this->db->select('il.itli_itemcode,
							il.itli_itemname,
							il.itli_itemnamenp,

							rema_reqdatebs,
							rema_reqdatead,
							rede_qty,
							rema_fyear');
		
		$this->db->from('xw_rema_reqmaster rm');
		$this->db->join('xw_rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','left');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=rd.rede_itemsid','left');
			
		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}
	function get_issue($id=false)
	{
		$this->db->select('itli_itemcode,
							itli_itemname,
							itli_itemnamenp,

							sama_billdatebs,
							sama_billdatead,
							sama_fyear,
							sade_qty,
							sade_curqty,
							sade_unitrate,
							sade_iscancel');
		
		$this->db->from('xw_sade_saledetail sd');
		$this->db->join('xw_sama_salemaster sm','sm.sama_salemasterid=sd.sade_salemasterid','left');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','left');
			
		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}

	function get_sales_return($id=false)
	{
		$this->db->select('itli_itemcode,
							itli_itemname,
							itli_itemnamenp,

							rema_returndatebs,
							rema_returndatead,
							rema_fyear,
							rede_qty,
							rede_unitprice,
							rede_total,
							rede_iscancel');
		
		$this->db->from('xw_rede_returndetail rd');
		$this->db->join('xw_rema_returnmaster rm','rm.rema_returnmasterid=rd.rede_returnmasterid','left');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=rd.rede_itemsid','left');
			
		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}

	function get_challan($id=false)
	{
		$this->db->select('itli_itemcode,
							itli_itemname,
							itli_itemnamenp,

							chma_challanrecdatebs,
							chma_challanrecdatead,
							chde_qty,
							chde_receivecomplete');
		
		$this->db->from('xw_chde_challandetails cd');
		$this->db->join('xw_chma_challanmaster cm','cm.chma_challanmasterid=cd.chde_challanmasterid','left');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=cd.chde_itemsid','left');
			
		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}

function get_convin($id=false)
	{
		$this->db->select('itli_itemcode,
							itli_itemname,
							itli_itemnamenp,

							conv_childqty,
							conv_childrate,
							conv_condatebs,
							conv_condatead');
		
		$this->db->from('xw_conv_conversion cn');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=cn.conv_childid','left');
			
		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query-> result();		
			return $data;		
		}		
		return false;

	}
 
function get_convout($id=false)
	{
		$this->db->select('itli_itemcode,
							itli_itemname,
							itli_itemnamenp,

							conv_parentqty,
							conv_parentrate,
							conv_condatebs,
							conv_condatead');
		
		$this->db->from('xw_conv_conversion cn');
		$this->db->join('xw_itli_itemslist il','il.itli_itemlistid=cn.conv_parentid','left');
			
		if($id)
		{
			$this->db->where('itli_itemlistid=',$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query-> result();		
			return $data;		
		}		
		return false;

	}
	  public function get_all_itemlist($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false,$groupby=false)
    {
        $srchtxt= $this->input->post('itemname');
        $this->db->select('*');
        $this->db->from('itli_itemslist');
        $this->db->group_by('itli_itemname');
        if($srstinl)
        {
            $this->db->where($srstinl);
        }

        if($srchtxt)
        {
            $this->db->where("itli_itemname like  '%".$srchtxt."%'  ");
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
        
        $this->db->set_dbprefix('');

        if($groupby)
        {
            $this->db->group_by($groupby);
        }
        
        $this->db->set_dbprefix('xw_');
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

}