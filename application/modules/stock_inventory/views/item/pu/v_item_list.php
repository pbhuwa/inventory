<h3 class="box-title"><?php echo $this->lang->line('item_list'); ?> 
    <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"> </i></a>
</h3>

<div class="pull-right">
    <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/item/get_item_category_list" data-location="stock_inventory/item/generate_item_list_excel?=1" data-tableid="#myitemListTable"><i class="fa fa-file-excel-o"></i></a>
</div>          

<div class="clearfix"></div>

<div class="table-responsive">
    <table id="myitemListTable" class="table table-striped">
        <thead>
            <tr>
                <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                <th width="5%"><?php echo $this->lang->line('material_type'); ?></th>
                <th width="15%"><?php echo $this->lang->line('category'); ?></th>
                <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                 <th width="15%"><?php echo $this->lang->line('item_name_np'); ?></th>
                <th width="7%"><?php echo $this->lang->line('purchase_rate'); ?></th>
                <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                <th width="15%"><?php echo $this->lang->line('store'); ?></th>
                <th width="15"> <?php echo $this->lang->line('action'); ?> </th>
            </tr>
        </thead>
        <tbody>
                  
        </tbody>
    </table>
</div>
  


<script type="text/javascript">
     $(document).ready(function(){
    
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl = base_url+"stock_inventory/item/get_item_category_list";
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
 
 
 
    var dtablelist = $('#myitemListTable').dataTable({
      "sPaginationType": "full_numbers"  ,
      
      "bSearchable": false,
      "lengthMenu": [[15,20, 30, 45, 60,100,200,500, -1], [15, 20,30, 45, 60,100,200,500, "All"]],
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
        "aTargets": [6,8]
      }
      ],      
      "aoColumns": [
      {"data": null},
      {"data": "maty_material"},
      {"data": "eqca_category"},
      {"data": "itli_itemcode"},
      {"data": "itli_itemname" },
      {"data": "itli_itemnamenp" },
      {"data": "itli_purchaserate" },
      {"data": "unit_unitname" },
      {"data": "eqty_equipmenttype" },
      {"data": "action" }
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
        { type: "text" },
      { type: null },
       { type: "text" },
     { type: "text" },
      ]
    });

  });
</script>
