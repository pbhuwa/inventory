 <div class="table-responsive">
                    <table id="myTable_item" class="table table-striped keypresstable">
                        <thead>
                            <tr>
                                <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                                <th width="25%"><?php echo $this->lang->line('item_name'); ?></th>
                                <th width="25%"><?php echo $this->lang->line('item_name_np'); ?></th>

                                <th width="10%"><?php echo $this->lang->line('stock'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('expiry_date'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('unit_name'); ?></th>

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
    var dataurl = base_url+"stock_inventory/item/get_item_list_stock_transfer/<?php echo $rowno.'/'.$storeid;?>";
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
        "aTargets": [0,5]
      }
      ],      
      "aoColumns": [
      {"data": null},
      {"data": "itemcode"},
      {"data": "itemname"},
      {"data": "itemnamenp"},

      {"data": "stockqty" },
       {"data": "expdatebs"},
       {"data": "unitname"}
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
            var rate=aData.trde_unitprice;
            var itemcode=aData.itemcode
            var itemname=aData.itemname;
            var itemname_display=aData.itemname_display;
            
            var stockqty=aData.stockqty;
            var mattransdetailid=aData.mattransdetailid;
            var mattransmasterid=aData.mattransmasterid;
            var expdatead=aData.expdatead;
            var controlno=aData.controlno;
            var unitname=aData.unitname;
            var unitid=aData.unitid;
            var purchaserate=aData.purchaserate;
            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1
            $(nRow).attr('id', 'listid_'+tblid);
            $(nRow).attr('data-rate',rate);
            $(nRow).attr('data-rowid',tblid);
            $(nRow).attr('data-rowno',rowno);
            $(nRow).attr('data-itemcode',itemcode);
            $(nRow).attr('data-itemname',itemname);
            $(nRow).attr('data-itemname_display',itemname_display);
            
            $(nRow).attr('data-itemid',itemid);
            $(nRow).attr('data-stockqty',stockqty);
            $(nRow).attr('data-mattransdetailid',mattransdetailid);
            $(nRow).attr('data-controlno',controlno);
            $(nRow).attr('data-mattransmasterid',mattransmasterid);
            $(nRow).attr('data-unitname',unitname);
            $(nRow).attr('data-unitid',unitid);
            $(nRow).attr('data-purchaserate',purchaserate);
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