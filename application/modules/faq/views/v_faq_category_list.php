
<h3 class="box-title"><?php echo $this->lang->line('list_of_item'); ?> <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"> </i></a></h3>

<div class="table-responsive">
    <table id="myTable" class="table table-striped">
        <thead>
            <tr>
                <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                <th width="15%"><?php echo $this->lang->line('category'); ?></th>
                <th width="15%"><?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('in_nepali'); ?></th>
                <th width="15%"><?php echo $this->lang->line('active'); ?></th>
                <th width="10%"><?php echo $this->lang->line('action'); ?></th>
                
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
        //var dataurl = base_url+"stock_inventory/item/get_item_category_list";
        var dataurl = base_url+"faq/faq/get_faq_category_list";
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
        "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
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
        "aTargets": [0,4]
        }
        ],
        "aoColumns": [
        {"data": null},
        {"data": "facq_catname"},
        {"data": "facq_catnamenp"},
        {"data": "facq_isactive"},
        {"data": "action"},



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
        { type: null},

        ]
        });
        });
</script>




