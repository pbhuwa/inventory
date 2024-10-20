<style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }
    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }
</style>
<h3 class="box-title"><?php echo $this->lang->line('stock_transfer_list'); ?> </h3>

<div class="searchWrapper">
    <div class="">
        <form>
             <?php echo $this->general->location_option(2,'locationid'); ?>
           
           
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('store'); ?></label>
              <select class="form-control" name="equipmenttypeid" autofocus="true" id="equipmenttypeid">
             <?php
             if($equipmnt_type): 
             foreach ($equipmnt_type as $ket => $etype):
             ?>
            <option value="<?php echo $etype->eqty_equipmenttypeid; ?>" ><?php echo $etype->eqty_equipmenttype; ?></option>
         <?php endforeach; endif; ?>
       </select>
            </div>
            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/stock_transfer/" data-location="stock_inventory/stock_transfer/exportToExcelTransferList" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/stock_transfer/" data-location="stock_inventory/stock_transfer/generate_pdfTransferList" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('dispatch_date'); ?>(BS)</th>
                    <th width="10%"><?php echo $this->lang->line('dispatch_date'); ?>(AD)</th>
                    <th width="15%"><?php echo $this->lang->line('type'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('issue_to_store'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('issued_by'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('received_by'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('issue_no'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('requisition_no'); ?> </th>
                    <!-- <th width="10%"><?php //echo $this->lang->line('action'); ?></th> -->
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    var locationid=$('#locationid').val();
    var equipmenttypeid=$('#equipmenttypeid').val();
    var dataurl = base_url+"stock_inventory/stock_transfer/stock_transfer_list_original";
    var message='';
    var showview='<?php echo MODULES_VIEW; ?>';
    if(showview=='N')
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
    'iDisplayLength': 20,
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
    "aTargets": [ 0,8 ]
    }
    ],
    
    "aoColumns": [
    { "data": null},
    { "data": "transactiondatebs"},
    { "data": "transactiondatead" },
    { "data": "transactiontype" },
    { "data": "equipmenttype" },
    { "data": "fromby" },
    { "data": "toby" },
    { "data": "issueno" },
    { "data": "reqno" }
   // { "data": "action" }
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
         aoData.push({ "name": "locationid", "value": locationid });
         aoData.push({ "name": "equipmenttypeid", "value": equipmenttypeid });
    },
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
        return nRow;
    },
    "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
        var oSettings = dtablelist.fnSettings();
        var tblid = oSettings._iDisplayStart+iDisplayIndex +1
        $(nRow).attr('id', 'listid_'+tblid);
    },
    }).columnFilter(
    {
        sPlaceHolder: "head:after",
        aoColumns: [ { type: null },
        {type: "text"},
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        ]
    });

        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
              locationid = $('#locationid').val();
            equipmenttypeid=$('#equipmenttypeid').val();
            dtablelist.fnDraw();
        });
});
</script>