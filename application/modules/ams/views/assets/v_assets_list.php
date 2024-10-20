<style type="text/css">
  .table>tbody>tr>td:not(:last-child), .table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important;
}
</style>
<?php  $this->load->view('assets/v_assets_common');?> 

<div class="white-box">
  <label class="dttable_ttl box-title"><center><?php echo $this->lang->line('assets_list'); ?> </center></label></div>

  <h3 class="box-title"><center>  </center><a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>

  <div class="searchWrapper">

    <div class="">
      <form class="col-sm-12">

        <div class="col-md-2">
          <label><?php echo $this->lang->line('date_selection'); ?>:<span class="required">*</span>:</label>
          <select name="dateSearch" class="form-control required_field" id="dateSearch">
            <option value="">All</option>
            <option value="purchasedate">Purchase Date</option>
            <option value="inservicedate">Inservice Date</option>
            <option value="warrentydate">Warrenty Date</option>
          </select>
        </div>
        <div id="datediv" style="display:none">
          <div class="col-md-2">
            <label><?php echo $this->lang->line('from_date'); ?></label>
            <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
          </div>
          
          <div class="col-md-2">
            <label><?php echo $this->lang->line('to_date'); ?></label>
            <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
          </div>
        </div>
        <div class="col-md-2">
          <label><?php echo $this->lang->line('assets_type'); ?></label>
          <select name="asen_assettype" class="form-control select2" id="asen_assettype">
            <option value="">All</option>
            <?php
            if($material):
              foreach ($material as $ks => $mat):
                ?>
                <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>"><?php echo $mat->eqca_category; ?></option>
                <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>

        <div class="col-md-2">
         <label><?php echo $this->lang->line('assets_status'); ?></label>
         <select name="asen_status" class="form-control select2" id="asen_status">
          <option value="">All</option>
          <?php
          if($status):
            foreach ($status as $ks => $stat):
              ?>
              <option value="<?php echo $stat->asst_asstid; ?>"><?php echo $stat->asst_statusname; ?></option>
              <?php
            endforeach;
          endif;
          ?>
        </select>
      </div>


      <div class="col-md-2">
       <label><?php echo $this->lang->line('assets_condition'); ?></label>
       <select name="asen_condition" class="form-control select2" id="asen_condition">
        <option value="">All</option>
        <?php
        if($condition):
          foreach ($condition as $ks => $cond):
            ?>
            <option value="<?php echo $cond->asco_ascoid; ?>"><?php echo $cond->asco_conditionname; ?></option>
            <?php
          endforeach;
        endif;
        ?>
      </select>
    </div>
        <div class="col-md-2">
       <label>Assets Description</label>
       <select name="asen_condition" class="form-control select2" id="asen_description">
        <option value="">All</option>
        <?php
        if($descriptuon):
          foreach ($descriptuon as $ks => $desc):
            ?>
            <option value="<?php echo $desc->itli_itemlistid; ?>"><?php echo $desc->itli_itemname; ?></option>
            <?php
          endforeach;
        endif;
        ?>
      </select>
    </div>
     <div class="col-md-2">
       <label>Department</label>
       <select name="asen_condition" class="form-control select2" id="depid">
        <option value="">All</option>
        <?php
        if($department_list):
          foreach ($department_list as $kd => $dept):
            ?>
            <option value="<?php echo $dept->dept_depid; ?>"><?php echo $dept->dept_depname; ?></option>
            <?php
          endforeach;
        endif;
        ?>
      </select>
    </div>

    <div class="col-md-2">
       <label>Is Disposal ?</label>
       <select name="asen_dispose" class="form-control" id="asen_dispose">
         <option value="">All</option>
         <option value="N">No</option>
         <option value="Y">Yes</option>
       </select>
     </div>


   <div class="col-md-2">
    <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
  </div>
  
  <div class="sm-clear"></div>
</form>
</div>

<div style="margin: 10">
  <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/assets/list_of_assets" data-location="ams/assets/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

  <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/assets/list_of_assets" data-location="ams/assets/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
</div>
<div class="clearfix"></div>

