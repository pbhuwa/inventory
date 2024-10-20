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
        <form class="col-sm-8">
             <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-2 col-sm-3">
                 
                <label for="example-text"><?php echo $this->lang->line('store_type'); ?><span class="required">*</span>:</label>
                <select id="store_id" name="store_id"  class="form-control" >
                    <option value="">---All---</option>
                    <?php 
                        if($store_type):
                            foreach ($store_type as $km => $dep):  //print_r($store_type);die;
                    ?>
                     <option value="<?php echo $dep->eqty_equipmenttypeid; ?>"><?php echo $dep->eqty_equipmenttype; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

             <!-- <div class="col-md-3 col-sm-2">
               <label for="example-text"><?php echo $this->lang->line('item_code'); ?>:<span class="required">*</span>:</label>
                <select id="code_id" name="code_id"  class="form-control select2" >
                    <option value="">---select---</option>
                    <?php 
                        if($code):
                            foreach ($code as $km => $dep):  //print_r($store_type);die;
                    ?>
                     <option value="<?php echo $dep->itli_itemlistid; ?>"><?php echo $dep->itli_itemcode; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>  -->
            <div class="col-md-3 col-sm-2">
               <label for="example-text"><?php echo $this->lang->line('category'); ?>:<span class="required">*</span>:</label>
                <select id="categoryid" name="categoryid"  class="form-control select2" >
                    <option value="">---select---</option>
                    <?php 
                        if($category):
                            foreach ($category as $km => $cat):  //print_r($store_type);die;
                    ?>
                     <option value="<?php echo $cat->eqca_equipmentcategoryid; ?>"><?php echo $cat->eqca_category; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-3">
                <label>Material Type</label>
                <select id="mat_id" name="mat_id"  class="form-control select2" >
                    <option value="">---select---</option>
                    <?php 
                        if($material_list):
                            foreach ($material_list as $kmt => $mat):  //print_r($store_type);die;
                    ?>
                     <option value="<?php echo $mat->maty_materialtypeid; ?>"><?php echo $mat->maty_material; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-2">
                <label>Print Orientation</label>
                <select name="page_orientation" id="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>
            <div class="col-md-3 col-sm-3">
                <label>Filter</label>
                <input id="searchText" name="searchText"  class="form-control" placeholder="Enter Item code/ Item Name">
            </div>
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>

            
        </form>

        <div class="col-sm-4 col-xs-12">
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
                    <li>
                        <div class="warning"></div> <a href="javascript:void(0)" data-approvedtype='all' class="approvetype" ><?php echo $this->lang->line('all'); ?> </a>
                        <span id="all"><?php echo !empty($return_count[0]->LimitCnt)?$return_count[0]->LimitCnt:'';?></span>
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
    <h3 class="box-title"><?php echo $this->lang->line('current_stock_list'); ?></h3>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?></th> 
                    <th width="10%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('type'); ?> </th>
                    <th width="10%"><?php echo $this->lang->line('max_limit'); ?> </th>
                    <th width="8%"><?php echo $this->lang->line('reorder_level'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('at_stock'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('summary'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('location'); ?> </th> 
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
        var categoryid = $('#categoryid').val();
        var mat_id=$('#mat_id').val();
        var searchText=$('#searchText').val();
        var locationid = "<?php echo $cur_locationid; ?>";
        var supplier = '';
        var items = '';
        var apptype='<?php echo $apptype; ?>';

        var dataurl = base_url + "stock_inventory/current_stock/search_current_stock_list";
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
                "aTargets": [0, 8]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "itemcode" },
                { "data": "itemname" },
                { "data": "unit" },
                { "data": "category" },
                { "data": "material" },
                { "data": "maxlimit" },
                { "data": "reorderlevel" },
                { "data": "totalstock" },
                { "data": "stockrmk" },
                { "data": "location" }
               
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "store_id","value": store_id});
                    aoData.push({"name": "toDate","value": toDate});
                    aoData.push({"name": "locationid","value": locationid});
                    aoData.push({"name": "supplier","value": supplier});
                    aoData.push({"name": "items","value": items});
                    aoData.push({ "name": "apptype", "value": apptype });
                    aoData.push({ "name": "categoryid", "value": categoryid });
                    aoData.push({ "name": "mat_id", "value": mat_id });
                    aoData.push({ "name": "searchText", "value": searchText });
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
                { type: null },
            ]
        });
        var otherlinkdata=base_url+'stock_inventory/current_stock/get_stock_count_total';
        var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,locationid,mat_id,store_id);

        $(document).off('click','.approvetype');
        $(document).on('click','.approvetype',function(){
            apptype= $(this).data('approvedtype');
            // alert(apptype);
            
            frmDate=$('#frmDate').val();
            toDate=$('#toDate').val();
            locationid=$('#locationid').val();  
            categoryid=$('#categoryid').val();   
            mat_id=$('#mat_id').val();
            searchText=$('#searchText').val();

            if(locationid){
                locationid = locationid;
            }else{
                locationid = "<?php echo $cur_locationid;?>";
            }
            type=$('#searchByType').val(); 
            dtablelist.fnDraw();  
            // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
        });

        $(document).off('keyup','#searchText');
        $(document).on('keyup','#searchText',function(){
            
            apptype= $(this).data('approvedtype');
            frmDate=$('#frmDate').val();
            toDate=$('#toDate').val();
            locationid=$('#locationid').val();  
            categoryid=$('#categoryid').val();   
            mat_id=$('#mat_id').val();
            searchText=$('#searchText').val();

            if(locationid){
                locationid = locationid;
            }else{
                locationid = "<?php echo $cur_locationid;?>";
            }
            type=$('#searchByType').val(); 
            dtablelist.fnDraw();  
        });

        function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false,mat_id=false,store_id=false){
            var returndata=[];   
            $.ajax({
                type: "POST",
                url: action,
                // data:$('form#'+formid).serialize(),
                dataType: 'html',
                data:{frmdate:frmdate,todate:todate,othertype:othertype,locationid:locationid,mat_id:mat_id,store_id:store_id},
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
                        issuedata= data.status_count;
                        available=parseFloat(issuedata[0].StockCnt);
                        slimit=parseFloat(issuedata[0].LimitCnt);
                        outstk=parseFloat(issuedata[0].ZeroCnt);
                        all = available + slimit + outstk;
                        
                    }
                    $('#available').html(available);
                    $('#limited').html(slimit);
                    $('#zero').html(outstk);
                    $('#all').html(all);
                    return false;
                }   
            });
        }
        $(document).on('click', '#searchByDate', function() {
            store_id = $('#store_id').val();
            toDate = $('#toDate').val();
            locationid = $('#locationid').val();
            categoryid = $('#categoryid').val();
            mat_id =$('#mat_id').val();
            searchText=$('#searchText').val();
            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata,frmDate,toDate,locationid,mat_id,store_id);
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