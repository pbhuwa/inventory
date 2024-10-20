<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('cron_mdl');
	}
	
	
	public function index()
	{
		$username= $this->db->username;
	    $password= $this->db->password;
	    $hostname= $this->db->hostname;
	    $database= $this->db->database;

		$this->load->dbutil();
        $prefs = array(     
                'format'      => 'zip',             
                'filename'    => 'my_db_backup.sql'
              );
        $backup = $this->dbutil->backup($prefs); 
        $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
        // $save = DATABASE_BACKUP_PATH.$db_name;
        $filepath='D:\xampp\htdocs\inventory\DB_BACKUP'.'/'.$db_name;

      
        $this->load->helper('file');
        write_file($filepath, $backup); 
        // $this->load->helper('download');
        // force_download($db_name, $backup); 
        $postdata['daba_databasename']=$database;
        $postdata['daba_filename']=$filepath;
        $postdata['daba_filepath']=DATABASE_BACKUP_PATH;
        $postdata['daba_postdatead']=CURDATE_EN;
		$postdata['daba_postdatebs']=CURDATE_NP;
		$postdata['daba_posttime']=date('H:i:s');
		$postdata['daba_postby']=$this->session->userdata(USER_ID);
		$postdata['daba_postip']=$this->general->get_real_ipaddr();
		$postdata['daba_postmac']=$this->general->get_Mac_Address();
		// echo "<pre>";
		// print_r($postdata);
		// die();

		if(!empty($postdata))
		{
			$this->db->insert('daba_databasebakup',$postdata);
			// echo $this->db->last_query();
			// $this->ftp_upload_to_data_server($db_name);
			$insertid=$this->db->insert_id();
			// echo $insertid;
			// die();
			if($insertid)
			{
				return $insertid;
			}
			else
			{
				return false;
			}
		}


}



public function ftp_upload_to_data_server($filename=false)
{
	// $filepath='http://localhost/sql_hold/DB_BACKUP/test.txt';
	$ftp_server = "xelwel.com.np";
	$ftp_user_name = "xelwelinnovationxelwel";
	$ftp_user_pass = "gzpbE8BRGwL_i";
	$remote_dir = "/web/db_backup/";

	// set up basic connection
	$conn_id = ftp_connect($ftp_server);

	// login with username and password
	$login_result = @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

	//default values
	$file_url = "http://localhost/sql_hold/DB_BACKUP/".$filename;

	if($login_result) {
	//set passive mode enabled
	ftp_pasv($conn_id, true);

	//check if directory exists and if not then create it
	if(!@ftp_chdir($conn_id, $remote_dir)) {
	//create diectory
	ftp_mkdir($conn_id, $remote_dir);
	//change directory
	ftp_chdir($conn_id, $remote_dir);
	}

	$file =$file_url;
	$remote_file = $filename;

	$ret = ftp_nb_put($conn_id, $remote_file, $file, FTP_BINARY, FTP_AUTORESUME);
	while(FTP_MOREDATA == $ret) {
	$ret = ftp_nb_continue($conn_id);
	}

	if($ret == FTP_FINISHED) {
	echo "File '" . $remote_file . "' uploaded successfully.";
	} else {
	echo "Failed uploading file '" . $remote_file . "'.";
	}
	} else {
	echo "Cannot connect to FTP server at " . $ftp_server;
	}
}




	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */