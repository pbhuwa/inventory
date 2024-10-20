
 <div class="table-responsive">
  <div class="row">
    <div class="form-group">
      <div class="col-sm-4">
         <input type="text" name="srchtxt" class="form-control text_filter" id="srchtxt" value="" autofocus >
      </div>
    </div>
  </div>
 
    <table id="myTable_item" class="table table-striped keypresstable">
        <thead>
            <tr>
                <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="25%"><?php echo $this->lang->line('item_name'); ?></th>
                <th width="25%"><?php echo $this->lang->line('item_name_np'); ?></th>
                <th width="15%"><?php echo $this->lang->line('unit'); ?></th>
                <th width="10%"><?php echo $this->lang->line('purchase_rate'); ?></th>
                
            </tr>
        </thead>
        <tbody>
                      
        </tbody>
    </table>
</div>
  


<script type="text/javascript">
     $(document).ready(function(){
    var rowno='<?php echo $rowno; ?>';
    var type='<?php echo $type; ?>';
    var srchtxt=$('#srchtxt').val();
    // alert(srchtxt);
    var dataurl = base_url+"stock_inventory/item/get_item_list_normal/<?php echo $rowno;?>/<?php echo $type;?>";
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
      {"data": "itemnamenp"},
       {"data": "unitname" },
      {"data": "purchase_rate"},
     
      ],
      "fnServerParams": function (aoData) {
        aoData.push({ "name": "searchtext", "value": srchtxt });
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
            // console.log(aData);
            var unitname =aData.unitname;
            var rowno=aData.rowno;
            var rate=aData.purchase_rate;
            var itemcode=aData.itemcode
            var itemname=aData.itemname;
            var itemid=aData.itemlistid;
            var itemdisplay=aData.itemname_display;
         
            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1

        $(nRow).attr('id', 'listid_'+tblid);
        $(nRow).attr('data-rate',rate);
        $(nRow).attr('data-unit',unitname);
        $(nRow).attr('data-rowid',tblid);
        $(nRow).attr('data-rowno',rowno);
        $(nRow).attr('data-itemcode',itemcode);
        $(nRow).attr('data-itemname',itemname);
        $(nRow).attr('data-itemid',itemid);
        $(nRow).attr('data-itemname_display',itemdisplay);
        $(nRow).addClass('itemDetail');
        if(tblid==1)
            {

               $(nRow).addClass('selected');
      
            }

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

    $(document).on('keyup','#srchtxt',function(){
      srchtxt=$('#srchtxt').val();
       dtablelist.fnDraw();       
    })

  });
</script>

<script type="text/javascript">
  // $(document).ready(function(){
    var dtablelist = $('#myTable_item').dataTable();
    setTimeout(function(){
      $('#srchtxt').focus();
    model_keypress();
       }, 500);


</script>
