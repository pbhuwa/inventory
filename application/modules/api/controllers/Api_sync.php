<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_sync extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('api_sync_mdl');
	}
	
	
	public function index()
	{
		//FAQ Catagories Synch
		$this->faq_cat_sync();
		// FAQ List
		$this->faq_sync();

	}

	public function faq_cat_db()
	{
		$api_key=$this->input->post('api_key');
		
		$faq_cat=$this->api_sync_mdl->get_all_faq_cat();
		// echo "<pre>";
		// print_r($faq_cat);
		// die();
		echo json_encode($faq_cat);
		
		
	}

	public function faq_cat_sync()
	{
		
		$headers = array(
		    'Content-Type: application/json',
		    );
		$url='https://xelwel.com.np/biomedical/api/api_sync/faq_cat_db';
		//API URL
		// $url = 'http://www.example.com/api';
		$api_key=$this->input->post('api_key');
		// echo $api_key;
		// die();
		$json = file_get_contents($url);
		$obj = json_decode($json);
		// echo "<pre>";
		// print_r($obj);
		// die();
		$faq_cat=$this->api_sync_mdl->get_all_faq_cat();
		$local_db_count=sizeof($faq_cat);
		$server_db_count=sizeof($obj );

		if($server_db_count!=$local_db_count)
		{
			$this->db->query('truncate xw_facq_faqcategory');

			if(!empty($obj))
			{
				$this->db->insert_batch('facq_faqcategory',$obj);
			}
		}

		
	}


public function faq_db()
	{
		$faq=$this->api_sync_mdl->get_all_faq();
		// echo "<pre>";
		// print_r($faq);
		// die();
		echo json_encode($faq);
	}

	public function faq_sync()
	{
		$headers = array(
		    'Content-Type: application/json',
		    );
		$url='https://xelwel.com.np/biomedical/api/api_sync/faq_db';
		//API URL
		// $url = 'http://www.example.com/api';
		$json = file_get_contents($url);
		$obj = json_decode($json);
		// echo "<pre>";
		// print_r($obj);
		// die();
		$faq=$this->api_sync_mdl->get_all_faq();
		$local_db_count=sizeof($faq);
		$server_db_count=sizeof($obj );

		if($server_db_count!=$local_db_count)
		{
			$this->db->query('truncate xw_fali_faqlist');
			if(!empty($obj))
			{
				$this->db->insert_batch('fali_faqlist',$obj);
			}
		}

		
	}	

	public function get_data_from_local_device()
	{
		$postdata=$this->input->post();

		// print_r($postdata);
		// return 1;
		// die();
		// $postdata=json_decode($postdata);
		// return json_encode("success");
		header("Content-Type:application/json");
$data = json_decode(file_get_contents('php://input'), true);
// print_r($data);
// return $data;
// echo "From Server";
// print_r($data);
// die();
$data= json_encode($data);

// die();


		$addarr=array(
			'data'=>$data,
			'date'=>date('Y-m-d H:i:s')
		);
		if($this->db->insert('test_synch',$addarr))
		{
			print_r("success");
			die();
		}
		print_r("error");
		die();
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */