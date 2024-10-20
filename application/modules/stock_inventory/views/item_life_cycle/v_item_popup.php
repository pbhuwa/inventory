<div class="table-responsive">
    <div class="row">
    <div class="form-group">
      <div class="col-sm-4">
        <label>Search Item</label>
         <input type="text" name="srchtxt" class="form-control text_filter" id="srchtxt" value="" autofocus >
      </div>
    </div>
  </div>
    <table id="myItem_tbl" class="table table-striped keypresstable">
        <thead>
            <tr>                
                 <tr>
                      
                    <tr>
                                 <th width="7%"><?php echo $this->lang->line('sn'); ?></th>
                                 <th width="13%"><?php echo $this->lang->line('item_code'); ?></th>
                                <th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
                                <th  width="10%">Unit</th>
                                <th  width="15%">Category</th>
                                <th width="10%"><?php echo $this->lang->line('material_type'); ?></th>
                            </tr>
                     
                  </tr>                   
            </tr>
        </thead>
        <tbody>
                      
        </tbody>
    </table>
</div>
  
<script type="text/javascript">
    $(document).ready(function(){
   var srchtxt=$('#srchtxt').val();
   var categoryid=$('#categoryid').val();
   var dataurl = base_url+"stock_inventory/item_life_cycle/get_itemlist/";

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
 
    var dtablelist = $('#myItem_tbl').dataTable({
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
        "aTargets": [0,3,4,5]
      }
      ],      
      "aoColumns": [
       {"data": null},
        { "data": "itli_itemcode" },
        { "data": "itli_itemname" },
        { "data": "unitname" },
         { "data": "category" },
        { "data": "maty_material" },
       
      ],
    

      "fnServerParams": function (aoData) {
            aoData.push({ "name": "categoryid", "value": categoryid });
            aoData.push({ "name": "searchtext", "value": srchtxt });
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();

            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
            // console.log(aData);
          
            
            var itli_itemlistid=aData.itli_itemlistid;
            var itli_itemcode=aData.itli_itemcode;
            var itli_itemname=aData.itli_itemname;
            var maty_material =aData.maty_material;
            
         
            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1
            var statusclass=aData.statusClass;
            $(nRow).attr('class', statusclass);
        $(nRow).attr('id', 'listid_'+tblid);
       // $(nRow).attr('data-rate',rate);
        
        $(nRow).attr('data-rowid',tblid);
       
        $(nRow).attr('data-itli_itemlistid',itli_itemlistid);
        $(nRow).attr('data-itli_itemcode',itli_itemcode);
        $(nRow).attr('data-itli_itemname',itli_itemname);
        $(nRow).attr('data-maty_material',maty_material);
        

        
        $(nRow).addClass('itemDetail');
        if(tblid==1)
            {

               $(nRow).addClass('selected');
      
            }

      },
    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [      { type: null},
      {type: "text"},
      { type: "text" },
      { type: null },
      { type: null },
      { type: null },
      
      
     
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
    var dtablelist = $('#myItem_tbl').dataTable();
    setTimeout(function(){
    model_keypress();
       }, 500);

</script>

<script type="text/javascript">
  $(document).ready(function(){
  setTimeout(function(){
  $('#srchtxt').focus();
    }, 700);
});

</script>

