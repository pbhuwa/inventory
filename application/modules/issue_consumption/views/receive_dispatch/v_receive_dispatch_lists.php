<style>
    table.dispatch_analysis  tr td:nth-child(7) {background: #99ff99}
    table.dispatch_analysis tr td:nth-child(8) {background: #99ff99}
    table.dispatch_analysis tr td:nth-child(9) {background: #99ff99}

    table.dispatch_analysis tr td:nth-child(10) {background: #ff9999}
    table.dispatch_analysis tr td:nth-child(11) {background: #ff9999}
    table.dispatch_analysis tr td:nth-child(12) {background: #ff9999}
    table.dispatch_analysis tr td:nth-child(13) {background: #ff9999}

    table.dispatch_analysis tr td:nth-child(14) {background: #99ccff}
    table.dispatch_analysis tr td:nth-child(15) {background: #99ccff}
    table.dispatch_analysis tr td:nth-child(16) {background: #99ccff}
</style>

<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="dispatch_analysis table table-striped">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="3%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('type'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('description'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('rec_qty'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('rec_rate'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('rec_total'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('dispatch_qty'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('dispatch_rate'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('dispatch_total'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('dispatch_loc'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('balance_qty'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('balance_rate'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('balance_total'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('remarks'); ?></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>   
<script type="text/javascript">
    $(document).ready(function() {
        var store_id = $('#store_id').val();
        var toDate = $('#toDate').val();
        var locationid = $('#locationid').val();
        var category = $('#category').val();
        var materialsid =  $('#materialsid').val();
        var itemsid =  $('#itemsid').val();
        var supplier = '';
        var items = '';

       var dataurl = base_url+"issue_consumption/receive_dispatch_analysis/receive_dispatch_analysis_report";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        // alert(showview);
        if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
        }

        var dtablelist = $('#myTable').dataTable({
            "sPaginationType": "full_numbers",

            "bSearchable": false,
            "lengthMenu": [
                [15, 30, 45, 60, 100, 200, 500, -1],[15, 30, 45, 60, 100, 200, 500, "All"]
            ],
            'iDisplayLength': 20,
            "sDom": 'ltipr',
            "bAutoWidth": false,

            "autoWidth": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": dataurl,
            "oLanguage": {
                "sEmptyTable": message
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 8,11,13,14,15,16]
            }],
            "aoColumns": [
                { "data": null},
                { "data": "itemcode" },
                { "data": "itemname" },
                { "data": "material" },
                { "data": "category" },
                { "data": "unitname" },
                { "data": "receivedqty" },
                { "data": "unitprice" },
                { "data": "rtotal" },
                { "data": "dispatch_qty" },
                { "data": "dispatch_rate" },
                { "data": "dispatchamount" },
                { "data": "dispatchlocation" },
                { "data": "balanceqty" },
                { "data": "unitprice" },
                { "data": "balancetotal" },
                { "data": "remarks" },
               
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "category","value": category});
                    aoData.push({"name": "materialsid","value": materialsid});
                     aoData.push({"name": "locationid","value": locationid});
                    aoData.push({"name": "itemsid","value": itemsid});
                    aoData.push({"name": "unitid","value": itemsid});
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1

                $(nRow).attr('id', 'listid_' + tblid);
            },
        }).columnFilter({
            sPlaceHolder: "head:after",
            aoColumns: [
                { type: null },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: null },
                { type: "text" },
                { type: "text" },
                { type: null },
                { type: "text" },
                { type: null },
                { type: null },
                { type: null },
                { type: "text" },
            ]
        });
        $(document).on('click', '#searchByDate', function() {
            category = $('#category').val();
            materialsid =  $('#materialsid').val();
             locationid =  $('#locationid').val();
            itemsid =  $('#itemsid').val();
            unitid =  $('#unitid').val();
            dtablelist.fnDraw();
        });
    });
</script>