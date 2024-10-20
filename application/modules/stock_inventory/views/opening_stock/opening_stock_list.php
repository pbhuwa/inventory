<style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }
    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }
</style>
<div class="searchWrapper">
    <div class="">
        <form>
            <?php echo $this->general->location_option(2,'locationid'); ?>
           <div class="col-md-2">
            <label><?php echo $this->lang->line('store'); ?></label>
             <select class="form-control" name=""  id="eqid">
             <?php
             if($equipmnt_type): 
             foreach ($equipmnt_type as $ket => $etype):
             ?>
            <option value="<?php echo $etype->eqty_equipmenttypeid; ?>" ><?php echo $etype->eqty_equipmenttype; ?></option>
         <?php endforeach; endif; ?>
       </select>
           </div>
            <div class="col-md-2">
                <label>Opening/Closing</label>
                  <select class="form-control" name=""  id="opstockyr">
             <?php
             if($fiscal_year): 
             foreach ($fiscal_year as $kf => $fyrs):
             ?>
            <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
         <?php endforeach; endif; ?>
       </select>
            </div>
            

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/opening_stock/opening_stock_list" data-location="stock_inventory/opening_stock/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/opening_stock/opening_stock_list" data-location="stock_inventory/opening_stock/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%">Material Type</th>
                    <th width="15%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="5%">Open. <?php echo $this->lang->line('qty'); ?></th>
                    <th width="5%">Unused Qty</th>
                    <th width="5%"><?php echo $this->lang->line('amount'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('op_date'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('time'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('remarks'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('action'); ?> </th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var eqid=$('#eqid :selected').val();
    // alert(eqid);
    var opstockyr=$('#opstockyr :selected').val();
    var locationid = $('#locationid').val();
    var dataurl = base_url+"stock_inventory/opening_stock/opening_stock_list";
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
    "aTargets": [ 0,6,7,11,12]
    }
    ],

    "aoColumns": [
    { "data": null},
    { "data": "itemcode" },
    { "data": "itemname" },
    { "data": "material" },
    { "data": "category" },
    { "data": "unitprice" },
    { "data": "requiredqty" },
    { "data": "unused_qty" },
    { "data": "amount" },
    { "data": "transactiondate" },
    { "data": "transtime" },
    { "data": "fyear" },
    { "data": "remarks" },
    { "data": "action" },

    
    ],


    "fnServerParams": function (aoData) {
        aoData.push({ "name": "eqid", "value": eqid });
        aoData.push({ "name": "opstockyr", "value": opstockyr });
        aoData.push({"name": "locationid","value": locationid});
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
        { type: null },
        { type: null },
        { type: null },
        { type: "text" },
        { type:  null },
        { type:  "text" },
        ]
    });
        $(document).off('click', '#searchByDate');
        $(document).on('click', '#searchByDate', function() {
          eqid=$('#eqid :selected').val();
          opstockyr=$('#opstockyr :selected').val();
          locationid = $('#locationid').val();
          // alert(eqid);
            dtablelist.fnDraw();
        });
});
</script>