<div class="searchWrapper">
    <div class="">
        <form>
             <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-2 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('store_type'); ?> :<span class="required">*</span>:</label>
                <select id="store_id" name="store_id"  class="form-control" >
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
      

        <div class="col-md-2 col-sm-2 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('from_date'); ?> : </label>
            <input type="text" name="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="frmDate">
            <span class="errmsg"></span>
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('to_date'); ?> : </label>
            <input type="text" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="toDate">
            <span class="errmsg"></span>
        </div>

            
             <div class="col-md-2">
                <label><?php echo $this->lang->line('supplier_name'); ?></label>
                <select class="form-control select2" id="supplierid">
                    <option value="">All</option>
                    <?php
                        if($supplier_all):
                            foreach ($supplier_all as $ks => $supp):
                        ?>
                    <option value="<?php echo $supp->dist_distributorid; ?>"><?php echo $supp->dist_distributor; ?></option>
                    <?php
                        endforeach;
                        endif;
                        ?>
                </select>
            </div>

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/receive_against_order/receive_against_order_list" data-location="purchase_receive/receive_against_order/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/receive_against_order/receive_against_order_list" data-location="purchase_receive/receive_against_order/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
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
                    <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('tax'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('clearance_amt'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('time'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('action'); ?></th>
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
        var locationid = $('#locationid').val();
        var supplierid = $('#supplierid').val();


        var supplier = '';
        var items = '';

        var dataurl = base_url + "purchase_receive/receive_against_order/received_against_order_list";
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
               // { "data": "recm_status" },
                //{ "data": "recm_amount" },
                { "data": "action" }
                
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name":  "frmDate","value": frmDate});
                    aoData.push({"name":  "toDate","value": toDate});
                    aoData.push({"name":  "store_id","value": store_id});
                    aoData.push({"name":  "fyear","value": fyear});
                    aoData.push({"name":  "locationid","value":locationid});
                    aoData.push({"name":  "supplierid","value":supplierid});
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
            locationid=$('#locationid').val();
            supplierid = $('#supplierid').val();

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