<?php  $this->load->view('assets/v_assets_common');?> 

<div class="white-box">
  <label class="dttable_ttl box-title"><center>Component Based Assets List </center></label></div>

  <h3 class="box-title"><center>  </center><a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>

  <div class="searchWrapper">

    <div class="">
      <form class="col-sm-12">

        <div class="col-md-2">
          <label>Soil Type</label>
          <select name="asen_assettype" class="form-control select2" id="asen_assettype">
            <option value="">All</option>
            <?php
            if($soil_type):
              foreach ($soil_type as $ks => $sot):
                ?>
                <option value="<?php echo $sot->soty_id; ?>"><?php echo $sot->soty_type; ?></option>
                <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>

        <div class="col-md-2">
         <label>Joint Type</label>
         <select name="asen_jointypeid" class="form-control select2" id="asen_jointypeid">
          <option value="">All</option>
          <?php
          if($joint_type):
            foreach ($joint_type as $ks => $jot):
              ?>
              <option value="<?php echo $jot->joty_id; ?>"><?php echo $jot->joty_name; ?></option>
              <?php
            endforeach;
          endif;
          ?>
        </select>
      </div>


      <div class="col-md-2">
       <label>Pipe Material Type</label>
       <select name="asen_condition" class="form-control select2" id="asen_condition">
        <option value="">All</option>
        <?php
        if($pipematerial_type):
          foreach ($pipematerial_type as $ks => $pmt):
            ?>
            <option value="<?php echo $pmt->pimt_id; ?>"><?php echo $pmt->pimt_name; ?></option>
            <?php
          endforeach;
        endif;
        ?>
      </select>
    </div>
    <div class="col-md-2">
       <label>Pipezone Type</label>
       <select name="asen_pipe_zone" class="form-control select2" id="asen_pipe_zone">
        <option value="">All</option>
        <?php
        if($pipezone_type):
          foreach ($pipezone_type as $ks => $pzt):
            ?>
            <option value="<?php echo $pzt->pizo_id; ?>"><?php echo $pzt->pizo_name; ?></option>
            <?php
          endforeach;
        endif;
        ?>
      </select>
    </div>
    <div class="col-md-2">
       <label>Pavement Type</label>
       <select name="asen_pavement_typeid" class="form-control select2" id="asen_pavement_typeid">
        <option value="">All</option>
        <?php
        if($pavement_type):
          foreach ($pavement_type as $ks => $pzt):
            ?>
            <option value="<?php echo $pzt->paty_id; ?>"><?php echo $pzt->paty_name; ?></option>
            <?php
          endforeach;
        endif;
        ?>
      </select>
    </div>
     <div class="col-md-2">
       <label>Valve Type</label>
       <select name="asen_pavement_typeid" class="form-control select2" id="asen_pavement_typeid">
        <option value="">All</option>
        <?php
        if($valve_type):
          foreach ($valve_type as $ks => $vt):
            ?>
            <option value="<?php echo $vt->vaty_id; ?>"><?php echo $vt->vaty_name; ?></option>
            <?php/
          endforeach;
        endif;
        ?>
      </select>
    </div>
      <div class="col-md-2">
       <label>Hydrants Type</label>
       <select name="asen_pavement_typeid" class="form-control select2" id="asen_pavement_typeid">
        <option value="">All</option>
        <?php
        if($hydrants_type):
          foreach ($hydrants_type as $ks => $ht):
            ?>
            <option value="<?php echo $ht->hyty_id; ?>"><?php echo $ht->hyty_name; ?></option>
            <?php
          endforeach;
        endif;
        ?>
      </select>
    </div> 
     <div class="col-md-2">
       <label>Flowmeter Type</label>
       <select name="asen_pavement_typeid" class="form-control select2" id="asen_pavement_typeid">
        <option value="">All</option>
        <?php
        if($hydrants_type):
          foreach ($hydrants_type as $ks => $ht):
            ?>
            <option value="<?php echo $ht->hyty_id; ?>"><?php echo $ht->hyty_name; ?></option>
            <?php
          endforeach;
        endif;
        ?>
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
          <th width="10%"><?php echo $this->lang->line('assets_code'); ?></th>
          <th width="10%"><?php echo $this->lang->line('assets_type'); ?></th>
          <th width="10%"><?php echo $this->lang->line('description'); ?></th>
          <th width="10%"><?php echo $this->lang->line('model_no'); ?></th>
          <th width="10%"><?php echo $this->lang->line('serial_no'); ?></th>
          <th width="10%"><?php echo $this->lang->line('status'); ?></th>
          <th width="10%"><?php echo $this->lang->line('condition'); ?></th>
          <th width="10%"><?php echo $this->lang->line('purchase_date'); ?></th>
          <th width="10%"><?php echo $this->lang->line('warrenty_date'); ?></th>
         
          <th width="10%"><?php echo $this->lang->line('action'); ?></th>
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
            "aTargets": [ 0,9 ]
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
          { "data": "warrenty_date" },
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
    { type: "text" },
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
