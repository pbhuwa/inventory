<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_tablemanage extends CI_Controller {

	function __construct() {
		parent::__construct();
		
	}
	
	
	public function index(){
		
	}

	public function get_schema_current_db(){
		// echo "<pre>";
		// print_r($this->db);;
		// die();

		$db_name=$this->db->database;

		$db['second'] = array(
			    'dsn'   => '',
			    'hostname' => $this->db->hostname,
			    'username' => $this->db->username,
			    'password' => $this->db->password,
			    'database' => $db_name,
			    'dbdriver' => $this->db->dbdriver,
			    'dbprefix' => '',
				'pconnect' => FALSE,
				'db_debug' => (ENVIRONMENT !== 'production'),
				'cache_on' => FALSE,
				'cachedir' => '',
				'char_set' => 'utf8',
				'dbcollat' => 'utf8_general_ci',
				'swap_pre' => '',
				'encrypt' => FALSE,
				'compress' => FALSE,
				'stricton' => FALSE,
				'failover' => array(),
				'save_queries' => TRUE
			);
		
		$db2 = $this->load->database($db['second'], TRUE);
		
		if(!empty($db2->conn_id)){
		// $db2data=	$db2->get('xw_aclo_actionlog')->result();
		// print_r($db2data);
			$db_name=$db_name;
			$tbl_list=$db2->query("SHOW TABLES")->result();
			// echo "<pre>";
			// print_r($tbl_list);
			// die();
			$column_name='Tables_in_'.$db_name;
			$create_query='';
			foreach ($tbl_list as $kt => $tlist) {
				$tbl_name = $tlist->{$column_name};
				// echo "<br>";
				if (strpos($tbl_name, 'vw') === false) {
				    // echo $tbl_name;
				    // echo "<br>";
				    // $this->DB3->query("DROP TABLE IF EXISTS $tbl_name");

				    $create_tbl=$db2->query("SHOW CREATE TABLE $tbl_name")->row();
				    // if(!empty($create_tbl)){
					  $create_query .=$create_tbl->{'Create Table'};
					  $create_query .=';';	
					  $create_query .="\n";		
					  $create_query .="\n";	  
				}
			}
			return $create_query;
		}else{
			 return false;
		}
		
	}



	public function get_schema_remote_db(){
		$db_name='xelwelco_kuinv';
		$db['second'] = array(
			    'dsn'   => '',
			    'hostname' => 'localhost',
			    'username' => 'xelwelco_kuinv',
			    'password' => 'kuinv@123',
			    'database' => 	$db_name,
			    'dbdriver' => $this->db->dbdriver,
			    'dbprefix' => '',
				'pconnect' => FALSE,
				'db_debug' => (ENVIRONMENT !== 'production'),
				'cache_on' => FALSE,
				'cachedir' => '',
				'char_set' => 'utf8',
				'dbcollat' => 'utf8_general_ci',
				'swap_pre' => '',
				'encrypt' => FALSE,
				'compress' => FALSE,
				'stricton' => FALSE,
				'failover' => array(),
				'save_queries' => TRUE
			);
		
		$db2 = $this->load->database($db['second'], TRUE);
		
		if(!empty($db2->conn_id)){
		// $db2data=	$db2->get('xw_aclo_actionlog')->result();
		// print_r($db2data);
			$db_name=	$db_name;
			$tbl_list=$db2->query("SHOW TABLES")->result();
			// echo "<pre>";
			// print_r($tbl_list);
			// die();
			$column_name='Tables_in_'.$db_name;
			$create_query='';
			foreach ($tbl_list as $kt => $tlist) {
				$tbl_name = $tlist->{$column_name};
				// echo "<br>";
				if (strpos($tbl_name, 'vw') === false) {
				    // echo $tbl_name;
				    // echo "<br>";
				    // $this->DB3->query("DROP TABLE IF EXISTS $tbl_name");

				    $create_tbl=$db2->query("SHOW CREATE TABLE $tbl_name")->row();
				    // if(!empty($create_tbl)){
					  $create_query .=$create_tbl->{'Create Table'};
					  $create_query .=';';	
					  $create_query .="\n";		
					  $create_query .="\n";	  
				}
			}
			return $create_query;
		}else{
			 return false;
		}
		
	}


	public function compare_schema()
	{
		// echo "asd";
		$updater = new DbStruct();
  
		// $dbStruct=$this->load->library('dbStruct');
		$src=$this->get_schema_remote_db();
		$dest=$this->get_schema_current_db();
		


		// $res=$dbStruct->getUpdates($src,$);
		$res_qry = $updater->getUpdates($dest,$src);

		// echo "<pre>";
		// print_r($res);
		// die();
		$temp_qry='';
		if(!empty($res_qry)){
			foreach ($res_qry as $krq => $rqy) {
			$temp_qry .=$rqy;
			$temp_qry .=';';
			$temp_qry .="\n";
			$temp_qry .="\n";
			}
		// echo $temp ;
		}
		if(!empty($temp_qry)){
							echo '<textarea width="100%" style="margin: 0px; height: 443px; width: 1128px;">'.$temp_qry.'</textarea>';
		    				exit;
		}else{
			echo "empty query";
			die();
		}

	}


	public function data_synch(){
		$this->data['tab_type']='data_synch';
		$this->data['page_title']='Function/View Code.';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->build('tablemanage/v_data_synch_common', $this->data);
	}

	public function get_compare_data(){
		// echo "asd";
		// die();
		$updater = new DbStruct();
		$sourcedb=$this->input->post('sourcedb');
		$destinationdb=$this->input->post('sourcedb');
		if($sourcedb=='local'){
			$db_name=$this->db->database;
			$db['source'] = array(
						    'dsn'   => '',
						    'hostname' => $this->db->hostname,
						    'username' => $this->db->username,
						    'password' => $this->db->password,
						    'database' => $db_name,
						    'dbdriver' => $this->db->dbdriver,
						    'dbprefix' => '',
							'pconnect' => FALSE,
							'db_debug' => (ENVIRONMENT !== 'production'),
							'cache_on' => FALSE,
							'cachedir' => '',
							'char_set' => 'utf8',
							'dbcollat' => 'utf8_general_ci',
							'swap_pre' => '',
							'encrypt' => FALSE,
							'compress' => FALSE,
							'stricton' => FALSE,
							'failover' => array(),
							'save_queries' => TRUE
						);
					// print_r($db['second']);

					$db2 = $this->load->database($db['source'], TRUE);
					if(!empty($db2->conn_id)){
					$tbl_list=$db2->query("SHOW TABLES")->result();
					// echo "<pre>";
					// print_r($tbl_list);
					// die();

					$column_name='Tables_in_'.$db_name;
					foreach ($tbl_list as $kt => $tlist) {
						$src_tbl_name = $tlist->{$column_name};
							if (strpos($src_tbl_name, 'vw') === false) {
					 	 	$source_query= $db2->query("SELECT 'source_tbl' as source_tbl,'$src_tbl_name' as source_tablename, count('*') as source_table_rows from $src_tbl_name")->row();
				 	 		$datarr=array(
								'source_tbl'=>$source_query->source_tbl,
								'source_tablename'=>$source_query->source_tablename,
								'source_table_rows'=>$source_query->source_table_rows
							);
							if(!empty($datarr)){
							$comparr[]=(object)$datarr;
						 }
						}	
						
						
						}
						// echo "<pre>";
						// print_r($comparr);
						// die();
						$compare_data_arr['source']=$comparr;

					 }
					 $db2->close();


			$db_name='xelwelco_kuinv';

			$db['destination'] = array(
					'dsn'	=> '',
					 'hostname' => 'localhost',
				     'username' => 'xelwelco_kuinv',
				    'password' => 'kuinv@123',
				    'database' => 	$db_name,
				    'dbdriver' => $this->db->dbdriver,
					'dbprefix' => '',
					'pconnect' => FALSE,
					'db_debug' => (ENVIRONMENT !== 'production'),
					'cache_on' => FALSE,
					'cachedir' => '',
					'char_set' => 'utf8',
					'dbcollat' => 'utf8_general_ci',
					'swap_pre' => '',
					'encrypt' => FALSE,
					'compress' => FALSE,
					'stricton' => FALSE,
					'failover' => array(),
					'save_queries' => TRUE
				);
					// echo "<pre>";
					// print_r($db['third']);
					// die();
				$db3 = $this->load->database($db['destination'],TRUE);
				// echo "<pre>";
				// print_r($db3);
				// die();

				if(!empty($db3->conn_id)){
					$destinationarr=array();
					$dest_list=$db3->query("SHOW TABLES")->result();
					// echo "<pre>";
					// print_r($dest_list);
					// die();

					$column_name='Tables_in_'.$db_name;
					foreach ($dest_list as $kt => $dlist) {
						$tbl_dest_name = $dlist->{$column_name};
							if (strpos($tbl_dest_name, 'vw') === false) {
								
					$destination_query= $db3->query("SELECT 'destination_tbl' as destination_tbl,'$tbl_dest_name' as destination_tablename, count('*') as destination_table_rows from $tbl_dest_name")->row();
					$datarrdest=array(
						'destination_tbl'=>$destination_query->destination_tbl,
						'destination_tablename'=>$destination_query->destination_tablename,
						'destination_table_rows'=>$destination_query->destination_table_rows
								);
						if(!empty($datarrdest)){
								$destinationarr[]=(object)$datarrdest;
							}
						}	
					
					$compare_data_arr['destination']=$destinationarr;
				 }
				 $db3->close();
				}
				

				
			// $dbStruct=$this->load->library('dbStruct');
			$src=$this->get_schema_current_db();


			$dest=$this->get_schema_remote_db();
			

			// echo $dest;
			// echo"-----------------------";
			// echo $src;
			// die();
			// $res=$dbStruct->getUpdates($src,$);
			$res_qry = $updater->getUpdates($dest,$src);

			// print_r($res_qry);
			// die();


			$temp_qry='';
			if(!empty($res_qry)){
				foreach ($res_qry as $krq => $rqy) {
				$temp_qry .=$rqy;
				$temp_qry .=';';
				$temp_qry .="\n";
				$temp_qry .="\n";
				}
			// echo $temp ;
			}



		}else{

			$db_name='xelwelco_kuinv';

			$db['source'] = array(
					'dsn'	=> '',
					 'hostname' => 'localhost',
				     'username' => 'xelwelco_kuinv',
				    'password' => 'kuinv@123',
				    'database' => 	$db_name,
				    'dbdriver' => $this->db->dbdriver,
					'dbprefix' => '',
					'pconnect' => FALSE,
					'db_debug' => (ENVIRONMENT !== 'production'),
					'cache_on' => FALSE,
					'cachedir' => '',
					'char_set' => 'utf8',
					'dbcollat' => 'utf8_general_ci',
					'swap_pre' => '',
					'encrypt' => FALSE,
					'compress' => FALSE,
					'stricton' => FALSE,
					'failover' => array(),
					'save_queries' => TRUE
				);

			
					// print_r($db['second']);

					$db2 = $this->load->database($db['source'], TRUE);
					if(!empty($db2->conn_id)){
					$tbl_list=$db2->query("SHOW TABLES")->result();
					// echo "<pre>";
					// print_r($tbl_list);
					// die();

					$column_name='Tables_in_'.$db_name;
					foreach ($tbl_list as $kt => $tlist) {
						$src_tbl_name = $tlist->{$column_name};
							if (strpos($src_tbl_name, 'vw') === false) {
					 	 	$source_query= $db2->query("SELECT 'source_tbl' as source_tbl,'$src_tbl_name' as source_tablename, count('*') as source_table_rows from $src_tbl_name")->row();
				 	 		$datarr=array(
								'source_tbl'=>$source_query->source_tbl,
								'source_tablename'=>$source_query->source_tablename,
								'source_table_rows'=>$source_query->source_table_rows
							);
							if(!empty($datarr)){
							$comparr[]=(object)$datarr;
						 }
						}	
						
						
						}
						// echo "<pre>";
						// print_r($comparr);
						// die();
						$compare_data_arr['source']=$comparr;

					 }
					 $db2->close();


			// ------------------
					 $db_name=$this->db->database;
					$db['destination'] = array(
						    'dsn'   => '',
						    'hostname' => $this->db->hostname,
						    'username' => $this->db->username,
						    'password' => $this->db->password,
						    'database' => $db_name,
						    'dbdriver' => $this->db->dbdriver,
						    'dbprefix' => '',
							'pconnect' => FALSE,
							'db_debug' => (ENVIRONMENT !== 'production'),
							'cache_on' => FALSE,
							'cachedir' => '',
							'char_set' => 'utf8',
							'dbcollat' => 'utf8_general_ci',
							'swap_pre' => '',
							'encrypt' => FALSE,
							'compress' => FALSE,
							'stricton' => FALSE,
							'failover' => array(),
							'save_queries' => TRUE
						);
					// echo "<pre>";
					// print_r($db['third']);
					// die();
				$db3 = $this->load->database($db['destination'],TRUE);
				// echo "<pre>";
				// print_r($db3);
				// die();

				if(!empty($db3->conn_id)){
					$destinationarr=array();
					$dest_list=$db3->query("SHOW TABLES")->result();
					// echo "<pre>";
					// print_r($dest_list);
					// die();

					$column_name='Tables_in_'.$db_name;
					foreach ($dest_list as $kt => $dlist) {
						$tbl_dest_name = $dlist->{$column_name};
							if (strpos($tbl_dest_name, 'vw') === false) {
								
					$destination_query= $db3->query("SELECT 'destination_tbl' as destination_tbl,'$tbl_dest_name' as destination_tablename, count('*') as destination_table_rows from $tbl_dest_name")->row();
					$datarrdest=array(
						'destination_tbl'=>$destination_query->destination_tbl,
						'destination_tablename'=>$destination_query->destination_tablename,
						'destination_table_rows'=>$destination_query->destination_table_rows
								);
						if(!empty($datarrdest)){
								$destinationarr[]=(object)$datarrdest;
							}
						}	
					
					$compare_data_arr['destination']=$destinationarr;
				 }
				 $db3->close();
				}
				
				$src=$this->get_schema_remote_db();
				$dest=$this->get_schema_current_db();
			


			// $res=$dbStruct->getUpdates($src,$);
				$res_qry = $updater->getUpdates($dest,$src);
				$temp_qry='';
				if(!empty($res_qry)){
					foreach ($res_qry as $krq => $rqy) {
					$temp_qry .=$rqy;
					$temp_qry .=';';
					$temp_qry .="\n";
					$temp_qry .="\n";
					}
				// echo $temp ;
				}
		}

		$this->data['source']=$comparr;
		$this->data['destination']=$destinationarr;
		$this->data['alter_query']=$temp_qry;
		$template=$this->load->view('tablemanage/v_data_compare_report',$this->data,TRUE);
		// echo $template;

		 if(!empty($template))
            {
                print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
                exit;
            }
            else{
                print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
                exit;
            }

	}


	public function data_synch_process(){
		$sourcedb=$this->input->post('dbsourceid');
		$destinationdb=$this->input->post('dbdestinationid');
		$tblname=$this->input->post('tblname');
		if($sourcedb=='local'){
			$db_name=$this->db->database;
				$db['source'] = array(
						    'dsn'   => '',
						    'hostname' => $this->db->hostname,
						    'username' => $this->db->username,
						    'password' => $this->db->password,
						    'database' => $db_name,
						    'dbdriver' => $this->db->dbdriver,
						    'dbprefix' => '',
							'pconnect' => FALSE,
							'db_debug' => (ENVIRONMENT !== 'production'),
							'cache_on' => FALSE,
							'cachedir' => '',
							'char_set' => 'utf8',
							'dbcollat' => 'utf8_general_ci',
							'swap_pre' => '',
							'encrypt' => FALSE,
							'compress' => FALSE,
							'stricton' => FALSE,
							'failover' => array(),
							'save_queries' => TRUE
						);
					// print_r($db['second']);

					$db2 = $this->load->database($db['source'], TRUE);
					if(!empty($db2->conn_id)){
					$result_source_data=$db2->query("SELECT * FROM $tblname")->result();
					 }
					 $db2->close();


				$db_name='xelwelco_kuinv';

				$db['destination'] = array(
						'dsn'	=> '',
						 'hostname' => 'localhost',
					     'username' => 'xelwelco_kuinv',
					    'password' => 'kuinv@123',
					    'database' => 	$db_name,
					    'dbdriver' => $this->db->dbdriver,
						'dbprefix' => '',
						'pconnect' => FALSE,
						'db_debug' => (ENVIRONMENT !== 'production'),
						'cache_on' => FALSE,
						'cachedir' => '',
						'char_set' => 'utf8',
						'dbcollat' => 'utf8_general_ci',
						'swap_pre' => '',
						'encrypt' => FALSE,
						'compress' => FALSE,
						'stricton' => FALSE,
						'failover' => array(),
						'save_queries' => TRUE
					);
					// echo "<pre>";
					// print_r($db['third']);
					// die();
				$db3 = $this->load->database($db['destination'],TRUE);
				// echo "<pre>";
				// print_r($db3);
				// die();
				$count_rws=0;
				if(!empty($db3)){
					if(!empty($result_source_data) && is_array($result_source_data)){
					$count_rws=sizeof($result_source_data);
					}
					$db3->trans_start();
					$destinationarr=array();
					$db3->query("TRUNCATE TABLE $tblname ;");
			 		$db3->insert_batch($tblname,$result_source_data);
			 		$db3->trans_complete();
			 	if ($db3->trans_status() === FALSE){
						$db3->trans_rollback();
							print_r(json_encode(array('status'=>'error','message'=>'Error While Uploading...')));
		       			 exit;	
						}
				else{
					$db3->trans_commit();
					print_r(json_encode(array('status'=>'success','message'=>'Successfully Uploaded !!','count_rws'=>$count_rws)));
		       		 exit;	
					}

		}
	}else{
			$db_name='xelwelco_kuinv';

				$db['source'] = array(
						'dsn'	=> '',
						 'hostname' => 'localhost',
					     'username' => 'xelwelco_kuinv',
					    'password' => 'kuinv@123',
					    'database' => 	$db_name,
					    'dbdriver' => $this->db->dbdriver,
						'dbprefix' => '',
						'pconnect' => FALSE,
						'db_debug' => (ENVIRONMENT !== 'production'),
						'cache_on' => FALSE,
						'cachedir' => '',
						'char_set' => 'utf8',
						'dbcollat' => 'utf8_general_ci',
						'swap_pre' => '',
						'encrypt' => FALSE,
						'compress' => FALSE,
						'stricton' => FALSE,
						'failover' => array(),
						'save_queries' => TRUE
					);

		
					// print_r($db['second']);

					$db2 = $this->load->database($db['source'], TRUE);
					if(!empty($db2->conn_id)){
					$result_source_data=$db2->query("SELECT * FROM $tblname")->result();
					 }
					 $db2->close();


			
					// echo "<pre>";
					// print_r($db['third']);
					// die();
					 	$db_name=$this->db->database;
				$db['destination'] = array(
						    'dsn'   => '',
						    'hostname' => $this->db->hostname,
						    'username' => $this->db->username,
						    'password' => $this->db->password,
						    'database' => $db_name,
						    'dbdriver' => $this->db->dbdriver,
						    'dbprefix' => '',
							'pconnect' => FALSE,
							'db_debug' => (ENVIRONMENT !== 'production'),
							'cache_on' => FALSE,
							'cachedir' => '',
							'char_set' => 'utf8',
							'dbcollat' => 'utf8_general_ci',
							'swap_pre' => '',
							'encrypt' => FALSE,
							'compress' => FALSE,
							'stricton' => FALSE,
							'failover' => array(),
							'save_queries' => TRUE
						);
				$db3 = $this->load->database($db['destination'],TRUE);
				// echo "<pre>";
				// print_r($db3);
				// die();
				$count_rws=0;
				if(!empty($db3)){
					if(!empty($result_source_data) && is_array($result_source_data)){
					$count_rws=sizeof($result_source_data);
					}
					$db3->trans_start();
					$destinationarr=array();
					$db3->query("TRUNCATE TABLE $tblname ;");
			 		$db3->insert_batch($tblname,$result_source_data);
			 		$db3->trans_complete();
			 	if ($db3->trans_status() === FALSE){
						$db3->trans_rollback();
							print_r(json_encode(array('status'=>'error','message'=>'Error While Uploading...')));
		       			 exit;	
						}
				else{
					$db3->trans_commit();
					print_r(json_encode(array('status'=>'success','message'=>'Successfully Uploaded !!','count_rws'=>$count_rws)));
		       		 exit;	
					}

		}


	  }
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */