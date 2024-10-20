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
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
         <div class="dateRangeWrapper">
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            </div>
            <!--  <div class="col-md-3">
               <label></label><br>
              <input type="checkbox" name="" id="supplierwise">Supplierwise Summary
             </div> -->


            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/mrn_book/mrn_book_list" data-location="purchase_receive/mrn_book/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/mrn_book/mrn_book_list" data-location="purchase_receive/mrn_book/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>

 <div class="pad-5">
        <div class="table-responsive">
            <table id="myTable" class="table serverDatatable table-striped  keyPressTable ">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('mrn'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('date'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('order_no'); ?></th>
                        <th width="9%"><?php echo $this->lang->line('bill_no'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('bill_date'); ?></th>
                        <th width="14%"><?php echo $this->lang->line('supplier_name'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('sub_total'); ?> </th>
                        <th width="7%"><?php echo $this->lang->line('discount'); ?> </th>
                        <th width="6%"><?php echo $this->lang->line('vat_amount'); ?> </th>
                        <th width="8%"><?php echo $this->lang->line('net_amount'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('user'); ?> </th>
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
    var locationid = $('#locationid').val();
     var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }
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
      }
      ],
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
         aoData.push({ "name": "locationid", "value": locationid });
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
          // console.log(aData);
        // var purchasemasterid=aData.purchaseordermasterid;
        // var viewurl =aData.viewurl;
        // var supplier=aData.supplier;
        // var orderdatebs=aData.orderdatebs;
        // var orderno=aData.orderno;
        // var oSettings = dtablelist.fnSettings();
        // var tblid= oSettings._iDisplayStart+iDisplayIndex +1
        // $(nRow).attr('id', 'listid_'+tblid);
        // $(nRow).attr('data-viewurl',viewurl);
        // $(nRow).attr('data-id',purchasemasterid);
        //   $(nRow).attr('data-heading',supplier+'| Order Date: '+orderdatebs+'| Order No:'+orderno);
        //  $(nRow).addClass('view');
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
            locationid=$('#locationid').val();
             searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }

            dtablelist.fnDraw();
        });
    $(document).off('change', '#searchDateType');
       $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });

});
</script>

<script type="text/javascript">

</script>
