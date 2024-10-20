<style type="text/css">
      .table>tbody>tr>td:not(:last-child),
    .table>tbody>tr>th {
        vertical-align: middle !important;
        white-space: normal !important;
    }
</style>

<h3 class="box-title"><?php echo $this->lang->line('list_of_distributor'); ?>  <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
<div class="searchWrapper">
    <div class="pull-right" style="margin-top:15px;">        
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="biomedical/distributors" data-location="biomedical/distributors/exportToExcel" data-tableid="#myTable">
            <i class="fa fa-file-excel-o"></i>
        </a>           
    </div>
<div class="">
<form class="col-sm-10">
        <div class="col-md-5">
            <label><?php echo $this->lang->line('distributor_name'); ?>/<?php echo $this->lang->line('government_reg_no'); ?>/Phone</label>
            <input type="text" id="text_srch" name="text_srch" class="form-control " />
        </div>
      
    <div class="sm-clear"></div>
</form>

</div>
<div class="clear"></div>
</div>
    <div class="pad-5">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped ">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                         <th width="8%"><?php echo $this->lang->line('distributor_code'); ?>
                         </th>
                        <th width="32%"><?php echo $this->lang->line('distributor_name'); ?>
                        </th>
                         </th>
                         <th width="10%"><?php echo $this->lang->line('phone_no'); ?></th>
                        
                        <th width="15%"><?php echo $this->lang->line('dist_address'); ?></th>
                        
                         <th width="15%"><?php echo $this->lang->line('government_reg_no'); ?></th>
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
    var text_srch=$('#text_srch').val();
 
    var rslt='<?php echo !empty($result)?$result:''; ?>';
    var orgid='<?php echo !empty($org_id)?$org_id:''; ?>';

    var dataurl = base_url+"biomedical/distributors/distributors_list/"+rslt+'/'+orgid;;
    var message='';
    var showview='<?php echo MODULES_VIEW; ?>';
    // alert(showview);
   
    /*if(showview=='N')
    {
      message="<p class='text-danger'>Permission Denial</p>";
    }
    else
    {
      message="<p class='text-danger'>No Record Found!! </p>";
    }*/
 
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
        "aTargets": [ 0,5 ]
      }
      ],      
      "aoColumns": [
       { "data": "dist_distributorid" },
       { "data": "dist_distributorcode" },
       { "data": "distributor" },
       { "data": "dist_phone1" },
       { "data": "address1" },
       { "data": "dist_govtregno" },
       { "data": "action" }
      ],
      "fnServerParams": function (aoData) {
        aoData.push({ "name": "text_srch", "value": text_srch });
      
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
             var oSettings = dtablelist.fnSettings();
            var tblid= oSettings._iDisplayStart+iDisplayIndex +1

        $(nRow).attr('id', 'listid_'+tblid);
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
      
      { type: null },
     
      ]
    });

     $(document).off('keyup', '#text_srch')
        $(document).on('keyup', '#text_srch', function() {
            text_srch = $(this).val();
            dtablelist.fnDraw();
        });

});
</script>