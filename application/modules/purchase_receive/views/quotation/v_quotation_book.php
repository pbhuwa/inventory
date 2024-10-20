<div class="white-box">
<div class="searchWrapper">
  <!--   <h3 class="box-title">Quotation Book</h3> -->
    <div class="">
        <form>
            <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
            <div class="col-md-2">
                <label for="Supplier"><?php echo $this->lang->line('select_date_wise'); ?>  :<span class="required">*</span>:</label>
                 <?php 
                     if($type=='Q'){
                        $date=$this->lang->line('quotation_date');
                        $no=$this->lang->line('quotation_no');
                    }else
                        {
                        $date=$this->lang->line('tender_date');
                        $no=$this->lang->line('tender_no');
                         }
                 ?>
                <select name="dateSearch" class="form-control required_field" id="dateSearch">
                    <option value="">---select---</option>
                    <option value="validate">Valid Date</option>
                    <option value="supplierdate">Supplier Date</option>
                    <option value="quotationdate"><?php echo $date ?></option>
                    <option value="entrydate">Entry Date</option>
                </select>
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" autocomplete="off"/>
            </div>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" autocomplete="off"/>
            </div>

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
     <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase/quotation_book" data-location="purchase_receive/quotation/exportToExcelQuotation" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase/quotation_book" data-location="purchase_receive/quotation/generate_pdfQuotation" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div> 
    <div class="clearfix"></div>
</div>
<div  id="FormDiv_quotationBook" class="formdiv">
    <div class="pad-5">
        <div class="table-responsive" id="displayDivquotationBook">
            <table id="myTable" class="table table-striped">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="20%"><?php echo $this->lang->line('req_no'); ?></th>
                        <th width="10%"><?php echo $no; ?></th>
                        <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>

                        <th width="10%"><?php echo $date; ?></th>
                        <th width="10%"><?php echo $this->lang->line('supplier_date'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('supplier_no'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('valid_till'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('grand_total'); ?></th>
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

<?php
    $apptype = $this->input->post('dashboard_data');
    if($apptype){
        $apptype = $apptype; 
    }else{
        $apptype = "";
    }
?>

<script type="text/javascript">
    $(document).ready(function(){
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();  //alert(frmDate);alert(toDate);
        var dateSearch = $('#dateSearch').val();
        var type = $('#type').val();
         var apptype='<?php echo $apptype; ?>';
        var dataurl = base_url+"purchase_receive/quotation/get_quotation_book_list";
        var message = '';
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
                    "aTargets": [ 0,8,9]
                }
            ],      
            "aoColumns": [
                { "data": "sno"},
                { "data": "quma_reqno"},
                { "data": "quma_quotationnumber"},
                { "data": "supp_suppliername" },
                { "data": "quma_quotationdate" },
                { "data": "quma_supplierquotationdate" },
                { "data": "quma_supplierquotationnumber" },
                { "data": "valid_date" },
                { "data": "quma_totalamount" },
                { "data": "action" }
            ],
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "frmDate", "value": frmDate });
                aoData.push({ "name": "toDate", "value": toDate });
                aoData.push({ "name": "dateSearch", "value": dateSearch });
                aoData.push({"name": "type","value": type});
                aoData.push({ "name": "apptype", "value": apptype });
            },
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
                return nRow;
            },
        }).columnFilter(
        {
            sPlaceHolder: "head:after",
            aoColumns: [ {type: null},
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

        $(document).off('click','#searchByDate')
        $(document).on('click','#searchByDate',function(){
            frmDate=$('#frmDate').val();
            toDate=$('#toDate').val(); 
            dateSearch = $('#dateSearch').val();  
            dtablelist.fnDraw();  
        });
    });
</script>

