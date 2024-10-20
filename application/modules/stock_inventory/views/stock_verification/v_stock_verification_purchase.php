<style type="text/css">
     table.dataTable tr td:nth-child(3) {font-weight: bold}
</style>


<div class="searchWrapper">
	<div class="row">
<form action="" class="form-material form-horizontal form"> 
	
       <?php 
           
            echo $this->general->location_option(2,'locationid'); ?>
		<div class="col-md-2 col-sm-3 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('store_type'); ?>:<span class="required">*</span>:</label>
                <select id="store_id" name="store_id"  class="form-control" >
                    <option value="">---select---</option>
                    <?php 
                    //$curstore=$this->session->userdata(STORE_ID);
                        if($store):
                            foreach ($store as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->eqty_equipmenttypeid; ?>" ><?php echo $dep->eqty_equipmenttype; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
       
		<div class="col-md-2 col-sm-3 col-xs-12">
			<label for="example-text"><?php echo $this->lang->line('from_date'); ?> : </label>
			<input type="text" name="frmdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="frmdate">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-2 col-sm-3 col-xs-12">
			<label for="example-text"><?php echo $this->lang->line('to_date'); ?> : </label>
			<input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12">
			<!--  <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="stock_inventory/stock_verification/issue_search"><?php echo $this->lang->line('search'); ?></button> -->
             <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
		</div>
		
		
 <!-- </div>
        
 </div>

  <div id="displayReportDiv"></div>   -->

</form>




<div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/stock_verification/verification_purchase" data-location="stock_inventory/stock_verification/generate_purchase_ExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>
        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/stock_verification/verification_purchase" data-location="stock_inventory/stock_verification/generate_purchase_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
</div>
     <div class="clear"></div>
</div>
<div class="clearfix"></div>


<div class="pad-5 mtop_10">
    <h3 class="box-title"><?php echo $this->lang->line('stock_verification').' '.$this->lang->line('purchase'); ?></h3>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="35%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('qty'); ?></th>  
                    <th width="8%"><?php echo $this->lang->line('rate'); ?></th>  
                    <th width="8%"><?php echo $this->lang->line('amount'); ?></th>
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

<script type="text/javascript">
    $(document).ready(function() {
        var frmDate=$('#frmdate').val();
        var toDate=$('#todate').val();
        var store_id = $('#store_id').val();
        var locationid=$('#locationid').val();
        var dataurl = base_url + "stock_inventory/stock_verification/purchase_search";
        var message = '';
        // var showview = '<?php echo MODULES_VIEW; ?>';
        // if(showview=='N')
        // {
        //     message="<p class='text-danger'>Permission Denial</p>";
        // }
        // else
        // {
        //     message="<p class='text-danger'>No Record Found!!</p>";
        // }
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
            "aoColumns": [
        { "data": null},
        { "data": "itemcode"},
        { "data": "itemname"},
        { "data": "unitname"},
        { "data": "qty"},
        { "data": "rate"},

        { "data": "amount"},
        
        ],
        
        "fnServerParams": function(aoData) {
            aoData.push({"name": "store_id","value": store_id});
            aoData.push({"name": "frmDate","value": frmDate});
            aoData.push({"name": "toDate","value": toDate});
            aoData.push({"name":"locationid","value":locationid});
            
            },
        "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
         "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
                var viewurl =aData.viewurl;
                var prime_id=aData.prime_id;
                var heading=aData.reqby;

                var appclass=aData.approvedclass;
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart+iDisplayIndex +1
                $(nRow).attr('id', 'listid_'+tblid);
                $(nRow).attr('class', appclass);

                var tbl_id = iDisplayIndex + 1;

                $(nRow).attr('data-rowid',tbl_id);
                $(nRow).attr('data-viewurl',viewurl);
                $(nRow).attr('data-id',prime_id);
                $(nRow).attr('data-heading',heading);
                // $(nRow).addClass('btnredirect');
            },
        }).columnFilter({
            sPlaceHolder: "head:after",
            aoColumns: [
                { type: null },
                { type: "text" },
                { type: "text" },
                { type: null },
                { type: null },
                { type: null },

                 { type: null },
            ]
        });

    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){

        frmDate=$('#frmdate').val();
        toDate=$('#todate').val();
        store_id=$('#store_id').val(); 
        locationid=$('#locationid').val(); 
        
         
        dtablelist.fnDraw();  
       // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
    });

        $(document).on('change', '#searchBySupplier', function() {
            supplier = $('#searchBySupplier').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#searchByItems', function() {
            store_id = $('#store_id').val();
            fiscal_year = $('#fiscal_year').val();
            appstatus = $('#appstatus').val();
            locationid = $('#locationid').val();
            dtablelist.fnDraw();
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


