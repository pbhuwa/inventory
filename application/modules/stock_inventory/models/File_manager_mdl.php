<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class File_manager_mdl extends CI_Model

{

	public function __construct()

	{

		parent::__construct();

		$this->table = 'fire_filerecord';
		$this->locationid = $this->session->userdata(LOCATION_ID);
	}



	public $validate_settings_material = array(

		array('field' => 'maty_material', 'label' => 'Material Type', 'rules' => 'trim|required|xss_clean|callback_exists_materialtype'),

	);







	public function file_save()

	{

		$postdata = $this->input->post();
		// echo "<pre>";
		// print_r($postdata);
		// die();
		$id = $this->input->post('id');
		$filedate = $this->input->post('filedate');
		if (DEFAULT_DATEPICKER == 'NP') {
			$filedatebs = $filedate;
			$filedatead = $this->general->NepToEngDateConv($filedate);
		} else {
			$filedatead = $filedate;
			$filedatebs = $this->general->EngToNepDateConv($filedate);
		}

		$postid = $this->general->get_real_ipaddr();
		$postmac = $this->general->get_Mac_Address();
		$old_attachment = $this->input->post('old_attachment');
		// echo "<pre>AT";
		// print_r($fire_attachement);
		// die();
		$item_code = $this->input->post('rede_code');
		$item_id = $this->input->post('rede_itemsid');
		$item_qty = $this->input->post('rede_qty');
		$frde_detailid = $this->input->post('frde_filerecorddetailid');
		unset($postdata['frde_filerecorddetailid']);
		unset($postdata['rede_code']);
		unset($postdata['rede_itemsid']);
		unset($postdata['rede_qty']);


		unset($postdata['id']);
		unset($postdata['filedate']);
		unset($postdata['fire_attachement']);
		unset($postdata['old_attachment']);
		$postdata['fire_datead'] = $filedatead;
		$postdata['fire_datebs'] = $filedatebs;
		if ($id) {
			$this->db->trans_start();

			$_FILES['attachments']['name'] = $_FILES['fire_attachement']['name'];
			$_FILES['attachments']['type'] = $_FILES['fire_attachement']['type'];
			$_FILES['attachments']['tmp_name'] = $_FILES['fire_attachement']['tmp_name'];
			$_FILES['attachments']['error'] = $_FILES['fire_attachement']['error'];
			$_FILES['attachments']['size'] = $_FILES['fire_attachement']['size'];


			if (!empty($_FILES)) {
				$imgfile = $this->doupload('attachments');
			} else {
				$imgfile = '';
			}
			if ($imgfile) {
				$postdata['fire_attachement'] = $imgfile;
				if (!empty($old_attachment)) {
					if (file_exists(FCPATH . FORM_FILE_ATTACHMENT_PATH . "/$old_attachment")) {
						unlink(FCPATH . FORM_FILE_ATTACHMENT_PATH . "/$old_attachment");
					}
				}
			}

			$postdata['fire_modifydatead'] = CURDATE_EN;
			$postdata['fire_modifydatebs'] = CURDATE_NP;
			$postdata['fire_modifytime'] = $this->general->get_currenttime();
			$postdata['fire_modifyby'] = $this->session->userdata(USER_ID);
			$postdata['fire_modifyip'] = $postid;
			$postdata['fire_modifymac'] = $postmac;

			if (!empty($postdata)) {
				$this->general->save_log($this->table, 'fire_filerecordid', $id, $postdata, 'Update');
				$this->db->update($this->table, $postdata, array('fire_filerecordid' => $id));
				foreach ($item_id as $key => $ids) {
					$detail_id = isset($frde_detailid[$key]) ? $frde_detailid[$key] : null;
					if ($detail_id) {
						$frd_detail_update = array(
							'frde_itemcode' => $item_code[$key],
							'frde_itemsid' => $ids,
							'frde_qty' => $item_qty[$key],
							'frde_modifydatead' => CURDATE_EN,
							'frde_modifydatebs' => CURDATE_NP,
							'frde_modifytime' => $this->general->get_currenttime(),
							'frde_modifyby' => $this->session->userdata(USER_ID),
							'frde_modifyip' => $postid,
							'frde_modifymac' => $postmac,
						);
						$this->db->update('frde_filerecorddetail', $frd_detail_update, array('frde_filerecorddetailid' => $detail_id));
					} else {
						$frd_detail_create = array(
							'frde_filerecord_masterid' => $id,
							'frde_itemcode' => $item_code[$key],
							'frde_itemsid' => $ids,
							'frde_qty' => $item_qty[$key],
							'frde_postdatead' => CURDATE_EN,
							'frde_postdatebs' => CURDATE_NP,
							'frde_posttime' => $this->general->get_currenttime(),
							'frde_postby' => $this->session->userdata(USER_ID),
							'frde_orgid' => $this->session->userdata(ORG_ID),
							'frde_postip' => $postid,
							'frde_postmac' => $postmac,
							'frde_locationid' => $this->locationid
						);
						$this->db->insert('frde_filerecorddetail', $frd_detail_create);
					}
				}
			}

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			} else {
				$this->db->trans_commit();
				return true;
			}
		} else {
			$imageList = '';
			// $new_image_name = $_FILES['fire_attachement']['name'];
			$_FILES['attachments']['name'] = $_FILES['fire_attachement']['name'];
			$_FILES['attachments']['type'] = $_FILES['fire_attachement']['type'];
			$_FILES['attachments']['tmp_name'] = $_FILES['fire_attachement']['tmp_name'];
			$_FILES['attachments']['error'] = $_FILES['fire_attachement']['error'];
			$_FILES['attachments']['size'] = $_FILES['fire_attachement']['size'];


			if (!empty($_FILES)) {
				$new_image_name = $_FILES['fire_attachement']['name'];
				$imgfile = $this->doupload('attachments');
			} else {
				$imgfile = '';
			}


			$postdata['fire_attachement'] = $imgfile;
			$postdata['fire_postdatead'] = CURDATE_EN;
			$postdata['fire_postdatebs'] = CURDATE_NP;
			$postdata['fire_posttime'] = $this->general->get_currenttime();
			$postdata['fire_postby'] = $this->session->userdata(USER_ID);
			$postdata['fire_orgid'] = $this->session->userdata(ORG_ID);
			$postdata['fire_postip'] = $postid;
			$postdata['fire_postmac'] = $postmac;

			$this->db->trans_start();

			if (!empty($postdata)) {
				$this->db->insert($this->table, $postdata);
				$fire_masterid = $this->db->insert_id();
				if (!empty($fire_masterid)) {
					foreach ($item_id as $key => $ids) {
						$frd_detail = array(
							'frde_filerecord_masterid' => $fire_masterid,
							'frde_itemcode' => $item_code[$key],
							'frde_itemsid' => $ids,
							'frde_qty' => $item_qty[$key],
							'frde_postdatead' => CURDATE_EN,
							'frde_postdatebs' => CURDATE_NP,
							'frde_posttime' => $this->general->get_currenttime(),
							'frde_postby' => $this->session->userdata(USER_ID),
							'frde_orgid' => $this->session->userdata(ORG_ID),
							'frde_postip' => $postid,
							'frde_postmac' => $postmac,
							'frde_locationid' => $this->locationid
						);
						$this->db->insert('frde_filerecorddetail', $frd_detail);
					}
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {

				$this->db->trans_rollback();

				return false;
			} else {

				$this->db->trans_commit();

				return true;
			}
		}

		return false;
	}




	public function doupload($file)
	{
		// echo "test";
		// die();
		// echo $file;
		// die();
		$config['upload_path'] = './' . FORM_FILE_ATTACHMENT_PATH; //define in constants
		$config['allowed_types'] = 'png|jpg|gif|jpeg|pdf|docx|doc|txt';
		$config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
		$config['encrypt_name'] = FALSE;
		$config['remove_spaces'] = TRUE;
		$config['max_size'] = '2000000';
		$config['max_width'] = '5000';
		$config['max_height'] = '5000';
		$this->upload->initialize($config);
		$this->load->library('upload', $config);
		$this->upload->do_upload($file);
		$data = $this->upload->data();
		// echo "<pre>";
		// // echo "file: ";
		// // print_r($file);
		// // echo "<br/>";
		// echo "Data: ";
		// print_r($data);
		// exit;
		$name_array = $data['file_name'];
		// echo $name_array;
		// exit;
		// $names= implode(',', $name_array);   
		//     // return $names;   
		return $name_array;
	}

	public function get_file_list($srch = false)

	{
		$frmDate = !empty($this->input->get('frmDate')) ? $this->input->get('frmDate') : CURMONTH_DAY1;
		$toDate = !empty($this->input->get('toDate')) ? $this->input->get('toDate') : DISPLAY_DATE;
		$dateSearch = $this->input->get('dateSearch');
		$fire_file_type = $this->input->get('fire_file_type');
		$fire_file_no = $this->input->get('fire_file_no');
		$get = $_GET;
		if (!empty($fire_file_type)) {
			$this->db->where('fire_filetypeid', $fire_file_type);
		}
		if (!empty($fire_file_no)) {
			$this->db->where('fire_file_no', $fire_file_no);
		}
		if ($frmDate &&  $toDate) {
			if (DEFAULT_DATEPICKER == 'NP') {
				$this->db->where(array('fire_datebs >=' => $frmDate, 'fire_datebs <=' => $toDate));
			} else {
				$this->db->where(array('fire_datead >=' => $frmDate, 'fire_datead <=' => $toDate));
			}
		}



		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}



		if (!empty($get['sSearch_0'])) {

			$this->db->where("fire_filerecordid like  '%" . $get['sSearch_0'] . "%'  ");
		}



		if (!empty($get['sSearch_1'])) {

			$this->db->where("ft.fity_typename like  '%" . $get['sSearch_1'] . "%'  ");
		}
		if (!empty($get['sSearch_2'])) {

			$this->db->where("fr.fire_file_no like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if (!empty($get['sSearch_3'])) {

			$this->db->where("fr.fire_datebs like  '%" . $get['sSearch_3'] . "%'  ");
		}
		if (!empty($get['sSearch_4'])) {

			$this->db->where("fr.fire_remarks like  '%" . $get['sSearch_4'] . "%'  ");
		}

		$resltrpt = $this->db->select("COUNT(*) as cnt")

			->from('fire_filerecord fr')
			->join('fity_filetype ft', 'ft.fity_filetypeid=fr.fire_filetypeid', 'left')

			->get()

			->row();

		//$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();

		//echo $this->db->last_query();die(); 

		$totalfilteredrecs = $resltrpt->cnt;



		$order_by = 'fire_filerecordid';

		$order = 'desc';

		if ($this->input->get('sSortDir_0')) {

			$order = $this->input->get('sSortDir_0');
		}



		$where = '';

		if ($this->input->get('iSortCol_0') == 0)

			$order_by = 'fire_filerecordid';

		else if ($this->input->get('iSortCol_0') == 1)

			$order_by = 'fity_typename';



		$totalrecs = '';

		$limit = 15;

		$offset = 0;

		$get = $_GET;



		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}



		if (!empty($_GET["iDisplayLength"])) {

			$limit = $_GET['iDisplayLength'];

			$offset = $_GET["iDisplayStart"];
		}
		if ($frmDate &&  $toDate) {
			if (DEFAULT_DATEPICKER == 'NP') {
				$this->db->where(array('fire_datebs >=' => $frmDate, 'fire_datebs <=' => $toDate));
			} else {
				$this->db->where(array('fire_datead >=' => $frmDate, 'fire_datead <=' => $toDate));
			}
		}
		if (!empty($fire_file_type)) {
			$this->db->where('fire_filetypeid', $fire_file_type);
		}

		if (!empty($fire_file_no)) {
			$this->db->where('fire_file_no', $fire_file_no);
		}



		if (!empty($get['sSearch_0'])) {

			$this->db->where("fire_filerecordid like  '%" . $get['sSearch_0'] . "%'  ");
		}



		if (!empty($get['sSearch_1'])) {

			$this->db->where("ft.fity_typename like  '%" . $get['sSearch_1'] . "%'  ");
		}
		if (!empty($get['sSearch_2'])) {

			$this->db->where("fr.fire_file_no like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if (!empty($get['sSearch_3'])) {

			$this->db->where("fr.fire_datebs like  '%" . $get['sSearch_3'] . "%'  ");
		}
		if (!empty($get['sSearch_4'])) {

			$this->db->where("fr.fire_remarks like  '%" . $get['sSearch_4'] . "%'  ");
		}

		$this->db->select('*');
		$this->db->from('fire_filerecord fr');
		$this->db->join('fity_filetype ft', 'ft.fity_filetypeid=fr.fire_filetypeid', 'left');

		$this->db->order_by($order_by, $order);

		if ($limit && $limit > 0) {

			$this->db->limit($limit);
		}

		if ($offset) {

			$this->db->offset($offset);
		}
		if ($srch) {
			$this->db->where($srch);
		}



		$nquery = $this->db->get();

		$num_row = $nquery->num_rows();

		// if(!empty($_GET['iDisplayLength'])) {

		//   $totalrecs = sizeof( $nquery);

		// }
		if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
			$totalrecs = sizeof($nquery);
		}





		if ($num_row > 0) {

			$ndata = $nquery->result();

			$ndata['totalrecs'] = $totalrecs;

			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {

			$ndata = array();

			$ndata['totalrecs'] = 0;

			$ndata['totalfilteredrecs'] = 0;
		}

		// echo $this->db->last_query();die();

		//echo "<pre>";print_r($ndata);die;

		return $ndata;
	}


	public function remove_files()

	{

		$id = $this->input->post('id');

		if ($id) {

			$this->general->save_log($this->table, 'fire_filerecordid', $id, $postdata = array(), 'Delete');
			$rslt = $this->db->select('fire_attachement')->from('fire_filerecord')->where('fire_filerecordid', $id)->get();
			$data = $rslt->row();
			if (!empty($data->fire_attachement)) {
				if (file_exists(FCPATH . FORM_FILE_ATTACHMENT_PATH . "/$data->fire_attachement")) {
					unlink(FCPATH . FORM_FILE_ATTACHMENT_PATH . "/$data->fire_attachement");
				}
			} 

			$this->db->delete($this->table, array('fire_filerecordid' => $id));

			$rowaffected = $this->db->affected_rows();

			if ($rowaffected) {
				$this->db->delete('frde_filerecorddetail', array('frde_filerecord_masterid' => $id));
				return $rowaffected;
			}

			return false;
		}

		return false;
	}
}
