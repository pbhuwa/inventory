<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset_category extends CI_Controller

{

  function __construct()

  {
    parent::__construct();
  }

  public function index()

  {

    // echo "sd";

  //   die(); 

    $this->db->select('*');

    $this->db->from('eqca_equipmentcategory ec');

    $this->db->where(array('eqca_isnonexp'=>'Y'));

    $result=$this->db->get()->result();
    // echo $this->db->last_query();

    // echo "<pre>";

    // print_r($result);

    // die();

    $this->data['category_type']=$result;

    $this->data['listurl']=base_url().'ams/asset_category/list_assets_cat_dep';

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

    $this->page_title = ORGA_NAME;

    $this->data['meta_keys']= ORGA_NAME;

    $this->data['meta_desc']= ORGA_NAME;

  }

  $this->data['breadcrumb']='Asset/Category ';

  $this->data['tab_type']='Asset Category';

  $this->template

  ->set_layout('general')

  ->enable_parser(FALSE)

  ->title($this->page_title)

  ->build('assets_category/v_assets_category', $this->data);

}

public function update_category(){

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

      $cat_id=$this->input->post('eqca_equipmentcategoryid');

      $depval=$this->input->post('eqca_deprate');

      if(!empty($cat_id)){

        foreach ($cat_id as $kc => $value) {

          $cat_arr[]=array(

            'eqca_equipmentcategoryid'=>$cat_id[$kc],

            'eqca_deprate'=>$depval[$kc],

          );

        }

        $this->db->trans_start();

        if(!empty($cat_arr)){

          $this->db->update_batch('eqca_equipmentcategory',$cat_arr, 'eqca_equipmentcategoryid'); 

        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){

          $this->db->trans_rollback();

          print_r(json_encode(array('status'=>'error','message'=>'Error While Updating !!')));

          exit;  

        }

        else{

          $this->db->trans_commit();

          print_r(json_encode(array('status'=>'success','message'=>'Record Updated Successfully!!')));

          exit;  

        }

      }

    } catch (Exception $e) {

      print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));

    }

  }

  else

  {

    print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

    exit;

  }

}

public function list_assets_cat_dep(){

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(MODULES_VIEW=='N')

    {

      $this->general->permission_denial_message();

      exit;

    }

    $this->data=array();

    $this->db->select('*');

    $this->db->from('eqca_equipmentcategory ec');

    $this->db->where('eqca_isnonexp','Y');

    $result=$this->db->get()->result();

    // echo "<pre>";

    // print_r($result);

    // die();

    $this->data['category_type']=$result;

    $template=$this->load->view('ams/assets_category/v_assets_cat_dep_list',$this->data,true);

    print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

    exit;  

  }

  else

  {

    print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

    exit;

  }

}

}

/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */