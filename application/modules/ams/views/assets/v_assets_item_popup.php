<div class="table-responsive">
    <table id="myTable_equip" class="table table-striped keypresstable">
        <thead>
            <tr>                
                 <tr>
                      
                    <tr>
                                <th width="7%"><?php echo $this->lang->line('sn'); ?></th>
                                <th width="13%"><?php echo $this->lang->line('assets_code'); ?></th>
                                <th width="20%"><?php echo $this->lang->line('description'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('brand'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('manufacture'); ?></th>
                                <th width="18%"><?php echo $this->lang->line('distributor'); ?></th>
                                  <!-- <th width="14%">Action</th> -->
                                  
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
  
    var rowno='<?php echo $rowno; ?>'
   // alert('a'+rowno);
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    var rslt='<?php echo !empty($result)?$result:''; ?>';
    var orgid='<?php echo !empty($org_id)?$org_id:''; ?>';  
   var dataurl = base_url+"ams/assets/get_item_asset/"+rowno;
   //alert('a'+dataurl);
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
 
    var dtablelist = $('#myTable_equip').dataTable({
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
        "aTargets": [0]
      }
      ],      
      "aoColumns": [
       {"data": null},
        { "data": "equipkey" },
        { "data": "description" },
        { "data": "brand" },
        { "data": "manu_manlst" },
        { "data": "distributor" }
       // { "data": "action" }
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
          
            var rowno=aData.rowno;
            //alert('A'+rowno);
            var equipid=aData.equipid;
            var equipkey=aData.equipkey;
            var description=aData.description;
            var brand =aData.brand;
            var manu_manlst=aData.manu_manlst;
            var distributor=aData.distributor;
            //var itemdisplay=aData.description_display;
         
            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1
            var statusclass=aData.statusClass;
            $(nRow).attr('class', statusclass);
        $(nRow).attr('id', 'listid_'+tblid);
       // $(nRow).attr('data-rate',rate);
        
        $(nRow).attr('data-rowid',tblid);
        $(nRow).attr('data-rowno',rowno);
        $(nRow).attr('data-equipid',equipid);
        $(nRow).attr('data-equipkey',equipkey);
        $(nRow).attr('data-description',description);
        $(nRow).attr('data-brand',brand);
        $(nRow).attr('data-manu_manlst',manu_manlst);
        $(nRow).attr('data-distributor',distributor);

        // $(nRow).attr('data-itemid',itemid);
        // $(nRow).attr('data-itemname_display',itemdisplay);
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
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      
     
      ]
    });

  });
</script>

<script type="text/javascript">
  // $(document).ready(function(){
    var dtablelist = $('#myTable_equip').dataTable();
    setTimeout(function(){
    model_keypress();
       }, 500);

</script>