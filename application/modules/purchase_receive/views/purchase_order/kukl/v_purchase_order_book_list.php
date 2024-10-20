<?php 
foreach ($status_count as $key => $color) 
{
    $statusname=$color->coco_statusname;
    $colors=$color->coco_color;
    $bgcolor=$color->coco_bgcolor;
    ?>
    <style>
        .table-striped tbody tr.<?php echo $statusname;?> td{
            color:<?php echo $colors;  ?>;
        }
        .index_chart li div.<?php echo $statusname; ?>
        {
            background-color:<?php echo $bgcolor; ?>
        }
        .white-box.noborder ul li.<?php echo $statusname; ?>{
            background-color:<?php echo $bgcolor; ?>
        }
        #<?php echo $statusname;?>
        { margin-left: 6px; }
        
    </style>
    <?php
} 
?>
<div class="white-box">
    <div class="sm-clear"></div>
    <div class="white-box pad-5">
      <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/purchase_order/search_allpurchase_item_list" data-location="purchase_receive/purchase_order/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/purchase_order/search_allpurchase_item_list" data-location="purchase_receive/purchase_order/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="row">
        <form class="col-sm-12">
            <div class="row">
               <?php echo $this->general->location_option(2,'locationid'); ?>
               <div class="col-md-2">
                <label>Date Search:</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>

            <div class="dateRangeWrapper">
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
                <label><?php echo $this->lang->line('supplier_wise'); ?> :</label>
                
                <select name="supplier" class="form-control select2" id="supplier">
                    <option value="">---select---</option>
                    <?php
                    if(!empty($distributor)):
                        foreach ($distributor as $km => $sup):
                            ?>
                            <option value="<?php echo $sup->dist_distributorid; ?>" ><?php echo $sup->dist_distributor; ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>

            <div class="col-md-1">
                <label>Filter</label>
                <input type="text" class="form-control" placeholder="PR. No/Dem. No/Manual No." 
                 name="srchtext" id="srchtext">
            </div>

            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </div>
    </form>

    <div class="col-sm-12">
        <div class="white-box pad-5 noborder" style="margin-top: 12px;">
         <ul class="index_chart purchasedOrderUl">
            <?php 
            if(!empty($status_count)):
                foreach ($status_count as $key => $col):
                  // echo"<pre>";   print_r($status_count);die;
                  ?>
                  <li  class="<?php echo $col->coco_statusname; ?>">
                    <a href="javascript:void(0)" data-approvedtype='<?php echo $col->coco_statusname; ?>' class="approvetype">
                        <em class="<?php echo $col->coco_statusname; ?>"></em>
                        <?php echo $col->coco_displaystatus; ?> 
                        <span id="<?php echo $col->coco_statusname; ?>"><?php echo !empty($col->statuscount)?$col->statuscount:'';?>
                    </span>
                </a> 
            </li>
        <?php endforeach;
    endif; ?>
    <div class="clearfix"></div>
</ul>
</div>

