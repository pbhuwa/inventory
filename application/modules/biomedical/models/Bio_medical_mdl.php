<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bio_medical_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'bmin_bmeinventory';
        $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
        $this->sess_dept = $this->session->userdata(USER_DEPT);
    }
    
    
    public $validate_settings_biomedical = array(array('field' => 'bmin_descriptionid', 'label' => 'Equi. Desc', 'rules' => 'trim|required|xss_clean'), array('field' => 'bmin_departmentid', 'label' => 'Department', 'rules' => 'trim|required|xss_clean'), array('field' => 'bmin_servicedate', 'label' => 'Service Date', 'rules' => 'trim|required|valid_date'), array('field' => 'bmin_endwarranty', 'label' => 'End Warrenty', 'rules' => 'trim|required|valid_date'), array('field' => 'bmin_riskid', 'label' => 'Risk Value', 'rules' => 'trim|required|xss_clean'), array('field' => 'bmin_cost', 'label' => 'Cost', 'rules' => 'trim|numeric|xss_clean')
    // array('field' => 'bmin_makeyear', 'label' => 'Make year', 'rules' => 'trim|required|numeric|xss_clean'),
        );
    
    public $validate_settings_biomedical_comments = array(array('field' => 'eqco_comment', 'label' => 'Problem Description', 'rules' => 'trim|required|xss_clean'));
    
    public $validate_settings_biomedical_maintenance = array(array('field' => 'malo_comment', 'label' => 'Problem Description', 'rules' => 'trim|required|xss_clean'));
    
    
    public function get_equipmentlist_for_code($srchcol = false)
    {
        $this->db->select('el.eqli_code,bm.*,di.dept_depcode');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqli_equipmentlist el', 'el.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT');
        $this->db->join('dept_department di', 'di.dept_depid=bm.bmin_departmentid', 'LEFT');
        $this->db->where('eqli_code<>', '');
        //$this->db->join()
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        $this->db->order_by('bm.bmin_descriptionid', 'ASC');
        //     $sql="SELECT  el.eqli_code,bm.* from xw_bmin_bmeinventory bm LEFT JOIN
        // xw_eqli_equipmentlist el on el.eqli_equipmentlistid=bm.bmin_descriptionid 
        // WHERE eqli_code <>''
        // ORDER BY bm.bmin_descriptionid ASC";
        $qry = $this->db->get();
        //echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
        
    }
    
    
    
    public function biomedicalinven_save()
    {
        $postdata = $this->input->post();
        // echo "<pre>";
        // print_r($postdata);
        // die();
        
        $servicedate     = $this->input->post('bmin_servicedate');
        $endwarrantydate = $this->input->post('bmin_endwarranty');
        $donatedate      = $this->input->post('bmin_donatedate');
        
        unset($postdata['bmin_servicedate']);
        unset($postdata['bmin_endwarranty']);
        unset($postdata['bmin_donatedate']);
        
        if (DEFAULT_DATEPICKER == 'NP') {
            $servicedatenp = $servicedate;
            $servicedateen = $this->general->NepToEngDateConv($servicedate);
            $donatedatenp  = $donatedate;
            $donatedateen  = $this->general->NepToEngDateConv($donatedate);
            
        } else {
            $servicedateen = $servicedate;
            $servicedatenp = $this->general->EngToNepDateConv($servicedate);
            $donatedateen  = $donatedate;
            $donatedatenp  = $this->general->EngToNepDateConv($donatedate);
        }
        if (DEFAULT_DATEPICKER == 'NP') {
            $endwarrantydatenp = $endwarrantydate;
            $endwarrantydateen = $this->general->NepToEngDateConv($endwarrantydate);
        } else {
            $endwarrantydateen = $endwarrantydate;
            $endwarrantydatenp = $this->general->EngToNepDateConv($endwarrantydate);
        }
        
        $postdata['bmin_servicedatebs']     = $servicedatenp;
        $postdata['bmin_servicedatead']     = $servicedateen;
        $postdata['bmin_endwarrantydatebs'] = $endwarrantydatenp;
        $postdata['bmin_endwarrantydatead'] = $endwarrantydateen;
        $postdata['bmin_donatedatead']      = $donatedateen;
        $postdata['bmin_donatedatebs']      = $donatedatenp;
        
        
        $id = $this->input->post('id');
        unset($postdata['id']);
        if ($id) {
            $bmin_old_billattachment   = $this->input->post('bmin_old_billattachment');
            $bmin_old_personattachment = $this->input->post('bmin_old_personattachment');
            unset($postdata['bmin_old_billattachment']);
            unset($postdata['bmin_old_personattachment']);
            $postdata['bmin_modifydatead']     = CURDATE_EN;
            $postdata['bmin_modifydatebs']     = CURDATE_NP;
            $postdata['bmin_modifytime']       = $this->general->get_currenttime();
            $postdata['bmin_modifyby']         = $this->session->userdata(USER_ID);
            $postdata['bmin_modifyip']         = $this->general->get_real_ipaddr();
            $postdata['bmin_modifymac']        = $this->general->get_Mac_Address();
            $postdata['bmin_billattachment']   = !empty($this->billattachment) ? $this->billattachment : $bmin_old_billattachment;
            $postdata['bmin_personattachment'] = !empty($this->knownattachment) ? $this->knownattachment : $bmin_old_personattachment;
            
            if (!empty($postdata)) { ///echo"<pre>"; print_r($postdata); die;
                $this->general->save_log($this->table, 'bmin_equipid', $id, $postdata, 'Update');
                $this->db->update($this->table, $postdata, array(
                    'bmin_equipid' => $id
                ));
                $rowaffected = $this->db->affected_rows();
                if ($rowaffected) {
                    return $rowaffected;
                } else {
                    return false;
                }
            }
        } else {
            $postdata['bmin_postdatead']       = CURDATE_EN;
            $postdata['bmin_postdatebs']       = CURDATE_NP;
            $postdata['bmin_posttime']         = $this->general->get_currenttime();
            $postdata['bmin_postby']           = $this->session->userdata(USER_ID);
            $postdata['bmin_postip']           = $this->general->get_real_ipaddr();
            $postdata['bmin_postmac']          = $this->general->get_Mac_Address();
            $postdata['bmin_orgid']            = $this->session->userdata(ORG_ID);
            $postdata['bmin_billattachment']   = $this->billattachment;
            $postdata['bmin_personattachment'] = $this->knownattachment;
            // echo "<pre>";
            // print_r($postdata);
            // die();
            $this->load->model('bio_inventory_setting_mdl');
            $autoarray = $this->bio_inventory_setting_mdl->get_auto_generated_id();
            
            
            if (!empty($postdata)) {
                $this->db->insert($this->table, $postdata);
                $insertid = $this->db->insert_id();
                if ($insertid) {
                    if ($autoarray->bise_isautogenerate == 'Y') {
                        $eqidescid = $this->input->post('bmin_descriptionid');
                        $this->db->set('eqli_maxval', 'eqli_maxval+1', FALSE);
                        $this->db->where('eqli_equipmentlistid', $eqidescid);
                        $this->db->update('eqli_equipmentlist');
                    }
                    return $insertid;
                } else {
                    return false;
                }
            }
        }
        
        return false;
        
    }
    
    
    public function upload_bill_attachment_images()
    {
        $image1_name = $this->file_settings_do_upload('bmin_billattachment', BILL_ATTACHMENT_PATH);
        // print_r($image1_name);
        // die();
        // echo $this->session->userdata('bill_error');
        if ($image1_name !== false) {
            $this->billattachment = $image1_name['file_name'];
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function upload_known_attachment_images()
    {
        $image2_name = $this->file_settings_do_upload('bmin_personattachment', KNOWN_ATTACHMENT_PATH);
        // print_r($image2_name);
        // die();
        // echo $this->session->userdata('bill_error');
        if ($image2_name !== false) {
            $this->knownattachment = $image2_name['file_name'];
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function file_settings_do_upload($file, $path)
    {
        // echo $file;
        // echo $path;
        // die();
        
        $config['upload_path']   = './' . $path; //define in constants
        $config['allowed_types'] = 'gif|jpg|png|docx|pdf|bmp|doc|xls|xlsx';
        $config['remove_spaces'] = TRUE;
        //$config['overwrite'] = TRUE;  
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = '5000';
        $config['max_width']     = '5000';
        $config['max_height']    = '5000';
        $this->upload->initialize($config);
        // print_r($_FILES);
        // die();
        
        $this->upload->do_upload($file);
        if ($this->upload->display_errors()) {
            
            
            $this->error_img = $this->upload->display_errors();
            // $this->error_img;
            if ($file == 'bmin_billattachment') {
                $this->session->set_userdata('bill_error', $this->error_img);
            }
            
            if ($file == 'bmin_personattachment') {
                $this->session->set_userdata('known_attach_error', $this->error_img);
            }
            return false;
        } else {
            
            $data = $this->upload->data();
            return $data;
        }
    }
    
    public function comment_save()
    {
        $postdata['eqco_postdatead'] = CURDATE_EN;
        $postdata['eqco_postdatebs'] = CURDATE_NP;
        $postdata['eqco_posttime'] = $this->general->get_currenttime();
        $postdata['eqco_postby']  = $this->session->userdata(USER_ID);
        $postdata['eqco_postip']  = $this->general->get_real_ipaddr();
        $postdata['eqco_postmac'] = $this->general->get_Mac_Address();
        $postdata['eqco_comment'] = $this->input->post('eqco_comment');
        $postdata['eqco_eqid'] = $this->input->post('eqco_eqid');
        $postdata['eqco_isdepapproved'] = 0;
        $postdata['eqco_isdepheadapproved'] = 0;
        $postdata['eqco_orgid'] = $this->session->userdata(ORG_ID);
        $postdata['eqco_locationid'] = $this->session->userdata(LOCATION_ID);
        $postdata['eqco_requestno'] = $this->general->generate_invoiceno('eqco_requestno','eqco_requestno','eqco_equipmentcomment',EQUIPMENT_COMMENT_NO_PREFIX,EQUIPMENT_COMMENT_NO_LENGTH,false,'eqco_locationid','eqco_equipmentcommentid DESC','M',false,'Y');
        //$postdata['eqco_requestno'] = $this->input->post('eqco_requestno');
        // echo "<pre>";
        // print_r($postdata);
        // die();
        
        
        if (!empty($postdata)) {
            $this->db->insert('eqco_equipmentcomment', $postdata);
            $insertid = $this->db->insert_id();
            if ($insertid) {
                return $insertid;
            } else {
                return false;
            }
        }
    }
    public function maintenance_save()
    {
        $postdata['malo_postdatead']    = CURDATE_EN;
        $postdata['malo_postdatebs']    = CURDATE_NP;
        $postdata['malo_posttime']      = $this->general->get_currenttime();
        $postdata['malo_postby']        = $this->session->userdata(USER_ID);
        $postdata['malo_postip']        = $this->general->get_real_ipaddr();
        $postdata['malo_postmac']       = $this->general->get_Mac_Address();
        $postdata['malo_comment']       = $this->input->post('malo_comment');
        $postdata['malo_equipid']       = $this->input->post('malo_equipid');
        $postdata['malo_commentdatead'] = $this->input->post('malo_commentdatead');
        $postdata['malo_commentdatebs'] = $this->input->post('malo_commentdatebs');
        // $postdata['malo_maintainedbyid'] = $this->input->post('malo_maintainedbyid');
        //$postdata['malo_depid'] = $this->input->post('malo_depid');
        $postdata['malo_remark']        = $this->input->post('malo_remark');
        $postdata['malo_time']          = $this->input->post('malo_time');
        
        // $postdata['malo_orgid']=$this->session->userdata(ORG_ID);
        // echo "<pre>";
        // print_r($postdata);
        // die();
        
        
        if (!empty($postdata)) {
            $this->db->insert('malo_maintenancelog', $postdata);
            $insertid = $this->db->insert_id();
            if ($insertid) {
                return $insertid;
            } else {
                return false;
            }
        }
    }
    
    
    public function get_biomedical_inventory($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false, $groupby = false)
    {
        $fromdate = $this->input->post('fromdate');
        $todate   = $this->input->post('todate');
        $srchdate = $this->input->post('date');
        $srchtxt  = $this->input->post('srchtext');
        
        $this->db->select('dis.dist_distributorid,eql.eqli_equipmentlistid,di.dept_depid,bm.*,eql.eqli_description,di.dept_depname as dein_department,ri.riva_risk,ri.riva_risktype, ri.riva_year,ri.riva_riskcount,ri.riva_times, dis.dist_distributor,mf.manu_manlst,rd.rode_roomname,dam.dist_distributor as amc_contractor,so.pudo_purdonated ');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT');
        $this->db->join('dept_department di', 'di.dept_depid=bm.bmin_departmentid', 'LEFT');
        $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
        $this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
        $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = bm.bmin_manufacturerid', 'LEFT');
        $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
        $this->db->join('dist_distributors dam', 'dam.dist_distributorid = bm.bmin_amcontractorid', 'LEFT');
        $this->db->join('pudo_purchdonate so', 'so.pudo_purdonatedid = bm.bmin_purch_donatedid', 'LEFT');
        
         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        
        if ($srchdate == 'se_st_date') {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('bmin_servicedatebs >=', $fromdate);
                $this->db->where('bmin_servicedatebs <=', $todate);
            } else {
                $this->db->where('bmin_servicedatead >=', $fromdate);
                $this->db->where('bmin_servicedatead <=', $todate);
            }
            
        }
        if ($srchdate == 'sr_end_war_date') {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('bmin_endwarrantydatebs >=', $fromdate);
                $this->db->where('bmin_endwarrantydatebs <=', $todate);
            } else {
                $this->db->where('bmin_endwarrantydatead >=', $fromdate);
                $this->db->where('bmin_endwarrantydatead <=', $todate);
            }
        }
        if ($srchtxt) {
            $this->db->where("bm.bmin_equipmentkey like  '%" . $srchtxt . "%'  ");
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        $this->db->set_dbprefix('');
        // print_r($groupby);die;
        if ($groupby) {
            $this->db->group_by($groupby);
        }
        $this->db->set_dbprefix('xw_');
        $qry = $this->db->get();
        // echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function overview_reports($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        $this->db->select('bm.*,eql.eqli_description,di.dept_depname as dein_department, ri.riva_risk, ri.riva_times, dis.dist_distributor, eqt.eqty_equipmenttype, rd.rode_roomname, mf.manu_manlst, mf.manu_address1, mf.manu_address2, mf.manu_email, mf.manu_website, mf.manu_phone1, pd.pudo_purdonated, cu.cuty_currencytypename, pm.pmta_pmtableid');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT');
        // $this->db->join('dept_department di','di.dein_departmentid=bm.bmin_departmentid','LEFT');
        $this->db->join('eqty_equipmenttype eqt', 'eqt.eqty_equipmenttypeid = bm.bmin_equipmenttypeid', 'LEFT');
        $this->db->join('dept_department di', 'di.dept_depid=bm.bmin_departmentid', 'LEFT');
        $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
        $this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
        $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
        $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = bm.bmin_manufacturerid', 'LEFT');
        $this->db->join('pudo_purchdonate pd', 'pd.pudo_purdonatedid = bm.bmin_purch_donatedid', 'LEFT');
        $this->db->join('cuty_currencytype cu', 'cu.cuty_currencytypeid = bm.bmin_currencytypeid', 'LEFT');
        
        $this->db->join('pmta_pmtable  pm', 'pm.pmta_equipid = bm.bmin_equipid', 'LEFT');

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        $qry = $this->db->get();
        //echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function overview_comments_count($srchcol = false)
    {
        $this->db->select('*');
        $this->db->from('bmin_bmeinventory bm');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        $qry = $this->db->get();
        //echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    
    public function overview_decommission_count($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        $this->db->select('bm.*, un.*');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('ureq_unrepaireqipment  un', 'un.ureq_equipid = bm.bmin_equipid');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        $qry = $this->db->get();
        //echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function overview_pmtable_reports($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        $this->db->select('bm.*, pm.*');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('pmta_pmtable  pm', 'pm.pmta_equipid = bm.bmin_equipid');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        $qry = $this->db->get();
        //echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    
    public function overview_repair_reports($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        $this->db->select('bm.*, re.*, d.dept_depname');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('rere_repairrequests  re', 're.rere_repairrequestid = bm.bmin_equipid');
        $this->db->join('dept_department d', 'd.dept_depid = bm.bmin_departmentid');

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        $qry = $this->db->get();
        //echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function overview_pmcompleted_reports($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        $this->db->select('bm.*, pm.*');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('pmco_pmcompleted  pm', 'pm.pmco_equipid = bm.bmin_equipid');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        $qry = $this->db->get();
        //echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    public function overview_comments_reports($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        $this->db->select('bm.*, eqpc.*,u.usma_username as postby, um.usma_username as approvedby');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqco_equipmentcomment  eqpc', 'eqpc.eqco_eqid = bm.bmin_equipid');
        $this->db->join('usma_usermain u', 'u.usma_userid = eqpc.eqco_postby', 'left');
        $this->db->join('usma_usermain um', 'um.usma_userid = eqpc.eqco_approvedby', 'left');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        $qry = $this->db->get();
        //echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    public function overview_maintenance_reports($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        $this->db->select('ml.*,eql.eqli_description,di.dept_depname,um.usma_username,bm.bmin_equipmentkey');
        $this->db->from('malo_maintenancelog ml');
        $this->db->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=ml.malo_equipid', 'LEFT');
        $this->db->join('bmin_bmeinventory bm', 'bm.bmin_equipid=ml.malo_equipid', 'LEFT');
        $this->db->join('dept_department di', 'di.dept_depid=ml.malo_depid', 'LEFT');
        $this->db->join('usma_usermain um', 'um.usma_userid=ml.malo_maintainedbyid', 'LEFT');
        
        
        
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        $qry = $this->db->get();
        //echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    public function get_selected_pmdata($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        $this->db->select('*');
        $this->db->from('pmta_pmtable');
        
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        // echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    public function get_selected_amcdata($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        $this->db->select('*');
        $this->db->from('amta_amctable');
        
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        // echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function get_pm_history($srchcol = false)
    {
        // $this->db->select('pm.*, pmc.*');
        // $this->db->from('pmta_pmtable pm');
        // $this->db->join('pmco_pmcompleted as pmc', 'pmc.pmco_equipid = pm.pmta_equipid');
        $this->db->select('*');
        $this->db->from('pmta_pmtable pm');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        // echo $this->db->last_query();die();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function get_biomedical_inventory_list($cond = false)
    {
        $get = $_GET;
        
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if (!empty($get['sSearch_0'])) {
            $this->db->where("bmin_equipid like  '%" . $get['sSearch_0'] . "%' ");
        }
        if (!empty($get['sSearch_1'])) {
            $this->db->where("bmin_equipmentkey like  '%" . $get['sSearch_1'] . "%' ");
        }
        
        if (!empty($get['sSearch_2'])) {
            $this->db->where("eqli_description like  '%" . $get['sSearch_2'] . "%' ");
        }
        
        if (!empty($get['sSearch_3'])) {
            $this->db->where("di.dept_depname like  '%" . $get['sSearch_3'] . "%'  ");
        }
        
        if (!empty($get['sSearch_4'])) {
            $this->db->where("mf.manu_manlst like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("ri.riva_risk like  '%" . $get['sSearch_5'] . "%'  ");
        }
        $this->db->where('bmin_isunrepairable ', "N");
        $this->db->where('bmin_isdelete ', "N");
        
        if ($cond) {
            $this->db->where($cond);
        }

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        $this->db->where('bmin_isdelete','N');
        
        $resltrpt  = $this->db->select("COUNT(*) as cnt")->from('bmin_bmeinventory bm')->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT')->join('dept_department di', 'di.dept_depid=bm.bmin_departmentid', 'LEFT')->join('manu_manufacturers mf', 'mf.manu_manlistid=bm.bmin_manufacturerid', 'LEFT')->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT')->get()->row();
        $totalfilteredrecs = $resltrpt->cnt;
        // echo $totalfilteredrecs;
        // die();
        
        $order_by = 'bm.bmin_equipid';
        $order    = 'desc';
        
        $where = '';
        if ($this->input->get('iSortCol_0') == 0)
            $order_by = 'bm.bmin_equipid';
        else if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'bm.bmin_equipmentkey';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'eql.eqli_description';
        else if ($this->input->get('iSortCol_0') == 3)
        // $order_by = 'di.dein_department';
            $order_by = 'di.dept_depname';
        else if ($this->input->get('iSortCol_0') == 4)
            $order_by = 'mf.manu_manlst';
        else if ($this->input->get('iSortCol_0') == 5)
            $order_by = 'ri.riva_risk';
        
        if ($this->input->get('sSortDir_0') == 'desc')
            $order = 'desc';
        else if ($this->input->get('sSortDir_0') == 'asc')
            $order = 'asc';
        
        $totalrecs = '';
        $limit     = 15;
        $offset    = 1;
        
        $get = $_GET;
        
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        
        if (!empty($_GET["iDisplayLength"])) {
            $limit  = ($_GET['iDisplayLength'] != '-1')?$_GET['iDisplayLength']:'';
            $offset = $_GET["iDisplayStart"];
        }
        
        if (!empty($get['sSearch_0'])) {
            $this->db->where("bmin_equipid like  '%" . $get['sSearch_0'] . "%' ");
        }
        if (!empty($get['sSearch_1'])) {
            $this->db->where("bm.bmin_equipmentkey like  '%" . $get['sSearch_1'] . "%' ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("eqli_description like  '%" . $get['sSearch_2'] . "%' ");
        }
        
        if (!empty($get['sSearch_3'])) {
            $this->db->where("di.dept_depname like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("mf.manu_manlst like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("ri.riva_risk like  '%" . $get['sSearch_5'] . "%'  ");
        }
        $this->db->select('bm.bmin_equipid,bm.bmin_equipmentkey,bm.bmin_descriptionid,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_departmentid,bm.bmin_riskid,bm.bmin_equip_oper,bm.bmin_manufacturerid,bm.bmin_distributorid,bm.bmin_amc,bm.bmin_servicedatead,bm.bmin_servicedatebs,bm.bmin_endwarrantydatead,bm.bmin_endwarrantydatebs,bm.bmin_purch_donatedid,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_amcontractorid,bm.bmin_accessories ,bm.bmin_comments,bm.bmin_currencytypeid,bm.bmin_cost,bm.bmin_removed,bm.bmin_isprintsticker,bm.bmin_postdatead,bm.bmin_postdatebs,bm.bmin_posttime,bm.bmin_postmac,bm.bmin_postip,bm.bmin_postby,bm.bmin_modifydatead,bm.bmin_modifydatebs,bm.bmin_modifytime,bm.bmin_modifymac,bm.bmin_modifyip,bm.bmin_modifyby,bm.bmin_isunrepairable,bm.bmin_isdelete,eql.eqli_description,di.dept_depname, mf.manu_manlst, ri.riva_risk');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT');
        $this->db->join('dept_department di', 'di.dept_depid=bm.bmin_departmentid', 'LEFT');
        $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid=bm.bmin_manufacturerid', 'LEFT');
        $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
        $this->db->where('bmin_isunrepairable ', "N");
        $this->db->where('bmin_isdelete ', "N");
        
        
        if ($cond) {
            $this->db->where($cond);
        }
        $this->db->order_by($order_by, $order);
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        
        $nquery  = $this->db->get();
        //echo $this->db->last_query(); die();
        $num_row = $nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
        }
        
        
        if ($num_row > 0) {
            $ndata                      = $nquery->result();
            $ndata['totalrecs']         = $totalrecs;
            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {
            $ndata                      = array();
            $ndata['totalrecs']         = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        // echo $this->db->last_query();die();
        return $ndata;
    }
    public function get_eqp_from_bmin($cond)
    {
        $this->db->select('bm.bmin_equipid,bm.bmin_equipmentkey,eql.eqli_description');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT');
        if ($cond) {
            $this->db->where($cond);
        }
        $qry = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function get_equipmentlist($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        
        $this->db->select('*');
        $this->db->from('eqli_equipmentlist');
        
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
        
        
    }
    public function get_usmain($srchcol)
    {
        $this->db->select('usma_username');
        $this->db->from('usma_usermain');
        $this->db->where('usma_userid', $srchcol);
        
        
        
        $qry = $this->db->get();
        //echo $this->db->last_query();
        // die();
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
        
    }
    
    
    public function get_departmentinfo($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        
        $this->db->select('*');
        $this->db->from('dept_department');
        
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
        
    }
    // public function get_department($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
    // {
    
    //   $this->db->select('bm.*,dp.*');
    //   $this->db->from('bmin_bmeinventory bm');
    //   $this->db->join('dept_department dp','dp.dept_depid=bm.bmin_departmentid','LEFT');
    
    //   if($srchcol)
    //   {
    //      $this->db->where($srchcol); 
    //   }
    
    //  $qry=$this->db->get();
    //   // echo $this->db->last_query();
    //   // die();
    //  if($qry->num_rows()>0)
    //  {
    //   return $qry->result();
    //  }
    //  return false;
    
    // }
    
    
    public function get_riskvalue($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        
        $this->db->select('*');
        $this->db->from('riva_riskvalues');
        
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function get_manufacturer($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        
        $this->db->select('*');
        $this->db->from('manu_manufacturers');
        
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function get_distributor_list($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        
        $this->db->select('*');
        $this->db->from('dist_distributors');
        
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function get_purchase_donate_list($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = false)
    {
        
        $this->db->select('*');
        $this->db->from('pudo_purchdonate');
        
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function get_biomedical_report()
    {
        $this->db->select('DISTINCT(dein_department), dein_departmentid');
        $this->db->from('dept_department');
        
        $qry = $this->db->get();
        
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function get_biomedical_inventry_report($srch = false, $limit = false, $offset = false, $order_by = false, $order = 'ASC')
    {
        $this->db->select('bm.*, riva.riva_risk');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('riva_riskvalues riva', 'riva.riva_riskid=bm.bmin_riskid', 'LEFT');
        //$this->db->join()
        if ($srch) {
            $this->db->where($srch);
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            return $sql->result();
        }
        return false;
    }


    public function get_user_repair_request_list()
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        $searchDateType = $get['searchDateType'];
        $locationid = $get['locationid'];
        $departmentid = $get['departmentid'];
        $frmDate = $get['frmDate'];
        $toDate = $get['toDate'];

        $this->db->start_cache();

        if (!empty($locationid)) {
            $this->db->where('eqco_locationid',$locationid);
        }

        if (!empty($departmentid)) {
            $this->db->where('dept_depid',$departmentid);
        }

        if ($searchDateType == 'date_range') {
            if (!empty($frmDate) && !empty($toDate)) {
                if (DEFAULT_DATEPICKER == "NP") {
                    $this->db->where('eqco_postdatebs >=',$frmDate); 
                    $this->db->where('eqco_postdatebs <=',$toDate); 
                }else{
                    $this->db->where('eqco_postdatead >=',$frmDate); 
                    $this->db->where('eqco_postdatead <=',$toDate); 
                }
            }
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("eqco_requestno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("bmin_equipmentkey like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("bmin_comments like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("di.dept_depname like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("eqco_comment like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("usma_fullname like  '%".$get['sSearch_6']."%'  ");
        }


         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        $this->db->stop_cache();
         
        $resltrpt=$this->db->select("COUNT(*) as cnt")
            ->from('eqco_equipmentcomment ec')
            ->join('bmin_bmeinventory bm','bm.bmin_equipid=ec.eqco_eqid','left')
             ->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT')
            ->join('usma_usermain um','um.usma_userid=ec.eqco_postby','left')
            ->get()
            ->row();
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'eqco_equipmentcommentid';
        $order = 'desc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'eqco_requestno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'bmin_equipmentkey';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'bmin_comments';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'dein_department';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'eqco_comment';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'usma_fullname';
        
        $totalrecs='';
        $limit = 10;
        $offset = 1;
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }


        $this->db->select("ec.*,um.usma_fullname,bm.bmin_comments, bm.bmin_equipmentkey, di.dept_depname as dein_department,eql.eqli_description");
        $this->db->from('eqco_equipmentcomment ec');
        $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid=ec.eqco_eqid','left');
        $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
        $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
        $this->db->join('usma_usermain um','um.usma_userid=ec.eqco_postby','left');
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
       $this->db->flush_cache();

       $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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
      return $ndata;
    }

    
    public function get_repair_request_rec()
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $where = '';
        
        if (!empty($get['sSearch_0'])) {
            $where .= "WHERE bm.bmin_equipid LIKE '%" . $get['sSearch_0'] . "%'";
        }
        
        
        if (!empty($get['sSearch_1'])) {
            $where .= "WHERE eqli_description LIKE '%" . $get['sSearch_1'] . "%'";
        }

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        
        
        $resltrpt          = $this->db->query("SELECT COUNT(*) as cnt FROM xw_eqco_equipmentcomment  $where ")->row();
        // echo $this->db->last_query();
        // die();
        $totalfilteredrecs = $resltrpt->cnt;
        
        $order_by = 'bm.bmin_equipid';
        $order    = 'desc';
        
        $where = '';
        if ($this->input->get('iSortCol_0') == 0)
            $order_by = 'bm.bmin_equipid';
        else if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'eql.eqli_description';
        else if ($this->input->get('iSortCol_0') == 2)
        // $order_by = 'di.dein_department';
            $order_by = 'di.dept_depname';
        
        if ($this->input->get('sSortDir_0') == 'desc')
            $order = 'desc';
        else if ($this->input->get('sSortDir_0') == 'asc')
            $order = 'asc';
        
        $totalrecs = '';
        $limit     = 15;
        $offset    = 1;
        
        $get = $_GET;
        
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        
        if (!empty($_GET["iDisplayLength"])) {
            $limit  = ($_GET['iDisplayLength'] != '-1')?$_GET['iDisplayLength']:'';
            $offset = $_GET["iDisplayStart"];
        }
        
        if (!empty($get['sSearch_0'])) {
            $this->db->where("bmin_equipid like  '%" . $get['sSearch_0'] . "%'  ");
        }
        
        if (!empty($get['sSearch_1'])) {
            $this->db->where("eqli_description like  '%" . $get['sSearch_1'] . "%'  ");
        }
        
        if (!empty($get['sSearch_2'])) {
            // $this->db->where("dein_department like  '%".$get['sSearch_2']."%'  ");
            $this->db->where("dept_depname like  '%" . $get['sSearch_2'] . "%'  ");
        }
        
        
        $this->db->select('ec.*,um.usma_fullname,bm.');
        $this->db->from('eqco_equipmentcomment ec');
        $this->db->join('bmin_bmeinventory bm', 'bm.bmin_equipid=ec.eqco_eqid', 'left');
        // $this->db->join('dept_department di','di.dein_departmentid=bm.bmin_departmentid','left');
        $this->db->join('dept_department di', 'di.dept_depid=bm.bmin_departmentid', 'left');
        $this->db->join('usma_usermain um', 'um.usma_userid=ec.eqco_postby', 'left');
        
        
        
        
        
        $this->db->order_by($order_by, $order);
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
           $new_sess_dept = explode(',',$this->sess_dept);
           $this->db->where_in('dept_depid',$new_sess_dept);
          }

        $nquery  = $this->db->get();
        // echo $this->db->last_query();
        // die();
        $num_row = $nquery->num_rows();
        if (!empty($_GET['iDisplayLength'])) {
            $totalrecs = sizeof($nquery);
        }
        
        
        if ($num_row > 0) {
            $ndata                      = $nquery->result();
            $ndata['totalrecs']         = $totalrecs;
            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {
            $ndata                      = array();
            $ndata['totalrecs']         = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        // echo $this->db->last_query();die();
        return $ndata;
    }
    
    public function get_equip_comment($srchcol = false)
    {
        $this->db->select('ec.*,um.usma_fullname');
        $this->db->from('eqco_equipmentcomment ec');
        $this->db->join('usma_usermain um', 'um.usma_userid=ec.eqco_postby', 'LEFT');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        $this->db->order_by('eqco_equipmentcommentid', 'DESC');
        $qry = $this->db->get();
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function get_biomedical_inventry_data($srchcol = false)
    {
        $this->db->select('bm.*,eql.eqli_description,di.dept_depname as dein_department, ri.riva_risk, ri.riva_times, dis.dist_distributor, mf.manu_manlst');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT');
        $this->db->join('dept_department di', 'di.dept_depid=bm.bmin_departmentid', 'LEFT');
        $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
        $this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
        $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = bm.bmin_manufacturerid', 'LEFT');

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        
        $qry = $this->db->get();
        
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function delete_inventory($delid = false)
    {
        try {
            if (empty($delid)) {
                throw new Exception("Error Processing Request", 1);
            }
            $this->general->save_log($this->table, 'bmin_equipid', $delid, $postdata = array(), 'Delete');
            $where = array(
                'bmin_equipid' => $delid
            );
            
            $data = array(
                'bmin_isdelete' => 'Y',
                'bmin_modifydatead' => CURDATE_EN,
                'bmin_modifydatebs' => CURDATE_NP,
                'bmin_modifytime' => $this->general->get_currenttime(),
                'bmin_modifyby' => $this->session->userdata(USER_ID),
                'bmin_modifyip' => $this->general->get_real_ipaddr(),
                'bmin_modifymac' => $this->general->get_Mac_Address()
            );
            
            $this->db->where($where);
            if ($this->db->update($this->table, $data))
                return true;
            else
                throw new Exception("Error Processing Request", 1);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function remove_bio_comment()
    {
        $id = $this->input->post('id');
        if ($id) {
            $this->db->delete('eqco_equipmentcomment', array(
                'eqco_equipmentcommentid' => $id
            ));
            $rowaffected = $this->db->affected_rows();
            if ($rowaffected) {
                return $rowaffected;
            }
            return false;
        }
        return false;
    }
    
    
    public function get_department_wise_report()
    {
        $this->db->select("bm.bmin_departmentid,COUNT('*') as cnt,dept_depname");
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('dept_department dp', 'dp.dept_depid=bm.bmin_departmentid', 'inner');
        $this->db->group_by('bm.bmin_departmentid');
        $this->db->order_by('bm.bmin_departmentid', 'ASC');

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        $qry = $this->db->get();
        // echo $this->db->last_query();
        // die();
        
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
        
    }
    
    public function get_column_wise_report($table1, $table2 = false, $where = false, $select, $join = false, $jointype = 'INNER', $group_by, $order_by = false, $order = 'ASC')
    {
        $this->db->select($select);
        $this->db->from($table1);
        if ($table2) {
            if ($join) {
                $this->db->join($table2, $join, $jointype);
            }
        }
        
        
        $this->db->group_by($group_by);
        if ($where) {
            $this->db->where($where);
        }
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        
        
        $qry = $this->db->get();
        ;
        // die();
        
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
        
    }
    
    public function warrantywise_checker()
    {
        $query1 = "SELECT bmin_descriptionid,el.eqli_description, SUM(inwarr) inwarr, SUM(outwarr) outwarr FROM ( select bmin_descriptionid, Count(*) as inwarr,0 As outwarr from xw_bmin_bmeinventory WHERE bmin_endwarrantydatead<>'0' AND bmin_endwarrantydatead> '" . CURDATE_EN . "'GROUP BY bmin_descriptionid";
        $query2 = "select bmin_descriptionid,0 as inwarr,Count(*) as outwarr from xw_bmin_bmeinventory WHERE bmin_endwarrantydatead<>'0' AND bmin_endwarrantydatead< '" . CURDATE_EN . "'GROUP BY bmin_descriptionid ) Z LEFT JOIN  xw_eqli_equipmentlist el on Z.bmin_descriptionid=el.eqli_equipmentlistid  GROUP BY bmin_descriptionid,el.eqli_description";
        $query  = $query1 . ' UNION ' . $query2;
        
        $sql = $this->db->query($query);
        //echo "<pre>";print_r($sql->result());die;
        return $sql->result();
    }
    
    public function get_warrenty_reports()
    {
        $this->db->select('bm.bmin_descriptionid,COUNT(' * ') as cnt,eqli_description');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqli_equipmentlist eq', 'eq.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT');
        
        $this->db->group_by('bm.bmin_descriptionid');
        
        $this->db->order_by('eqli_description', 'ASC');
        
        
        $qry = $this->db->get();
        // die();
        
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    public function in_warrenty()
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->where('bm.bmin_endwarrantydatebs >', CURDATE_NP);
        
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        }
        return false;
    }
    
    
    public function out_warrenty()
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->where('bm.bmin_endwarrantydatebs <', CURDATE_NP);
        
        
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        }
        return false;
    }
    
    
    public function get_equip_key($srchcol = false, $limit = false)
    {
        $this->db->select("bm.*, eql.*");
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        $qry = $this->db->get();
        
        
        if ($qry->num_rows() > 0) {
            return $qry->result();
        }
        return false;
    }
    
    
    
    
    public function get_allreport_list($cond = false)
    {
        $get = $_GET;
        $description_id = !empty($get['description_id']) ? $get['description_id'] : '';

        $department_id = !empty($get['department_id']) ? $get['department_id'] : '';
        $amc_id = !empty($get['amc_id']) ? $get['amc_id'] : '';
        $distributor_id = !empty($get['distributor_id']) ? $get['distributor_id'] : '';
        $purchase_id = !empty($get['purchase_id']) ? $get['purchase_id'] : '';
        $fromdate= !empty($get['fromdate']) ? $get['fromdate'] : '';
        $todate= !empty($get['todate']) ? $get['todate'] : '';
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
       if (!empty($get['sSearch_0'])) {
            $this->db->where("bmin_equipid like  '%" . $get['sSearch_0'] . "%'  ");
        }
        
        if (!empty($get['sSearch_1'])) {
            $this->db->where("bmin_equipmentkey like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("eqli_description like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("dept_depname like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("rode_roomname like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("bmin_modelno like  '%" . $get['sSearch_5'] . "%'  ");
        }
        
        if (!empty($get['sSearch_6'])) {
            $this->db->where("bmin_serialno like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("manu_manlst like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if (!empty($get['sSearch_8'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_8'] . "%'  ");
        }
        if (!empty($get['sSearch_9'])) {
            $this->db->where("riva_risk like  '%" . $get['sSearch_9'] . "%'  ");
        }
        if (!empty($get['sSearch_10'])) {
            $this->db->where("bmin_amc like  '%" . $get['sSearch_10'] . "%'  ");
        }
        if (!empty($get['sSearch_11'])) {
            $this->db->where("bmin_equip_oper like  '%" . $get['sSearch_11'] . "%'  ");
        }
        if (!empty($get['sSearch_12'])) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where("bmin_servicedatebs like  '%" . $get['sSearch_12'] . "%'  ");
            } else {
                $this->db->where("bmin_servicedatebs like  '%" . $get['sSearch_12'] . "%'  ");
            }
        }
        if (!empty($get['sSearch_13'])) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where("bmin_endwarrantydatebs like  '%" . $get['sSearch_13'] . "%'  ");
            } else {
                $this->db->where("bmin_endwarrantydatebs like  '%" . $get['sSearch_13'] . "%'  ");
            }
        }
        
        if (!empty($get['sSearch_14'])) {
            $this->db->where("bmin_ismaintenance like  '%" . $get['sSearch_14'] . "%'  ");
        }
        
        if ($cond) {
            $this->db->where($cond);
        }

        if(!empty($description_id)){
            $this->db->where("bmin_descriptionid", $description_id);
        }

        if(!empty($department_id)){
            $this->db->where("bmin_departmentid", $department_id);
        }

        if(!empty($amc_id)){
            $this->db->where("bmin_amc", $amc_id);
        }

        if(!empty($distributor_id)){
            $this->db->where("bmin_distributorid", $distributor_id);
        }

         if(!empty($purchase_id)){
            $this->db->where("bmin_purch_donatedid", $purchase_id);
        }
       
          if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
        $this->db->where('bmin_isdelete','N');
        
        $this->db->select("*")
        ->from('bmin_bmeinventory bm')
        ->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT')
        ->join('dept_department di', 'di.dept_depid=bm.bmin_departmentid', 'LEFT')
        ->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT')
        ->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT')
        ->join('manu_manufacturers mf', 'mf.manu_manlistid = bm.bmin_manufacturerid', 'LEFT')
        ->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT')
        ->join('dist_distributors dam', 'dam.dist_distributorid = bm.bmin_amcontractorid', 'LEFT')
        ->join('pudo_purchdonate so', 'so.pudo_purdonatedid = bm.bmin_purch_donatedid', 'LEFT');
        $resltrpt = $this->db->get()->result();
        
        // echo $this->db->last_query();die(); 
        // $totalfilteredrecs=$resltrpt->cnt;
        $totalfilteredrecs = sizeof($resltrpt);

        $order_by = 'bm.bmin_equipid';
        $order    = 'desc';
        if ($this->input->get('sSortDir_0')) {
            $order = $this->input->get('sSortDir_0');
        }

        $where = '';
       
        if ($this->input->get('iSortCol_0') == 0)
            $order_by = 'bmin_equipmentkey';
        else if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'eqli_description';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'dept_depname';
        else if ($this->input->get('iSortCol_0') == 3)
            $order_by = 'rode_roomname';
        else if ($this->input->get('iSortCol_0') == 4)
            $order_by = 'bmin_modelno';
        else if ($this->input->get('iSortCol_0') == 5)
            $order_by = 'bmin_serialno';
        else if ($this->input->get('iSortCol_0') == 6)
            $order_by = 'manu_manlst';
        else if ($this->input->get('iSortCol_0') == 7)
            $order_by = 'dist_distributor';
        else if ($this->input->get('iSortCol_0') == 8)
            $order_by = 'riva_risk';
        else if ($this->input->get('iSortCol_0') == 9)
            $order_by = 'bmin_amc';
        else if ($this->input->get('iSortCol_0') == 10)
            $order_by = 'bmin_equip_oper';
        
        
        $totalrecs = '';
        $limit     = 15;
        $offset    = 1;
        $get       = $_GET;
        
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        
        if (!empty($_GET["iDisplayLength"])) {
            $limit  = ($_GET['iDisplayLength'] != '-1')?$_GET['iDisplayLength']:'';
            $offset = $_GET["iDisplayStart"];
        }
        if (!empty($get['sSearch_0'])) {
            $this->db->where("bmin_equipid like  '%" . $get['sSearch_0'] . "%'  ");
        }
        
        if (!empty($get['sSearch_1'])) {
            $this->db->where("bmin_equipmentkey like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("eqli_description like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("dept_depname like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("rode_roomname like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("bmin_modelno like  '%" . $get['sSearch_5'] . "%'  ");
        }
        
        if (!empty($get['sSearch_6'])) {
            $this->db->where("bmin_serialno like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("manu_manlst like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if (!empty($get['sSearch_8'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_8'] . "%'  ");
        }
        if (!empty($get['sSearch_9'])) {
            $this->db->where("riva_risk like  '%" . $get['sSearch_9'] . "%'  ");
        }
        if (!empty($get['sSearch_10'])) {
            $this->db->where("bmin_amc like  '%" . $get['sSearch_10'] . "%'  ");
        }
        if (!empty($get['sSearch_11'])) {
            $this->db->where("bmin_equip_oper like  '%" . $get['sSearch_11'] . "%'  ");
        }
        if (!empty($get['sSearch_12'])) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where("bmin_servicedatebs like  '%" . $get['sSearch_12'] . "%'  ");
            } else {
                $this->db->where("bmin_servicedatebs like  '%" . $get['sSearch_12'] . "%'  ");
            }
        }
        if (!empty($get['sSearch_13'])) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where("bmin_endwarrantydatebs like  '%" . $get['sSearch_13'] . "%'  ");
            } else {
                $this->db->where("bmin_endwarrantydatebs like  '%" . $get['sSearch_13'] . "%'  ");
            }
        }
        
        if (!empty($get['sSearch_14'])) {
            $this->db->where("bmin_ismaintenance like  '%" . $get['sSearch_14'] . "%'  ");
        }
        
        if ($cond) {
            $this->db->where($cond);
        }
        if(!empty($description_id)){
            $this->db->where("bmin_descriptionid", $description_id);
        }

        if(!empty($department_id)){
            $this->db->where("bmin_departmentid", $department_id);
        }

        if(!empty($amc_id)){
            $this->db->where("bmin_amc", $amc_id);
        }

        if(!empty($distributor_id)){
            $this->db->where("bmin_distributorid", $distributor_id);
        }

         if(!empty($purchase_id)){
            $this->db->where("bmin_purch_donatedid", $purchase_id);
        }
   
        
        $this->db->select('dis.dist_distributorid,eql.eqli_equipmentlistid,di.dept_depid,bm.*,eql.eqli_description,di.dept_depname as dein_department,ri.riva_risk,ri.riva_risktype, ri.riva_year,ri.riva_riskcount,ri.riva_times, dis.dist_distributor,mf.manu_manlst,rd.rode_roomname,dam.dist_distributor as amc_contractor,so.pudo_purdonated ');
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('eqli_equipmentlist eql', 'eql.eqli_equipmentlistid=bm.bmin_descriptionid', 'LEFT');
        $this->db->join('dept_department di', 'di.dept_depid=bm.bmin_departmentid', 'LEFT');
        $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
        $this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
        $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = bm.bmin_manufacturerid', 'LEFT');
        $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
        $this->db->join('dist_distributors dam', 'dam.dist_distributorid = bm.bmin_amcontractorid', 'LEFT');
        $this->db->join('pudo_purchdonate so', 'so.pudo_purdonatedid = bm.bmin_purch_donatedid', 'LEFT');
         $this->db->where('bmin_isdelete ', "N");
        
        
        if ($cond) {
            $this->db->where($cond);
        }
        $this->db->order_by($order_by, $order);
        
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){

            $new_sess_dept = explode(',',$this->sess_dept);
            $this->db->where_in('dept_depid',$new_sess_dept);
        }
        
        $nquery = $this->db->get();
       // echo $this->db->last_query();die(); 
        
        $num_row = $nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery->result()) && count($nquery->result()) > 0 ) {
            $totalrecs = count($nquery->result());
        }
        if ($num_row > 0) {
            $ndata                      = $nquery->result();
            $ndata['totalrecs']         = $totalrecs;
            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {
            $ndata                      = array();
            $ndata['totalrecs']         = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        // echo $this->db->last_query();die();
        return $ndata;
        
    }
}