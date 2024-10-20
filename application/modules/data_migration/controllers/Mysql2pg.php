<?php 
ini_set('max_execution_time', '3000'); 
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mysql2pg extends CI_Controller {
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
	echo "test";
}

public function mysql2pgsql(){
	$db_name=$this->db->database;
		$tbl_list=$this->db->query("SHOW TABLES")->result();
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

			    $create_tbl=$this->db->query("SHOW CREATE TABLE $tbl_name")->row();
			    // if(!empty($create_tbl)){
				  $create_query .=$create_tbl->{'Create Table'};
				  $create_query .=';';	
				  $create_query .='<br>';			  
			}
		}
		echo $create_query;
		die();

		$pg_format=$this->convert_live($create_query);

		echo $pg_format;
}

public function convert_live($source_schema)
{
	$response = $this->httpPost("http://www.sqlines.com/sqlines_run.php",
	array("source"=>$source_schema,"source_type"=>"MySQL","target_type"=>"PostgreSQL"));
	$response_new=str_replace("__SQLINES_MULTI_PART__", " ", $response);
	return $response_new;

}

function httpPost($url, $data){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function change_data_type()
{
	// SELECT DISTINCT CONCAT('ALTER TABLE ',
 //                       TABLE_NAME,
 //                       ' MODIFY ',
 //                       COLUMN_NAME,
 //                       ' decimal(15,2)',
 //                       if(IS_NULLABLE = 'NO', ' NOT ', ''),
 //                       ' NULL;') as alter_datatype
 //  from information_schema.columns
 // WHERE TABLE_SCHEMA='inv_kukl' AND DATA_TYPE='float' AND TABLE_NAME NOT LIKE 'xw_vw%' ;
}

}

?>