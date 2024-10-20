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
            <div class="col-md-2">
                <label>From Date</label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
             <div class="col-md-2">
                <label>To Date</label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;">Search</a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/quotation_details/quotation_details_list" data-location="purchase_receive/quotation_details/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/quotation_details/quotation_details_list" data-location="purchase_receive/quotation_details/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>

 <div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table serverDatatable table-striped  keyPressTable ">
            <thead>
                <tr>
                    <th width="10%">S.n.</th>
                    <th width="10%">MRN</th>
                    <th width="15%">Date</th>
                    <th width="15%">Order No</th>
                    <th width="10%">Bill No.</th>
                    <th width="10%">Bill Date</th>
                    <th width="15%">Supplier</th>
                    <th width="15%">Amount </th>
                    <th width="15%">Discount </th>
                    <th width="15%">VAT </th> 
                    <th width="15%">Net Amount </th> 
                    <th width="15%">User </th> 
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
     
        var dataurl = base_url+"purchase_receive/mrn_book/mrn_book_list";
        var message='';
        var showview='<?php echo MODULES_VIEW; ?>';
        // alert(showview);
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
                "aTargets": [ 0,11 ]
            }],      
            "aoColumns": [
                { "data": "invoiceno" },
                { "data": "invoiceno" },
                { "data": "receiveddatebs" },
                { "data": "purchaseorderno" },
                { "data": "supplierbillno" },
                { "data": "supbilldatebs" },    
                { "data": "distributor" },
                { "data": "amount" },
                { "data": "discount" },
                { "data": "taxamount" },
                { "data": "cleranceamount" },
                { "data": "enteredby" },
            ],
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "frmDate", "value": frmDate });
                aoData.push({ "name": "toDate", "value": toDate });
            },
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
                return nRow;
            },
            "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
            },
        }).columnFilter(
        {
            sPlaceHolder: "head:after",
            aoColumns: [ 
                {type: null},
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" }
            ]
        });
        
        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            
            dtablelist.fnDraw();
        });
    });
</script>