<?php 
ini_set('max_execution_time', '3000'); 
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration extends CI_Controller {
function __construct() {
		parent::__construct();
		$this->DB2 = $this->load->database('pg_server', TRUE);
		$this->load->library('excel');

		if(!$this->DB2){
			echo "Server Database Not Defined.";
			exit();
		}
		
	}
	public function index(){
		$db_name=$this->db->database;
		$tbl_list=$this->db->query("SHOW TABLES")->result();
		// echo "<pre>";
		// print_r($tbl_list);
		// die();
		$column_name='Tables_in_'.$db_name;
		// echo $column_name;
		// die();

		if(!empty($tbl_list))
		{
			$this->DB2->trans_start();
			foreach ($tbl_list as $kt => $tlist) {
				$tbl_name = $tlist->{$column_name};
				if (strpos($tbl_name, 'vw') === false) {
				 	 $source_query= $this->db->query("SELECT 'source_tbl' as source_tbl,'$tbl_name' as source_tablename, count('*') as source_table_rows from $tbl_name")->row(); 

					$destination_query = $this->DB2->query("SELECT 'destination_tbl' as destination_tbl,'$tbl_name' as destination_tablename, count('*') as destination_table_rows from $tbl_name")->row(); 
					if(!empty($source_query)){
						$datarr=array(
							'source_tbl'=>$source_query->source_tbl,
							'source_tablename'=>$source_query->source_tablename,
							'source_table_rows'=>$source_query->source_table_rows,
							'destination_tablename'=>!empty($destination_query->destination_tablename)?$destination_query->destination_tablename:'',
							'destination_table_rows'=>!empty($destination_query->destination_table_rows)?$destination_query->destination_table_rows:'0'
							);
					}
					$comparr[]=(object)$datarr;

				  
				}
			}
			
			
		}
		$this->data['comparr_data'] = $comparr;
		$seo_data='';
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('data_migration/v_data_migration', $this->data);

		// $this->db->query("CREATE TABLE test_create as SELECT * FROM xw_forest_info ");
	}


	public function table_synch_process(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$tblname=$this->input->post('tblname');
		$this->db->trans_start();
		$count_rws=0;
		if($tblname!='all'){
			$this->db->select('*');
			$this->db->from($tblname);
			$query = $this->db->get();
			$result = $query->result();
			if(!empty($result) && is_array($result)){
				$count_rws=sizeof($result);
				$this->DB2->query("TRUNCATE TABLE $tblname CASCADE ;");
			 $this->DB2->insert_batch($tblname,$result);
			}

		}
		if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
					print_r(json_encode(array('status'=>'error','message'=>'Error While Uploading...')));
       			 exit;	
				}
		else{
			$this->db->trans_commit();
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Uploaded !!','count_rws'=>$count_rws)));
       		 exit;	
			}
		 $this->db->trans_complete();
		
		}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
		}
	}

	public function all_table_synch_to_another_database()
	{
		$db_name=$this->db->database;
		$tbl_list=$this->db->query("SHOW TABLES")->result();
		// echo "<pre>";
		// print_r($tbl_list);
		// die();
		$column_name='Tables_in_'.$db_name;
		// echo $column_name;
		// die();

		if(!empty($tbl_list))
		{
			$this->DB2->trans_start();
			foreach ($tbl_list as $kt => $tlist) {
				$tbl_name = $tlist->{$column_name};
				// echo "<br>";
				if (strpos($tbl_name, 'vw') === false) {
				    // echo $tbl_name;
				    // echo "<br>";
				    // $this->DB2->query("DROP TABLE IF EXISTS $tbl_name");

				   //  $create_tbl=$this->DB2->query("SHOW CREATE TABLE $tbl_name ")->row();
				   //  if(!empty($create_tbl)){
					  // $create_query=$create_tbl->{'Create Table'};
					  // $this->DB2->query("DROP TABLE IF EXISTS $tbl_name");
					  // $this->DB2->query("$create_query");
					  
								
				   //  }

					 $source_query= $this->db->query("SELECT 'source_tbl' as source_tbl,'$tbl_name' as source_tablename, count('*') as source_table_rows from $tbl_name")->row(); 

					$destination_query = $this->DB2->query("SELECT 'destination_tbl' as destination_tbl,'$tbl_name' as destination_tablename, count('*') as destination_table_rows from $tbl_name")->row(); 
					if(!empty($source_query)){
						$datarr=array(
							'source_tbl'=>$source_query->source_tbl,
							'source_tablename'=>$source_query->source_tablename,
							'source_table_rows'=>$source_query->source_table_rows,
							'destination_tablename'=>!empty($destination_query->destination_tablename)?$destination_query->destination_tablename:'X',
							'destination_table_rows'=>!empty($destination_query->destination_table_rows)?$destination_query->destination_table_rows:'0'
							);
					}
					$comparr[]=(object)$datarr;

					

					// $this->insert_table_data_to_live_server_table($tbl_name);
				  
				}
			}
			$local_result = $comparr;
			echo "<pre>";
			print_r($local_result);
			die();
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
			}
			 else{
			$this->db->trans_commit();
			}

			$this->DB2->trans_complete();
		}

		// $this->db->query("CREATE TABLE test_create as SELECT * FROM xw_forest_info ");

	}

	public function insert_table_data_to_live_server_table($tbl_name)
	{
		$this->db->select('*');
		$this->db->from($tbl_name);
		$query = $this->db->get();
		$result = $query->result();
		if(!empty($result)){
			$count_rws=sizeof($result);
		 $this->DB2->insert_batch($tbl_name,$result);
		}
	}


	public function all_function_synch_to_live_database()
	{
		$db_name=$this->DB2->database;
		$fn_list=$this->DB2->query("SHOW FUNCTION STATUS WHERE Db='".$db_name."'")->result();
		// echo "<pre>";
		// print_r($fn_list);
		// die();
		if(!empty($fn_list))
		{
			foreach ($fn_list as $kfl => $fn) {
				$fn_name=$fn->{'Name'};
				$security_type=$fn->{'Security_type'};
				$definer=$fn->{'Definer'};
				echo "<pre>";
				if(!empty($fn_name))
				{
					$fn_script_result=$this->DB2->query("SHOW CREATE FUNCTION $fn_name")->row();

					// print_r($fn_script_result);
					if(!empty($fn_script_result))
					{
						$fn_script=$fn_script_result->{'Create Function'};
						// echo $fn_script;
						$def_string="$security_type=$definer";
						$new_script= str_replace('`',"",$fn_script);
						$new_script=str_replace($def_string,"",$new_script);
						// $new_script;
						// echo $new_script;
						// echo ";<br>";
						$this->DB3->query("DROP FUNCTION IF EXISTS $fn_name");
						$this->DB3->query("$new_script");	
					}
				}
				// echo "<br>";
			}
		}
	}


	public function all_view_synch_to_live_database()
	{
		$db_name=$this->DB2->database;
		$view_list=$this->DB2->query("SELECT CONCAT('CREATE OR REPLACE VIEW ',TABLE_NAME,' AS ',VIEW_DEFINITION) as view_rslt FROM information_schema.VIEWS WHERE TABLE_SCHEMA='".$db_name."'")->result();
		// echo "<pre>";
		// print_r($view_list);
		// die();
		if(!empty($view_list))
		{
			foreach ($view_list as $kfl => $vw) {
				$view_list=$vw->view_rslt;
				echo $view_list.';';
				echo "<br>";
				// $this->DB3->query($view_list);
				// echo "<br>";
			}
		}
	}


	
}