</div>
<div class="pad-5">
  <div class="table-responsive">
    <table id="myTable" class="table table-striped">
      <thead>
        <tr>
          <th width="5%"><?php echo $this->lang->line('assets_code'); ?></th>
          <th width="10%"><?php echo $this->lang->line('assets_type'); ?></th>
          <th width="20%"><?php echo $this->lang->line('description'); ?></th>
          <th width="8%"><?php echo $this->lang->line('model_no'); ?></th>
          <th width="10%"><?php echo $this->lang->line('serial_no'); ?></th>
          <th width="5%"><?php echo $this->lang->line('status'); ?></th>
          <th width="5%"><?php echo $this->lang->line('condition'); ?></th>
          <th width="6%">Pur. Date</th>
          <th width="5%">Rate</th>
         <th width="10%">Department</th>
          <th width="5%"><?php echo $this->lang->line('action'); ?></th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">
 $(document).ready(function(){
  
  var frmDate=$('#frmDate').val();
  var toDate=$('#toDate').val(); 
  var dateSearch = $('#dateSearch').val();
  var asen_assettype=$('#asen_assettype').val();
  var asen_status=$('#asen_status').val();
  var asen_condition=$('#asen_condition').val();
   var asen_description=$('#asen_description').val();
   var depid=$('#depid').val();
   var asen_dispose=$('#asen_dispose').val();
  var srchtext=$('#id').val();
           // alert(srchtext);
           

           
           var dataurl = base_url+"ams/assets/get_assets_list";
           var message='';
           
           
           
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
            "aTargets": [ 0,10 ]
          }
          ],      
          "aoColumns": [
          { "data": "assets_code"},
          { "data": "assets_type"},
          { "data": "description"},
          
          { "data": "model_no"},
          { "data": "serial_no" },
          { "data": "status" },
          { "data": "condition" },
          { "data": "purchase_date" },
          { "data": "rate" },
          { "data": "depname" },
           { "data": "action" }
          
          
          ],
          "fnServerParams": function (aoData) {
            aoData.push({ "name": "frmDate", "value": frmDate });
            aoData.push({ "name": "toDate", "value": toDate });
            aoData.push({ "name": "dateSearch", "value": dateSearch });
            aoData.push({ "name": "asen_assettype", "value": asen_assettype });
            aoData.push({ "name": "asen_status", "value": asen_status });
            aoData.push({ "name": "asen_condition", "value": asen_condition });
            aoData.push({ "name": "asen_description", "value": asen_description });
            aoData.push({ "name": "depid", "value": depid });
            aoData.push({ "name": "asen_dispose", "value": asen_dispose });
            aoData.push({ "name": "searchtext", "value": srchtext });

          },


      // "fnRowCallback" : function(nRow, aData, iDisplayIndex){
      //        var oSettings = dtablelist.fnSettings();
      //       $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
      //       return nRow;
      //   },
      "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
       var oSettings = dtablelist.fnSettings();
       var tblid = oSettings._iDisplayStart+iDisplayIndex +1

       $(nRow).attr('id', 'listid_'+tblid);
     },
   }).columnFilter(
   {
    sPlaceHolder: "head:after",
    aoColumns: [ 
    { type: "text" },
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

   $(document).on('click', '#searchByDate', function() {
    frmDate = $('#frmDate').val();
    toDate = $('#toDate').val();
    dateSearch = $('#dateSearch').val(); 
    asen_assettype = $('#asen_assettype').val();
    asen_status = $('#asen_status').val();
    asen_condition = $('#asen_condition').val(); 
    asen_description = $('#asen_description').val();
    depid=$('#depid').val();
    asen_dispose=$('#asen_dispose').val();
    srchtext = $('#srchtext').val();
    
    dtablelist.fnDraw();
  });

 });
</script>

<script type="text/javascript">
  $('.engdatepicker').datepicker({
    format: 'yyyy/mm/dd',
    autoclose: true
  });
  $('.nepdatepicker').nepaliDatePicker();
</script>
<script type="text/javascript">
  $(document).on('change', '#dateSearch', function() {
   var dateSearch = $('#dateSearch').val();
   if(dateSearch!=''){
    $('#datediv').show();

  }else{
    $('#datediv').hide();
  }
});
</script>
