<style type="text/css">
    table.dataTable tbody tr.success {
        color: #20B2AA !important;
    }
    table.dataTable tbody tr.danger {
        color: #DC143C !important;
    }
    table.dataTable tbody tr.warning {
        color: #FF4500 !important;
    }
    table.dataTable tbody tr.active {
        color: #fff !important;
    }
</style>
<div class="searchWrapper">
    <div class="">
    <form class="col-sm-12">
        <div class="form-group">
            <div class="row">
                 <!-- <?php echo $this->general->location_option(1,'locationid'); ?> -->
            <div class="col-md-3 col-sm-3 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('department'); ?>:<span class="required">*</span>:</label>
                <select id="depid" name="depid"  class="form-control required_field select2" >
                    <?php if($this->session->userdata(USER_GROUPCODE)=='SA'){?>
                          <option value="">All</option>
                         <?php } ?>
                    <?php 
                        if($department):
                            foreach ($department as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->apde_invdepid; ?>" ><?php echo $dep->apde_departmentname; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
      <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Inventory Item </label>
                <select id="itemid" name="itemid"  class="form-control required_field select2" >
                    <option value="">All</option>
                    <?php 
                        if($items_name):
                            foreach ($items_name as $km => $item):
                    ?>
                    <option value="<?php echo $item->itli_itemlistid; ?>" ><?php echo $item->itli_itemname; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div> 
 

               <!--  <div class="col-md-2">
                    <label><?php echo $this->lang->line('from'); ?></label>
                    <input type="text" id="fromdate" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>

                <div class="col-md-2">
                    <label><?php echo $this->lang->line('to'); ?></label>
                    <input type="text" id="todate" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>
 -->
        

                <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            </div>
        </div>
    </form>

     <div class="col-sm-12 col-xs-12">
            <div class="white-box pad-5">
                <ul class="index_chart xx">
                    <li>
                        <div class="success"></div> <a href="javascript:void(0)" data-approvedtype='available' class="approvetype"><?php echo $this->lang->line('available'); ?></a>
                        <span id="available"><?php echo !empty($status_count[0]->StockCnt)?$status_count[0]->StockCnt:'';?></span>
                    </li>
                    <li>
                        <div class="danger"></div><a href="javascript:void(0)" data-approvedtype='zero' class="approvetype"> <?php echo $this->lang->line('out_of_stock'); ?></a> 
                        <span id="zero"><?php echo !empty($status_count[0]->ZeroCnt)?$status_count[0]->ZeroCnt:'';?></span>
                    </li>
                    
                    <li>
                        <div class="primary"></div> <a href="javascript:void(0)" data-approvedtype='limited' class="approvetype" ><?php echo $this->lang->line('limited'); ?> </a>
                        <span id="limited"><?php echo !empty($return_count[0]->LimitCnt)?$return_count[0]->LimitCnt:'';?></span>
                    </li>
                    <div class="clearfix"></div>
                    
                </ul>
            </div>
        </div>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/current_stock/search_current_stock_list" data-location="stock_inventory/current_stock/exportToExcelList" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/current_stock/search_current_stock_list" data-location="stock_inventory/current_stock/generate_details_pdfList" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

   

    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    <h3 class="box-title"> REAGENT STOCK OF DEPARTMENT</h3>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                <th width="3%" style="text-align: center"><?php echo $this->lang->line('sn'); ?></th>
                <th width="6%"><?php echo $this->lang->line('item_name'); ?></th> 
             
                <th width="6%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="7%">Department</th>
                
                <th  width="6%">TEST</th>
                <th  width="6%">Remaining Test</th>
                <th width="7%"><?php echo $this->lang->line('expenses_qty'); ?></th>
                <th width="6%">Receive KIT</th>
                <th width="6%">Exp Kit</th>
                <th width="7%">Rem KIT </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>

<?php
    $apptype = $this->input->get('apptype');
    if($apptype){
        $apptype = $apptype; 
    }else{
        $apptype = "";
    }
?>

<?php
    $cur_locationid = $this->session->userdata(LOCATION_ID);
?>

<script type="text/javascript">
    $(document).ready(function() {
        var store_id = $('#store_id').val();
        var frmDate=$('#frmDate').val();
        var toDate = $('#toDate').val();
        var depid = $('#depid').val();
        var locationid = "<?php echo $cur_locationid; ?>";
        var supplier = '';
        var items = '';
        var apptype='<?php echo $apptype; ?>';

        var dataurl = base_url + "issue_consumption/test/reagent_stock_list";
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
                "aTargets": [0, 7]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "itli_itemname" },
                { "data": "itli_itemcode" },
                { "data": "dept_depname" },
               
                { "data": "test_qty" },
                { "data": "remaing_test" },
                { "data": "exp_qty" },
                { "data": "rec_qty" },
                { "data": "exp_kit" },
                { "data": "remaining_stock" }

              
               
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "store_id","value": store_id});
                    aoData.push({"name": "toDate","value": toDate});
                    aoData.push({"name": "locationid","value": locationid});
                    aoData.push({"name": "supplier","value": supplier});
                    aoData.push({"name": "items","value": items});
                    aoData.push({ "name": "apptype", "value": apptype });
                    aoData.push({ "name": "depid", "value": depid });
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var statusclass=aData.statusClass;
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1

                $(nRow).attr('id', 'listid_' + tblid);
                $(nRow).attr('class', statusclass);
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
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
              
                { type: null },
            ]
        });
        var otherlinkdata=base_url+'issue_consumption/test/get_reagent_stock_count_total';
        var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,locationid);

        $(document).off('click','.approvetype');
        $(document).on('click','.approvetype',function(){
            apptype= $(this).data('approvedtype');
            // alert(apptype);
            
            frmDate=$('#frmDate').val();
            toDate=$('#toDate').val();
            locationid=$('#locationid').val();  
            depid=$('#depid').val();   
            if(locationid){
                locationid = locationid;
            }else{
                locationid = "<?php echo $cur_locationid;?>";
            }
            type=$('#searchByType').val(); 
            dtablelist.fnDraw();  
            // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
        });

        function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false){
            var returndata=[];   
            $.ajax({
                type: "POST",
                url: action,
                // data:$('form#'+formid).serialize(),
                dataType: 'html',
                data:{frmdate:frmdate,todate:todate,othertype:othertype,locationid:locationid} ,
                success: function(jsons) //we're calling the response json array 'cities'
                {
                    // console.log(jsons);
                    data = jQuery.parseJSON(jsons); 
                    var  issuereturn=0;
                    var zero=0; 
                    // console.log(data);
                    $('#available').html('');
                    $('#limited').html();
                    $('#zero').html();
                    if(data.status=='success'){
                        issuedata=data.status_count;
                        available=issuedata[0].StockCnt;
                        slimit=issuedata[0].LimitCnt;
                        outstk=issuedata[0].ZeroCnt;
                        
                    }
                    $('#available').html(available);
                    $('#limited').html(slimit);
                    $('#zero').html(outstk);
                    return false;
                }   
            });
        }
        $(document).on('click', '#searchByDate', function() {
            store_id = $('#store_id').val();
            toDate = $('#toDate').val();
            locationid = $('#locationid').val();
            depid = $('#depid').val();
            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata,frmDate,tDaote,locationid);
        });
    });
</script>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>

<script type="text/javascript">
    $(document).on( 'click', '#myTable tbody tr', function () {
        var stocklist = $('#myTable').dataTable();
        if ( $(this).hasClass('selected') ) {

            $(this).removeClass('selected');
        }
        else {
            stocklist.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
</script>


