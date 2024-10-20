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
            <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('store'); ?><span class="required">*</span>:</label>
                <select name="store_id" class="form-control required_field select2" id="store_id">
                    <option value="">---All---</option>
                    <?php
                    if($store):
                    foreach ($store as $km => $st):
                    ?>
                    <option value="<?php echo $st->eqty_equipmenttypeid; ?>"><?php echo $st->eqty_equipmenttype; ?></option>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('from_date'); ?>: </label>
                <input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="fromdate" autocomplete="off">
                <span class="errmsg"></span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('to_date'); ?>: </label>
                <input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate" autocomplete="off">
                <span class="errmsg"></span>
            </div>
     
            <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('select_items'); ?><span class="required">*</span>:</label>
                <select name="itemid" id="itemid" class="form-control required_field select2" >
                    <option value="">---All---</option>
                    <?php
                    if($items):
                    foreach ($items as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->itli_itemlistid; ?>"><?php echo $dep->itli_itemcode." | ".$dep->itli_itemname; ?></option>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
     <div class="pull-right" style="margin-top:15px;">
         <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/items_ledger/search_ledger_report" data-location="stock_inventory/items_ledger/generate_excel_items_ledger" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/items_ledger/search_ledger_report" data-location="stock_inventory/items_ledger/generate_pdf_items_ledger" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('sn'); ?></th>
                    <th><?php echo $this->lang->line('date_ad'); ?></th>
                    <th><?php echo $this->lang->line('date_bs'); ?></th>
                    <th><?php echo $this->lang->line('description'); ?></th>
                    <th><?php echo $this->lang->line('ref_no'); ?></th>
                    <!-- Department/Supplier -->
                    <th><?php echo $this->lang->line('dept_supplier'); ?></th>
                    <!-- Rec/Pur Qty -->
                    <th><?php echo $this->lang->line('rec_pur_qty'); ?></th>
                    <th><?php echo $this->lang->line('rec_rate'); ?></th>
                    <th><?php echo $this->lang->line('rec_amt'); ?></th>
                    <th><?php echo $this->lang->line('issue_qty'); ?></th>
                    <th><?php echo $this->lang->line('issue_rate'); ?></th>
                    <th><?php echo $this->lang->line('issue_amt'); ?></th>
                    <th><?php echo $this->lang->line('bal_qty'); ?></th>
                    <th><?php echo $this->lang->line('rate'); ?></th>
                    <th><?php echo $this->lang->line('bal_amt'); ?></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var fromdate=$('#fromdate').val();
    var todate=$('#todate').val();
    var locationid=$('#locationid').val();
    var itemid=$('#itemid').val();
    var store_id=$('#store_id').val();

    var dataurl = base_url+"stock_inventory/items_ledger/search_ledger_report";
    var message='';
    var showview='<?php echo MODULES_VIEW; ?>';

    
     if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
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
    "aTargets": [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14 ]
    }
    ],
    
    "aoColumns": [
        {"data":"sno"},
        {"data":"datesad"},
        {"data":"dates"},
        {"data":"description"},
        {"data":"refno"},
        {"data":"Depname"},
        {"data":"rec_purqty"},
        {"data":"rec_rate"},
        {"data":"rec_amt"},
        {"data":"issueQty"},
        {"data":"iss_rate"},
        {"data":"issuAmt"},
        {"data":"bqty"},
        {"data":"rate"},
        {"data":"bamt"},
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "fromdate", "value": fromdate });
        aoData.push({ "name": "todate", "value": todate });
        aoData.push({ "name": "locationid", "value": locationid });
        aoData.push({ "name": "store_id", "value": store_id });
        aoData.push({ "name": "itemid", "value": itemid });
         
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
        {type: null},
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
            fromdate = $('#fromdate').val();
            todate = $('#todate').val();
              locationid = $('#locationid').val();
              itemid=$('#itemid').val();
            store_id=$('#store_id').val();
            dtablelist.fnDraw();
        });
});
</script>