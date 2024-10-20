<div class="searchWrapper">
    <div class="row">
        <form class="col-sm-12">
            <?php echo $this->general->location_option(2); ?>
            <div class="col-md-2">
                <label>Date Search:</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_all">All</option>
                    <option value="date_range">By Date Range</option>
                    
                </select>
            </div>
         <div class="dateRangeWrapper" style="display:none">
            <div class="col-md-1">
                <label><?php echo $this->lang->line('from_date'); ?> :</label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-1">
                <label><?php echo $this->lang->line('to_date'); ?>:</label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
        </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('category'); ?>:</label>
                <select name="eqca_equipmentcategoryid" class="form-control select2" id="categoryid">
                <option value=''>ALL</option>
                <?php 
                if(!empty($equipmentcategory)): 
                    foreach ($equipmentcategory as $ky => $cat) {
                       ?>
                       <option value="<?php echo $cat->eqca_equipmentcategoryid; ?>"><?php echo $cat->eqca_code.' | '.$cat->eqca_category; ?></option>
                    <?php
                    }
                endif; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :<span class="required">*</span>:</label>
                <select name="fiscalyear" class="form-control required_field" id="fiscalyear">
                    <?php
                        if($fiscalyear):

                        foreach ($fiscalyear as $km => $dt): ?>
                        <option value="<?php echo $dt->fiye_name; ?>" <?php if(CUR_FISCALYEAR == $dt->fiye_name) echo "Selected = selected"; ?> ><?php echo $dt->fiye_name; ?></option>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
        </form> 
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable keypresstable"  data-tableid="#myTable" width="100%">
            <thead>
                <tr>
                    <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('received_date_ad'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('received_date_bs'); ?></th>
                   
                    <th width="6%"><?php echo $this->lang->line('invoice_no'); ?></th>
                       
                    <th width="4%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('supplier'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('amount'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('action'); ?></th>
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

    var searchDateType = $('#searchDateType').val();
    if(searchDateType == 'date_all'){
    var frmDate = '';
    var toDate = '';
        }

    var locationid=$('#locationid').val();
    var fiscalyear=$('#fiscalyear').val();
    var type =$('#searchByType').val();
    var categoryid=$('#categoryid').val();
    // alert(categoryid);
    var apptype='';
    var dataurl = base_url+"ams/asset_sync/itemslist_from_inventory";
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

    var tableid = $('.serverDatatable').data('tableid');
    
    var firstTR = $('#myTable tbody tr:first');
    firstTR.addClass('selected');

     $(tableid).on("draw.dt", function(){
        var rowsNext = $(tableid).dataTable().$("tr:first");
        rowsNext.addClass("selected");
    });

    var dtablelist = $(tableid).dataTable({
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
    "aTargets": [ 0, 8,9,10,11]
    }
    ],
    "aoColumns": [
    { "data": null},
    { "data": "received_date_ad"},
    { "data": "received_date_bs"},
    { "data": "invoice_no"},
    { "data": "item_code"},
    { "data": "item_name" },
    { "data": "category" },
    { "data": "supplier" },
    { "data": "qty" },
    { "data": "rate" },
    { "data": "amount" },
    { "data": "action" },
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "locationid", "value": locationid });
        aoData.push({ "name": "fiscalyear", "value": fiscalyear });
        aoData.push({ "name": "type", "value": type });
        aoData.push({ "name": "apptype", "value": apptype });
        aoData.push({ "name": "categoryid", "value": categoryid });
    },
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        // console.log(aData);

        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
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
    }).columnFilter(
    {
        sPlaceHolder: "head:after",
        aoColumns: [ { type: null },
        {type: "text"},
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: null },
        { type: null },
        { type: null },
        ]
    });
    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        searchDateType = $('#searchDateType').val();

        if(searchDateType == 'date_all'){
            frmDate = '';
            toDate = '';
        }
        categoryid=$('#categoryid').val();
        fiscalyear=$('#fiscalyear').val();
        locationid=$('#locationid').val();
        type=$('#searchByType').val(); 
        dtablelist.fnDraw();
    });

    $(document).off('change','#searchByType')
    $(document).on('change','#searchByType',function(){
        type=$('#searchByType').val();
        dtablelist.fnDraw();  
    });

    $(document).off('click','.approvetype');
    $(document).on('click','.approvetype',function(){
       apptype= $(this).data('approvedtype');
        // alert(apptype);
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();  
        type=$('#searchByType').val(); 
        locationid=$('#locationid').val();
        fiscalyear=$('#fiscalyear').val();
        categoryid=$('#categoryid').val();
        dtablelist.fnDraw();  
    });

    $(document).on('click', '.serverDatatable tbody tr', function() {
            // console.log(tableid);
            var selectedTR = $(tableid).find('.selected');

            var dtablelist = $(tableid).dataTable();
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                prime_id = 0;
            } else {
                dtablelist.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                prime_id = dtablelist.api().row(this).data().prime_id;
            }
        });
});

</script>
<script type="text/javascript">
    $(document).off('click','.btnredirect');
    $(document).on('click','.btnredirect',function(){
        var id=$(this).data('id');
        var url=$(this).data('viewurl');
        var redirecturl=url;
        $.redirectPost(redirecturl, {id:id });
    })
</script>
<script type="text/javascript">
    $(document).off('change','#searchDateType');
    $(document).on('change','#searchDateType',function(){
        var search_date_val = $(this).val();

        if(search_date_val == 'date_all'){
            $('.dateRangeWrapper').hide();
        }else{
            $('.dateRangeWrapper').show();
        }
    });
</script>