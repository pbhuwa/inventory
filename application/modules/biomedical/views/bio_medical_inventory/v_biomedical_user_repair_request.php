<div id="dtl_supplier" class="tab-pane fade in active white-box">
<div class="formdiv frm_bdy col-md-12">
<h3 class="box-title">User Equipement Comment List
  <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a>
</h3>
<div class="searchWrapper">
    <div class="row">
        <form class="col-sm-12">

            <?php echo $this->general->location_option(2); ?>

            <div class="col-md-3">
              <label>Department:</label>
              <select name="departmentid" id="departmentid" class="form-control">
                <option value="">--All--</option>
                <?php if (!empty($department)):
                  foreach($department as $dep):?>
                    <option value="<?=$dep->dept_depid?>"><?=$dep->dept_depname?></option>
                  <?php endforeach; endif; ?>
              </select>              
            </div>  

            <div class="col-md-2">
                <label>Date Search:</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_all">All</option>
                    <option value="date_range">By Comment Date</option>
                </select>
            </div>

            <div class="dateRangeWrapper" style="display:none">

                <div class="col-md-1">
                    <label><?php echo $this->lang->line('from_date'); ?> :</label>
                    <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />
                </div>

                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to_date'); ?>:</label>
                    <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />
                </div>
            </div>
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
        </form>
    </div>
    <div class="clear"></div>
</div>
  <div class="pad-5">
      <div class="table-responsive">
         <?php $this->load->view('common/v_biomedical_status_bar'); ?>
          <table id="myTable" class="table table-striped ">
              <thead>
                  <tr>
                      <th width="7%">S.n.</th>
                      <th width="10%">Request No.</th>
                      <th width="10%">Equipment ID</th>
                      <th width="15%">Desc.</th>
                      <th width="10%">Deptartment.</th>
                      <th width="15%">Comments</th>
                      <th width="10%">Commmented By</th>
                      <th width="5%">Date</th>
                      <th width="8%">Status</th>
                      <th width="10%">Action</th>
                  </tr>
              </thead>
              <tbody>
                        
              </tbody>
          </table>
      </div>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){   
    
    var frmDate = $('#frmDate').val();
    var toDate = $('#toDate').val();
    var searchDateType = $('#searchDateType').val();
    if (searchDateType == 'date_all') {
        frmDate = '';
        toDate = '';
    }
    var locationid = $('#locationid').val();
    var departmentid = $('#departmentid').val(); 
    
    var dataurl = base_url + "biomedical/bio_medical_inventory/user_repair_request_list"; 
    
    var message='';
    var showview='<?php echo MODULES_VIEW; ?>';
    // alert(showview);
    if(showview == 'N')
    {
      message="<p class='text-danger'>Permission Denial</p>";
    }
    else
    {
      message="<p class='text-danger'>No Record Found!! </p>";
    }
 
    var dtablelist = $('#myTable').dataTable({
      "sPaginationType": "full_numbers"  ,
      
      "bSearchable": false,
      "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
      'iDisplayLength': 10,
      "sDom": 'ltipr',
      "bAutoWidth":false,
    
      "autoWidth": true,
      "aaSorting": [[0,'desc']],
      "bProcessing":true,
      "bServerSide":true,    
      "sAjaxSource":dataurl,
      "oLanguage": {
        "sEmptyTable":message   
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [ 0,7,8 ]
      }
      ],      
      "aoColumns": 
      [
        { "data": "equipid" },
        { "data": "request_no" },
        { "data": "equipkey" },
        { "data": "description" },
        { "data": "department" },
        { "data": "comments" },
        { "data": "commented_by" },
        { "data": "date" },
        { "data": "status" },
        { "data": "action" }
      ],
      "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "searchDateType", "value": searchDateType });
        aoData.push({ "name": "locationid", "value": locationid });
        aoData.push({ "name": "departmentid", "value": departmentid });
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
          var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
         return nRow;
      },
      "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
        var oSettings = dtablelist.fnSettings();
        var rowClass = aData.row_class;
        var tblid= oSettings._iDisplayStart+iDisplayIndex +1
        $(nRow).attr('id', 'listid_'+tblid);
        $(nRow).addClass(rowClass);
    },
    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [ 
      { type: null},
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: null },
      { type: null },
     
      ]
    });

    $(document).off('click', '#searchByDate')
    $(document).on('click', '#searchByDate', function() {

        frmDate = $('#frmDate').val();
        toDate = $('#toDate').val();
        searchDateType = $('#searchDateType').val();
        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }
        locationid = $('#locationid').val();
        departmentid = $('#departmentid').val();
        dtablelist.fnDraw();
    });

});
</script>

<script type="text/javascript">
    $(document).off('change', '#searchDateType');
    $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();
        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });
</script>