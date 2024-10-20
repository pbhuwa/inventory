<h3 class="box-title"><?php echo $this->lang->line('list_of_items_category'); ?> <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>

<div class="pull-right">
    <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="biomedical/equipments/get_equipment_cat_list" data-location="biomedical/equipments/generate_items_category_list_excel?=1" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>


</div>   

<div class="clearfix"></div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('equipment_type'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('equipment_code'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('parent_category'); ?></th>
                    <th width="10%">Material Type</th>
                   <!--  <th width="10%"><?php echo $this->lang->line('isnonexp'); ?></th>
                     <th width="10%"><?php echo $this->lang->line('isitdep'); ?></th> -->
                    <th width="10%"><?php echo $this->lang->line('action'); ?></th>
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
    var dataurl = base_url+"biomedical/equipments/get_equipment_cat_list";
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
 
 
 
    var dtablelist = $('#myTable').dataTable({
      "sPaginationType": "full_numbers"  ,
      
      "bSearchable": false,
      "lengthMenu": [[15, 20, 30, 45, 60,100,200,500, -1], [15, 20, 30, 45, 60,100,200,500, "All"]],
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
        "aTargets": [ 4 ]
      }
      ],      
      "aoColumns": [
      { "data": null},
       { "data": "eqty_equipmenttype"},
       { "data": "eqca_code"},
       { "data": "eqca_category"},
       { "data": "parent_cat" },
        { "data": "mattype" },
       // { "data": "isnonexp" },
       // { "data":'isitdep'},
       { "data": "action" }
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
             var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1

        $(nRow).attr('id', 'listid_'+tblid);
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
      { type: null },
     
      ]
    });

});
</script>