</div>
</div>
</div>
<div  id="FormDiv_orderDetails" class="formdiv frm_bdy">
    <div class="pad-5">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped no-padd">
                <thead>
                    <tr>
                        <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="6%"><?php echo $this->lang->line('order_no'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                        <th width="9%"><?php echo $this->lang->line('order_date'); ?> <?php echo $this->lang->line('ad'); ?></th>
                        <th width="9%"><?php echo $this->lang->line('order_date'); ?> <?php echo $this->lang->line('bs'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('delivery_date'); ?> <?php echo $this->lang->line('ad'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('delivery_date'); ?> <?php echo $this->lang->line('bs'); ?></th>
                        <th width="11%"><?php echo $this->lang->line('delivery_site'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('supplier_name'); ?></th> 
                        <th width="9%"><?php echo $this->lang->line('order_amount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('req_no'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('approved'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<?php
$apptype = $this->input->post('dashboard_data');
if($apptype){
    $apptype = $apptype; 
}else{
    $apptype = "";
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        var srchtext = $('#srchtext').val();
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();
        var supplier = $('#supplier').val();
        var locationid=$('#locationid').val();
        var item = $('#item').val();
        var apptype='<?php echo $apptype; ?>';
        var searchDateType = $('#searchDateType').val();

        if(searchDateType == 'date_all'){
            var frmDate = '';
            var toDate = '';
        }
        // var apptype='';
        // var rslt='<?php echo !empty($result)?$result:''; ?>';
        // var orgid='<?php echo !empty($org_id)?$org_id:''; ?>';
        //var dataurl = base_url+"biomedical/purchase_receive/analysis_ii_list/"+rslt+'/'+orgid;
        var dataurl = base_url+"purchase_receive/purchase_order/purchase_order_book_list";
        var message='';
        var showview='<?php echo MODULES_VIEW; ?>';
        //alert(showview);
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
                "aTargets": [ 0,10 ,11]
            }
            ],
            "aoColumns": [
            { "data": "puor_purchaseordermasterid" },
            { "data": "orderno" },
            { "data": "fyear" },
            { "data": "puor_orderdatead" },
            { "data": "puor_orderdatebs" },
            { "data": "puor_deliverydatead" },
            { "data": "puor_deliverydatebs" },
            { "data": "puor_deliverysite" },
            { "data": "supplier" },
            { "data": "totalamount" },
            { "data": "requno" },
            { "data": "puor_approvedby" },
            { "data": "action" }
            
            
            ],
            "fnServerParams": function (aoData) {
                aoData.push({"name": "srchtext", "value": srchtext });
                aoData.push({ "name": "frmDate", "value": frmDate });
                aoData.push({ "name": "toDate", "value": toDate });
                aoData.push({ "name": "apptype", "value": apptype });
                aoData.push({ "name": "supplier", "value": supplier });
                aoData.push({ "name": "locationid", "value": locationid });

            },
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
                return nRow;
            },
            "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
               var appclass=aData.approvedclass;
               var oSettings = dtablelist.fnSettings();
               var tblid= oSettings._iDisplayStart+iDisplayIndex +1
               $(nRow).attr('id', 'listid_'+tblid);
               $(nRow).attr('class', appclass);
           },
       }).columnFilter(
       {
        sPlaceHolder: "head:after",
        aoColumns: [ {type: null},
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
       var otherlinkdata=base_url+'purchase_receive/purchase_order/purchased_summary';

       var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,apptype,supplier,locationid);

       $(document).off('click','#searchByDate')
       $(document).on('click', '#searchByDate', function() {
         srchtext = $('#srchtext').val();
        frmDate = $('#frmDate').val();
        toDate = $('#toDate').val();
        supplier = $('#supplier').val();
        item = $('#item').val();
        apptype='';
        locationid=$('#locationid').val();
        searchDateType = $('#searchDateType').val();

        if(searchDateType == 'date_all'){
            frmDate = '';
            toDate = '';
        }
        dtablelist.fnDraw();
        get_other_ajax_data(otherlinkdata,frmDate,toDate,apptype,supplier,locationid);  
    });
       $(document).off('click','.approvetype');
       $(document).on('click','.approvetype',function(){
        supplier = $('#supplier').val();
        item = $('#item').val();
        apptype= $(this).data('approvedtype');
            // alert(apptype);
            if(apptype == 'cancel' || apptype == 'issue' || !apptype){
                $('.tr_return').hide();
                $('.tr_issue').show();
            }else if(apptype == 'issuereturn' || apptype == 'returncancel'){
                $('.tr_return').show();
                $('.tr_issue').hide();
            }
            srchtext = $('#srchtext').val();
            frmDate=$('#frmDate').val();
            toDate=$('#toDate').val();  
            type=$('#searchByType').val(); 
            locationid=$('#locationid').val();
            searchDateType = $('#searchDateType').val();

            if(searchDateType == 'date_all'){
                frmDate = '';
                toDate = '';
            }
            dtablelist.fnDraw();  
            get_other_ajax_data(otherlinkdata,frmDate,toDate,apptype,supplier,locationid);   
        });

       function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false,supplier=false,locationid=false){
        var returndata=[];   
        $.ajax({
            type: "POST",
            url: action,
                // data:$('form#'+formid).serialize(),
                dataType: 'html',
                data:{frmdate:frmdate,todate:todate,othertype:othertype,supplier:supplier,locationid:locationid} ,
                success: function(jsons) //we're calling the response json array 'cities'
                {
                    // console.log(jsons);
                    data = jQuery.parseJSON(jsons);
                    //     issuedata=data.status_count;
                    // each(issuedata function(i,k){
                    //    var k.coco_statusname=0;
                    //    $('#'+k.coco_statusname).html(''); 
                    //    if(data.status=='success'){
                    //     k.coco_statusname=k.statuscount;

                    //    }
                    //    $('#'+k.coco_statusname).html(k.coco_statusname);

                    // });
                    // return false;

                    var pending=0;
                    var cancel = 0;
                    var complete=0;
                    var partialcomplete=0;
                    var challan = 0;
                    console.log(data);
                    $('#pending').html('');
                    $('#cancel').html('');
                    $('#complete').html('');
                    $('#partialcomplete').html('');
                    $('#challan').html('');
                    if(data.status=='success'){
                        issuedata=data.status_count;

                        // console.log(issuedata);
                        // console.log(issuedata[0].cancel)
                        pending=issuedata[0].pending;
                        cancel = issuedata[0].cancel;
                        complete=issuedata[0].complete;
                        partialcomplete=issuedata[0].partialcomplete;
                        challan = issuedata[0].challan;       
                    }
                    $('#pending').html(pending);
                    $('#cancel').html(cancel);
                    $('#complete').html(complete);
                    $('#partialcomplete').html(partialcomplete);
                    $('#challan').html(challan);

                    return false;
                }   
            });
    }
});
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