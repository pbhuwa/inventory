<style>
    table.dataTable tr td:nth-child(4) {font-weight: bold}
</style>

<div class="searchWrapper">
    <div class="">
        <form>
            <?php 
            $locationid=$this->session->userdata(LOCATION_ID);
            echo $this->general->location_option(2,'locationname','locationid',$locationid); ?>

            <div class="col-md-2">
                <label for="example-text"><?php echo $this->lang->line('store'); ?>:</label>
                <select name="store_id" class="form-control select2" id="store_id">
                    <option value="">---All---</option>
                    <?php
                    if($store):
                        foreach ($store as $km => $st):
                        ?>
                        <option value="<?php echo $st->eqty_equipmenttypeid; ?>"><?php echo $st->eqty_equipmenttype; ?></option>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>

           
            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="clear"></div>
</div>
<div class="clearfix"></div>
<div class="pad-5 mtop_10">
    <h3 class="box-title"><?php echo $this->lang->line('department_issue_list'); ?><!-- Department Issue List --></h3>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped  dataTable container">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('code'); ?></th>
                    <th width="15%" style="min-width: 200px;"><?php echo $this->lang->line('name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('total'); ?></th>
                    <?php if($department_all)
                    // echo "<pre>";print_r($location);die();
                     {
                        $dtable_column = '';
                        $dtable_column .='[{ "data": null },{ "data": "code" },{ "data": "name" },{ "data": "total" },';
                        foreach ($department_all as $key => $dep) { 
                        $dtable_column .='{ "data": "dep'.$dep->dept_depid.'" },';
                         ?>
                    <th width="1%">
                        <?php echo $dep->dept_depname; ?>
                    </th>
                    <?php } }
                  
                    $dtable_clmn = rtrim($dtable_column,',');  $dtable_clmn .="]";
                    ?> 
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();  
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var store_id = $('#store_id').val();
        var toDate = $('#toDate').val();
        var frmDate = $('#frmDate').val();
        var locationid = $('#locationid').val();
        var supplier = '';
        var items = '';
        var dataurl = base_url + "/issue_consumption/department_issue/department_wise_stock_detail_list";
        var message = 'ss';
        var showview = '<?php echo MODULES_VIEW; ?>';
        var dtbl = <?php echo $dtable_clmn; ?>;
        // console.log(dtbl);

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
                "bSortable": true,
                "aTargets": [1, 2]
            }],
            "aoColumns": dtbl,
            
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "store_id","value": store_id});
                    aoData.push({"name": "toDate","value": toDate});
                    aoData.push({"name": "locationid","value": locationid});
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "items","value": items});
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                 // console.log(aData);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                // var rate = aData.sade_unitrate;
                // console.log(aData);
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1
                //$(nRow).attr('title',rate);
                // $(nRow).attr('data-toggle',"popover");
                // $(nRow).attr('data-trigger',"hover");
                // $(nRow).attr('data-content',rate);
                $(nRow).attr('id', 'listid_' + tblid);
                
            },
        }).columnFilter({
            sPlaceHolder: "head:after",
            aoColumns: [
                { type: null },
                { type: "text" },
                { type: "text" },
                
            ]
        });
        $(document).on('click', '#searchByDate', function() {
            store_id = $('#store_id').val();
            toDate = $('#toDate').val();
            frmDate = $('#frmDate').val();
             locationid = $('#locationid').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#searchBySupplier', function() {
            supplier = $('#searchBySupplier').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#searchByItems', function() {
            items = $('#searchByItems').val();
            dtablelist.fnDraw();
        });
    });
</script>
