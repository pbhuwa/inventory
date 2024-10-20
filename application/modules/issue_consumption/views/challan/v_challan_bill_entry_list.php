<div class="searchWrapper">
    <div class="">
        <form>
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('store_type'); ?> :<span class="required">*</span>:</label>
                <select id="store_id" name="store_id"  class="form-control required_field" >
                    <option value="">---All---</option>
                    <?php 
                        if($store_type):
                            foreach ($store_type as $km => $dep):  //print_r($store_type);die;
                    ?>
                     <option value="<?php echo $dep->eqty_equipmenttypeid; ?>"><?php echo $dep->eqty_equipmenttype; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
              <!-- <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :<span class="required">*</span>:</label>
                <select id="fyear" name="fyear"  class="form-control" >
                    <option value="">---select---</option>
                    <option value="074/75">74/75</option>
                  <?php 
                        if($store_type):
                            foreach ($store_type as $km => $dep):  
                    ?>
                     <option value="<?php echo $dep->st_store_id; ?>"><?php echo $dep->st_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?> 
                </select>
            </div>-->


        <div class="col-md-3 col-sm-3 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('from_date'); ?> : </label>
            <input type="text" name="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="frmDate">
            <span class="errmsg"></span>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('to_date'); ?> : </label>
            <input type="text" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="toDate">
            <span class="errmsg"></span>
        </div>

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/challan/orderlist_bill_entry_by_order_no" data-location="issue_consumption/challan/exportToExcelBillDetails" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/challan/orderlist_bill_entry_by_order_no" data-location="issue_consumption/challan/generate_pdfBillDetails" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
   
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('received_date'); ?> </th>
                    <th width="7%"><?php echo $this->lang->line('fiscal_year'); ?> </th>

                    <th width="5%"><?php echo $this->lang->line('invoice_no'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <!-- <th width="20%"><?php echo $this->lang->line('budget_name'); ?></th> -->
                    <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('tax'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('clearance_amt'); ?></th>
                        <!-- <th width="5%">Rate</th>
                        <th width="5%">Dis %</th> -->
                    <th width="5%"><?php echo $this->lang->line('time'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('challan_no'); ?></th>
                    <!-- <th width="5%"><?php echo $this->lang->line('canceled'); ?></th> -->
                    <!-- <th width="5%"><?php echo $this->lang->line('amount'); ?></th> -->
                    <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                    <!-- <th width="5%">Remarks</th> -->
                </tr>
            </thead>
            <tbody>
                      
            </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();
        var fyear = $('#fyear').val();
        var store_id = $('#store_id').val();


        var supplier = '';
        var items = '';

        var dataurl = base_url + "issue_consumption/challan/get_challan_bill_entry_lists";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        // alert(showview);
        if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
        }

        var dtablelist = $('#myTable').dataTable({
            "sPaginationType": "full_numbers",

            "bSearchable": false,
            "lengthMenu": [
                [15, 30, 45, 60, 100, 200, 500, -1],[15, 30, 45, 60, 100, 200, 500, "All"]
            ],
            'iDisplayLength': 20,
            "sDom": 'ltipr',
            "bAutoWidth": false,

            "autoWidth": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": dataurl,
            "oLanguage": {
                "sEmptyTable": message
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0,9]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "recm_receiveddatebs" },
                { "data": "recm_fyear" },

                { "data": "recm_invoiceno" },
                { "data": "orderno" },
                { "data": "dist_distributor" },
                //{ "data": "budg_budgetname" },
                { "data": "recm_discount" },
                { "data": "recm_taxamount" },
                { "data": "recm_clearanceamount" },
                { "data": "recm_posttime" },
                { "data": "challan_history" }, 
               // { "data": "recm_status" },
                //{ "data": "recm_amount" },
                { "data": "action" }
                
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "toDate","value": toDate});
                    aoData.push({"name": "store_id","value": store_id});
                    aoData.push({"name": "fyear","value": fyear});
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1

                $(nRow).attr('id', 'listid_' + tblid);
            },
        }).columnFilter({
            sPlaceHolder: "head:after",
            aoColumns: [
                { type: null },
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
            fyear = $('#fyear').val();
            store_id = $('#store_id').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#searchBySupplier', function() {
            supplier = $('#searchBySupplier').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#searchByItems', function() {
            items = $('#searchByItems').val();
            dtablelist.fnDraw();
        });

        $('#searchByDate').click();
    });
</script>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>