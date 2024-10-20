<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General
{

  /**

   * CodeIgniter global

   *

   * @var string

   **/

  protected $ci;

  /**

   * account status ('not_activated', etc ...)

   *

   * @var string

   **/

  protected $status;

  /**

   * error message (uses lang file)

   *

   * @var string

   **/

  protected $errors = array();

  public $members_data;

  // $this->adjacencyList='';

  public $adjacencyList;

  public $adjacencyCheckboxlist;

  // public $level=1;

  public function __construct()

  {

    $this->ci = &get_instance();
    // $this->ci->db->query("alter session set nls_comp=LINGUISTIC");

    $this->load_db_constant();

    //define site settings info

    // echo DEP_METHOD;

    // die();

    $cur_date = date('Y/m/d');

    $np_date = $this->EngToNepDateConv($cur_date);

    define('CURDATE_NP', $np_date);

    define('CURDATE_EN', $cur_date);

    // define()

    // die();

    $curdateen = strtotime(CURDATE_EN);

    $nextyearen = date('Y/m/d', strtotime("+1 year", $curdateen));

    $prevyearen = date('Y/m/d', strtotime("-1 year", $curdateen));

    $petyearnp = $this->EngToNepDateConv($prevyearen);

    $nextyearnp = $this->EngToNepDateConv($nextyearen);

    // echo $nextyearnp; die();

    define('CURDATE_EN_NEXT_YR', $nextyearen);

    define('CURDATE_NP_NEXT_YR', $nextyearnp);

    define('CURDATE_NP_PREV_YR', $petyearnp);

    // $this->ipfilter();

    // USER_ACCESS_TYPE

    // USER_ACCESS_SYSTEM

    $org_info = $this->get_organization_info(array('orga_isdefaultdb' => 'Y'));

    $accesstype = $this->ci->session->userdata(USER_ACCESS_TYPE);

    $this->usergroup = $this->ci->session->userdata(USER_GROUP);
    $this->lang = $this->ci->session->userdata('lang');

    if ($accesstype == 'S') {

      $access_system = $this->ci->session->userdata(USER_ACCESS_SYSTEM);

      $org_info = $this->get_organization_info(array('orga_orgid' => $access_system));
    }

    // echo "<pre>";

    // print_r($org_info);

    // die();

    $currenturl = $this->getUrl();

    $qrystringCnt = substr_count($currenturl, '?');

    // die();

    if ($this->ci->input->is_ajax_request()) {

      $currenturl = $_SERVER['HTTP_REFERER'];
    }

    $new_url = str_replace(base_url(), "", $currenturl);

    $urlchk = '/' . $new_url;

    // echo $urlchk;

    // die();

    $menu_permission = $this->check_menu_permission($urlchk); //Check Menu Permission return 0 if not permission and return 1 if permission

    // echo"<pre>";

    // print_r($menu_permission);

    // die();

    $lang = $this->ci->session->userdata('lang');

    $menu_name = !empty($menu_permission->modu_displaytext) ? $menu_permission->modu_displaytext : '';

    $menu_name_np = !empty($menu_permission->modu_displaytextnp) ? $menu_permission->modu_displaytextnp : '';

    if ($lang == 'np') {

      define('BREADCRUMB_2', $menu_name_np);
    } else {

      define('BREADCRUMB_2', $menu_name);
    }

    $parentmoduleid = !empty($menu_permission->modu_parentmodule) ? $menu_permission->modu_parentmodule : '';

    if (!empty($parentmoduleid)) {

      $parentname = $this->get_tbl_data('modu_displaytext, modu_displaytextnp', 'modu_modules', array('modu_moduleid' => $parentmoduleid));

      if ($lang == 'np') {

        define('BREADCRUMB_1', $parentname[0]->modu_displaytextnp);
      } else {

        define('BREADCRUMB_1', $parentname[0]->modu_displaytext);
      }
    } else {

      define('BREADCRUMB_1', '');
    }

    // $this->moduleid=!empty($this->menu_permission->modu_moduleid)? $this->menu_permission->modu_moduleid:0;

    $mope_insert = !empty($menu_permission->mope_insert) ? $menu_permission->mope_insert : 'N';

    $mope_update = !empty($menu_permission->mope_update) ? $menu_permission->mope_update : 'N';

    $mope_delete = !empty($menu_permission->mope_delete) ? $menu_permission->mope_delete : 'N';

    $mope_view = !empty($menu_permission->mope_view) ? $menu_permission->mope_view : 'N';

    $mope_approve = !empty($menu_permission->mope_approve) ? $menu_permission->mope_approve : 'N';

    $mope_verified = !empty($menu_permission->mope_verified) ? $menu_permission->mope_verified : 'N';

    // echo $this->mope_insert;

    // die();

    // echo $mope_insert;

    // die();

    // echo $this->ci->uri->segment(1);

    // die();

    if ($this->ci->uri->segment(1) == 'home' && empty($this->ci->uri->segment(1))) {

      $mope_view = 'Y';
    }

    define('MODULES_INSERT', $mope_insert);

    define('MODULES_UPDATE', $mope_update);

    define('MODULES_DELETE', $mope_delete);

    define('MODULES_VIEW', $mope_view);

    define('MODULES_VERIFIED', $mope_verified);

    define('MODULES_APPROVE', $mope_approve);

    // if($this->ci->uri->segment(1)=='home' || $this->ci->uri->segment(1)=='')

    // {

    // define('MODULES_INSERT',$mope_insert);

    // define('MODULES_UPDATE',$mope_update);

    // define('MODULES_DELETE',$mope_delete);

    // runkit_constant_remove('MODULES_VIEW');

    // runkit_constant_redefine('MODULES_VIEW', 'Y');

    // define('MODULES_VIEW','Y');

    // }

    // echo MODULE_INSERT;

    // die();
    // echo $this->ci->uri->segment(2);
    // die();

    if (!$this->ci->input->is_ajax_request()) {

      if (empty($menu_permission) && ($this->ci->uri->segment(1) != 'permission_denial') && ($this->ci->uri->segment(1) != 'home') && ($qrystringCnt) < 1 && ($this->ci->uri->segment(1) != 'login') && ($this->ci->uri->segment(1) != 'cron') && ($this->ci->uri->segment(1) != 'api' && ($this->ci->uri->segment(1) != 'register') && (($this->ci->uri->segment(1) != 'ams') && $this->ci->uri->segment(2) != 'assets_overview'))) {

        // echo "not permission";

        // redirect('permission_denial','refresh');

        // exit();

      }
    }

    define('PDF_IMAGEATEXT', $org_info['orga_pdftextimage']);

    define('ORGA_NAME', $org_info['orga_organame']);

    define('ORGA_ADDRESS1', $org_info['orga_orgaddress1']);

    define('ORGA_ADDRESS2', $org_info['orga_orgaddress2']);

    define('ORGA_PHONE', $org_info['orga_contactno']);

    define('ORGA_EMAIL', $org_info['orga_email']);

    define('ORGA_WEBSITE', $org_info['orga_website']);

    define('ORGA_SOFTWARENAME', $org_info['orga_software']);

    define('ORGA_IMAGE', $org_info['orga_image']);

    define('QRCODE_URL', $org_info['orga_qrurl']);

    define('DEFAULT_DATEPICKER', $org_info['orga_defaultpicker']);

    define('LOG_INVALID_LOGIN', $org_info['orga_loginactivities']);

    define('ISUSERACCESS', $org_info['orga_isuseraccess']);

    // echo DEFAULT_DATEPICKER;

    // die();

    //   define('CURDATE_NP_NEXT_YR',$nextyearnp);

    // define('CURDATE_EN_NEXT_YR',$nextyearen);

    if (DEFAULT_DATEPICKER == 'NP') {

      define('DATEPICKER_CLASS', 'nepdatepicker');

      define('DISPLAY_DATE', CURDATE_NP);

      define('DISPLAY_DATE_NEXT_YR', CURDATE_NP_NEXT_YR);

      $np_date = explode('/', $np_date);

      $cur_year = $np_date[0];

      $cur_month = $np_date[1];

      $cur_days = $np_date[2];

      define('CURYEAR', $cur_year);

      define('CURMONTH', $cur_month);

      define('CURDAYS', $cur_days);
    } else {

      define('DATEPICKER_CLASS', 'engdatepicker');

      define('DISPLAY_DATE', CURDATE_EN);

      define('DISPLAY_DATE_NEXT_YR', CURDATE_EN_NEXT_YR);

      $cur_date_en = explode('/', $cur_date);

      $cur_year = $cur_date_en[0];

      $cur_month = $cur_date_en[1];

      $cur_days = $cur_date_en[2];

      define('CURYEAR', $cur_year);

      define('CURMONTH', $cur_month);

      define('CURDAYS', $cur_days);
    }

    if (empty($this->ci->session->userdata('lang'))) {

      $this->ci->session->set_userdata('lang', 'en');
    }

    $fiscalyear = $this->getFiscalYear(array('fiye_status' => 'I'));

    // echo $fiscalyear;

    // die();

    $cur_fiscalyear = !empty($fiscalyear[0]->fiye_name) ? $fiscalyear[0]->fiye_name : '';

    define('CUR_FISCALYEAR', $cur_fiscalyear);

    $FirstDayOfCurrentMonth = $this->getFirstDayOfCurrentMonth();

    define('CURMONTH_DAY1', $FirstDayOfCurrentMonth);

    // if($this->ci->session->userdata(USER_ID)){

    //  $this->updateOnlineMemberByTime();

    // }

    // if(!($this->ci->session->userdata(USER_ID)) && ($this->ci->uri->segment(1)!='login'))

    // {

    //  redirect('login','refresh');

    //  exit();

    // }

    // echo ISUSERACCESS;

    // die();

    if (ISUSERACCESS == 'Y') {

      if (!($this->ci->session->userdata(USER_ID)) && ($this->ci->session->userdata('ACCESS_KEY') != 'YES') && ($this->ci->uri->segment(1) != 'useraccess')) {

        redirect('/useraccess', 'refresh');

        exit;
      }
    } else {

      if (!($this->ci->session->userdata(USER_ID)) && ($this->ci->uri->segment(1) != 'login') && ($this->ci->uri->segment(1) != 'cron') && ($this->ci->uri->segment(1) != 'api') && ($this->ci->uri->segment(1) != 'register') && (($this->ci->uri->segment(1) != 'ams') && $this->ci->uri->segment(2) != 'assets_overview')) {

        if (!empty($_SERVER['QUERY_STRING'])) {

          $uri = uri_string() . '?' . $_SERVER['QUERY_STRING'];
        } else {

          $uri = uri_string();
        }

        $this->ci->session->set_userdata('redirect', $uri);

        redirect('login', 'refresh');

        exit();
      }
    }
  }

  public function string_limit($string, $limit)

  {

    $name = (strlen($string) > $limit) ? substr($string, 0, $limit) . '.' : $string;

    return $name;
  }

  public function check_permission_module()

  {

    $currenturl = $this->getUrl();

    $qrystringCnt = substr_count($currenturl, '?');

    // die();

    if ($this->ci->input->is_ajax_request()) {

      $currenturl = $_SERVER['HTTP_REFERER'];
    }

    $new_url = str_replace(base_url(), "", $currenturl);

    $urlchk = '/' . $new_url;

    // echo $urlchk;

    // die();

    $menu_permission = $this->check_menu_permission($urlchk); //Check Menu 

    // $this->moduleid=!empty($this->menu_permission->modu_moduleid)? $this->menu_permission->modu_moduleid:0;

    $mope_insert = !empty($menu_permission->mope_insert) ? $menu_permission->mope_insert : 'N';

    $mope_update = !empty($menu_permission->mope_update) ? $menu_permission->mope_update : 'N';

    $mope_delete = !empty($menu_permission->mope_delete) ? $menu_permission->mope_delete : 'N';

    $mope_view = !empty($menu_permission->mope_view) ? $menu_permission->mope_view : 'N';

    $mope_approve = !empty($menu_permission->mope_approve) ? $menu_permission->mope_approve : 'N';

    $mope_verified = !empty($menu_permission->mope_verified) ? $menu_permission->mope_verified : 'N';

    define('MODULES_INSERT_SERVER', $mope_insert);

    define('MODULES_UPDATE_SERVER', $mope_update);

    define('MODULES_DELETE_SERVER', $mope_delete);

    define('MODULES_VIEW_SERVER', $mope_view);

    define('MODULES_APPROVE_SERVER', $mope_approve);
  }

  public function convert_string_case($string)
  {
    // print_r($this->ci);
    // die();
    if ($this->ci->db->dbdriver == 'oci8') {
      return strtoupper($string);
    }
    return $string;
  }

  public function load_db_constant()

  {

    $db_constant = $this->get_tbl_data('*', 'cons_constant', array('cons_isactive' => 'Y'), 'cons_id', 'ASC');

    // echo "<pre>";

    // print_r($db_constant);

    // die();

    if (!empty($db_constant)) {

      $defineconstant = '';

      foreach ($db_constant as $kcon => $const) {
        // print_r(array_change_key_case((array)$const,CASE_LOWER));
        // die();
        // echo $kcon. $const->{$this->convert_string_case('cons_name')};
        // echo "<br>";
        // define($const->{$this->convert_string_case('cons_name')},$const->{$this->convert_string_case('cons_value')});
        define($const->cons_name, $const->cons_value);

        // echo $const_db;

        // echo "<br>";

        // define($const_db);

      }
    }
    // die();

    if (DEFAULT_HEADER == 'NP') {

      define('FONT_CLASS', '');
    } else {

      define('FONT_CLASS', '');
    }

    // die();

  }

  public function add_date($date, $num, $type = false, $sign = '+')

  {

    $dateval = strtotime($date);

    if ($type == 'year') {

      $nextdate = date('Y/m/d', strtotime("$sign $num year", $dateval));
    } else if ($type == 'month') {

      $nextdate = date('Y/m/d', strtotime("$sign $num month", $dateval));
    } else {

      $nextdate = date('Y/m/d', strtotime("$sign $num days", $dateval));
    }

    return $nextdate;
  }

  function permission_denial_message()

  {

    if ($this->ci->input->is_ajax_request()) {

      print_r(json_encode(array('status' => 'error', 'message' => 'Permission Denial ')));

      exit;
    } else {

      echo "Permission Denial";
    }
  }

  public function disabled_edit_message()

  {

    print_r(json_encode(array('status' => 'error', 'message' => 'Can be edited only within ' . EDIT_HOURS . ' Hours')));

    exit;
  }

  public function compare_item_price($itemid, $unitprice = false)

  {

    $itemrate = $this->get_tbl_data('itli_purchaserate,itli_itemlistid', 'itli_itemslist', array('itli_itemlistid' => $itemid), false, 'DESC');

    if ($unitprice != $itemrate[0]->itli_purchaserate) {

      $updateItemsPrice = array(

        'itli_purchaserate' => !empty($unitprice) ? $unitprice : '',

        'itli_salesrate' => !empty($unitprice) ? $unitprice : '',

      );

      if (!empty($updateItemsPrice)) {

        $this->ci->db->where('itli_itemlistid', $itemid);

        $this->ci->db->update('itli_itemslist', $updateItemsPrice);

        return $this->ci->db->affected_rows();
      }

      return false;
    }
  }

  public function compute_data_for_edit($date = false, $time = false)

  {

    // echo date('now');

    // die();

    $concate_date_time = $date . ' ' . $time;

    // echo strtotime($concate_date_time);

    // die();

    $new_date_time = strtotime($concate_date_time . "+" . EDIT_HOURS . " hours");

    $current_date_time = strtotime(date('Y/m/d H:i:s'));

    // echo date('Y/m/d H:i:s',$current_date_time);

    // die();

    // echo $new_date_time;

    if ($current_date_time >= $new_date_time) {

      return 0;
    }

    return 1;
  }

  public function getUrl()
  {

    // echo $_SERVER['SERVER_PORT'];

    // die();

    if ($_SERVER['SERVER_PORT'] != '80') {

      // echo "port";

      //if Port is enabled

      $url  = @($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["SERVER_NAME"] . ':' . $_SERVER['SERVER_PORT'] :  'https://' . $_SERVER["SERVER_NAME"];
    } else {

      // echo "not port";

      $url  = @($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["SERVER_NAME"] :  'https://' . $_SERVER["SERVER_NAME"];
    }

    // die();

    $url .= $_SERVER["REQUEST_URI"];

    return $url;
  }

  public function check_menu_permission($modulelink = false)

  {

    $usergroup = $this->ci->session->userdata(USER_GROUP);

    $this->ci->db->select('*');

    $this->ci->db->from('modu_modules m');

    $this->ci->db->join('mope_modulespermission p', 'p.mope_moduleid=m.modu_moduleid');

    $this->ci->db->where(array('p.mope_usergroupid' => $usergroup));

    $this->ci->db->where(array('m.modu_modulelink' => $modulelink));

    $this->ci->db->where(array('p.mope_hasaccess' => 1));

    $qry = $this->ci->db->get();

    // echo $this->ci->db->last_query();

    // die();

    if ($qry->num_rows() > 0) {

      return $qry->row();
    }

    return 0;
  }

  public function get_currenttime()

  {

    return date('H:i:s');
  }

  public function user_logout()

  {

    $usma_userid = $this->ci->session->userdata(USER_ID);

    $this->ci->session->unset_userdata(USER_ID);

    $this->ci->session->unset_userdata(USER_NAME);

    $this->ci->session->unset_userdata(LOGINDATETIME);

    $this->ci->session->sess_destroy();

    $udata = array(

      'usma_islogin' => '0',

      'usma_logouttime' => $this->get_currenttime(),

      'usma_logoutdatead' => CURDATE_EN,

      'usma_logoutdatebs' => CURDATE_NP,

    );

    $this->ci->db->where('usma_userid', $usma_userid);

    $this->ci->db->update('usma_usermain', $udata);

    return true;
  }

  public function timezone_list($name, $default = '')
  {

    static $timezones = null;

    if ($timezones === null) {

      $timezones = [];

      $offsets = [];

      $now = new DateTime();

      foreach (DateTimeZone::listIdentifiers() as $timezone) {

        $now->setTimezone(new DateTimeZone($timezone));

        $offsets[] = $offset = $now->getOffset();

        $hours = intval($offset / 3600);

        $minutes = abs(intval($offset % 3600 / 60));

        $gmt_ofset = 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');

        $timezone_name = str_replace('/', ', ', $timezone);

        $timezone_name = str_replace('_', ' ', $timezone_name);

        $timezone_name = str_replace('St ', 'St. ', $timezone_name);

        $timezones[$timezone] = $timezone_name . ' (' . $gmt_ofset . ')';
      }

      array_multisort($offsets, $timezones);
    }

    $formdropdown = form_dropdown($name, $timezones, trim($default));

    return $formdropdown;
  }

  public function get_menulink()
  {
    $menu_template = $this->select_menu_link_from_db();
    // echo 's'. $menu_template;
    // die();
    return $menu_template;
  }

  public function select_menu_link_from_db()
  {

    $groupid = $this->ci->session->userdata(USER_GROUP);
    $userid = $this->ci->session->userdata(USER_ID);
    $location_id = $this->ci->session->userdata(LOCATION_ID);
    $orgid = $this->ci->session->userdata(ORG_ID);
    if ($this->ci->db->table_exists('meli_menulink')) {
      $result = $this->ci->db->select('meli_meliid,meli_links')
        ->from('meli_menulink')
        ->where(array(
          'meli_groupid' => $groupid,
          'meli_locationid' => $location_id,
          'meli_orgid' => $orgid
        ))
        ->get()->row();
      // echo $this->ci->db->last_query();
      // echo "<pre>";
      // print_r($result);
      // die();
      if (!empty($result)) {
        return $result->meli_links;
      }
      return false;
    } else {

      $create_meli_table = "CREATE TABLE xw_meli_menulink (
                meli_meliid BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                meli_links TEXT,
                meli_userid BIGINT(15),
                meli_groupid BIGINT(15),
                meli_locationid INT(15),
                meli_orgid INT(15)
                )";
      $this->ci->db->query($create_meli_table);
      $result = $this->ci->db->select('meli_meliid,meli_links')
        ->from('meli_menulink')
        ->where(array(
          'meli_groupid' =>   $groupid,
          'meli_locationid' => $location_id,
          'meli_orgid' => $orgid
        ))
        ->order_by('meli_meliid', 'ASC')
        ->get()->row();
      // echo $this->ci->db->last_query();
      // echo "<pre>";
      // print_r($result);
      // die();
      if (!empty($result)) {
        return $result->meli_links;
      }
      return false;
    }
  }

  public function generate_menu_link($operation = false)
  {
    $groupid = $this->ci->session->userdata(USER_GROUP);
    $userid = $this->ci->session->userdata(USER_ID);
    $location_id = $this->ci->session->userdata(LOCATION_ID);
    $orgid = $this->ci->session->userdata(ORG_ID);
    if ($operation == 'update') {
      $template = $this->menu_adjacency_main(0, 0, false);
      $darray = array(
        'meli_groupid' => $groupid,
        'meli_orgid' => $orgid
      );
      if (!empty($darray)) {
        $this->ci->db->update('meli_menulink', array('meli_links' => $template), $darray);
      }
    } else {

      $template = $this->menu_adjacency_main(0, 0, false);
      $darray = array(
        'meli_links' => $template,
        'meli_groupid' =>   $groupid,
        'meli_locationid' => $location_id,
        'meli_orgid' => $orgid
      );
      if (!empty($darray)) {
        $this->ci->db->insert('meli_menulink', $darray);
      }
    }
  }

  public function menu_adjacency_main($parent, $level, $location = false, $filename = false, $first_call = true)
  {
    $usergroup = $this->ci->session->userdata(USER_GROUP);
    // echo $level;

    // echo $usergroup;

    // die();

    if ($first_call == true) :

      $this->ci->db->select('m.modu_moduleid,m.modu_parentmodule,m.modu_displaytextnp,m.modu_displaytext,modu_icon,modu_modulelink');

      $this->ci->db->from('modu_modules m');

      $this->ci->db->join('mope_modulespermission p', 'p.mope_moduleid=m.modu_moduleid', 'INNER');

      $this->ci->db->where(array('p.mope_hasaccess' => 1, 'mope_usergroupid' =>  $usergroup));

      $this->ci->db->where(array('m.modu_parentmodule' => 0));

      $this->ci->db->where(array('m.modu_isactive' => 'Y'));

      $this->ci->db->where(array('m.modu_ishidden' => 'N'));

      $this->ci->db->order_by('m.modu_order', 'ASC');

      $qry = $this->ci->db->get();

      $this->adjacencyList .= '<ul class="nav navbar-nav mblmenu metismenu" id="side-menu"><li class="home"><a href="' . base_url() . '"></a></li>';

    else :

      $this->ci->db->select('m.modu_moduleid,m.modu_parentmodule,m.modu_displaytextnp,m.modu_displaytext,modu_icon,modu_modulelink');

      $this->ci->db->from('modu_modules m');

      $this->ci->db->join('mope_modulespermission p', 'p.mope_moduleid=m.modu_moduleid', 'INNER');

      $this->ci->db->where(array('p.mope_hasaccess' => 1, 'mope_usergroupid' =>  $usergroup));

      $this->ci->db->where(array('m.modu_parentmodule' => $parent));

      $this->ci->db->where(array('m.modu_isactive' => 'Y'));

      $this->ci->db->where(array('m.modu_ishidden' => 'N'));

      $this->ci->db->order_by('m.modu_order', 'ASC');

      $qry = $this->ci->db->get();

      // echo $this->db->last_query();

      // die();

      $this->adjacencyList .= "\n" . '<ul class="dropdown-menu">';

    endif;

    $oMenus = $qry->result();

    // echo $this->ci->db->last_query();

    // echo "<br>";

    // echo "<pre>";

    // print_r($oMenus);

    // exit;

    foreach ($oMenus as $menu) :

      // $subqry="(SELECT COUNT('*') as cnt FROM xw_modu_modules mi WHERE mi.modu_parentmodule= m.modu_moduleid) as subcount"
      $this->ci->db->select('m.modu_moduleid,m.modu_parentmodule,m.modu_displaytextnp,m.modu_displaytext,modu_icon,modu_modulelink');

      $this->ci->db->from('modu_modules m');

      $this->ci->db->join('mope_modulespermission p', 'p.mope_moduleid=m.modu_moduleid', 'INNER');

      $this->ci->db->where(array('p.mope_hasaccess' => 1, 'mope_usergroupid' =>  $usergroup));

      $this->ci->db->where(array('m.modu_parentmodule' => $menu->modu_moduleid));

      $this->ci->db->where(array('m.modu_isactive' => 'Y'));

      $this->ci->db->where(array('m.modu_ishidden' => 'N'));

      $this->ci->db->order_by('m.modu_order', 'ASC');

      $qry_sub = $this->ci->db->get();

      // $this->db->last_query();

      // // die();

      $submenu_total = $qry_sub->result();

      // echo count($submenu_total);

      $other_att = '';

      $menu_url = base_url($menu->modu_modulelink);

      if ($this->lang == 'np') {

        $menu_name = $menu->modu_displaytextnp;
      } else {

        $menu_name = $menu->modu_displaytext;
      }

      $active = "";

      $target = '';

      $sub_class = '';

      $caret = '';

      if (count($submenu_total) > 0) {

        $sub_class = '';
      }

      foreach ($submenu_total as $ksm => $subtot) {

        // echo $subtot->modu_moduleid."<br>";

        $sub_sub_menu = $this->check_sub_menu($subtot->modu_moduleid);
        // echo $this->ci->db->last_query();
        // die();

        if (is_array($sub_sub_menu) && count($sub_sub_menu) > 0) {

          $caret = '<span class="fa arrow"></span>';

          if ($menu->modu_parentmodule != 0) {

            $sub_class = 'dropdown-submenu';

            $caret = '';
          }
        }
      }

      if ($menu->modu_parentmodule == '0') {

        $class_menu_item = '';
      } else {

        $class_menu_item = '';
      }

      if (count($submenu_total) > 0) :

        $this->adjacencyList .= "\n" . '<li class="dropdown ' . $sub_class . ' "><a class="dropdown-toggle" data-toggle="dropdown"  ' . $other_att . '  href="' . $menu_url . '"  data-toggle="dropdown" title="' . stripslashes(strip_tags($menu_name)) . '" >' . '<span class="mbl_link">' . stripslashes($menu_name) . '</span>' . $caret . '<i class="' . $menu->modu_icon . '"></i></a>';

        // if($menu->link=='login' && empty($this->session->userdata('loggedin')))

        // {

        $this->menu_adjacency_main($menu->modu_moduleid, $level + 1, $location, $filename, false);

        // }

        $this->adjacencyList .= '</li>' . "\n";

      else :

        $this->adjacencyList .= "\n" . '<li class="dropdown ' . $sub_class . ' "><a class="page-scroll" ' . $other_att . ' href="' . $menu_url . '" ' . $target . '  title="' . stripslashes(strip_tags($menu_name)) . '">' . '<span class="mbl_link">' . stripslashes($menu_name) . '</span>' . '<i class="' . $menu->modu_icon . '"></i></a></li>' . "\n";

      endif;

    endforeach;

    $this->adjacencyList .= "</ul>\n";

    // var_dump( $this->adjacencyList);exit;

    return $this->adjacencyList;
  }

  public function menu_premission_main($parent, $level, $location = false, $filename = false, $first_call = true, $groupid = false, $all_perent = false)
  {

    // echo $level;

    // if($groupid)

    // {

    //    echo $groupid;

    //    die();

    // }

    $groupArray = $this->get_permissionlist($groupid);

    // echo "<pre>";

    // print_r($groupArray);

    // die();

    $lang = $this->ci->session->userdata('lang');

    $usergroup = $this->ci->session->userdata(USER_GROUP);

    // echo $usergroup;

    // die();

    if ($first_call == true) :

      $this->ci->db->select('*');

      $this->ci->db->from('modu_modules m');

      $this->ci->db->where(array('m.modu_isactive' => 'Y'));

      $this->ci->db->where(array('m.modu_parentmodule' => 0, 'm.modu_orgid' => $this->ci->session->userdata(ORG_ID)));

      $this->ci->db->order_by('m.modu_order', 'ASC');

      $qry = $this->ci->db->get();

      $this->adjacencyCheckboxlist .= '<ul class="checktree">';

    else :

      $this->ci->db->select('*');

      $this->ci->db->from('modu_modules m');

      $this->ci->db->where(array('m.modu_isactive' => 'Y'));

      $this->ci->db->where(array('m.modu_parentmodule' => $parent, 'm.modu_orgid' => $this->ci->session->userdata(ORG_ID)));

      $this->ci->db->order_by('m.modu_order', 'ASC');

      $qry = $this->ci->db->get();

      // echo $this->db->last_query();

      // die();

      $this->adjacencyCheckboxlist .= "\n" . '<ul>';

    endif;

    $oMenus = $qry->result();

    // echo $this->ci->db->last_query();

    // echo "<br>";

    // echo "<pre>";

    // print_r($oMenus);

    // exit;

    foreach ($oMenus as $menu) :

      $this->ci->db->select('*');

      $this->ci->db->from('modu_modules m');

      //  $this->ci->db->join('mope_modulespermission p','p.mope_moduleid=m.modu_moduleid','INNER');

      // $this->ci->db->where(array('p.mope_hasaccess'=>1,'mope_usergroupid'=>$usergroup));

      $this->ci->db->where(array('m.modu_parentmodule' => $menu->modu_moduleid));

      $this->ci->db->where(array('m.modu_isactive' => 'Y'));

      $this->ci->db->order_by('m.modu_order', 'ASC');

      $qry_sub = $this->ci->db->get();

      // $this->db->last_query();

      // // die();

      $submenu_total = $qry_sub->result();

      // echo count($submenu_total);

      $ckd = '';

      if (!empty($groupArray)) :

        if (in_array($menu->modu_moduleid, $groupArray)) {

          $ckd = 'checked=checked';
        } else {

          $ckd = '';
        }

      endif;

      $other_att = '';

      $menu_url = base_url($menu->modu_modulelink);

      if ($lang == 'np') {

        $menu_name = $menu->modu_displaytextnp;
      } else {

        $menu_name = $menu->modu_displaytext;
      }

      $active = "";

      $target = '';

      $sub_class = '';

      $caret = '';

      if (count($submenu_total) > 0) {

        $sub_class = '';
      }

      foreach ($submenu_total as $ksm => $subtot) {

        // echo $subtot->modu_moduleid."<br>";

        $sub_sub_menu = $this->check_sub_menu($subtot->modu_moduleid);

        if (is_array($sub_sub_menu) &&  count($sub_sub_menu) > 0) {

          if ($menu->modu_parentmodule != 0) {

            $sub_class = 'dropdown-submenu';
          }
        }
      }

      if ($menu->modu_parentmodule == '0') {

        $class_menu_item = '';
      } else {

        $class_menu_item = '';
      }

      if (count($submenu_total) > 0) :

        $this->adjacencyCheckboxlist .= "\n" . '<li class="' . $sub_class . ' "><input  class="perm-check chkmaster_' . $parent . ' ' . 'dropdown-submenu_' . $menu->modu_parentmodule . '" name="module[' . $menu->modu_moduleid . ']" value="Y" type="checkbox" ' . $ckd . ' data-module_id=' . $menu->modu_moduleid . '   />&nbsp;<strong>' . stripslashes($menu_name) . '</strong>   ';

        // if($menu->link=='login' && empty($this->session->userdata('loggedin')))

        // {

        $this->menu_premission_main($menu->modu_moduleid, $level + 1, $location, $filename, false, $groupid, $menu->modu_parentmodule);

        // }

        $this->adjacencyCheckboxlist .= '</li>' . "\n";

      else :

        $checkboxview = '';

        $chkview = $this->checkpermission($groupid, $menu->modu_moduleid, 'mope_view', 'Y');

        if ($chkview) {

          $checkboxview = "checked=checked";
        }

        $checkboxinsert = '';

        $chkinsert = $this->checkpermission($groupid, $menu->modu_moduleid, 'mope_insert', 'Y');

        if ($chkinsert) {

          $checkboxinsert = "checked=checked";
        }

        $checkboxupdate = '';

        $chkupdate = $this->checkpermission($groupid, $menu->modu_moduleid, 'mope_update', 'Y');

        if ($chkupdate) {

          $checkboxupdate = "checked=checked";
        }

        $checkboxdelete = '';

        $chkdelete = $this->checkpermission($groupid, $menu->modu_moduleid, 'mope_delete', 'Y');

        if ($chkdelete) {

          $checkboxdelete = "checked=checked";
        }

        $checkboxapproved = '';

        $chkapprove = $this->checkpermission($groupid, $menu->modu_moduleid, 'mope_approve', 'Y');

        if ($chkapprove) {

          $checkboxapproved = "checked=checked";
        }

        $checkboxverified = '';

        $chkapprove = $this->checkpermission($groupid, $menu->modu_moduleid, 'mope_verified', 'Y');

        if ($chkapprove) {

          $checkboxverified = "checked=checked";
        }

        $isinsert = $menu->modu_isinsert;

        if ($isinsert == 'Y') {

          $insrt = '<span class="inline-check mw_100 chkbox_' . $menu->modu_moduleid . '"><input class="operation chkbox_' . $menu->modu_moduleid . ' chkmaster_' . $parent . ' ' . 'dropdown-submenu_' . $all_perent . '"   type="checkbox" ' . $checkboxinsert . ' name="insert[' . $menu->modu_moduleid . ']" value="Y" data-operation="Insert" data-module_id=' . $menu->modu_moduleid . ' />&nbsp;Insert</span>';
        } else {

          $insrt = '<span class="inline-check mw_100 chkbox_' . $menu->modu_moduleid . '"></span>';
        }

        $isview = $menu->modu_isview;

        if ($isview == 'Y') {

          $vwe = '<span class="inline-check mw_100 chkbox_' . $menu->modu_moduleid . '" name="mope_view" ><input class="operation chkbox_' . $menu->modu_moduleid . ' chkmaster_' . $parent . ' ' . 'dropdown-submenu_' . $all_perent . '"  data-operation="View" name="view[' . $menu->modu_moduleid . ']" value="Y" data-module_id=' . $menu->modu_moduleid . '  type="checkbox" ' . $checkboxview . ' />&nbsp;View</span>';
        } else {

          $vwe = '<span class="inline-check mw_100 chkbox_' . $menu->modu_moduleid . '"></span>';
        }

        $isupdate = $menu->modu_isupdate;

        if ($isupdate == 'Y') {

          $updat = '<span class="inline-check mw_100 "><input class="operation chkbox_' . $menu->modu_moduleid . ' chkmaster_' . $parent . ' ' . 'dropdown-submenu_' . $all_perent . '"   type="checkbox" ' . $checkboxupdate . ' data-operation="Update" name="update[' . $menu->modu_moduleid . ']" value="Y" data-module_id=' . $menu->modu_moduleid . ' />&nbsp;Update</span>';
        } else {

          $updat = '<span class="inline-check mw_100 chkbox_' . $menu->modu_moduleid . '"></span>';
        }

        $isdelete = $menu->modu_isdelete;

        if ($isdelete == 'Y') {

          $delt = '<span class="inline-check mw_100"><input class="operation chkbox_' . $menu->modu_moduleid . ' chkmaster_' . $parent . ' ' . 'dropdown-submenu_' . $all_perent . '" name="delete[' . $menu->modu_moduleid . ']" value="Y"  type="checkbox" ' . $checkboxdelete . ' data-operation="Delete" data-module_id=' . $menu->modu_moduleid . ' />&nbsp;Delete</span>';
        } else {

          $delt = '<span class="inline-check mw_100 chkbox_' . $menu->modu_moduleid . '"></span>';
        }

        $isapproved = $menu->modu_isapproved;

        if ($isapproved == 'Y') {

          $approvd = '<span class="inline-check mw_100"><input class="operation chkbox_' . $menu->modu_moduleid . ' chkmaster_' . $parent . ' ' . 'dropdown-submenu_' . $all_perent . ' " name="approved[' . $menu->modu_moduleid . ']"  value="Y" type="checkbox" ' . $checkboxapproved . ' data-operation="Approved" data-module_id=' . $menu->modu_moduleid . ' />&nbsp;Approved</span>';
        } else {

          $approvd = '<span class="inline-check mw_100 chkbox_' . $menu->modu_moduleid . '"></span>';
        }

        $isverified = $menu->modu_isverified;

        if ($isverified == 'Y') {

          $verified = '<span class="inline-check mw_100"><input class="operation chkbox_' . $menu->modu_moduleid . ' chkmaster_' . $parent . ' ' . 'dropdown-submenu_' . $all_perent . ' " name="verified[' . $menu->modu_moduleid . ']"  value="Y" type="checkbox" ' . $checkboxverified . ' data-operation="Verified" data-module_id=' . $menu->modu_moduleid . ' />&nbsp;Verified</span>';
        } else {

          $verified = '<span class="inline-check mw_100 chkbox_' . $menu->modu_moduleid . '"></span>';
        }

        $this->adjacencyCheckboxlist .= "\n" . '<li class="checkli "><span class="inline-check"><input class="perm-check chkmaster_' . $parent . ' ' . 'dropdown-submenu_' . $all_perent . '" name="module[' . $menu->modu_moduleid . ']" value="Y"  type="checkbox" ' . $ckd . ' data-module_id=' . $menu->modu_moduleid . '  />&nbsp;' . stripslashes($menu->modu_displaytext) . '</span><div class="checkbox-wrapper">' . $insrt . ' ' . $vwe . ' ' . $updat . ' ' . $delt . ' ' . $verified . ' ' . $approvd . '</div></li>' . "\n";

      endif;

    endforeach;

    $this->adjacencyCheckboxlist .= "</ul>\n";

    // var_dump( $this->adjacencyCheckboxlist);exit;

    return $this->adjacencyCheckboxlist;
  }

  public function get_permissionlist($groupid)

  {

    $arrayPer = array();

    $this->ci->db->select('*');

    $this->ci->db->from('mope_modulespermission');

    $this->ci->db->where(array('mope_usergroupid' => $groupid, 'mope_hasaccess' => 1));

    $permission_list = $this->ci->db->get()->result();

    if ($permission_list) {

      foreach ($permission_list as $kp => $per) {

        $arrayPer[] = $per->mope_moduleid;
      }

      return $arrayPer;
    }

    return false;
  }

  public function checkpermission($groupid, $moduid, $column, $status)

  {

    $this->ci->db->select('*');

    $this->ci->db->from('mope_modulespermission');

    $this->ci->db->where(array('mope_usergroupid' => $groupid, 'mope_moduleid' => $moduid, $column => $status));

    $rows = $this->ci->db->get()->num_rows();

    if ($rows) {

      return true;
    }

    return false;
  }

  public function getMenuByID($id = false)
  {

    $this->ci->db->select('*');

    $this->ci->db->from('modu_modules m');

    $this->ci->db->where(array('modu_moduleid' => $id));

    $qry = $this->ci->db->get();

    // echo $this->db->last_query();

    // die();

    if ($qry->num_rows() > 0) {

      return $qry->result();
    }

    return false;
  }

  public function check_sub_menu($id = false)
  {

    $this->ci->db->select('*');

    $this->ci->db->from('modu_modules m');

    $this->ci->db->where(array('modu_parentmodule' => $id));

    $qry = $this->ci->db->get();

    // echo $this->db->last_query();

    // die();

    if ($qry->num_rows() > 0) {

      return $qry->num_rows();
    }

    return false;
  }

  /*  

  public function get_menu($srchcol=false)

  { 

    if($srchcol)

    {

      $this->ci->db->where($srchcol);

    }

    $query = $this->ci->db->get("modu_modules");

    // echo $this->ci->db->last_query();

    // die();

    if ($query->num_rows() > 0) 

    {

      $data=$query->result();   

      return $data;   

    }   

    return false;

  }

*/

  public function get_menu($srchcol = false)

  {

    $this->ci->db->select('*');

    $this->ci->db->from('modu_modules');

    $this->ci->db->order_by('modu_displaytext');

    if ($srchcol) {

      $this->ci->db->where($srchcol);
    }

    $query = $this->ci->db->get();

    // echo $this->ci->db->last_query();

    // die();

    if ($query->num_rows() > 0) {

      $data = $query->result();

      return $data;
    }

    return false;
  }

  public function get_pagination_config(&$config)

  {

    $config['first_link'] = 'First';

    $config['first_tag_open'] = '';

    $config['first_tag_close'] = '';

    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '';

    $config['last_tag_close'] = '';

    $config['next_link'] = 'Next';

    $config['prev_link'] = 'Previous';

    $config['next_tag_open'] = '';

    $config['next_tag_close'] = '';

    $config['cur_tag_open'] = '<span>';

    $config['cur_tag_close'] = '</span>';

    $config['num_tag_open'] = '';

    $config['num_tag_close'] = '';

    $get_vars = $this->ci->input->get();

    if (is_array($get_vars)) {

      $config['suffix'] = '?' . http_build_query($get_vars, '', '&');
    }

    return $config;
  }

  //pagination config for frontend

  public function frontend_pagination_config(&$config)

  {

    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';

    $config['next_link'] = 'Next';

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = 'Prev';

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0)"><span>';

    $config['cur_tag_close'] = '</span></a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';

    $config['first_link'] = 'First';

    $config['first_tag_open'] = '<li>';

    $config['first_tag_close'] = '</li>';

    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '<li>';

    $config['last_tag_close'] = '</li>';

    $get_vars = $this->ci->input->get();

    if (is_array($get_vars)) {

      $config['suffix'] = '?' . http_build_query($get_vars, '', '&');
    }

    return $config;
  }

  public function get_organization_info($srchcol = false)

  {

    $data = array();

    if ($srchcol) {

      $this->ci->db->where($srchcol);
    }

    $query = $this->ci->db->get("orga_organization");

    if ($query->num_rows() > 0) {

      $data = $query->row_array();
    }

    return $data;
  }

  public function EngToNepDateConv($date = false)
  {

    try {

      $this->ci->db->select('need_bsdate');

      $this->ci->db->from('need_nepequengdate');

      $this->ci->db->where('need_addate', $date);

      $query = $this->ci->db->get();

      // echo $this->ci->db->last_query();

      // die();

      if ($query->num_rows() > 0) {

        $result = $query->row();

        return $result->need_bsdate;
      }

      return false;
    } catch (Exception $e) {

      return "";
    }
  }

  public function NepToEngDateConv($date = false)

  {

    try {

      $this->ci->db->select('need_addate');

      $this->ci->db->from('need_nepequengdate');

      $this->ci->db->where('need_bsdate', $date);

      $query = $this->ci->db->get();

      if ($query->num_rows() > 0) {

        $result = $query->row();

        return $result->need_addate;
      }

      return false;
    } catch (Exception $e) {

      return "";
    }
  }

  public function get_real_ipaddr()

  {

    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet

      $ip = $_SERVER['HTTP_CLIENT_IP'];

    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy

      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

    else

      $ip = $_SERVER['REMOTE_ADDR'];

    return $ip;
  }

  public function get_Mac_Address()
  {

    // ob_start();  

    // system('ipconfig /all');  

    // $mycomsys=ob_get_contents();  

    // ob_clean();  

    // $find_mac = "Physical";   

    // $pmac = strpos($mycomsys, $find_mac);  

    // $macaddress=substr($mycomsys,($pmac+36),17);  

    // return $macaddress;  

    return 0;
  }

  public function get_tbl_data($select, $table = false, $where = false, $order = false, $order_by = 'ASC', $limit = false, $offset = false)

  {

    $this->ci->db->select($select);

    if ($where) {

      $this->ci->db->where($where);
    }

    if ($order) {

      $this->ci->db->order_by($order, $order_by);
    }

    if ($limit) {

      $this->ci->db->limit($limit);
    }

    if ($offset) {

      $this->ci->db->offset($offset);
    }

    $qry = $this->ci->db->get($table);

    // echo $this->ci->db->last_query();

    // exit;

    if ($qry->num_rows() > 0) {

      return $qry->result();
    }

    return false;
  }

  public function get_count_data($select, $table = false, $where = false, $order = false, $order_by = 'ASC')

  {

    $this->ci->db->select($select);

    if ($where) {

      $this->ci->db->where($where);
    }

    if ($order) {

      $this->ci->db->order_by($order, $order_by);
    }

    $qry = $this->ci->db->get($table);

    // echo $this->ci->db->last_query();

    // exit;

    if ($qry->num_rows() > 0) {

      return $qry->num_rows();
    }

    return false;
  }

  public function getlastvisit($patientid = false, $isvisit = false)

  {

    $this->ci->db->select('*');

    $this->ci->db->from('pavi_patientvisit');

    $this->ci->db->where('pavi_patientid', $patientid);

    $this->ci->db->order_by('pavi_visitid', 'DESC');

    $this->ci->db->limit(1);

    $qry = $this->ci->db->get();

    if ($qry->num_rows() > 0) {

      if ($isvisit == TRUE) {

        return $qry->row()->pavi_visitid;
      }

      return $qry->row();
    }

    return false;
  }

  public function getpatieninfo($patientid = false)

  {

    $this->ci->db->select('*');

    $this->ci->db->from('pama_patientmain');

    $this->ci->db->where('pama_patientid', $patientid);

    $qry = $this->ci->db->get();

    if ($qry->num_rows() > 0) {

      return $qry->row();
    }

    return false;
  }

  public function salt()

  {

    return substr(md5(uniqid(rand(), true)), 0, '10');
  }

  public function generate_username()

  {

    return substr(md5(uniqid(rand(), true)), 0, '10');
  }

  public function hash_password($password, $salt)

  {

    return  sha1($salt . sha1($salt . sha1($password)));
  }

  function create_password($length = 8, $use_upper = 1, $use_lower = 1, $use_number = 1, $use_custom = "")

  {

    $upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    $lower = "abcdefghijklmnopqrstuvwxyz";

    $number = "0123456789";

    $seed_length = '';

    $seed = '';

    $password = '';

    if ($use_upper) {

      $seed_length += 26;

      $seed .= $upper;
    }

    if ($use_lower) {

      $seed_length += 26;

      $seed .= $lower;
    }

    if ($use_number) {

      $seed_length += 10;

      $seed .= $number;
    }

    if ($use_custom) {

      $seed_length += strlen($use_custom);

      $seed .= $use_custom;
    }

    for ($x = 1; $x <= $length; $x++) {

      $password .= $seed[rand(0, $seed_length - 1)];
    }

    return $password;
  }

  public function set_sessionval($patientid = false)

  {

    $this->ci->session->set_userdata('patientid', $patientid);

    $this->ci->session->set_userdata('visitid', $this->getlastvisit($patientid, $isvisit = true));
  }

  public function save_log($tablename = false, $primarykey = false, $primaryid = false, $postdata = false, $action = false)

  {

    // echo "<pre>";

    // print_r($postdata);

    // die();

    $new_data = '';

    if ($postdata) :

      $new_data = '<table class="table table-border  table-site-detail dataTable"><thead><tr><th>Column Name</th><th>Value</th></tr></thead>';

      foreach ($postdata as $kn => $val_new) {

        $new_data .= '<tr><td>' . $kn . '</td><td>' . $val_new . '</td></tr>';
      }

      $new_data .= '</table>';

      $new_data = json_encode($postdata);

    endif;

    // die();

    $old_rec = $this->ci->db->get_where($tablename, array($primarykey => $primaryid))->row();

    // echo"<pre>";

    // print_r($old_rec);

    // die();

    $old_data = '';

    if ($old_rec) {

      $old_data = '<table class="table table-border  table-site-detail dataTable"><thead><tr><th>Column Name</th><th>Value</th></tr></thead>';

      foreach ($old_rec as $ko => $val_old) {

        $old_data .= '<tr><td>' . $ko . '</td><td>' . $val_old . '</td></tr>';
      }

      $old_data .= '</table>';

      $old_data = json_encode($old_rec);
    }

    //  echo "<pre>";

    // print_r($old_rec);

    // die();

    // $result=array_diff_assoc($old_rec,$postdata);

    // print_r($result);

    // die();

    $log_insert['colt_tablename'] = $this->ci->db->dbprefix($tablename);

    $log_insert['colt_primaryid'] = $primaryid;

    $log_insert['colt_primarykey'] = $primarykey;

    $log_insert['colt_patientid'] = $this->ci->session->userdata('patientid');

    $log_insert['colt_visitid'] = $this->ci->session->userdata('visitid');

    $log_insert['colt_action'] = $action;

    $log_insert['colt_datanew'] = $new_data;

    $log_insert['colt_dataold'] = $old_data;

    $log_insert['colt_postdatead'] = CURDATE_EN;

    $log_insert['colt_postdatebs'] = CURDATE_NP;

    $log_insert['colt_posttime'] = $this->get_currenttime();

    $log_insert['colt_postmac'] = $this->get_Mac_Address();

    $log_insert['colt_postip'] = $this->get_real_ipaddr();

    $log_insert['colt_postby'] = $this->ci->session->userdata(USER_ID);

    $this->ci->db->insert('colt_commonlogtable', $log_insert);
  }

  public function get_left_days($date1 = false, $date2 = false)

  {

    $days = $date1 - $date2;

    if ($days > 0) {

      $result = floor($days / 86400);

      return $result;
    }

    return 'Expiry';
  }

  public function ipfilter()

  {

    $ipaddres = $this->get_real_ipaddr();

    $macadd = $this->get_Mac_Address();

    // echo $macadd;

    // die();

    $qry = $this->ci->db->get_where('ipfi_ipfilter', array('ipfi_ipaddress' => $ipaddres));

    $rwno = $qry->num_rows();

    if ($rwno) {

      $result = $qry->row();

      if ($result) {

        $is_unlimited = $result->ipfi_unlimiteduser;

        $usertype = $result->ipfi_usertype;

        if ($is_unlimited == 'N' && $usertype != 'P') {

          // redirect('Restrict','refresh');

          // exit();

        }
      }
    } else {

      $postdata['ipfi_ipaddress'] = $ipaddres;

      $postdata['ipfi_macaddress'] = $macadd;

      $postdata['ipfi_postdatead'] = CURDATE_EN;

      $postdata['ipfi_postdatebs'] = CURDATE_NP;

      $postdata['ipfi_posttime'] = $this->get_currenttime();

      $postdata['ipfi_expirydatead'] = CURDATE_EN;

      $postdata['ipfi_expirydatebs'] = CURDATE_NP;

      $postdata['ipfi_exprytime'] = date("h:i:s", strtotime(date("h:i:s") . " +30 minutes"));

      $postdata['ipfi_isallow'] = 'Y';

      $postdata['ipfi_usertype'] = "U";

      $postdata['ipfi_computername'] = gethostname();

      // echo "<pre>";

      // print_r($postdata);

      // die();

      $this->ci->db->insert('ipfi_ipfilter', $postdata);

      return true;
    }
  }

  public function check_user_access_key($key)

  {

    $this->ci->db->select('*');

    $this->ci->db->from('usac_useraccess');

    $this->ci->db->where('usac_accesskey', $key);

    $qry = $this->ci->db->get();

    if ($qry) {

      return $qry->row();
    }

    return false;
  }

  public function pp($echo = '', $die = TRUE)
  {

    echo '<pre>';

    print_r($echo);

    echo '</pre>';

    $die && die;
  }

  public function getFiscalYear($srchcol = false, $order_by = false, $order = 'ASC')
  {

    try {

      $this->ci->db->select('*');

      $this->ci->db->from('fiye_fiscalyear');

      if ($srchcol) {

        $this->ci->db->where($srchcol);
      }

      if ($order_by) {

        $this->ci->db->order_by($order_by, $order);
      }

      $query = $this->ci->db->get();

      if ($query->num_rows() > 0) {

        $result = $query->result();

        return $result;
      }

      return false;
    } catch (Exception $e) {

      throw $e;
    }
  }

  public function find_end_of_month($yrs_mnth)

  {

    // echo $yrs_mnth;

    // die();

    $this->ci->db->select('*');

    $this->ci->db->from('need_nepequengdate');

    $this->ci->db->where('need_bsdate LIKE "' . $yrs_mnth . '%"');

    $dateresult = $this->ci->db->order_by('need_bsdate', 'DESC')->get()->row();

    if (!empty($dateresult)) :

      if (DEFAULT_DATEPICKER == 'NP') :

        return $dateresult->need_bsdate;

      else :

        return $dateresult->need_addate;

      endif;

    else :

      return false;

    endif;
  }

  // string  seperator either string or number

  function stringseperator($string, $type_return)
  {

    $numbers = array();

    $alpha = array();

    $array = str_split($string);

    for ($x = 0; $x < count($array); $x++) {

      if (is_numeric($array[$x]))

        array_push($numbers, $array[$x]);

      else

        array_push($alpha, $array[$x]);
    } // end for         

    $alpha = implode($alpha);

    $numbers = implode($numbers);

    if ($type_return == 'number')

      return $numbers;

    elseif ($type_return == 'alpha')

      return $alpha;
  }

  public function getFirstDayOfCurrentMonth()
  {

    if (DEFAULT_DATEPICKER == 'NP') {

      $curdate = CURDATE_NP;

      $newdate = explode('/', $curdate);

      $startdate = $newdate[0] . '/' . $newdate[1] . '/' . '01';
    } else {

      $curdate = CURDATE_EN;

      $startdate = date('Y/m/01');
    }

    return $startdate;
  }

  public function getLastNo($fieldname, $tablename, $wherecond = false)
  {

    if (empty($fieldname) || empty($tablename)) {

      throw new Exception("Error Processing Request", 1);
    }

    $this->ci->db->select_max($fieldname);

    $this->ci->db->from($tablename);

    if ($wherecond) {

      $this->ci->db->where($wherecond);
    }

    $query = $this->ci->db->get();

    if ($query->num_rows() > 0) {

      $result = $query->row();

      return $result->$fieldname;
    }

    return false;
  }

  public function location_option($colno = 2, $optionname = 'locationname', $id = 'locationid', $dfl_select = false, $addfield = false, $all = false)

  {

    $location_id = $this->ci->session->userdata(LOCATION_ID);

    $location_ismain = $this->ci->session->userdata(ISMAIN_LOCATION);

    $groupcode = $this->ci->session->userdata(USER_GROUPCODE);

    $option = '';

    $seloption = '';

    // $show_location_group = array('SA', 'SK', 'SI');
    $show_location_group = array('SA');

    if ($location_ismain == 'Y' && in_array($groupcode, $show_location_group)) {

      $db_location = $this->get_tbl_data('*', 'loca_location', array('loca_isactive' => 'Y'), 'loca_locationid', 'ASC');
    } else {

      $db_location = $this->get_tbl_data('*', 'loca_location', array('loca_locationid' => $location_id), 'loca_locationid', 'ASC');
    }

    if ($addfield == 'all' || $all == 'all') {

      $db_location = $this->get_tbl_data('*', 'loca_location', false, 'loca_locationid', 'ASC');
    }

    // print_r($db_location);

    // die();

    if ($addfield != 'all' && $addfield != '') {

      $addfield = $addfield;
    }

    $option .= '<div class="col-md-' . $colno . '">';

    $option .= '<label>' . $this->ci->lang->line('location') . ' ' . $addfield . ':</label>';

    if ($db_location) :

      $option .= '<select name="' . $optionname . '" id="' . $id . '" class="form-control"> ';

      if ($location_ismain == 'Y' && $groupcode == 'SA') {

        $option .= '<option value="">--All--</option>';
      }

      if ($addfield == 'all' || $all == 'all') {

        $option .= '<option value="">--All--</option>';
      }

      foreach ($db_location as $km => $loca) :

        if ($dfl_select) {

          if ($loca->loca_locationid == $dfl_select) {

            $select_opt = 'selected=selected';
          } else {

            $select_opt = '';
          }
        } else if ($location_ismain == 'Y') {

          if ($loca->loca_locationid == $location_id) {

            $select_opt = 'selected=selected';
          } else {

            $select_opt = '';
          }
        } else if ($dfl_select && $location_ismain == 'Y') {

          if ($loca->loca_locationid == $dfl_select) {

            $select_opt = 'selected=selected';
          } else {

            $select_opt = '';
          }
        } else {

          $select_opt = '';
        }

        $option .= '<option value="' . $loca->loca_locationid . '" ' . $select_opt . '>' . $loca->loca_name . '</option>';

      endforeach;

      $option .= '</select>';

      $option .= '</div>';

    endif;

    echo $option;

    // return $option;

  }

  public function generate_invoiceno($fieldname, $invoice_fieldname, $tablename, $prefix_no, $length, $cond = false, $location_fieldname = false, $order_by = false, $order_type = 'S', $order = 'DESC', $is_disable_prefix = 'N')
  {
    error_reporting(0);

    $locationid = $this->ci->session->userdata(LOCATION_ID);

    if (defined('LOCATION_CODE')) :

      $location_code = $this->ci->session->userdata(LOCATION_CODE);

    endif;

    $curmnth = CURMONTH;

    if ($curmnth == 1) {

      $prefix = 'A';
    }

    if ($curmnth == 2) {

      $prefix = 'B';
    }

    if ($curmnth == 3) {

      $prefix = 'C';
    }

    if ($curmnth == 4) {

      $prefix = 'D';
    }

    if ($curmnth == 5) {

      $prefix = 'E';
    }

    if ($curmnth == 6) {

      $prefix = 'F';
    }

    if ($curmnth == 7) {

      $prefix = 'G';
    }

    if ($curmnth == 8) {

      $prefix = 'H';
    }

    if ($curmnth == 9) {

      $prefix = 'I';
    }

    if ($curmnth == 10) {

      $prefix = 'J';
    }

    if ($curmnth == 11) {

      $prefix = 'K';
    }

    if ($curmnth == 12) {

      $prefix = 'L';
    }

    if (ORGANIZATION_NAME == 'NPHL') {

      $prefix = 'E';
    }

    if ($is_disable_prefix == 'Y') {

      $prefix = '';
    }

    $this->ci->db->select($fieldname);

    $this->ci->db->from($tablename);
    $this->ci->db->where("lower(" . $invoice_fieldname . ") LIKE '%" . $prefix_no . $prefix . "%'");
    // $this->ci->db->where($invoice_fieldname.' LIKE '.'"%'.$prefix_no.$prefix.'%"');

    $this->ci->db->where($location_fieldname, $locationid);

    if ($cond) {

      $this->ci->db->where($cond);
    }

    $this->ci->db->limit(1);

    if ($order_type == 'M' && $order_by) {

      $this->ci->db->order_by($order_by);
    } else if ($order_type == 'S' && $order_by) {

      $this->ci->db->order_by($order_by, $order);
    } else {

      $this->ci->db->order_by($fieldname, 'DESC');
    }

    $query = $this->ci->db->get();

    // echo $this->ci->db->last_query(); die();

    $dbinvoiceno = 0;

    if ($query->num_rows() > 0) {

      $dbinvoiceno = $query->row()->$fieldname;
    }

    // echo $dbinvoiceno.' '.$prefix_no.$prefix;

    // die();

    $invoiceno = str_replace($prefix_no . $prefix, ' ', $dbinvoiceno);

    // die();

    // $invoiceno=$this->stringseperator($dbinvoiceno,'number');

    // echo $invoiceno;

    // die();

    $nw_invoice = str_pad($invoiceno + 1, $length, 0, STR_PAD_LEFT);

    // echo $nw_invoice;

    if (defined('SHOW_FORM_NO_WITH_LOCATION')) {

      if (SHOW_FORM_NO_WITH_LOCATION == 'Y') {

        return $location_code . '-' . $prefix_no . $prefix . $nw_invoice;
      } else {

        return $prefix_no . $prefix . $nw_invoice;
      }
    } else {

      return $prefix_no . $prefix . $nw_invoice;
    }
  }

  public function generate_form_no($fieldname, $tablename, $cond = false, $order_fieldname = false, $order_by = 'DESC')
  {

    if (defined('LOCATION_CODE')) :

      $location_code = $this->ci->session->userdata(LOCATION_CODE);

    endif;

    $this->ci->db->select("max(convert($fieldname, SIGNED INTEGER)) as form_no");

    $this->ci->db->select($fieldname);

    $this->ci->db->from($tablename);

    if ($cond) {

      $this->ci->db->where($cond);
    }

    if ($order_fieldname && $order_by) {

      $this->ci->db->order_by($order_fieldname, $order_by);
    }

    $query = $this->ci->db->get();

    if ($query->num_rows() > 0) {

      $get_form_no = $query->row()->form_no;
    } else {

      $get_form_no = 0;
    }

    $cur_form_no = $get_form_no + 1;

    if (defined('SHOW_FORM_NO_WITH_LOCATION')) {

      if (SHOW_FORM_NO_WITH_LOCATION == 'Y') {

        return $location_code . '-' . $cur_form_no;
      } else {

        return $cur_form_no;
      }
    } else {

      return $cur_form_no;
    }
  }

  public function number_to_word($number = '')

  {

    error_reporting(0);

    // echo ITEM_DISPLAY_TYPE;

    // die();

    //  if(ITEM_DISPLAY_TYPE=='NP')

    //  {

    //   return $this->number_to_word_nepali($number);

    // } 

    // else

    // {

    return $this->number_to_word_english($number);

    // }

  }

  public function number_to_word_english($number = '')

  {

    $number = round($number, 2);

    $decimal = round($number - ($no = floor($number)), 2) * 100;

    $hundred = null;

    $digits_length = strlen($no);

    $i = 0;

    $str = array();

    $words = array(
      0 => '', 1 => 'one', 2 => 'two',

      3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',

      7 => 'seven', 8 => 'eight', 9 => 'nine',

      10 => 'ten', 11 => 'eleven', 12 => 'twelve',

      13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',

      16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',

      19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',

      40 => 'forty', 50 => 'fifty', 60 => 'sixty',

      70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
    );

    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore', 'arab', 'kharab');

    while ($i < $digits_length) {

      $divider = ($i == 2) ? 10 : 100;

      $number = floor($no % $divider);

      $no = floor($no / $divider);

      $i += $divider == 10 ? 1 : 2;

      if ($number) {

        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;

        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;

        $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
      } else $str[] = null;
    }

    $Rupees = implode('', array_reverse($str));

    $paise = ($decimal) ? "and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paisa' : '';

    return ucfirst(($Rupees ? $Rupees . 'Rupees ' : '') . $paise);
  }

  public function number_to_word_nepali($number = '')

  {

    // echo "num";

    // echo $number;

    // die();

    $number = round($number, 2);

    $decimal = round($number - ($no = floor($number)), 2) * 100;

    // echo 'c'.$decimal;

    // die();

    $hundred = null;

    $digits_length = strlen($no);

    // echo 'dl'.$digits_length;

    // die();

    $i = 0;

    $str = array();

    $words = array(0 => '', 1 => 'एक', 2 => 'दुई', 3 => 'तिन', 4 => 'चार', 5 => 'पाँच', 6 => 'छ', 7 => 'सात', 8 => 'आठ', 9 => 'नौ', 10 => 'दश', 11 => ' एघार', 12 => 'बाह्र', 13 => 'तेह्र', 14 => 'चौध', 15 => 'पन्ध्र', 16 => 'सोह्र', 17 => 'सत्र', 18 => 'अठार', 19 => 'उन्नाइस', 20 => 'विस', 21 => "एकाइस", 22 => "बाइस", 23 => "तेइस", 24 => "चौबीस", 25 => "पचीस", 26 => "छब्बीस", 27 => "सत्ताइस", 28 => "अठ्ठाइस", 29 => "उनन्तीस", 30 => "तीस", 31 => "एकतीस", 32 => "बतीस", 33 => "तेतीस", 34 => "चौतीस", 35 => "पैतीस", 36 => "छतीस", 37 => "सरतीस", 38 => "अरतीस", 39 => "उननचालीस", 40 => "चालीस", 41 => "एकचालीस", 42 => "बयालिस", 43 => "तीरचालीस", 44 => "चौवालिस", 45 => "पैंतालिस", 46 => "छयालिस", 47 => "सरचालीस", 48 => "अरचालीस", 49 => "उननचास", 50 => "पचास", 51 => "एकाउन्न", 52 => "बाउन्न", 53 => "त्रिपन्न", 54 => "चौवन्न", 55 => "पच्पन्न", 56 => "छपन्न", 57 => "सन्ताउन्न", 58 => "अन्ठाउँन्न", 59 => "उनान्न्साठी ", 60 => "साठी", 61 => "एकसाठी", 62 => "बासाठी", 63 => "तीरसाठी", 64 => "चौंसाठी", 65 => "पैसाठी", 66 => "छैसठी", 67 => "सत्सठ्ठी", 68 => "अर्सठ्ठी", 69 => "उनन्सत्तरी", 70 => "सतरी", 71 => "एकहत्तर", 72 => "बहत्तर", 73 => "त्रिहत्तर", 74 => "चौहत्तर", 75 => "पचहत्तर", 76 => "छहत्तर", 77 => "सत्हत्तर", 78 => "अठ्हत्तर", 79 => "उनास्सी", 80 => "अस्सी", 81 => "एकासी", 82 => "बयासी", 83 => "त्रीयासी", 84 => "चौरासी", 85 => "पचासी", 86 => "छयासी", 87 => "सतासी", 88 => "अठासी", 89 => "उनानब्बे", 90 => "नब्बे", 91 => "एकानब्बे", 92 => "बयानब्बे", 93 => "त्रियानब्बे", 94 => "चौरानब्बे", 95 => "पंचानब्बे", 96 => "छयानब्बे", 97 => "सन्तान्‍नब्बे", 98 => "अन्ठानब्बे", 99 => "उनान्सय",);

    $digits = array('', 'सय', 'हजार', 'लाख', 'करोड', 'अरब', 'खरब');

    while ($i < $digits_length) {

      $divider = ($i == 2) ? 10 : 100;

      // echo '<br>i.'.$i.' div'.$divider;

      $number = floor($no % $divider);

      $no = floor($no / $divider);

      $i += $divider == 10 ? 1 : 2;

      // echo 'number'.$number;

      if ($number) {

        $plural = (($counter = count($str)) && $number > 9) ? '' : null;

        $hundred = ($counter == 1 && $str[0]) ? '  ' : null;

        // $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;

        $str[] = ($number > 0) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
      } else $str[] = null;

      // echo "<pre>";

      // print_r($str);

    }

    $Rupees = implode('', array_reverse($str));

    $paise = !empty($decimal) ? "र " . ($words[$decimal]) . ' पैसा' : '';

    return ($Rupees ? $Rupees . 'रुपैंया ' : '') . $paise . 'मात्र';
  }

  public function getNepaliMonth($month)
  {

    $monthname = "";

    switch ($month) {

      case "1":
        $monthname = "Baishak";
        break;

      case "2":
        $monthname = "Jesth";
        break;

      case "3":
        $monthname = "Ashadh";
        break;

      case "4":
        $monthname = "Shrawan";
        break;

      case "5":
        $monthname = "Bhadra";
        break;

      case "6":
        $monthname = "Aaswin";
        break;

      case "7":
        $monthname = "Kartik";
        break;

      case "8":
        $monthname = "Mangir";
        break;

      case "9":
        $monthname = "Poush";
        break;

      case "10":
        $monthname = "Magh";
        break;

      case "11":
        $monthname = "Falgun";
        break;

      case "12":
        $monthname = "Chaitra";
        break;
    }

    return $monthname;
  }

  public function generate_pdf($html = false, $filename = false, $pdfsize = false)
  {
    // echo $html;
    // die();

    $CI = &get_instance();

    error_reporting(0);
    if (!empty($pdfsize)) {
      $pdfsize = $pdfsize;
    } else {
      $pdfsize = 'A4';
    }
    require_once  APPPATH . '/third_party/mpdf/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf([

      'mode' => 'utf-8',
      'format' => $pdfsize

    ]);

    $stylesheet = '';

    $mpdf->autoScriptToLang = true;

    $mpdf->autoLangToFont = true;

    ini_set('memory_limit', '4048M');
    ini_set("pcre.backtrack_limit", "50000000");

    if (PDF_IMAGEATEXT == '3') {

      $mpdf->SetWatermarkImage(PDF_WATERMARK);

      $mpdf->showWatermarkImage = true;

      $mpdf->showWatermarkText = true;

      $mpdf->SetWatermarkText(ORGA_NAME);
    }

    if (PDF_IMAGEATEXT == '1') {

      $mpdf->SetWatermarkImage(PDF_WATERMARK);

      $mpdf->showWatermarkImage = true;
    }

    if (PDF_IMAGEATEXT == '2') {

      $mpdf->showWatermarkText = true;

      $mpdf->SetWatermarkText(ORGA_NAME);
    }

    $mpdf->WriteHTML($stylesheet, 1);

    $mpdf->SetHTMLFooter('<div style="text-align: center">{PAGENO} of {nbpg}</div>');

    $mpdf->WriteHTML($html);

    if ($filename) {
      $mpdf->Output($filename, 'D');
    } else {

      $mpdf->Output();
    }
    // ob_end_flush(); 

  }

  public function get_signature($userid)
  {

    if (!empty($userid)) {

      if (NAME_DISPLAY_TYPE == 'NP') {

        $this->ci->db->select('usma_fullnamenp as usma_fullname, usma_signaturepath, usma_designationnp as usma_designation, usma_employeeid');
      } else {

        $this->ci->db->select('usma_fullname, usma_signaturepath, usma_designation, usma_employeeid');
      }

      $this->ci->db->from('usma_usermain');

      $this->ci->db->where('usma_userid', $userid);

      $query = $this->ci->db->get();

      if ($query->num_rows() > 0) {

        return $query->row();
      }

      return false;
    } else {

      return false;
    }
  }

  public function check_store_person_count($type = false)
  {

    $this->ci->db->select('usma_userid');

    $this->ci->db->from('usma_usermain');

    $this->ci->db->where('usma_storeposttype', $type);

    $query = $this->ci->db->get();

    if ($query->num_rows() > 0) {

      return $query->num_rows();
    } else {

      return false;
    }
  }

  public function get_store_post_data($date = false, $type = false)
  {

    $store_post_count = $this->check_store_person_count($type);

    $this->ci->db->select('usma_userid');

    $this->ci->db->from('usma_usermain');

    $this->ci->db->where('usma_storeposttype', $type);

    if ($store_post_count > 1) {

      $this->ci->db->where('usma_servicestartdatebs >=', $date);

      $this->ci->db->where('usma_serviceenddatebs <=', $date);
    }

    $query = $this->ci->db->get();

    if ($query->num_rows() > 0) {

      return $query->row()->usma_userid;
    }

    return false;
  }

  public function get_current_common_tab()

  {

    $usergroup = $this->ci->session->userdata(USER_GROUP);

    $currenturl = $this->getUrl();

    // echo $currenturl;

    // die();

    $qrystringCnt = substr_count($currenturl, '?');

    // die();

    if ($this->ci->input->is_ajax_request()) {

      $currenturl = $_SERVER['HTTP_REFERER'];
    }

    $new_url = str_replace(base_url(), "", $currenturl);

    $urlchk = '/' . $new_url;

    // echo $urlchk;

    // die();
    // $rslt= $this->ci->db->select("m.modu_moduleid,(CASE WHEN (m.modu_modulelink='".$urlchk."') THEN 'cur' ELSE 'non_cur' END) as urlstatus");
    //  $this->ci->db->from('modu_modules m');
    //  $this->ci->db->join('mope_modulespermission p',' p.mope_moduleid=m.modu_moduleid','LEFT');
    //  $this->ci->db->where("m.modu_parentmodule IN 
    //  (SELECT ms.modu_parentmodule FROM xw_modu_modules ms WHERE ms.modu_modulelink='".$urlchk."') AND m.modu_modulelink !='#' 
    //  AND  m.modu_parentmodule !='0' AND m.modu_isactive='Y' AND p.mope_hasaccess='1' AND p.mope_usergroupid=$usergroup AND m.modu_ishidden ='N' ");
    //  // $this->ci->db->group_by('m.modu_moduleid');
    //  $this->ci->db->order_by('m.modu_order','ASC');
    //  $this->ci->db->get()->result();

    $rslt = $this->ci->db->query("SELECT m.*, (CASE WHEN (m.modu_modulelink='" . $urlchk . "') THEN 'cur' ELSE 'non_cur' END) as urlstatus from xw_modu_modules m LEFT join xw_mope_modulespermission p on  p.mope_moduleid=m.modu_moduleid  WHERE m.modu_parentmodule IN
  (SELECT ms.modu_parentmodule FROM xw_modu_modules ms WHERE ms.modu_modulelink='" . $urlchk . "')
  AND m.modu_modulelink !='#' 
  AND  m.modu_parentmodule !='0' AND m.modu_isactive='Y' AND p.mope_hasaccess='1' AND p.mope_usergroupid=$usergroup AND m.modu_ishidden ='N'
  ORDER BY m.modu_order ASC")->result();
    // echo $this->ci->db->last_query();
    // die();

    // if($first_call == true): 

    //     $this->ci->db->select('*');

    //    $this->ci->db->from('modu_modules m');

    //    $this->ci->db->join('mope_modulespermission p','p.mope_moduleid=m.modu_moduleid','INNER');

    //    $this->ci->db->where(array('p.mope_hasaccess'=>1,'mope_usergroupid'=>$usergroup));

    //    $this->ci->db->where(array('m.modu_parentmodule'=>0));

    //     $this->ci->db->where(array('m.modu_isactive'=>'Y'));

    //    $this->ci->db->where(array('m.modu_ishidden'=>'N'));

    //    $this->ci->db->order_by('m.modu_order','ASC');  

    //    $qry=$this->ci->db->get();

    // echo "<pre>";

    // print_r($rslt);

    // die();

    if (!empty($rslt)) {

      return $rslt;
    }

    return false;
  }

  public function send_message_params($action, $msg_params, $user_params = false, $post_locationid = false)
  {

    $this->ci->db->select('mest_fromgroup, mest_togroup, mest_title, mest_content, mest_path, mest_type');

    $this->ci->db->from('mest_messagestatus ms');

    $this->ci->db->where('mest_processaction', $action);

    $query = $this->ci->db->get();

    // echo $this->ci->db->last_query();

    // die();

    if ($query->num_rows() > 0) {

      $data = $query->result();

      $mess_user = !empty($data[0]->mest_togroup) ? $data[0]->mest_togroup : '';

      $mess_title = !empty($data[0]->mest_title) ? $data[0]->mest_title : '';

      $mess_content = !empty($data[0]->mest_content) ? $data[0]->mest_content : '';

      $mess_path = !empty($data[0]->mest_path) ? $data[0]->mest_path : '';

      $mess_type = !empty($data[0]->mest_type) ? $data[0]->mest_type : '';

      if (!strpos($mess_user, ',') === false) {

        $mess_user_array = explode(',', $mess_user);
      }

      if (!empty($msg_params)) {

        foreach ($msg_params as $mkey => $mval) {

          $mess_title = str_replace("[$mkey]", $mval, $mess_title);

          $mess_user = str_replace("[$mkey]", $mval, $mess_user);
        }
      }

      // if(!empty($user_params) && $mess_type == 'U'){

      //   foreach($user_params as $ukey=>$uval){

      //     $mess_user = str_replace("[$ukey]",$uval,$mess_user);

      //   }

      // }

      $mess_message = !empty($mess_content) ? $mess_content : $mess_title;

      if (!empty($mess_user_array)) {

        foreach ($mess_user_array as $mukey => $muval) {

          $mess_user = $muval;

          $this->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, $mess_type, $post_locationid);
        }
      } else {

        $this->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, $mess_type, $post_locationid);
      }

      return false;
    }
  }

  public function send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path = false, $send_type = false, $post_locationid = false)
  {

    if ($send_type == 'G') {

      $this->ci->db->select('usma_userid');

      $this->ci->db->from('usma_usermain um');

      $this->ci->db->join('usgr_usergroup ug', 'ug.usgr_usergroupid = um.usma_usergroupid', 'left');

      $this->ci->db->where_in('usgr_usergroupcode', $mess_user);

      // if($this->ci->session->userdata(LOCATION_ID)):

      //   $this->ci->db->where('usma_locationid',$this->ci->session->userdata(LOCATION_ID));

      // else:

      //   $this->ci->db->where('usma_locationid', $post_locationid); // for user registration

      // endif;

      if (!empty($post_locationid)) {

        $this->ci->db->where('usma_locationid', $post_locationid);
      } else if ($this->ci->session->userdata(LOCATION_ID)) {

        $this->ci->db->where('usma_locationid', $this->ci->session->userdata(LOCATION_ID));
      } else {

        $this->ci->db->where('usma_locationid', $post_locationid);
      }

      $query = $this->ci->db->get();

      // echo $this->ci->db->last_query();die();

      // print_r($query->num_rows());

      // die();

      if ($query->num_rows() > 0) {

        $data = $query->result();

        if (!empty($post_locationid)) :

          $locationid = $post_locationid;

        else :

          $locationid = $this->ci->session->userdata(LOCATION_ID);

        endif;

        foreach ($data as $user) {

          $messageArray = array(

            'mess_title' => $mess_title,

            'mess_message' => $mess_message,

            'mess_userid' => $user->usma_userid,

            'mess_status' => 'U',

            'mess_path' => $mess_path,

            'mess_postby' => !empty($this->ci->session->userdata(USER_ID)) ? $this->ci->session->userdata(USER_ID) : '',

            'mess_postdatead' => CURDATE_NP,

            'mess_postdatebs' => CURDATE_EN,

            'mess_posttime' => $this->get_currenttime(),

            'mess_postip' => $this->get_real_ipaddr(),

            'mess_postmac' => $this->get_Mac_Address(),

            'mess_locationid' => !empty($locationid) ? $locationid : $this->ci->session->userdata(LOCATION_ID),

            'mess_orgid' => !empty($this->ci->session->userdata(ORG_ID)) ? $this->ci->session->userdata(ORG_ID) : ''

          );

          // print_r($messageArray);

          // die();

          if ($messageArray) {

            $this->ci->db->insert('mess_message', $messageArray);
          }
        }

        return true;
      }
    } else {

      $messageArray = array(

        'mess_title' => $mess_title,

        'mess_message' => $mess_message,

        'mess_userid' => $mess_user,

        'mess_status' => 'U',

        'mess_path' => $mess_path,

        'mess_postby' => !empty($this->ci->session->userdata(USER_ID)) ? $this->ci->session->userdata(USER_ID) : '',

        'mess_postdatead' => CURDATE_NP,

        'mess_postdatebs' => CURDATE_EN,

        'mess_posttime' => $this->get_currenttime(),

        'mess_postip' => $this->get_real_ipaddr(),

        'mess_postmac' => $this->get_Mac_Address(),

        'mess_locationid' => !empty($this->ci->session->userdata(LOCATION_ID)) ? $this->ci->session->userdata(LOCATION_ID) : $post_locationid,

        'mess_orgid' => !empty($this->ci->session->userdata(ORG_ID)) ? $this->ci->session->userdata(ORG_ID) : ''

      );

      if ($messageArray) {

        $this->ci->db->insert('mess_message', $messageArray);

        return true;
      }
    }

    return false;
  }

  public function get_message($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = 'ASC')
  {

    $this->ci->db->select('mess_messageid,
  mess_title,
  mess_message,
  mess_userid,
  mess_status,
  mess_postdatead,
  mess_postdatebs,
  mess_posttime');

    $this->ci->db->from('mess_message');

    $this->ci->db->order_by('mess_messageid', 'DESC');

    if ($srchcol) {

      $this->ci->db->where($srchcol);
    }

    if ($limit) {

      $this->ci->db->limit($limit);
    }

    if ($offset) {

      $this->ci->db->offset($offset);
    }

    if ($order_by) {

      $this->ci->db->order_by($order_by, $order);
    }

    $query = $this->ci->db->get();

    // echo $this->ci->db->last_query();

    // die();

    if ($query->num_rows() > 0) {

      $data = $query->result();

      return $data;
    }

    return false;
  }

  public function saveActionLog($tablename, $masterid, $userid, $status, $fieldname = false, $comment = false)
  {

    $actionLogArray = array(

      'aclo_tablename' => $tablename,

      'aclo_masterid' => $masterid,

      'aclo_userid' => $userid,

      'aclo_status' => $status,

      'aclo_fieldname' => $fieldname,

      'aclo_comment' => $comment,

      'aclo_actiondatead' => CURDATE_EN,

      'aclo_actiondatebs' => CURDATE_NP,

      'aclo_actiontime' =>  $this->get_currenttime(),

      'aclo_actionmac' => $this->get_Mac_Address(),

      'aclo_actionip' => $this->get_real_ipaddr(),

      'aclo_locationid' => $this->ci->session->userdata(LOCATION_ID),

      'aclo_orgid' => $this->ci->session->userdata(ORG_ID)

    );

    if ($actionLogArray) {

      $this->ci->db->insert('aclo_actionlog', $actionLogArray);

      return true;
    }

    return false;
  }

  public function get_color_code($select, $table = false, $where = false, $order = false, $order_by = 'ASC')

  {

    $this->ci->db->select($select);

    if ($where) {

      $this->ci->db->where($where);
    }

    if ($order) {

      $this->ci->db->order_by($order, $order_by);
    }

    $qry = $this->ci->db->get($table);

    // echo $this->ci->db->last_query();

    // exit;

    if ($qry->num_rows() > 0) {

      return $qry->result();
    }

    return false;
  }

  public function get_user_list_by_group($srch = false, $user_groupid = false, $order_by = false, $order_type = 'ASC', $user_group_array = false, $not_in_userid = false)
  {

    $this->ci->db->select('um.usma_username, um.usma_usergroupid, um.usma_userid, um.usma_accountlvl');

    $this->ci->db->from('usgr_usergroup ug');

    $this->ci->db->join('usma_usermain um', 'um.usma_usergroupid = ug.usgr_usergroupid');

    if ($srch) {

      $this->ci->db->where($srch);
    }

    if ($user_groupid) {

      $this->ci->db->where('usgr_usergroupcode', $user_groupid);
    }

    if ($user_group_array) {

      $this->ci->db->where_in('usgr_usergroupcode', $user_group_array);
    }

    if ($order_by && $order_type) {

      $this->ci->db->order_by($order_by, $order_type);
    }

    if ($not_in_userid) {

      $this->ci->db->where('usma_userid <>', $not_in_userid);
    }

    $this->ci->db->where('usma_locationid', $this->ci->session->userdata(LOCATION_ID));

    $query = $this->ci->db->get();

    // echo $this->ci->db->last_query();

    // die();

    if ($query->num_rows() > 0) {

      return $query->result();
    }

    return false;
  }

  public function insert_query_log($query = false)

  {

    if ($query) {

      $qry = $query;
    } else {

      $qry = $this->ci->db->last_query();
    }

    $arrayquery = array(

      'qulo_query' => $qry,

      'qulo_postdatead' => CURDATE_EN,

      'qulo_postdatebs' => CURDATE_NP,

      'qulo_posttime' =>  $this->get_currenttime(),

      'qulo_postby' => $this->ci->session->userdata(USER_ID),

      'qulo_postmac' => $this->get_Mac_Address(),

      'qulo_postip' => $this->get_real_ipaddr(),

      'qulo_locationid' => $this->ci->session->userdata(LOCATION_ID),

      'qulo_orgid' =>  $this->ci->session->userdata(ORG_ID)

    );

    if (!empty($arrayquery)) {

      $this->ci->db->insert('qulo_querylog', $arrayquery);
    }
  }

  public function get_user_list_for_report($reqno, $fyear, $status = false, $field = false)
  {

    $locationid = $this->ci->session->userdata(LOCATION_ID);

    $orgid =  $this->ci->session->userdata(ORG_ID);

    $sql = "

            SELECT aclo_tablename, aclo_masterid, aclo_userid, aclo_status, aclo_fieldname,rema_reqno,um.usma_fullname, um.usma_employeeid, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip 

            from xw_aclo_actionlog xaa

            left join xw_rema_reqmaster rm on xaa.aclo_masterid = rm.rema_reqmasterid and aclo_tablename = 'rema_reqmaster'

            left join xw_usma_usermain um on um.usma_userid = xaa.aclo_userid

            where rema_reqno = '$reqno' and rema_fyear = '$fyear' and aclo_status = '$status' and aclo_fieldname = '$field' and usma_locationid = '$locationid'

            UNION

            SELECT aclo_tablename, aclo_masterid, aclo_userid, aclo_status, aclo_fieldname, pure_streqno, um.usma_fullname, um.usma_employeeid, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip

            from xw_aclo_actionlog xaa 

            left join xw_pure_purchaserequisition pr on xaa.aclo_masterid = pr.pure_purchasereqid and aclo_tablename = 'pure_purchaserequisition' 

            left join xw_usma_usermain um on um.usma_userid = xaa.aclo_userid

            where pure_streqno = '$reqno' and pure_fyear = '$fyear' 

            and aclo_status = '$status' and aclo_fieldname = '$field' and usma_locationid = '$locationid'
            ";

    $query = $this->ci->db->query($sql);

    if ($query->num_rows() > 0) {

      return $query->result();
    }

    return false;
  }

  public function get_username_from_actionlog($srchcol = false)
  {

    $this->ci->db->select('um.usma_fullname, um.usma_fullnamenp, um.usma_employeeid, aclo_masterid, aclo_status, aclo_fieldname, aclo_comment, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip');

    $this->ci->db->from('aclo_actionlog a');

    $this->ci->db->join('usma_usermain um', 'um.usma_userid = a.aclo_userid');

    if ($srchcol) {

      $this->ci->db->where($srchcol);
    }

    $query = $this->ci->db->get();

    if ($query->num_rows() > 0) {

      return $query->result();
    }

    return false;
  }

  public function get_monthname($monthnum, $mnthtype = 'np')
  {

    $this->ci->db->select('mona_monthid,mona_codenp,mona_namenp,mona_coden,mona_nameen');

    $this->ci->db->from('xw_mona_monthname ');

    $this->ci->db->where('mona_monthid', $monthnum);

    $result = $this->ci->db->get()->row();

    if (!empty($result)) {

      if ($mnthtype == 'np') {

        return $result->mona_namenp;
      } else {

        return $result->mona_nameen;
      }
    }

    return false;
  }

  // public function get_history_data($id, $reqno = false, $fyear = false, $order = false){

  //       $pur_data = $this->get_tbl_data('pure_purchasereqid, pure_reqno','pure_purchaserequisition',array('pure_fyear'=>$fyear,'pure_streqno'=>$reqno));

  //       $pur_id = !empty($pur_data[0]->pure_purchasereqid)?$pur_data[0]->pure_purchasereqid:0;

  //       $pur_reqno = !empty($pur_data[0]->pure_reqno)?$pur_data[0]->pure_reqno:0;

  //       $hnd_data = $this->get_tbl_data('harm_handovermasterid, harm_fromlocationid, harm_tolocationid','harm_handoverreqmaster',array('harm_fyear'=>$fyear,'harm_reqno'=>$reqno));

  //       $hnd_id = !empty($hnd_data[0]->harm_handovermasterid)?$hnd_data[0]->harm_handovermasterid:0;

  //       $from_locationid = !empty($hnd_data[0]->harm_fromlocationid)?$hnd_data[0]->harm_fromlocationid:0;

  //       $to_locationid = !empty($hnd_data[0]->harm_tolocationid)?$hnd_data[0]->harm_tolocationid:0;

  //       $issue_data =  $this->get_tbl_data('sama_salemasterid','sama_salemaster',array('sama_fyear'=>$fyear,'sama_requisitionno'=>$reqno));

  //       $iss_id = !empty($issue_data[0]->sama_salemasterid)?$issue_data[0]->sama_salemasterid:0;

  //       $puor_data = $this->get_tbl_data('puor_purchaseordermasterid','puor_purchaseordermaster',array('puor_fyear'=>$fyear,'puor_requno'=>$pur_reqno));

  //       $puor_id = !empty($puor_data[0]->puor_purchaseordermasterid)?$puor_data[0]->puor_purchaseordermasterid:0;

  //       if(empty($order)){

  //           $order = "asc";

  //       }

  //       $this->locationid = $this->ci->session->userdata(LOCATION_ID);

  //       if($puor_id){

  //           $query = $this->ci->db->query("

  //               select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment

  //               from(

  //               select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $id and aclo_tablename='rema_reqmaster'

  //           and aclo_locationid = $this->locationid

  //           UNION

  //           select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $pur_id and aclo_tablename='pure_purchaserequisition'

  //           and aclo_locationid = $this->locationid

  //           UNION

  //           select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $puor_id and aclo_tablename='puor_purchaseordermaster'

  //           and aclo_locationid = $this->locationid

  //           ) x order by aclo_id $order

  //           ");

  //       }

  //       else if($pur_id){

  //          $query = $this->ci->db->query("

  //               select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment

  //               from(

  //               select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $id and aclo_tablename='rema_reqmaster'

  //           and aclo_locationid = $this->locationid

  //           UNION

  //           select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $pur_id and aclo_tablename='pure_purchaserequisition'

  //           and aclo_locationid = $this->locationid

  //           ) x order by aclo_id $order

  //           ");

  //       }

  //       else if($hnd_id){

  //           $query = $this->ci->db->query("

  //               select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment

  //               from(

  //               select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $id and aclo_tablename='rema_reqmaster'

  //           and aclo_locationid = $this->locationid

  //           UNION

  //           select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $pur_id and aclo_tablename='pure_purchaserequisition'

  //           and aclo_locationid = $this->locationid

  //           UNION

  //           select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $hnd_id and aclo_tablename='harm_handoverreqmaster' and aclo_locationid = $from_locationid

  //           UNION

  //           select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $hnd_id and aclo_tablename='harm_handoverreqmaster' and aclo_locationid = $to_locationid

  //           ) x order by aclo_id $order

  //           ");

  //       }

  //       else if($iss_id){

  //         $query = $this->ci->db->query("

  //               select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment

  //               from(

  //               select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $id and aclo_tablename='rema_reqmaster'

  //           and aclo_locationid = $this->locationid

  //           UNION

  //           select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid in (".$iss_id.") and aclo_tablename='sama_salemaster'

  //           and aclo_locationid = $this->locationid

  //           ) x order by aclo_id $order

  //           ");

  //       }

  //       else{

  //            $query = $this->ci->db->query("select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_comment from xw_aclo_actionlog xaa 

  //           left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

  //           left join xw_usma_usermain u on u.usma_userid = aclo_userid

  //           where aclo_masterid = $id and aclo_tablename='rema_reqmaster' and aclo_locationid = $this->locationid

  //           order by aclo_id $order

  //       ");

  //       }

  // using single query

  // $query = $this->ci->db->query("select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment

  //   from(

  //   select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment 

  //   from xw_aclo_actionlog xaa 

  //   left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname 

  //   left join xw_usma_usermain u on u.usma_userid = aclo_userid 

  //   where aclo_masterid = $id and aclo_tablename='rema_reqmaster' and aclo_locationid = $this->locationid 

  //   union

  //   select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment 

  //   from xw_aclo_actionlog xaa 

  //   left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname 

  //   left join xw_usma_usermain u on u.usma_userid = aclo_userid 

  //   where aclo_masterid = (select pure_purchasereqid from xw_pure_purchaserequisition xpp 

  //   where pure_fyear = $fyear and pure_streqno = $id) and aclo_tablename='pure_purchaserequisition' and aclo_locationid = $this->locationid 

  //   union

  //   select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

  //   left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname 

  //   left join xw_usma_usermain u on u.usma_userid = aclo_userid 

  //   where aclo_masterid = (select puor_purchaseordermasterid from xw_puor_purchaseordermaster xpp 

  //   where puor_fyear =$fyear and puor_requno = (select pure_reqno from xw_pure_purchaserequisition xpp 

  //   where pure_fyear = $fyear and pure_streqno = $id)) and aclo_tablename='puor_purchaseordermaster' and aclo_locationid = $this->locationid 

  //   union

  //   select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment 

  //   from xw_aclo_actionlog xaa 

  //   left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname 

  //   left join xw_usma_usermain u on u.usma_userid = aclo_userid 

  //   where aclo_masterid in (select sama_salemasterid from xw_sama_salemaster xss 

  //   where sama_fyear = $fyear and sama_requisitionno = $id) and aclo_tablename='sama_salemaster' and aclo_locationid = $this->locationid

  //   ) x order by aclo_id $order");

  //       // echo $this->ci->db->last_query();

  //       // die();

  //       $result=$query->result();

  //       return $result;

  //   }

  public function get_history_data($id, $reqno = false, $fyear = false, $order = false)
  {

    $pur_data = $this->get_tbl_data('pure_purchasereqid, pure_reqno', 'pure_purchaserequisition', array('pure_fyear' => $fyear, 'pure_streqno' => $reqno));

    $pur_id = !empty($pur_data[0]->pure_purchasereqid) ? $pur_data[0]->pure_purchasereqid : 0;

    $pur_reqno = !empty($pur_data[0]->pure_reqno) ? $pur_data[0]->pure_reqno : 0;

    $hnd_data = $this->get_tbl_data('harm_handovermasterid, harm_fromlocationid, harm_tolocationid', 'harm_handoverreqmaster', array('harm_fyear' => $fyear, 'harm_reqno' => $reqno));

    $hnd_id = !empty($hnd_data[0]->harm_handovermasterid) ? $hnd_data[0]->harm_handovermasterid : 0;

    $from_locationid = !empty($hnd_data[0]->harm_fromlocationid) ? $hnd_data[0]->harm_fromlocationid : 0;

    $to_locationid = !empty($hnd_data[0]->harm_tolocationid) ? $hnd_data[0]->harm_tolocationid : 0;

    $issue_data =  $this->get_tbl_data('sama_salemasterid', 'sama_salemaster', array('sama_fyear' => $fyear, 'sama_requisitionno' => $reqno));

    $iss_id = !empty($issue_data[0]->sama_salemasterid) ? $issue_data[0]->sama_salemasterid : 0;

    $puor_data = $this->get_tbl_data('puor_purchaseordermasterid', 'puor_purchaseordermaster', array('puor_fyear' => $fyear, 'puor_requno' => $pur_reqno));

    $puor_id = !empty($puor_data[0]->puor_purchaseordermasterid) ? $puor_data[0]->puor_purchaseordermasterid : 0;

    if (empty($order)) {

      $order = "asc";
    }

    $this->locationid = $this->ci->session->userdata(LOCATION_ID);

    $rem_query  = $pur_query = $puor_query = $iss_query = $hnd_query = "";

    $rem_query = "select aclo_status, inst_comment, usma_userid, usma_username, aclo_tablename, aclo_masterid, aclo_fieldname, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $id and aclo_tablename='rema_reqmaster'

            and aclo_locationid = $this->locationid";

    if ($pur_id) {

      $pur_query = "UNION select aclo_status, inst_comment, usma_userid, usma_username, aclo_tablename, aclo_masterid, aclo_fieldname, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $pur_id and aclo_tablename='pure_purchaserequisition'

            and aclo_locationid = $this->locationid";
    }

    if ($puor_id) {

      $puor_query = "UNION select aclo_status, inst_comment, usma_userid, usma_username, aclo_tablename, aclo_masterid, aclo_fieldname, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $puor_id and aclo_tablename='puor_purchaseordermaster'

            and aclo_locationid = $this->locationid";
    }

    if ($hnd_id) {

      $hnd_query = "UNION select aclo_status, inst_comment, usma_userid, usma_username, aclo_tablename, aclo_masterid, aclo_fieldname, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $hnd_id and aclo_tablename='harm_handoverreqmaster' and aclo_locationid = $from_locationid

            UNION

            select aclo_status, inst_comment, usma_userid, usma_username, aclo_tablename, aclo_masterid, aclo_fieldname, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $hnd_id and aclo_tablename='harm_handoverreqmaster' and aclo_locationid = $to_locationid";
    }

    if ($iss_id) {

      $iss_query = "UNION select aclo_status, inst_comment, usma_userid, usma_username, aclo_tablename, aclo_masterid, aclo_fieldname, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid in (" . $iss_id . ") and aclo_tablename='sama_salemaster'

            and aclo_locationid = $this->locationid";
    }

    $query = $this->ci->db->query("select aclo_status, inst_comment, usma_userid, usma_username, aclo_tablename, aclo_masterid, aclo_fieldname, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id, aclo_comment

                from(

                $rem_query $pur_query $puor_query $iss_query $hnd_query

              ) x order by aclo_id $order");

    // echo $this->ci->db->last_query();

    // die();

    $result = $query->result();

    return $result;
  }

  // public function 

  // function find_end_of_month($yrs_mnth)

  //  {

  //    // echo $yrs_mnth;

  //    // die();

  //      $data=$this->db->get('need_nepequengdate')->where('need_bsdate', 'like', $yrs_mnth.'%')->order_by('need_bsdate','DESC')->result()->row();

  //      // print_r($data);

  //      // die();

  //      $defaultpicker=get_constant_value('DEFAULT_DATEPICKER');

  //      if(DEFAULT_DATEPICKER=='NP'){

  //        return $data->bsdate;

  //      }

  //      else{

  //        return $data->addate;

  //      }

  //  }

  public function api_send_budget_demand_amount($post_data)
  {
    $api_url = "http://api.kathmanduwater.com:8085/api/BudgetDemand/BudgetDemand%40ccessKuK!nv!ntegr%40t!0n20!0/";
    // return false;
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json-patch+json',
      'Content-Length: ' . strlen(json_encode($post_data))
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    $response = curl_exec($ch);
    $response_data = json_decode($response);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // print_r($post_data);
    // print_r($response_data);
    // print_r($httpcode);
    curl_close($ch);
    if ($httpcode === 200) {
      return true;
    } else {
      throw new Exception('Api Error Code ' . $httpcode . json_encode($response_data));
    }
  }
}