<div class="table-responsive">
    <table id="myTable_equip" class="table table-striped keypresstable">
        <thead>
            <tr>                
                 <tr>
                      
                    <tr>
                                 <th width="7%">S.n.</th>
                                 <th width="13%">Equip.ID</th>
                                <th width="20%">Descp.</th>
                                <th width="10%">Dept.</th>
                                <th width="15%">Manufacture</th>
                                <th width="18%">Risk</th>
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
   var dataurl = base_url+"biomedical/bio_medical_inventory/get_equipmentlist/"+rowno;
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
        { "data": "department" },
        { "data": "manu_manlst" },
        { "data": "risk" }
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
            var department =aData.department;
            var manu_manlst=aData.manu_manlst;
            var risk=aData.risk;
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
        $(nRow).attr('data-department',department);
        $(nRow).attr('data-manu_manlst',manu_manlst);
        $(nRow).attr('data-risk',risk);

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