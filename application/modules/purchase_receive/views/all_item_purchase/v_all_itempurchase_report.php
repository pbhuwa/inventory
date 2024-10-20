<style>
    .ov_report_dtl .ov_lst_ttl { font-size:12px; margin-bottom: 5px; padding-bottom: 5px; border-bottom: 1px solid #efefef; }
    .ov_report_dtl .pm_data_tbl { width:100%; margin-bottom:10px; }
    .ov_report_dtl .pm_data_tbl td, .ov_report_dtl .pm_data_tbl td b { font-size:12px; }
    .ov_report_dtl .count { background-color:#e3e3e3; font-size:12px; padding:2px 5px; }
    
    table.ov_report_tbl { border-left:1px solid #e3e3e3; border-top:1px solid #e3e3e3; border-collapse:collapse; margin-bottom:10px; }
    table.ov_report_tbl thead th { text-align:left; background-color:#e3e3e3; padding:2px; font-size:12px; }
    table.ov_report_tbl tbody td { font-size:12px; border-right:1px solid #e3e3e3; border-bottom:1px solid #e3e3e3; line-height:13px; padding:2px; }
    .search_pm_data ul.pm_data li label{
        width: 150px;
    }
    .search_pm_data ul.pm_data li{
        font-size: 13px;
        line-height: 17px;
        display:table;
        width:100%;
    }
    .search_pm_data ul.pm_data li label, .search_pm_data ul.pm_data li span{ display:table-cell; vertical-align: top; padding:4px 0; }
    .search_pm_data ul.pm_data { padding:5px 7px; }
    #barcodePrint{
        position: absolute;top: 0;right: 5px;    background-color: #03a9f3; border: 1px solid #03a9f3; color:#fff;
    }

    .ov_report_tabs #tab_selector { margin-bottom:5px; }

    .ov_report_tabs #tab_selector {
        border: none;
        background-color: #00663f;
        background: -webkit-linear-gradient(#00b588, #017558);
        background: -o-linear-gradient(#00b588, #017558);
        background: -moz-linear-gradient(#00b588, #017558);
        background: linear-gradient(#00b588, #017558);
        color: #fff;
    }
    .ov_report_tabs #tab_selector option {
        color: #444;
    }

    @media only screen and (max-width:991px) { 
    .ov_report_tabs ul.nav-tabs li a { font-size:12px; padding:10px; }
     }
     @media only screen and (max-width:767px) {
        .ov_report_tabs ul.nav-tabs li a { font-size: 12px; padding: 10px 29px; }
     }
     @media only screen and (max-width:667px) {
        .ov_report_tabs ul.nav-tabs li { width:33.33333333%; }
        .ov_report_tabs ul.nav-tabs li a { padding:10px; text-align:center; }
        .search_pm_data ul.pm_data li.eqp_cod label, .search_pm_data ul.pm_data li.eqp_cod span { display:block; }
     }
     @media only screen and (max-width:414px) {
        .ov_report_tabs ul.nav-tabs li { width:50%; }
        .search_pm_data ul.pm_data { column-count: 1; }
     }
</style>
<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('all_purchase_item'); ?></h3>
			<div class="ov_report_tabs pad-5 tabbable">
			    <?php $this->load->view('all_item_purchase/v_item_form');?>
			</div>
		<div id="dtl_rpt">
            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                
            </div>
		</div>
    </div>
</div>
</div>