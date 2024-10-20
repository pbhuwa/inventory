<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Department_mdl extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'dept_department';
		// $this->table='usma_usermain';
		$this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
		$this->sess_dept = $this->session->userdata(USER_DEPT);
		$this->locationid = $this->session->userdata(LOCATION_ID);
	}


	public $validate_settings_department = array(
		array('field' => 'dept_depcode', 'label' => 'Dep. Code', 'rules' => 'trim|required|xss_clean|callback_exists_departcode'),
		array('field' => 'dept_depname', 'label' => 'Dep. Name', 'rules' => 'trim|required|xss_clean|callback_exists_departname'),
		// array('field' => 'dept_deporder', 'label' => 'Dep. Order', 'rules' => 'trim|xss_clean|numeric'),
		// array('field' => 'dept_deptype', 'label' => 'Dep.Type', 'rules' => 'trim|required|xss_clean'),
	);



	public $validate_settings_country = array(
		array('field' => 'coun_countrycode', 'label' => 'Dep. Code', 'rules' => 'trim|required|xss_clean|callback_exists_countrycode'),
		array('field' => 'coun_countryname', 'label' => 'Dep. Name', 'rules' => 'trim|required|xss_clean|callback_exists_countryname'),
	);



	public function department_save()
	{
		$postdata = $this->input->post();
		$id = $this->input->post('id');
		// echo "<prev>";
		// print_r($id);
		// die();
		unset($postdata['id']);

		if ($id) {
			$postdata['dept_modifydatead'] = CURDATE_EN;
			$postdata['dept_modifydatebs'] = CURDATE_NP;
			$postdata['dept_modifytime'] = date('H:i:s');
			$postdata['dept_modifyby'] = $this->session->userdata(USER_ID);
			$postdata['dept_modifyip'] = $this->general->get_real_ipaddr();
			$postdata['dept_modifymac'] = $this->general->get_Mac_Address();

			if (!empty($postdata['dept_parentdepid'])) {
				$postdata['dept_locationid'] = $postdata['dept_parentdepid'];
			} else {
				$postdata['dept_locationid'] = !empty($postdata['dept_locationid']) ? $postdata['dept_locationid'] : $this->locationid;
			}
			if (!empty($postdata)) {
				$this->general->save_log($this->table, 'dept_depid', $id, $postdata, 'Update');
				$this->db->update($this->table, $postdata, array('dept_depid' => $id));
				$rowaffected = $this->db->affected_rows();
				if ($rowaffected) {

					return $rowaffected;
				} else {
					return false;
				}
			}
		} else {
			$postdata['dept_postdatead'] = CURDATE_EN;
			$postdata['dept_postdatebs'] = CURDATE_NP;
			$postdata['dept_posttime'] = date('H:i:s');
			$postdata['dept_postby'] = $this->session->userdata(USER_ID);
			$postdata['dept_orgid'] = $this->session->userdata(ORG_ID);
			$postdata['dept_postip'] = $this->general->get_real_ipaddr();
			$postdata['dept_postmac'] = $this->general->get_Mac_Address();

			if (!empty($postdata['dept_parentdepid'])) {
				$postdata['dept_locationid'] = $postdata['dept_parentdepid'];
			} else {
				$postdata['dept_locationid'] = !empty($postdata['dept_locationid']) ? $postdata['dept_locationid'] : $this->locationid;
			}
			// $postdata['dept_deptype']=7;
			// echo "<pre>";
			// print_r($postdata);
			// die();
				if (!empty($postdata)) {
				$this->db->insert($this->table, $postdata);
				$insertid = $this->db->insert_id();
				if ($insertid) {
					return $insertid;
				} else {
					return false;
				}
			}
		}
			return false;
	}


	public function textimage_update($id)
	{
		$orgid = $this->session->userdata(ORG_ID);
		$userid = $this->session->userdata(USER_ID);
		//$postdata=$this->input->post();
		$this->db->set('usma_textimage', $id);
		$this->db->where('usma_userid', $userid);
		$this->db->update('usma_usermain');


		// $sql = $this->db->last_query();
		// echo "<pre>";
		// print_r($sql);
		// die();

		$rowaffected = $this->db->affected_rows();
		if ($rowaffected) {

			return $rowaffected;
		} else {
			return false;
		}
	}


	public function get_all_usermain($srchcol = false)
	{
		$this->db->select('us.*');
		$this->db->from('usma_usermain us');

		if ($srchcol) {
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data;
		}
		return false;
	}



	public function get_all_department($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = 'ASC')
	{
		$this->db->select('dp.*,lo.*');
		$this->db->from('dept_department dp');
		// $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
		$this->db->join('loca_location lo', 'lo.loca_locationid=dp.dept_locationid', 'LEFT');
		// if (!empty($this->locationid) && $this->location_ismain !== 'Y') {
		// 	$this->db->where('dtfp.dept_locationid', $this->locationid);
		// }

		if (ORGANIZATION_NAME == 'KU') {
			if (($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')) {
				if (!empty($this->sess_dept)) {
					$new_sess_dept = explode(',', $this->sess_dept);
					$this->db->where_in('dept_depid', $new_sess_dept);
				}
			}
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

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) {
			$data = $query->result();
		// 	echo "<pre>";
		// print_r($data);
		// die();
			return $data;
		}
		// dd($data);

		return false;
	}

	public function get_all_department_with_subdepartments($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = 'ASC')
	{
		if (!empty($this->locationid) && $this->location_ismain !== 'Y') {
			$cond = " WHERE dp.dept_locationid = $this->locationid";
		} else {
			$cond = "";
		}
		$sql = "SELECT  dept_depid,dept_depname,dept_depcode,dept_locationid,dept_postdatebs,lo.* FROM xw_dept_department dp
		LEFT JOIN `xw_loca_location` `lo` ON `lo`.`loca_locationid` = `dp`.`dept_locationid`
		$cond
		UNION
		SELECT (CASE WHEN(dpf.dept_depname!='') THEN dpf.dept_depid ELSE dp.dept_depid END ) as dept_depid,
		(CASE WHEN(dpf.dept_depname!='') THEN dpf.dept_depname ELSE dp.dept_depname END ) as dept_depname,
		(CASE WHEN(dpf.dept_depcode!='') THEN dpf.dept_depcode ELSE dp.dept_depcode END ) as dept_depcode,
		(CASE WHEN(dpf.dept_locationid!='') THEN dpf.dept_locationid ELSE dp.dept_locationid END ) as dept_locationid,
		(CASE WHEN(dpf.dept_postdatebs!='') THEN dpf.dept_postdatebs ELSE dp.dept_postdatebs END ) as dept_postdatebs,
		lo.*
		 from xw_dept_department dp
		LEFT JOIN xw_dept_department dpf on dpf.dept_locationid=dp.dept_depid
		LEFT JOIN `xw_loca_location` `lo` ON `lo`.`loca_locationid` = `dp`.`dept_locationid`
		$cond";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data;
		}
		return false;
	}

	public function get_all_department_reg($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = 'ASC')
	{
		$this->db->select('dp.*,lo.*');
		$this->db->from('dept_department dp');
		$this->db->join('loca_location lo', 'lo.loca_locationid=dp.dept_locationid', 'LEFT');




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

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data;
		}
		return false;
	}



	public function get_all_departmenttype($srchcol = false)
	{
		$this->db->select('dt.*');
		$this->db->from('dety_departmenttype dt');
		if ($srchcol) {
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data;
		}
		return false;
	}


	public function remove_department()
	{
		$id = $this->input->post('id');
		if ($id) {
			$this->general->save_log($this->table, 'dept_depid', $id, $postdata = array(), 'Delete');
			$this->db->delete($this->table, array('dept_depid' => $id));
			$rowaffected = $this->db->affected_rows();
			if ($rowaffected) {

				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function check_exit_deptcode_for_other($depcode, $id)
	{

		$data = array();
		if ($id) {
			$query = $this->db->get_where($this->table, array('dept_depcode' => $depcode, 'dept_depid !=' => $id));
		} else {
			$query = $this->db->get_where($this->table, array('dept_depcode' => $depcode));
		}

		if ($query->num_rows() > 0) {
			$data = $query->row();
			return $data;
		}
		return false;
	}

	public function check_exit_deptname_for_other($depname = false, $id = false)
	{
		$data = array();

		if ($id) {
			$query = $this->db->get_where($this->table, array('dept_depname' => $depname, 'dept_depid !=' => $id));
		} else {
			$query = $this->db->get_where($this->table, array('dept_depname' => $depname));
		}
		if ($query->num_rows() > 0) {
			$data = $query->row();
			return $data;
		}
		return false;
	}


	public function check_exit_countrycode_for_other($concode, $id)
	{

		$data = array();
		if ($id) {
			$query = $this->db->get_where('coun_country', array('coun_countrycode' => $concode, 'coun_countryid !=' => $id));
		} else {
			$query = $this->db->get_where('coun_country', array('coun_countrycode' => $concode));
		}

		if ($query->num_rows() > 0) {
			$data = $query->row();
			return $data;
		}
		return false;
	}

	public function check_exit_countname_for_other($countname = false, $id = false)
	{
		$data = array();

		if ($id) {
			$query = $this->db->get_where('coun_country', array('coun_countryname' => $countname, 'coun_countryid !=' => $id));
		} else {
			$query = $this->db->get_where('coun_country', array('coun_countryname' => $countname));
		}
		if ($query->num_rows() > 0) {
			$data = $query->row();
			return $data;
		}
		return false;
	}

	public function country_save()
	{
		$postdata = $this->input->post();
		if (!empty($postdata)) {
			$this->db->insert('coun_country', $postdata);
			$insertid = $this->db->insert_id();
			if ($insertid) {
				return $insertid;
			}
			return false;
		}
	}

	public function get_all_country($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = 'ASC')
	{
		$this->db->select('*');
		$this->db->from('coun_country cn');
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
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data;
		}
		return false;
	}
}
