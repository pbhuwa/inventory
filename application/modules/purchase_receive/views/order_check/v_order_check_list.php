 <style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }
    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }
</style>

 <div class="pad-5">
        <div class="table-responsive">
            <table id="myTable" class="table serverDatatable table-striped  keyPressTable ">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('supplier_name'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('order_date'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('order_no'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('delivery_site'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('delivery_date'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('requisition_no'); ?></th>
                       
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
    var dataurl = base_url+"purchase_receive/order_check/order_check_list";
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
        "aTargets": [ 0,6 ]
      }
      ],      
       "aoColumns": [
         { "data": "supplier" },
       { "data": "supplier" },
       { "data": "orderdatebs" },
       { "data": "orderno" },
       { "data": "deliverysite" },
       { "data": "deliverydatebs" },
       { "data": "requno" } 
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
          // console.log(aData);
        var purchasemasterid=aData.purchaseordermasterid;
        var viewurl =aData.viewurl;
        var supplier=aData.supplier;
        var orderdatebs=aData.orderdatebs;
        var orderno=aData.orderno;
        var oSettings = dtablelist.fnSettings();
        var tblid= oSettings._iDisplayStart+iDisplayIndex +1
        $(nRow).attr('id', 'listid_'+tblid);
        $(nRow).attr('data-viewurl',viewurl);
        $(nRow).attr('data-id',purchasemasterid);
          $(nRow).attr('data-heading',supplier+'| Order Date: '+orderdatebs+'| Order No:'+orderno);
         $(nRow).addClass('view');
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
     { type: "text" }
      ]
    });

});
</script>

<script type="text/javascript">
   var tableid = $('.serverDatatable').data('tableid');
  $(document).ready(function(){
   
   setTimeout(function(){
      var firstTR = $('.keyPressTable tbody tr:first');
        var lastTR = $('.keyPressTable tbody tr:last');

        firstTR.addClass('selected');
        var selectedTR = $('.keyPressTable').find('.selected');
        var req_masterid = selectedTR.data('purchasemasterid');
      },800);
});

   $(document).off('keydown');
        $(document).on('keydown',function(){   
          selectedTR = $(tableid).find('.selected');
          var rowid = selectedTR.data('rowid');
          var numRow = selectedTR.data('numRow');
          var numTR = $(tableid+' tr').length-1;
          var keypressed = event.keyCode;
 // console.log(keypressed);

            if(keypressed == '40' && rowid < numTR){
                selectedTR.removeClass('selected');
                nextTR = selectedTR.next('tr');

                nextTR.addClass('selected');
                req_masterid = nextTR.data('masterid');
                setTimeout(function(){
                    nextTR.focus();
                }, 100);
            }

            if(keypressed == '38' && rowid != '1'){
                selectedTR.removeClass('selected');
                prevTR = selectedTR.prev('tr');

                prevTR.addClass('selected');
                req_masterid = prevTR.data('masterid');
                setTimeout(function(){
                    prevTR.focus();
                }, 100);
            }

            if(keypressed == '13'){
               selectedTR.click();
               // console.log( $(this).closest('tr').attr('id'));
                selectedTR.addClass('selected');
            }
        });

</script>