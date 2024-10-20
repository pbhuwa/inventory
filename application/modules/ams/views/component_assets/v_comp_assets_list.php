<?php  $this->load->view('assets/v_assets_common');?> 

<div class="white-box">
  <label class="dttable_ttl box-title"><center>Component Based Assets List</center></label></div>

  <h3 class="box-title"><center>  </center><a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>

  <div class="searchWrapper">

    <div class="">
      <form class="col-sm-12">
        <div class="col-md-2">
          <label>Network Components</label>
          <select name="asen_component_typeid" class="form-control select2" id="asen_component_typeid">
            <option value="">All</option>
            <?php
            if($network_comp):
              foreach ($network_comp as $ks => $not):
                ?>
                <option value="<?php echo $not->coty_id; ?>"><?php echo $not->coty_name; ?></option>
                <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>

        <div class="col-md-2">
          <label>Soil Type</label>
          <select name="asen_soli_typeid" class="form-control select2" id="asen_soli_typeid">
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
       <select name="asen_pipe_zoneid" class="form-control select2" id="asen_pipe_zoneid">
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
      <label>Search Text</label>
       <input type="text" name="srchtext" class="form-control" id="srchtext">
    </div>
    


   <div class="col-md-2">
    <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
  </div>
  
  <div class="sm-clear"></div>
</form>
</div>

<div style="margin: 10">
  <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/assets/list_of_comp_assets" data-location="ams/assets/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

  <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/assets/list_of_comp_assets" data-location="ams/assets/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
</div>
<div class="clearfix"></div>

</div>
<div class="pad-5">
  <div class="table-responsive">
    <table id="myTable" class="table table-striped">
      <thead>
        <tr>
          <th width="10%">N.Comp</th>
          <th width="10%">A.Code</th>
          <th width="10%">NID</th>
          <th width="10%">J.Type</th>
          <th width="10%">P.Type</th>
          <th width="10%">D.Man</th>
          <!-- <th width="10%">D.Ins.</th> -->
          <!-- <th width="10%"><?php //echo $this->lang->line('purchase_date'); ?></th>
          <th width="10%"><?php //echo $this->lang->line('warrenty_date'); ?></th> -->
         
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
  
  // var frmDate=$('#frmDate').val();
  // var toDate=$('#toDate').val(); 
  // var dateSearch = $('#dateSearch').val();
  var asen_component_typeid=$('#asen_component_typeid').val();
  var asen_jointypeid=$('#asen_jointypeid').val();
  var asen_pavement_typeid=$('#asen_pavement_typeid').val();
  var asen_soli_typeid=$('#asen_soli_typeid').val();
  var asen_pipe_zoneid=$('#asen_pipe_zoneid').val();
  //  var asen_description=$('#asen_description').val();
  var srchtext=$('#srchtext').val();
           // alert(srchtext);
           

           
           var dataurl = base_url+"ams/assets/get_comp_assets_list";
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
            "aTargets": [ 0,6 ]
          }
          ],      
          "aoColumns": [
          { "data": "coty_name"},
          { "data": "asen_assetcode"},
          { "data": "asen_ncomponentid"},
          
          { "data": "joty_name"},
          { "data": "paty_name" },
          { "data": "asen_manufacture_datead" },
          // { "data": "" },
          // { "data": "purchase_date" },
          // { "data": "warrenty_date" },
           { "data": "action" }
          
          
          ],
          "fnServerParams": function (aoData) {
            // aoData.push({ "name": "frmDate", "value": frmDate });
            // aoData.push({ "name": "toDate", "value": toDate });
            // aoData.push({ "name": "dateSearch", "value": dateSearch });
            aoData.push({ "name": "asen_component_typeid", "value": asen_component_typeid });
            aoData.push({ "name": "asen_jointypeid", "value": asen_jointypeid });
            aoData.push({ "name": "asen_pavement_typeid", "value": asen_pavement_typeid });
            aoData.push({ "name": "asen_soli_typeid", "value": asen_soli_typeid });
            aoData.push({ "name": "asen_pipe_zoneid", "value": asen_pipe_zoneid });
            // aoData.push({ "name": "asen_description", "value": asen_description });
            aoData.push({ "name": "srchtext", "value": srchtext });

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
    // { type: "text" },
    { type: null },
    
    ]
  });

   $(document).on('click', '#searchByDate', function() {
    // frmDate = $('#frmDate').val();
    // toDate = $('#toDate').val();
    // dateSearch = $('#dateSearch').val(); 
    asen_component_typeid = $('#asen_component_typeid').val();
    asen_jointypeid = $('#asen_jointypeid').val();
    asen_pavement_typeid = $('#asen_pavement_typeid').val(); 
    asen_soli_typeid = $('#asen_soli_typeid').val();
    asen_pipe_zoneid = $('#asen_pipe_zoneid').val();
    //   asen_description = $('#asen_description').val();
    srchtext = $('#srchtext').val();
    
    dtablelist.fnDraw();
  });

 });
</script>
