<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_maintenance_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='amta_amctable';
	}

	public $validate_amc_data = array(  
	 	array('field' => 'amta_equipid', 'label' => 'Search And Add Data', 'rules' => 'trim|required|xss_clean'),            
        );
	
	


	public function get_all_mlog_data($srchcol=false)
	{
		$this->db->select('amc.*');
		$this->db->from('amta_amctable amc');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
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
    
    public function get_mlog_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
  {
    $fromdate = $this->input->post('fromdate');
    $todate = $this->input->post('todate');
    
    $this->db->select("*");
        $this->db->from('malo_maintenancelog ml');
        $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=ml.malo_equipid','LEFT');
        $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = ml.malo_equipid','LEFT');
        $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
         $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
         $this->db->join('usma_usermain um','um.usma_userid=ml.malo_postby','LEFT');
    if($fromdate &&  $todate){
          if(DEFAULT_DATEPICKER=='NP')
          {
            $this->db->where('ml.malo_postdatebs >=', $fromdate);
            $this->db->where('ml.malo_postdatebs <=', $todate);
          }
          else
          {
            $this->db->where('ml.malo_postdatead >=', $fromdate);
            $this->db->where('ml.malo_postdatead <=', $todate);
          }
      }
      

        if($srchcol)
        {
          $this->db->where($srchcol); 
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
   


	
/*
	public function get_maintenance_log_list()
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	if(!empty($get['sSearch_0'])){
            $this->db->where("riva_riskid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("riva_risk like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("riva_comments like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("riva_postdatebs like  '%".$get['sSearch_3']."%'  ");
        }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('riva_riskvalues')
  					->get()
  					->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'riva_riskid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'riva_riskid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'riva_risk';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'riva_comments';
       	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'riva_postdatebs';
       	
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
            $this->db->where("riva_riskid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("riva_risk like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("riva_comments like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("riva_postdatebs like  '%".$get['sSearch_3']."%'  ");
        }
       
        $this->db->select('*');
		  $this->db->from('riva_riskvalues');
        $this->db->order_by($order_by,$order);
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
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
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

*/	
  public function get_all_mlog_summary($srchcol=false,$othersrch=false)
	{
		   
      		    $get = $_GET;
       
            	foreach ($get as $key => $value) {
              	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
            	}
     	
        
              if(!empty($get['sSearch_1'])){
                  $this->db->where("bm.bmin_equipmentkey like  '%".$get['sSearch_1']."%' ");
                }

                if(!empty($get['sSearch_2'])){
                  $this->db->where("eql.eqli_description like  '%".$get['sSearch_2']."%' ");
                }

                if(!empty($get['sSearch_3'])){
                  $this->db->where("di.dept_depname like  '%".$get['sSearch_3']."%'  ");
                }

                if(!empty($get['sSearch_4'])){
                  $this->db->where("rd.rode_roomname like  '%".$get['sSearch_4']."%'  ");
                }
                if(!empty($get['sSearch_5'])){
                  $this->db->where("malo_comment like  '%".$get['sSearch_5']."%'  ");
                }

                if(!empty($get['sSearch_6'])){
                  $this->db->where("malo_remark like  '%".$get['sSearch_6']."%'  ");
                }

                if(!empty($get['sSearch_7'])){
                  $this->db->where("usma_username like  '%".$get['sSearch_7']."%'  ");
                }

                if(!empty($get['sSearch_8'])){
                  $this->db->where("malo_posttime like  '%".$get['sSearch_8']."%'  ");
                }

                if(!empty($get['sSearch_9'])){
                  $this->db->where("malo_postdatebs like  '%".$get['sSearch_9']."%'  ");
                }
      
              $this->db->select("*");
              $this->db->from('malo_maintenancelog ml');
              $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=ml.malo_equipid','LEFT');
              $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = ml.malo_equipid','LEFT');
              $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
               $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
       
               if($srchcol)
               {
                  $this->db->where($srchcol);
               }
             if($othersrch)
             {
              $this->db->where($othersrch);
             }

          //$this->db->group_by('amc.amta_equipid');
    
	
      	    $resltrpt=$this->db->get();

              $rslt=$resltrpt->num_rows();
              if(!empty($rslt))
             	{
              $totalfilteredrecs=$rslt;
          	}
          	else
          	{
          		$totalfilteredrecs=0;
          	}


            	$order_by = 'ml.malo_equipid';
            	$order = 'asc';
  
          	$where='';
     

               if($this->input->get('iSortCol_0')==0)
            	       $order_by = 'ml.malo_equipid';
                 else if($this->input->get('iSortCol_0')==1)
            	       $order_by = 'bmin_equipmentkey';
          	     else if($this->input->get('iSortCol_0')==2)
            	       $order_by = 'eqli_description';
          	     else if($this->input->get('iSortCol_0')==3)
            	       $order_by = 'dept_depname';
          	     else if($this->input->get('iSortCol_0')==4)
           		       $order_by = 'rode_roomname';
           	     else if($this->input->get('iSortCol_0')==5)
          	 	       $order_by = 'malo_comment';
          	     else if($this->input->get('iSortCol_0')==6)
          	 	       $order_by = 'malo_remark';
          	     else if($this->input->get('iSortCol_0')==7)
          	 	       $order_by = 'usma_username';
                   else if($this->input->get('iSortCol_0')==8)
                       $order_by = 'malo_posttime';
                   else if($this->input->get('iSortCol_0')==9)
                       $order_by = 'malo_postdatebs';
        
      	
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
                      $this->db->where("bm.bmin_equipmentkey like  '%".$get['sSearch_1']."%' ");
                    }

                    if(!empty($get['sSearch_2'])){
                      $this->db->where("eql.eqli_description like  '%".$get['sSearch_2']."%' ");
                    }

                if(!empty($get['sSearch_3'])){
                  $this->db->where("di.dept_depname like  '%".$get['sSearch_3']."%'  ");
                }

                if(!empty($get['sSearch_4'])){
                  $this->db->where("rd.rode_roomname like  '%".$get['sSearch_4']."%'  ");
                }
                if(!empty($get['sSearch_5'])){
                  $this->db->where("malo_comment like  '%".$get['sSearch_5']."%'  ");
                }

                if(!empty($get['sSearch_6'])){
                  $this->db->where("malo_remark like  '%".$get['sSearch_6']."%'  ");
                }

                if(!empty($get['sSearch_7'])){
                  $this->db->where("usma_username like  '%".$get['sSearch_7']."%'  ");
                }

                if(!empty($get['sSearch_8'])){
                  $this->db->where("malo_posttime like  '%".$get['sSearch_8']."%'  ");
                }

                if(!empty($get['sSearch_9'])){
                  $this->db->where("malo_postdatebs like  '%".$get['sSearch_9']."%'  ");
                }
      

         $this->db->select("*");
          $this->db->from('malo_maintenancelog ml');
          $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=ml.malo_equipid','LEFT');
          $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = ml.malo_equipid','LEFT');
          $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
           $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
      	  if($srchcol)
      	 {
      	 	$this->db->where($srchcol);
      	 }
          if($othersrch)
         {
          $this->db->where($othersrch);
         }
      	 //$this->db->group_by('amc.amta_equipid');

          $this->db->order_by($order_by,$order);
          // $this->db->group_by('amta_equipid');
          if($limit && $limit>0)
          {  
              $this->db->limit($limit);
          }
          if($offset)
          {
              $this->db->offset($offset);
          }
        
          $nquery=$this->db->get();

          //print_r($this->db->last_query());die;

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
  	   //  echo $this->db->last_query();die();
  	    return $ndata;
	}


  public function get_all_mlog($srchcol=false)
  {
        


        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
    
        $this->db->select("*");
        $this->db->from('malo_maintenancelog ml');
        $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=ml.malo_equipid','LEFT');
        $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = ml.malo_equipid','LEFT');
        $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
        $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
        $this->db->join('usma_usermain um','um.usma_userid=ml.malo_postby','LEFT');
        if($fromdate &&  $todate){
          if(DEFAULT_DATEPICKER=='NP')
          {
            $this->db->where('ml.malo_postdatebs >=', $fromdate);
            $this->db->where('ml.malo_postdatebs <=', $todate);
          }
          else
          {
            $this->db->where('ml.malo_postdatead >=', $fromdate);
            $this->db->where('ml.malo_postdatead <=', $todate);
          }
      }
      

        if($srchcol)
        {
          $this->db->where($srchcol); 
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

      public function get_all_mlog_detail($srchcol=false,$othersrch=false)
      {
        //$add_date=  date('Y/m/d',strtotime(CURDATE_EN . "+15 days"));
            $get = $_GET;
     
            foreach ($get as $key => $value) {
              $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
            }
          

          if(!empty($get['sSearch_1'])){
              $this->db->where("bm.bmin_equipmentkey like  '%".$get['sSearch_1']."%' ");
            }

            if(!empty($get['sSearch_2'])){
              $this->db->where("eql.eqli_description like  '%".$get['sSearch_2']."%' ");
            }

            if(!empty($get['sSearch_3'])){
              $this->db->where("di.dept_depname like  '%".$get['sSearch_3']."%'  ");
            }

            if(!empty($get['sSearch_4'])){
              $this->db->where("rd.rode_roomname like  '%".$get['sSearch_4']."%'  ");
            }
            if(!empty($get['sSearch_5'])){
              $this->db->where("rv.riva_risk like  '%".$get['sSearch_5']."%'  ");
            }

            if(!empty($get['sSearch_6'])){
              $this->db->where("mf.manu_manlst like  '%".$get['sSearch_6']."%'  ");
            }
               if(!empty($get['sSearch_7'])){
              $this->db->where("dis.dist_distributor like  '%".$get['sSearch_7']."%'  ");
            }
                 if(!empty($get['sSearch_8'])){
              $this->db->where("amc.amta_postdatead like  '%".$get['sSearch_8']."%'  ");
            }
                 if(!empty($get['sSearch_9'])){
              $this->db->where("amc.amta_postdatebs like  '%".$get['sSearch_9']."%'  ");
            }


          
            //$this->db->where('amta_amcdatead <=', $add_date);

            $this->db->select("*");
               $this->db->from('amta_amctable amc');
               $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = amc.amta_equipid','LEFT');
               $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
               $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
               $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','LEFT');
               $this->db->join('dist_distributors dis','dis.dist_distributorid = amc.amta_amccontractorid','LEFT');
               $this->db->join('manu_manufacturers mf','mf.manu_manlistid=bm.bmin_manufacturerid','LEFT');
               $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
               if($srchcol)
               {
                $this->db->where($srchcol);
               }
               if($othersrch)
               {
                $this->db->where($othersrch);
               }

            // $this->db->group_by('amc.amta_equipid');
        
      
          $resltrpt=$this->db->get();
            $rslt=$resltrpt->num_rows();
            if(!empty($rslt))
            {
            $totalfilteredrecs=$rslt;
          }
          else
          {
            $totalfilteredrecs=0;
          }


            $order_by = 'amc.amta_amcdatead';
            $order = 'asc';
      
            $where='';
            if($this->input->get('iSortCol_0')==0)
              $order_by = 'amc.amta_equipid';
            else if($this->input->get('iSortCol_0')==1)
              $order_by = 'bm.bmin_equipmentkey';
            else if($this->input->get('iSortCol_0')==2)
              $order_by = 'eqli_description';
            else if($this->input->get('iSortCol_0')==3)
              $order_by = 'dept_depname';
            else if($this->input->get('iSortCol_0')==4)
              $order_by = 'rode_roomname';
            else if($this->input->get('iSortCol_0')==5)
              $order_by = 'riva_risk';
            else if($this->input->get('iSortCol_0')==6)
              $order_by = 'manu_manlst';
            else if($this->input->get('iSortCol_0')==7)
              $order_by = 'dist_distributor';
             else if($this->input->get('iSortCol_0')==8)
              $order_by = 'amta_postdatead';
            
             else if($this->input->get('iSortCol_0')==9)
              $order_by = 'amta_postdatebs';
            
            
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
              $this->db->where("bm.bmin_equipmentkey like  '%".$get['sSearch_1']."%' ");
            }

            if(!empty($get['sSearch_2'])){
              $this->db->where("eql.eqli_description like  '%".$get['sSearch_2']."%' ");
            }

            if(!empty($get['sSearch_3'])){
              $this->db->where("di.dept_depname like  '%".$get['sSearch_3']."%'  ");
            }

            if(!empty($get['sSearch_4'])){
              $this->db->where("rd.rode_roomname like  '%".$get['sSearch_4']."%'  ");
            }
            if(!empty($get['sSearch_5'])){
              $this->db->where("rv.riva_risk like  '%".$get['sSearch_5']."%'  ");
            }

            if(!empty($get['sSearch_6'])){
              $this->db->where("mf.manu_manlst like  '%".$get['sSearch_6']."%'  ");
            }
               if(!empty($get['sSearch_7'])){
              $this->db->where("dis.dist_distributor like  '%".$get['sSearch_7']."%'  ");
            }
                 if(!empty($get['sSearch_8'])){
              $this->db->where("amc.amta_postdatead like  '%".$get['sSearch_8']."%'  ");
            }
                 if(!empty($get['sSearch_9'])){
              $this->db->where("amc.amta_postdatbs like  '%".$get['sSearch_9']."%'  ");
            }


            $this->db->select("amc.*,rv.riva_risk,bm.bmin_equipmentkey,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_amc,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_servicedatebs,bm.bmin_endwarrantydatebs,bm.bmin_servicedatead,bm.bmin_endwarrantydatead,eql.eqli_description, rv.riva_risk,di.dept_depname AS dein_department,mf.manu_manlst,dis.dist_distributor, rd.rode_roomname");
           $this->db->from('amta_amctable amc');
           $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = amc.amta_equipid','LEFT');
            $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
           $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
           $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','LEFT');
           $this->db->join('dist_distributors dis','dis.dist_distributorid = amc.amta_amccontractorid','LEFT');
           $this->db->join('manu_manufacturers mf','mf.manu_manlistid=bm.bmin_manufacturerid','LEFT');
           $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
            if($srchcol)
           {
            $this->db->where($srchcol);
           }
            if($othersrch)
           {
            $this->db->where($othersrch);
           }
          // $this->db->group_by('amc.amta_equipid');

            $this->db->order_by($order_by,$order);
            // $this->db->group_by('amta_equipid');
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
           //echo $this->db->last_query();die();
          return $ndata;
      }



	public function get_amc_data_reports($searchcol=false)
	{
		$fromdate=$this->input->post('frmDate');
		$toDate=$this->input->post('toDate');
		$equpid=$this->input->post('equid');

		if($searchcol)
		{
			$wherecol= 'WHERE '.$searchcol;
		}
		else
		{
			$wherecol='';
		}
		$where='';
		if($fromdate && $toDate)
		{
				if(DEFAULT_DATEPICKER=='NP')
					{
						$fromdateen=$this->general->NepToEngDateConv($fromdate);
						$toDateen=$this->general->NepToEngDateConv($toDate);	
					}
				else
					{
						$fromdateen=$fromdate;
						$toDateen=$toDate;	
				}

			$where="WHERE amta_amcdatead >='".$fromdateen."' AND amta_amcdatead <= '".$toDateen."'";
		}

		$sql1="SELECT amta_equipid,eql.eqli_description,rv.riva_risk,di.dept_depname as dein_department, bm.bmin_equipmentkey,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_amc,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_servicedatebs,bm.bmin_endwarrantydatebs,bm.bmin_servicedatead,bm.bmin_endwarrantydatead,mf.manu_manlst,dis.dist_distributor from(	
				SELECT amta_equipid from xw_amta_amctable $where
				group by amta_equipid )pm  LEFT JOIN xw_bmin_bmeinventory bm ON bm.bmin_equipid = amc.amta_equipid
				LEFT JOIN xw_eqli_equipmentlist eql ON eql.eqli_equipmentlistid=bm.bmin_descriptionid
				LEFT JOIN xw_dept_department di ON di.dept_depid = bm.bmin_departmentid
				LEFT JOIN xw_riva_riskvalues rv ON rv.riva_riskid = bm.bmin_riskid
				LEFT JOIN xw_manu_manufacturers mf ON mf.manu_manlistid = bm.bmin_manufacturerid
				LEFT JOIN xw_dist_distributors dis ON dis.dist_distributorid = bm.bmin_distributorid $wherecol ";

		$query = $this->db->query($sql1);
		// echo $this->db->last_query(); die();
		
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}

	public function get_pm_completed_reports($searchcol=false)
	{
		    $fromdate=$this->input->post('frmDate');
			$toDate=$this->input->post('toDate');
			$equpid=$this->input->post('equid');
			if($searchcol)
			{ 
				$wherecol= "WHERE $searchcol";
				//print_r($wherecol);die;
			}
			else
			{
				$wherecol='';
			}
			$where='';
			if($fromdate && $toDate)
			{
				if(DEFAULT_DATEPICKER=='NP')
					{
						$fromdateen=$this->general->NepToEngDateConv($fromdate);
						$toDateen=$this->general->NepToEngDateConv($toDate);	
					}
				else
					{
						$fromdateen=$fromdate;
						$toDateen=$toDate;	
				}
			
				$where="WHERE pmco_postdatead >='".$fromdateen."' AND pmco_postdatead <= '".$toDateen."'";
			}

			
			$sql1="SELECT * from(	
					SELECT pmco_pmcompletedid from xw_pmco_pmcompleted $where
					group by pmco_pmcompletedid )pm  LEFT JOIN xw_bmin_bmeinventory bm ON bm.bmin_equipid = amc.pmco_pmcompletedid
					LEFT JOIN xw_eqli_equipmentlist eql ON eql.eqli_equipmentlistid=bm.bmin_descriptionid
					LEFT JOIN xw_dept_department di ON di.dept_depid = bm.bmin_departmentid
					LEFT JOIN xw_riva_riskvalues rv ON rv.riva_riskid = bm.bmin_riskid
					LEFT JOIN xw_manu_manufacturers mf ON mf.manu_manlistid = bm.bmin_manufacturerid
					LEFT JOIN xw_dist_distributors dis ON dis.dist_distributorid = bm.bmin_distributorid $wherecol ";

			$query = $this->db->query($sql1);
			
			if ($query->num_rows() > 0) 
			{
				$data=$query->result();		
				return $data;		
			}		
		    return false;
	}

	public function get_repair_request_report($searchcol=false)
	{
	    $fromdate=$this->input->post('frmDate');
		$toDate=$this->input->post('toDate');
		$equpid=$this->input->post('equid');
		if($fromdate && $toDate)
		{
			if(DEFAULT_DATEPICKER=='NP')
				{
					$fromdateen=$this->general->NepToEngDateConv($fromdate);
					$toDateen=$this->general->NepToEngDateConv($toDate);	
				}
			else
				{
					$fromdateen=$fromdate;
					$toDateen=$toDate;	
			}
			$this->db->where("rere_postdatead >='".$fromdateen."' AND rere_postdatead <= '".$toDateen."'");
		}
		if($searchcol){
			$this->db->where($searchcol);
		}
		$this->db->select('re.*, dp.dept_depname,bm.bmin_modelno, bm.bmin_serialno,bm.bmin_equipmentkey, bm.bmin_endwarrantydatebs, bm.bmin_endwarrantydatead,bm.bmin_amc,bm.bmin_isoperation, bm.bmin_ismaintenance, mf.manu_manlst, r.riva_risk,eql.eqli_description');
		$this->db->from('rere_repairrequests re');
      $this->db->join('bmin_bmeinventory bm' , 'bm.bmin_equipid = re.rere_equid');
		$this->db->join('dept_department dp' , 'dp.dept_depid = bm.bmin_departmentid', 'LEFT');
	
		$this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = re.rere_manufcontacted', 'LEFT');
		$this->db->join('riva_riskvalues r' , 'r.riva_riskid = bm.bmin_riskid', 'LEFT');
		$this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
		$query = $this->db->get();
		//echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
		
	}
	

	public function get_pm_detail_list($srchcol=false)
	{
		$month=$this->input->post('month');
		$year=$this->input->post('year');
        $week=$this->input->post('week');
        $date=$this->input->post('date');
    
		$type=$this->input->post('type');
		$this->db->select('vamc.*,amc.*,bm.bmin_equipid,bm.bmin_equipmentkey,bm.bmin_descriptionid,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_departmentid,bm.bmin_riskid,bm.bmin_equip_oper,bm.bmin_manufacturerid,bm.bmin_distributorid,bm.bmin_amc,bm.bmin_servicedatead,bm.bmin_servicedatebs,bm.bmin_endwarrantydatead,bm.bmin_endwarrantydatebs,bm.bmin_purch_donatedid,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_amcontractorid,bm.bmin_accessories ,bm.bmin_comments,bm.bmin_currencytypeid,bm.bmin_cost,bm.bmin_removed,bm.bmin_isprintsticker,bm.bmin_postdatead,bm.bmin_postdatebs,bm.bmin_posttime,bm.bmin_postmac,bm.bmin_postip,bm.bmin_postby,bm.bmin_modifydatead,bm.bmin_modifydatebs,bm.bmin_modifytime,bm.bmin_modifymac,bm.bmin_modifyip,bm.bmin_modifyby,bm.bmin_isunrepairable,bm.bmin_isdelete,eql.eqli_description,di.dept_depname as dein_department, mf.manu_manlst, ri.riva_risk,dis.dist_distributor, rd.rode_roomname');
		$this->db->from('vwpmdata vpm');
		$this->db->join('amta_amctable amc','vamc.amta_equipid=amc.amta_equipid AND vamc.amta_amcdatead=amc.amta_amcdatead ','LEFT');
		$this->db->join('bmin_bmeinventory bm' , 'bm.bmin_equipid = vamc.amta_equipid','LEFT');
	 	$this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
      	$this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
      	$this->db->join('manu_manufacturers mf','mf.manu_manlistid=bm.bmin_manufacturerid','LEFT');
      	$this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
      	$this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
        $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
	
		if($month)
		{
			$this->db->where('vamc.month',$month);
		}
		if($year)
		{
			$this->db->where('vamc.year',$year);
		}
        if($week)
        {
          $this->db->where('vamc.week',$week);
        }
        if($date)
        {
           $this->db->where('vamc.amta_amcdatead',$date);
        }
		if(!empty($month) && !empty($year))
		{
			$mnth=$month;
			if($month<10)
			{
				$mnth='0'.$month;
			}
			// echo $mnth;
			$datesrch=$year.'/'.$mnth;
			$this->db->like('vamc.amta_amcdatead',$datesrch, 'after');
		}
		if($srchcol)
		{
			$this->db->where($srchcol);
		}

		$query = $this->db->get();
		// echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}
	
	
}