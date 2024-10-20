
<!-- <?php // $this->load->view('asset_insurance/v_asset_insurance');?> -->
<!-- <h3 class="box-title">List Of Assets Insurance <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
<table id="Dtable" class="table table-striped menulist" >
<thead>
    <tr>
        <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
           <th width="10%"><?php echo $this->lang->line('asset_name'); ?></th>
        <th width="10%"><?php echo $this->lang->line('asset_insurance_name'); ?></th>
        <th width="10%"><?php echo $this->lang->line('asset_insurance_type'); ?></th>
              <th><?php echo $this->lang->line('renewal_period'); ?></th>
        <th><?php echo $this->lang->line('start_date'); ?></th>
         <th><?php echo $this->lang->line('end_date'); ?></th>
         <th><?php echo $this->lang->line('asset_insurance_rate'); ?></th>
        <th><?php echo $this->lang->line('action'); ?></th>
    </tr>
</thead>
<tbody>
     <?php
            if($asset_insurance_all):
                $i=1;
                foreach ($asset_insurance_all as $kpc => $demo):
        ?>
            <tr id="listid_<?php echo $demo->asin_asinid; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $demo->asen_assetcode; ?></td>
            <td><?php echo $demo->inco_name; ?></td>
            <td><?php echo $demo->inty_name; ?></td>
            <td><?php echo $demo->peri_name; ?></td>
            <td><?php echo $demo->asin_startdatead; ?></td>
            <td><?php echo $demo->asin_enddatead; ?></td>
            <td><?php echo $demo->asin_insurancerate; ?></td>     
            <td> -->
      <!--  <a href="javascript:void(0)" data-id='<?php echo $demo->asin_asinid; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a> | -->
        <!--     <a href="javascript:void(0)" data-id='<?php echo $demo->asin_asinid; ?>' class="btnDelete"><i class="fa fa-trash"></i></a>
            </td>
            </tr>
        <?php
        $i++;
        endforeach;
    endif;
     ?>
 </tbody>
</table> -->


<div class="searchWrapper">
    <div class="row">
        <form class="col-sm-8">
            <?php echo $this->general->location_option(); ?>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?> :</label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?>:</label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            <!-- <div class="col-md-2">
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
            </div> -->
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
        </form> 
    </div>
<div style="margin: 10">
<a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/asset_insurance/list_asset_insurance" data-location="ams/asset_insurance/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

<a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/asset_insurance/list_asset_insurance" data-location="ams/asset_insurance/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
</div>
<div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable keypresstable"  data-tableid="#myTable" width="100%">
            <thead>
                <tr>
                    <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('asset_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('asset_insurance_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('asset_insurance_type'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('renewal_period'); ?></th>
                     <th width="10%"><?php echo $this->lang->line('asset_insurance_amount'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('start_date'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('end_date'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('asset_insurance_rate'); ?></th>
                  
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
    var locationid=$('#locationid').val();
   // var fiscalyear=$('#fiscalyear').val();
    var type =$('#searchByType').val();
    var apptype='';
    var dataurl = base_url+"ams/asset_insurance/itemslist_from_inventory";
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
    "lengthMenu": [[10, 20, 30, 40,50,100,200, -1], [10, 20, 30, 40,50,100,500, "All"]],
    'iDisplayLength': 10,
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
    "aTargets": [ 0, 9]
    }
    ],
    "aoColumns": [
    { "data": null},
    { "data": "asen_assetcode"},
    { "data": "inco_name"},
    { "data": "inty_name"},
    { "data": "peri_name"},
    {"data":"asin_insuranceamount"},
    { "data": "asin_startdatead" },
    { "data": "asin_enddatead" },
    { "data": "asin_insurancerate" },
    // { "data": "asset_insurance_policy_no" },
    { "data": "action" },
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "locationid", "value": locationid });
        //aoData.push({ "name": "fiscalyear", "value": fiscalyear });
        aoData.push({ "name": "type", "value": type });
        aoData.push({ "name": "apptype", "value": apptype });
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
         { type: null },
        { type: null },
        { type: null },
        { type: null },
        { type: null },
        // { type: null },
        // { type: null },
        // { type: null },
        ]
    });
    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
      //  fiscalyear=$('#fiscalyear').val();
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
        //fiscalyear=$('#fiscalyear').val();
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