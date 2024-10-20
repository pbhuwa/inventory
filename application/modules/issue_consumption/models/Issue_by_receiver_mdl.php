<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Issue_by_receiver_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
            $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}

    public function get_issue_by_receiver($cond = false, $dist=false){
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = $this->input->post('fromdate');
        $toDate = $this->input->post('todate');
        $receivername = $this->input->post('receiverid');
        $locationid= $this->input->post('locationid');
        $cond = '';
       
        if(!empty($receivername)){
            $cond .= (" AND sm.sama_receivedby = '".$receivername."'");
        }
        if(!empty($locationid)){
             $cond .= (" AND sm.sama_locationid = $locationid ");
        }
        if($dist=='dist')
        {
         $dis_sqlst="SELECT DISTINCT(sama_receivedby)sama_receivedby from(";
         $dis_sqlen=")X ";
        }
       else
       {
        $dis_sqlst='';
        $dis_sqlen='';
    }
       
        // if(!empty($locationid)){
        //     $cond .= (" AND sm.sama_locationid = $locationid");
        // }

        $sql = "$dis_sqlst SELECT
                    itli_itemlistid,
                    qty,
                    rate,
                    (qty*rate) tamount,
                    itli_itemcode,
                    itli_itemname,
                    unit_unitname,
                    sama_receivedby,
                    sama_salemasterid,
                    sama_billdatebs,
                    sama_billdatead,
                    sama_invoiceno,
                    sama_requisitionno FROM(
                        SELECT
                            it.itli_itemlistid,
                            sd.sade_qty AS qty,
                            sd.sade_unitrate as rate,
                            sm.sama_salemasterid,
                            sm.sama_receivedby,
                            sm.sama_requisitionno,
                            it.itli_itemname,
                            u.unit_unitname,
                            it.itli_itemcode,
                            sm.sama_billdatebs,
                            sm.sama_billdatead,
                            sm.sama_invoiceno
                        FROM
                            xw_sama_salemaster sm
                        LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
                        INNER JOIN xw_itli_itemslist it ON it.itli_itemlistid = sd.sade_itemsid
                        LEFT JOIN xw_unit_unit u ON u.unit_unitid = it.itli_unitid
                        WHERE
                            sm.sama_st = 'N' AND sm.sama_billdatebs BETWEEN '$frmDate' AND '$toDate' $cond
                        GROUP BY
                            sm.sama_receivedby,
                            sm.sama_requisitionno,
                            it.itli_itemname,
                            u.unit_unitname,
                            it.itli_itemcode,
                            sm.sama_billdatebs,
                            sm.sama_billdatead,
                            sm.sama_invoiceno
                    ) p
                GROUP BY
                    p.sama_receivedby,
                    p.rate,
                    p.itli_itemcode,
                    p.itli_itemname,
                    p.unit_unitname,
                    p.sama_billdatebs,
                    p.sama_billdatead,
                    p.sama_invoiceno,
                    p.sama_requisitionno $dis_sqlen";

        $query=$this->db->query($sql);
        // echo $this->db->last_query();die;        
        if($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }

}