<div class="white-box">
    <h3 class="box-title"><?php echo $this->lang->line('list_of_depreciation'); ?></h3>  <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
<form>
  <div class="clearfix"></div>
    <div class="white-box">
        <div class="pad-10">
            <div class="form-group resp_xs">
             <?php $this->general->location_option(2); ?>
             <div class="col-md-2 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?>:<span class="required">*</span>:</label>
                <select id="fiscal_year" name="fiscal_year"  class="form-control required_field" >
                  <option value="">----- All-----</option>
                    <?php 
                        if($fiscalyear):
                            foreach ($fiscalyear as $km => $dep):
                    ?>
                     <option value="<?php echo $dep->fiye_name; ?>" ><?php echo $dep->fiye_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

              <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <label>Assets Type  <span class="required">*</span>:</label>
                            <select class="form-control change_assets" name="asen_assettype" id="assettypeid"  data-srchurl='<?php echo base_url('ams/assets/get_assets_item_by_assets_type');?>' >
                                <option value="">---All---</option>
                                <?php 
                                    if($material):
                                        foreach ($material as $kcl => $mat):
                                ?>
                                <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>"> <?php echo $mat->eqca_category; ?></option>
                            <?php
                                        endforeach;
                                    endif;
                            ?>
                            </select>
                        </div>
                    </div>
                     <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <label>Assets Items<span class="required">*</span>:</label>
                            
                            <select class="form-control" name="asen_asenid" id="result_assettypeid">
                                <option value="0">---All---</option>
                            </select>
                        </div>
                    </div>


          <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
        </div>
</form>
</div>
<div style="margin: 10">
<a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/depreciation_report/v_depreciation_list" data-location="ams/depreciation_reports/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

<a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/depreciation_report/v_depreciation_list" data-location="ams/depreciation_reports/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
</div>
<div class="clearfix"></div>

    <div class="pad-5">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped ">
                <thead>
                    <tr>
                        <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('ass_code'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('assets'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('pur_date'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('s_date'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('e_date'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('pur_cost'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('ope_balance'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('deprate'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('f_year'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('accm_val'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('accmulatdepprevyrs'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('totaldeptilldateval'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('netvalue'); ?></th>
                       
                    </tr>
                </thead>
                <tbody>
                          
                </tbody>
            </table>
        </div>
    </div>
<script type="text/javascript">
  $(document).ready(function(){
    // var frmDate=$('#frmDate').val();
    // var toDate=$('#toDate').val();
      
    var fiscal_year = $('#fiscal_year').val();
    var assettype=$('#assettypeid').val();
    var dataurl = base_url+"ams/depreciation_reports/get_depreciation_list";
    var message='';
    var showview='<?php echo MODULES_VIEW; ?>';
    // alert(showview);
    /*if(showview=='N')
    {
      message="<p class='text-danger'>Permission Denial</p>";
    }
    else
    {
      message="<p class='text-danger'>No Record Found!! </p>";
    }*/
 

 
    var dtablelist = $('#myTable').dataTable({
      "sPaginationType": "full_numbers"  ,
      
      "bSearchable": false,
      "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
      'iDisplayLength': 20,
      "sDom": 'ltipr',
      "bAutoWidth":false,
    
      "autoWidth": true,
      "aaSorting": [[0,'asc']],
      "bProcessing":true,
      "bServerSide":true,    
      "sAjaxSource":dataurl,
      "oLanguage": {
      "sEmptyTable":message  
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [ 0,5 ]
      }
      ],      
      "aoColumns": [
       { "data": null },
       { "data": "asen_assetcode" },
       { "data": "itli_itemname" },
       { "data": "purchasedatebs" },
       { "data": "startdatebs" },
       { "data": "enddatebs" },
       { "data": "originalcost" },
       { "data": "opbalance" },
       { "data": "deprate" },
       { "data": "fiscalyrs" },
       { "data": "accmulateval" },
       { "data": "accmulatdepprevyrs" },
       { "data": "totaldeptilldateval" },
       { "data": "netvalue" },
   
       

      ],
      "fnServerParams": function (aoData) {
        // aoData.push({ "name": "frmDate", "value": frmDate });
        // aoData.push({ "name": "toDate", "value": toDate });
         aoData.push({"name": "fiscal_year","value": fiscal_year});
         aoData.push({"name": "assettype","value": assettype});
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
             var oSettings = dtablelist.fnSettings();
            var tblid= oSettings._iDisplayStart+iDisplayIndex +1

        $(nRow).attr('id', 'listid_'+tblid);
      },
    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [ {type: null},
      { type: "text" },
      { type: "text" },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
    
      
      
     
      ]
    });

    $(document).on('click', '#searchByDate', function() {
           
            fiscal_year = $('#fiscal_year').val();
            assettype=$('#assettypeid').val();
            
           
            dtablelist.fnDraw();
        });


});
</script>
<script type="text/javascript">
$(document).off('change','.change_assets');
$(document).on('change','.change_assets',function(){
var attrid=$(this).attr('id');
var locid=$('#locationid').val();
var id=$(this).val();
var srchurl=$(this).data('srchurl');
$.ajax({
  type: "POST",
  url: srchurl,
  data:{id:id,locid:locid},
  dataType: 'html',
  beforeSend: function() {
    $('.overlay').modal('show');
  },
   success: function(jsons) 
   {
      // console.log(jsons);
      var jsondata=jQuery.parseJSON(jsons);   
      // return false;
      // console.log(jsondata.data);
      if(jsondata.status=='success')
      {
        $('#result_'+attrid).html(jsondata.template);
        $('#result_'+attrid).select2();

      }
      else
      {
        $('#result_'+attrid).html('');
      }
      
       $('.overlay').modal('hide');
    }
  })

})
</script>
