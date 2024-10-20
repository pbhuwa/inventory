 <div class="table-responsive">
                    <table id="myTable_item" class="table table-striped keypresstable">
                        <thead>
                            <tr>
                                <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                                <th width="25%"><?php echo $this->lang->line('item_name'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('stock'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('purchase_rate'); ?></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                                  
                        </tbody>
                    </table>
                </div>
  


<script type="text/javascript">
     $(document).ready(function(){
    var rowno='<?php echo $rowno; ?>'
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl = base_url+"stock_inventory/item/get_item_list_purchase_requisition/<?php echo $rowno.'/'.$storeid;?>";
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
 
 
 
    var dtablelist = $('#myTable_item').dataTable({
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
        "aTargets": [0,4]
      }
      ],      
      "aoColumns": [
      {"data": null},
      {"data": "itemcode"},
      {"data": "itemname"},
      {"data": "unitname"},
      {"data": "stock_qty" },
      {"data": "purchaserate"},      
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
            var rowno=aData.rowno;
            var itemid=aData.itemlistid;
            var itemcode=aData.itemcode
            var itemname=aData.itemname;
            var purchaserate=aData.purchaserate;
            var stock_qty=aData.stock_qty;
            var unitname=aData.unitname;
            var quotationmasterid=aData.quotationmasterid;
            var quotationnumber=aData.quotationnumber;
           
            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1
            $(nRow).attr('id', 'listid_'+tblid);
            $(nRow).attr('data-rowid',tblid);
            $(nRow).attr('data-rowno',rowno);
            $(nRow).attr('data-itemcode',itemcode);
            $(nRow).attr('data-itemname',itemname);
            $(nRow).attr('data-itemid',itemid);
            $(nRow).attr('data-purrate',purchaserate);
            $(nRow).attr('data-stock_qty',stock_qty);
            $(nRow).attr('data-unitname',unitname);
             $(nRow).attr('data-quotationmasterid',quotationmasterid);
            $(nRow).attr('data-quotationnumber',quotationnumber);

            $(nRow).addClass('itemDetail');
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
       { type: "text" },
     { type: "text" },
      ]
    });

  });
</script>

<script type="text/javascript">
  // $(document).ready(function(){
    var dtablelist = $('#myTable_item').dataTable();
     setTimeout(function(){
    model_keypress();
       }, 500);
  // })
</script>